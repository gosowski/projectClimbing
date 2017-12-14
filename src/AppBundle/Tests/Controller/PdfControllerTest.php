<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PdfControllerTest extends WebTestCase
{
    public function testGeneratesinglepdf()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/generateSinglePdf');
    }

}
