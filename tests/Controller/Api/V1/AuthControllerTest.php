<?php

namespace App\Tests\Controller\Api\V1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthControllerTest extends WebTestCase
{
    public function testLogin() : void
    {
        $client = static::createClient();

        $crawler = $client->jsonRequest('POST', '/api/v1/auth', [
            'username' => 'admin@admin.ru',
            'password' => 'admin@admin.ru',
        ]);

        self::assertResponseIsSuccessful();

        $response = $client->getResponse()->getContent();

        $content = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        self::assertIsArray($content);
        self::assertNotEmpty($content, 'Получили пустой ответ');
        self::assertArrayHasKey('token', $content);
    }
}