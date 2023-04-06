<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookTypeControllerTest extends WebTestCase
{

    private string $fileName = __DIR__ . '/responses/BookTypeControllerTest_testGetBookTypes.json';

    public function testGetBookTypes(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/book-types');
        $responseContent = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonFile($this->fileName, $responseContent);

    }
}
