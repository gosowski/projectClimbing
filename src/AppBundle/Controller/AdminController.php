<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Route("/advices/delete/{id}/")
     */
    public function deleteAdviceAction($id) {

        return $this->deleteFromDB("advices", $id);

    }

    /**
     * @Route("/{topics}/update/{id}/")
     */
    public function updateQuestionAction($id, Request $request, $topics) {

        $bundleName = ucfirst(rtrim($topics, "s"));

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository("AppBundle:".$bundleName);
        $toModify = $repository->find($id);

        $newForm = $this->generateQuestionForm($toModify);
        $newForm->handleRequest($request);

        if($newForm->isSubmitted() && $newForm->isValid()) {

            $newText = $newForm->getData();
            $entityManager->persist($newText);
            $entityManager->flush($newText);

            if($topics == 'questions'){
                return $this->redirectToRoute('app_admin_users', ['item' => "questions"]);
            } elseif($topics == 'advices') {
                return $this->redirectToRoute('app_admin_users', ['item' => "advices"]);

            }
        }

        return $this->render('AppBundle:Admin:adminModify.html.twig', ['form' => $newForm->createView()]);
    }

    /**
     * @Route("/advices/update/{id}/")
     */
    public function updateAdviceAction($id, Request $request) {

        $entityManager = $this->getDoctrine()->getManager();

        $repository = $entityManager->getRepository("AppBundle:Advice");
        $toModify = $repository->find($id);

        $newForm = $this->generateAdviceForm($toModify);
        $newForm->handleRequest($request);

        if($newForm->isSubmitted() && $newForm->isValid()) {
            $newText = $newForm->getData();
            dump($newText);

        }

        return $this->render("AppBundle:Admin:adminModify.html.twig", ['form' => $newForm->createView()]);
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

    protected function generateQuestionForm($obj) {

        $newForm = $this->createFormBuilder($obj)
                ->setMethod("POST")
                ->add("text", TextType::class, ["label" => "Tekst: "])
                ->add("save", SubmitType::class, ['label' => 'Modyfikuj'])
                ->getForm();

        return $newForm;
    }

}
