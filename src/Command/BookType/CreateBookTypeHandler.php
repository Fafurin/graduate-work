<?php

namespace App\Command\BookType;

use App\Entity\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CreateBookTypeHandler implements CreateBookTypeHandlerInterface
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    function handle(Request $request): void
    {
        $bookType = new BookType();

        $data = json_decode($request->getContent(), true);
        $bookType->setTitle($data['title']);
        $bookType->setSlug($data['title']); // пока так

        $this->entityManager->persist($bookType);
        $this->entityManager->flush();
    }
}
