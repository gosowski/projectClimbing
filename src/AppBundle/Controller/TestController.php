<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use	Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TestController extends Controller
{
    /**
     * @Route("/showTests/")
     */
    public function showTestsAction()
    {
        $user = $this->getUser();

        if($user === null) {
            return $this->redirectToRoute('homepage');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository("AppBundle:Test");

        $allTests = $repository->loadAllTestsByDate($entityManager);
        return $this->render('AppBundle:Test:show_tests.html.twig', ['tests' => $allTests]);
    }

    /**
     * @Route("/singleTest/")
     */
    public function singleTestAction(SessionInterface $session) {

        $user = $this->getUser();
        if ($user == null) {
            return $this->redirectToRoute('homepage');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $testId = $session->get('test');
        $repository = $entityManager->getRepository("AppBundle:Answer");
        $allAnswers = $repository->loadQuestionAsc($entityManager, $testId);

        return $this->render('AppBundle:Answer:show_result_logged.html.twig', ['answers' => $allAnswers ]);
    }


    /**
     * @Route("/updateTest/")
     */
    public function updateTest(SessionInterface $session, Request $request) {
        $user = $this->getUser();

        if($user == null) {
            return $this->redirectToRoute('app_question_result');
        }

        $testId = $session->get('test');

        $entityManager = $this->getDoctrine()->getManager();
        $repoTest = $entityManager->getRepository("AppBundle:Test");
        $currentTest = $repoTest->find($testId);

        $repository = $entityManager->getRepository("AppBundle:Answer");
        $allAnswers = $repository->findByTest($currentTest);

        //declare 3 variables with value = 0
        $psyche = 0;
        $tactic = 0;
        $strength = 0;

        //loop for each element in array and sum values into vars
        foreach($allAnswers as $answer) {

            $questionId = $answer->getQuestion()->getId();

            if($questionId < 11) {
                $psyche += $answer->getValue();
            } elseif ($questionId >= 11 && $questionId < 21) {
                $tactic += $answer->getValue();
            } else {
                $strength += $answer->getValue();
            }
        }

        $currentTest->setPsyche($psyche);
        $currentTest->setTactic($tactic);
        $currentTest->setStrength($strength);

        //form for description add
        $newForm = $this->generateDescForm($currentTest);
        $newForm->handleRequest($request);

        if($newForm->isSubmitted()){

            //save values into DB
            $entityManager->persist($currentTest);
            $entityManager->flush();

            return $this->redirectToRoute("app_question_result");

        }

        return $this->render("AppBundle:Test:test_desc.html.twig", ['form' => $newForm->createView()]);
    }

    protected function generateDescForm($obj) {

        $newForm = $this->createFormBuilder($obj)
                ->setMethod("POST")
                ->add('description', TextType::class, ['required' => false, 'attr' => ['value' => "--"]])
                ->add('save', SubmitType::class, ['label' => 'Wyślij'])
                ->getForm();
        return $newForm;
    }

}
