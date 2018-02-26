<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class DefaultController
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", methods={"GET"}, name="homepage")
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }
}
