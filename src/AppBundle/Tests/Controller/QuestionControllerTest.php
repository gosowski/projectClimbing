<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuestionControllerTest extends WebTestCase
{
    public function testNextquestion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/nextQuestion');
    }

    public function testPreviousquestion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/previousQuestion');
    }

}
