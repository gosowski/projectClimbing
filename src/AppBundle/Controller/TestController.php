<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TestController extends Controller
{
    /**
     * @Route("/showTests/")
     */
    public function showTestsAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository("AppBundle:Test");

        $allTests = $repository->findAll();

        return $this->render('AppBundle:Test:show_tests.html.twig', ['tests' => $allTests]);
    }

}
