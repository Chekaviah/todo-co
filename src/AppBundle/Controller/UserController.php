<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class UserController
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class UserController extends Controller
{
    /**
     * @Route("/users", methods={"GET"}, name="user_list")
     *
     * @return Response
     */
    public function listAction()
    {
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

        return $this->render('user/list.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * @param Request $request
     *
     * @Route("/users/create", methods={"GET", "POST"}, name="user_create")
     *
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user)->handleRequest($request);

        $userCreateHandler = $this->get('app.user_create_handler');

        if ($userCreateHandler->handle($form, $user)) {
            $this->addFlash('success', "L'utilisateur a bien été ajouté.");
            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param User    $user
     * @param Request $request
     *
     * @Route("/users/{id}/edit", methods={"GET", "POST"}, name="user_edit")
     *
     * @return RedirectResponse|Response
     */
    public function editAction(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user)->handleRequest($request);

        $userEditHandler = $this->get('app.user_edit_handler');

        if ($userEditHandler->handle($form, $user)) {
            $this->addFlash('success', "L'utilisateur a bien été modifié.");
            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }
}
