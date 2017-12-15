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
     * @Route("/{item}/")
     */
    public function usersAction($item) {

        return $this->loadAllFromDB($item);
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

    protected function loadAllFromDB($item) {

        $bundleName = ucfirst(rtrim($item, "s"));

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository("AppBundle:".$bundleName);

        $allItems = $repository->findAll();

        return $this->render("AppBundle:Admin:admin".$bundleName."s.html.twig", ['items' => $allItems]);
    }

}
