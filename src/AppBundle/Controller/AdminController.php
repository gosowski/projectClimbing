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

    /**
     * @Route("/tests/delete/{id}/")
     */
    public function deleteTestAction($id) {

        return $this->deleteFromDB("tests", $id);
    }

    /**
     * @Route("/users/delete/{id}/")
     */
    public function deleteUserAction($id) {

        return $this->deleteFromDB("users", $id);
    }

    /**
     * @Route("/questions/delete/{id}/")
     */
    public function deleteQuestionAction($id) {

        return $this->deleteFromDB("questions", $id);
    }


    protected function deleteFromDB($name, $id) {

        $bundleName = ucfirst(rtrim($name, "s"));

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository("AppBundle:".$bundleName);

        $toRemove = $repository->find($id);
        $entityManager->remove($toRemove);
        $entityManager->flush($toRemove);

        return $this->redirectToRoute('app_admin_'.$name);
        
    }

}
