<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class TaskController.
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class TaskController extends Controller
{
    /**
     * @Route("/tasks", methods={"GET"}, name="task_list")
     *
     * @return Response
     */
    public function listAction()
    {
        $tasks = $this->getDoctrine()->getRepository('AppBundle:Task')->findAll();

        return $this->render('task/list.html.twig', array(
            'tasks' => $tasks,
        ));
    }

    /**
     * @param Request $request
     *
     * @Route("/tasks/create", methods={"GET", "POST"}, name="task_create")
     *
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task)->handleRequest($request);

        $taskCreateHandler = $this->get('app.task_create_handler');

        if ($taskCreateHandler->handle($form, $task)) {
            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Task    $task
     * @param Request $request
     *
     * @Route("/tasks/{id}/edit", methods={"GET", "POST"}, name="task_edit")
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Task $task, Request $request)
    {
        $form = $this->createForm(TaskType::class, $task)->handleRequest($request);

        $taskEditHandler = $this->get('app.task_edit_handler');

        if ($taskEditHandler->handle($form, $task)) {
            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @param Task $task
     *
     * @Route("/tasks/{id}/toggle", methods={"GET"}, name="task_toggle")
     *
     * @return RedirectResponse
     */
    public function toggleTaskAction(Task $task)
    {
        $task->setDone(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', sprintf('Le status de la tâche %s a bien été mis à jour.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @param Task    $task
     * @param string  $csrf
     *
     * @Route("/tasks/{id}/delete/{csrf}", methods={"GET"}, name="task_delete")
     *
     * @return RedirectResponse
     */
    public function deleteTaskAction(Task $task, $csrf)
    {
        $this->denyAccessUnlessGranted(new Expression(
            '"ROLE_ADMIN" in roles or (user === object.getUser())'
        ), $task);

        if (!$this->isCsrfTokenValid('delete', $csrf)) {
            return $this->redirectToRoute('task_list');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
