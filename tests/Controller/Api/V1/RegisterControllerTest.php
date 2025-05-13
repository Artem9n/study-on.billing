<?php

namespace App\Tests\Controller\Api\V1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterControllerTest extends WebTestCase
{
    public function testRegister() : void
    {
        $client = static::createClient();

        $crawler = $client->jsonRequest('POST', '/api/v1/register', [
            'username' => 'test@test.ru',
            'password' => 'test@test.ru',
        ]);

        self::assertResponseIsSuccessful();

        $response = $client->getResponse()->getContent();

        $data = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        self::assertIsArray($data);
        self::assertNotEmpty($data, 'Получили пустой ответ');
        self::assertArrayHasKey('token', $data);
        self::assertArrayHasKey('roles', $data);
    }
}