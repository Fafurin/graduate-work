<?php

namespace App\Controller;

use App\Command\BookFormat\CreateBookFormatHandlerInterface;
use App\Command\BookFormat\DeleteBookFormatHandlerInterface;
use App\Command\BookFormat\UpdateBookFormatHandlerInterface;
use App\Model\BookFormatListItem;
use App\Model\BookFormatListResponse;
use App\Service\BookFormatServiceInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookFormatController extends AbstractController
{
    public function __construct(
        private readonly BookFormatServiceInterface $bookFormatService,
        private readonly CreateBookFormatHandlerInterface $createBookFormatHandler,
        private readonly UpdateBookFormatHandlerInterface $updateBookFormatHandler,
        private readonly DeleteBookFormatHandlerInterface $deleteBookFormatHandler,
    ){}

    #[Route('/api/v1/book-formats', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns book formats',
        content: new Model(type: BookFormatListResponse::class)
    )]
    public function get(): Response
    {
        return $this->json($this->bookFormatService->getBookFormats());
    }

    #[Route('/api/v1/book-format/create', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Create new book format'
    )]
    public function create(Request $request): Response
    {
        $this->createBookFormatHandler->handle($request);

        return $this->json(['book format' => 'saved']);
    }

    #[Route('/api/v1/book-format/{slug}', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return book format by slug',
        content: new Model(type: BookFormatListItem::class)
    )]
    public function show(string $slug): Response
    {
        return $this->json($this->bookFormatService->getBookFormat($slug));
    }

    #[Route('/api/v1/book-format/{id}/get', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return book format by id',
        content: new Model(type: BookFormatListItem::class)
    )]
    public function getOneById(int $id): Response
    {
        return $this->json($this->bookFormatService->getBookFormatById($id));
    }

    #[Route('/api/v1/book-format/{id}/update', methods: ['PUT'])]
    #[OA\Response(
        response: 200,
        description: 'Update book format by id'
    )]
    public function update(Request $request, int $id): Response
    {
        $this->updateBookFormatHandler->handle($request, $id);

        return $this->json(['book format' => 'updated']);
    }

    #[Route('/api/v1/book-format/{id}/delete', methods: ['DELETE'])]
    #[OA\Response(
        response: 200,
        description: 'Update book format by id'
    )]
    public function delete(int $id): Response
    {
        $this->deleteBookFormatHandler->handle($id);

        return $this->json(['book format' => 'deleted']);
    }
}
