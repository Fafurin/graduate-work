<?php

namespace App\Controller;

use App\Model\BookTypeListResponse;
use App\Service\BookTypeServiceInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookTypeController extends AbstractController
{
    public function __construct(private readonly BookTypeServiceInterface $bookTypeService)
    {
    }

    #[Route('/api/v1/book-types', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns book types',
        content: new Model(type: BookTypeListResponse::class)
    )]
    public function getBookTypes(): Response
    {
        return $this->json($this->bookTypeService->getBookTypes());
    }
}
