<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;


class PdfController extends Controller
{
    /**
     * @Route("/generateSinglePdf/{testId}/")
     */
    public function generateSinglePdfAction($testId)
    {
        $entityManager = $this->getDoctrine()->getManager();

        //test repository
        $testRepo = $entityManager->getRepository("AppBundle:Test");
        $testToShow = $testRepo->find($testId);

        //answers repo
        $ansRepo = $entityManager->getRepository("AppBundle:Answer");
        $testAnswers = $ansRepo->findByTest($testId);

        //generate pdf file

        $html = $this->renderView('AppBundle:Pdf:generate_single_pdf.html.twig', [
            'test' => $testToShow,
            'answers' => $testAnswers]);

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html), 'Test.pdf');
    }

}
