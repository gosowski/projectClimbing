<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class QuestionController extends Controller
{
    /**
     * @Route("/question/{id}/")
     */
    public function startAction($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository("AppBundle:Question");

        $question = $repository->find($id);

        return $this->render("AppBundle:Question:show_question.html.twig", ['question' => $question, 'id' => $id]);
    }

}
