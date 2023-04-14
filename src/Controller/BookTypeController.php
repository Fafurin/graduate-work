<?php

namespace App\Controller;

use App\Command\BookType\CreateBookTypeHandlerInterface;
use App\Command\BookType\DeleteBookTypeHandlerInterface;
use App\Command\BookType\UpdateBookTypeHandlerInterface;
use App\Model\BookTypeListItem;
use App\Model\BookTypeListResponse;
use App\Service\BookTypeServiceInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookTypeController extends AbstractController
{
    public function __construct(
        private readonly BookTypeServiceInterface         $bookTypeService,
        private readonly CreateBookTypeHandlerInterface   $createBookTypeHandler,
        private readonly UpdateBookTypeHandlerInterface $updateBookTypeHandler,
        private readonly DeleteBookTypeHandlerInterface $deleteBookTypeHandler,
    ){}

    #[Route('/api/v1/book-types', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns book types',
        content: new Model(type: BookTypeListResponse::class)
    )]
    public function get(): Response
    {
        return $this->json($this->bookTypeService->getBookTypes());
    }

    #[Route('/api/v1/book-type/create', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Create new book type'
    )]
    public function create(Request $request): Response
    {
        $this->createBookTypeHandler->handle($request);

        return $this->json(['book type' => 'saved']);
    }

    #[Route('/api/v1/book-type/{slug}', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return book type by slug',
        content: new Model(type: BookTypeListItem::class)
    )]
    public function show(string $slug): Response
    {
        return $this->json($this->bookTypeService->getBookType($slug));
    }

    #[Route('/api/v1/book-type/{id}/get', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return book type by id',
        content: new Model(type: BookTypeListItem::class)
    )]
    public function getOneById(int $id): Response
    {
        return $this->json($this->bookTypeService->getBookTypeById($id));
    }

    #[Route('/api/v1/book-type/{id}/update', methods: ['PUT'])]
    #[OA\Response(
        response: 200,
        description: 'Update book type by id'
    )]
    public function update(Request $request, int $id): Response
    {
        $this->updateBookTypeHandler->handle($request, $id);

        return $this->json(['book type' => 'updated']);
    }

    #[Route('/api/v1/book-type/{id}/delete', methods: ['DELETE'])]
    #[OA\Response(
        response: 200,
        description: 'Update book type by id'
    )]
    public function delete(int $id): Response
    {
        $this->deleteBookTypeHandler->handle($id);

        return $this->json(['book type' => 'deleted']);
    }
}
