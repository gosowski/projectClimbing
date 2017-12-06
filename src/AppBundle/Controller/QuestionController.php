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
     * @Route("/question/{id}/")
     */
    public function startAction($id, Request $request, SessionInterface $session) {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository("AppBundle:Question");

        //load all question by id
        $question = $repository->find($id);

        //create new form with radio buttons
        $answer = new Answer();

        $newForm = $this->generateForm($answer);

        $newForm->handleRequest($request);

        if($newForm->isSubmitted()) {
            $newForm->getData();

            //create new array session
            $answers = $session->get('answers',[]);

            $answers[$id] = $answer->getValue();

            //add to existing values - new ones;
            $session->set('answers' ,$answers);
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
        $allAnswers = $session->get('answers');

        $session->invalidate('answers');

        return $this->render('AppBundle:Answer:show_result.html.twig', ['answers' => $allAnswers ]);

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
