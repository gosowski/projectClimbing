<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Test;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {

        return $this->render("default/index.html.twig");
    }

    /**
     * @Route("/testStart/")
     */
    public function startTestAction(SessionInterface $session) {

        $user = $this->getUser();
        if($user){

            //get date of taking test
            $testDate = new \DateTime($time = 'now');

            //create new test entity and add values
            $newTest = new Test();

            $newTest->setUser($user);
            $newTest->setDate($testDate);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newTest);
            $entityManager->flush();

            $session->set('test', $newTest->getId());
        }
        return $this->redirectToRoute("app_question_start");
    }
}
