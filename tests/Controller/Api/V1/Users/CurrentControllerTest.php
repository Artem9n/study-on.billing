<?php

namespace App\Tests\Controller\Api\V1\Users;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CurrentControllerTest extends WebTestCase
{
    public function testUserCurrent() : void
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

        $token = $content['token'];

        self::assertNotEmpty($token);

        $crawler = $client->jsonRequest('GET', '/api/v1/users/current', [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $token,
        ]);

        self::assertResponseIsSuccessful();

        $response = $client->getResponse()->getContent();
        $content = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        self::assertIsArray($content);
        self::assertNotEmpty($content, 'Получили пустой ответ');
        self::assertEquals('admin@admin.ru', $content['username']);
        self::assertEquals(42.23, $content['balance']);
    }
}