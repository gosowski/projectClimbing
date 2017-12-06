<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Answer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class QuestionController extends Controller
{
    /**
     * @Route("/question/{id}/", defaults={"id"=1})
     */
    public function startAction($id, Request $request, SessionInterface $session) {

        //check if user is logged
        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository("AppBundle:Question");

        //load all question by id
        $question = $repository->find($id);

        $newAnswer = new Answer();

        $newForm = $this->generateForm($newAnswer);

        $newForm->handleRequest($request);

        if($newForm->isSubmitted()) {
            $newForm->getData();

            //if not logged - do not save value into db
            if($user === null) {
                //create new array session
                $answers = $session->get('answers',[]);

                //add value from form to array key - question number
                $answers[$id] = $newAnswer->getValue();

                //add to existing values - new ones;
                $session->set('answers' ,$answers);

                //if logged - save value into db, with date of test
            } else {

                //get test entity with id from session in DB
                $testId = $session->get('test');
                $repoTest = $entityManager->getRepository("AppBundle:Test");
                $newTest = $repoTest->find($testId);

                //set test parameters
                $newAnswer->setTest($newTest);
                $newAnswer->setQuestion($question);

                //prepare and save values into db
                $entityManager->persist($newAnswer);
                $entityManager->persist($newTest);
                $entityManager->flush();

            }
        }


        return $this->render("AppBundle:Question:show_question.html.twig", [
            'question' => $question,
            'id' => $id,
            'form' => $newForm->createView()]);
    }

    /**
     * @Route("/result/")
     */

    public function resultAction(SessionInterface $session) {

        //check if user is logged
        $user = $this->getUser();

        //if no user
        if($user === null) {

            //get session with results
            $allAnswers = $session->get('answers');

            //clear session
            $session->invalidate('answers');

            return $this->render('AppBundle:Answer:show_result.html.twig', ['answers' => $allAnswers ]);
        }

        //if user is logged

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository("AppBundle:Answer");



    }

    /**
     * @Route("/singleQuestion/{id}/")
     */
    public function showSingleAction($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository("AppBundle:Question");

        $singleQuestion = $repository->find($id);

        return $this->render("AppBundle:Answer:show_single_question.html.twig", ['question' => $singleQuestion]);
    }

    protected function generateForm($obj, $method = "POST") {

        $newForm = $this->createFormBuilder($obj)
            ->setMethod($method)
            ->add('value', ChoiceType::class, ['choices' => [
                '0 punktów' => 0,
                '1 punkt' => 1,
                '2 punkty' => 2,
                '3 punkty' => 3,
                '4 punkty' => 4,
                '5 punktów' => 5], 'label' => "Twoja ocena: ", 'attr' => [
                'class' => 'form-control'
            ]])
            ->getForm();

        return $newForm;
    }


}
