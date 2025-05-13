<?php

namespace App\Controller\Api\V1\Users;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;

class CurrentController extends AbstractController
{
    #[Route('/api/v1/users/current', name: 'api_v1_user_current', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Current user',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'username', type: 'string', example: 'user@study-on.ru'),
                new OA\Property(
                    property: 'roles',
                    type: 'array',
                    items: new OA\Items(type: 'string'),
                    example: ['ROLE_USER']
                ),
                new OA\Property(property: 'balance', type: 'float', example: 42.22),
            ],
            type: 'object'
        )
    )]
    #[Security(name: 'Bearer')]
    public function current(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user) {
            return $this->json([
                'code' => 401,
                'message' => 'User not found'
            ], 401);
        }

        return $this->json([
            'username' => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
            'balance' => $user->getBalance(),
        ]);
    }
}