<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use	Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin")
 */

class AdminController extends Controller
{
    /**
     * @Route("/")
     */
    public function adminAction() {
        $user = $this->getUser();

        return $this->render("AppBundle:Admin:mainAdmin.html.twig", ['user' => $user]);
    }

    /**
     * @Route("/users/")
     */
    public function usersAction() {
        $entityManager = $this->getDoctrine()->getManager();
        $userRepo = $entityManager->getRepository("AppBundle:User");

        $allUsers = $userRepo->findAll();

        return $this->render('AppBundle:Admin:adminUsers.html.twig', ['users' => $allUsers]);
    }

    /**
     * @Route("/tests/")
     */
    public function testsAction() {
        $entityManager = $this->getDoctrine()->getManager();
        $testRepo = $entityManager->getRepository("AppBundle:Test");

        $allTests = $testRepo->findAll();

        return $this->render('AppBundle:Admin:adminTests.html.twig', ['tests' => $allTests]);
    }

    /**
     * @Route("/questions/")
     */
    public function questionsAction() {
        $entityManager = $this->getDoctrine()->getManager();
        $questionRepo = $entityManager->getRepository("AppBundle:Question");

        $allQuestions = $questionRepo->findAll();

        return $this->render('AppBundle:Admin:adminQuestions.html.twig', ['questions' => $allQuestions]);
    }
}
