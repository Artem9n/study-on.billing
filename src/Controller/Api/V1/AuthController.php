<?php

namespace App\Controller\Api\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

class AuthController extends AbstractController
{
    #[Route('/api/v1/auth', name: 'api_v1_login', methods: ['POST'])]
    #[OA\Post(
        summary: 'Authorize user',
        requestBody: new OA\RequestBody(
            description: 'JSON Payload',
            required: true,
            content: new OA\JsonContent(
                required: ['username', 'password'],
                properties: [
                    new OA\Property(property: 'username', type: 'string', example: 'user@study-on.ru'),
                    new OA\Property(property: 'password', type: 'string', example: 'password123'),
                ],
                type: 'object'
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Auth successful',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'token', type: 'string'),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'code',
                            type: 'integer',
                            example: 401,
                        ),
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Invalid credentials.',
                        )
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Bad request',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'code',
                            type: 'integer',
                            example: 400,
                        ),
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: "The key \"username\" must be provided.",
                        )
                    ],
                    type: 'object'
                )
            )
        ]
    )]

    public function login(): void
    {
        throw new BadRequestHttpException('This method should not be called directly.');
    }
}