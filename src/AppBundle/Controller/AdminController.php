<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @Route("/{topics}/delete/{id}/")
     */
    public function deleteTopicAction($topics, $id, Request $request) {

        return $this->deleteFromDB($topics, $id, $request);
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

    protected function deleteFromDB($name, $id, $request) {

        $bundleName = ucfirst(rtrim($name, "s"));

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository("AppBundle:".$bundleName);

        $toRemove = $repository->find($id);
        $entityManager->remove($toRemove);
        $entityManager->flush($toRemove);

        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);

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
