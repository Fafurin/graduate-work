<?php

namespace App\Controller;

use App\Repository\BookTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookTypeController extends AbstractController
{
    public function __construct(private readonly BookTypeRepository $bookTypeRepository)
    {
    }

    #[Route('/api/v1/book_types')]
    public function root(): Response
    {
        return $this->json($this->bookTypeRepository->findAll());
    }
}
