<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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

//        $allTests = $repository->findAll();

        $allTests = $repository->loadAllTestsByDate($entityManager);
        return $this->render('AppBundle:Test:show_tests.html.twig', ['tests' => $allTests]);
    }

    /**
     * @Route("/updateTest/")
     */
    public function updateTest(SessionInterface $session) {
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

        //save values into DB
        $currentTest->setPsyche($psyche);
        $currentTest->setTactic($tactic);
        $currentTest->setStrength($strength);
        $entityManager->persist($currentTest);
        $entityManager->flush();

        return $this->redirectToRoute("app_question_result");
    }

}
