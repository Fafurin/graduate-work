<?php

namespace App\Controller;

use App\Service\BookTypeServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookTypeController extends AbstractController
{
    public function __construct(private readonly BookTypeServiceInterface $bookTypeService)
    {
    }

    #[Route('/api/v1/book_types')]
    public function getBookTypes(): Response
    {
        return $this->json($this->bookTypeService->getBookTypes());
    }
}
