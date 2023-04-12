<?php

namespace App\Command\BookType;

use App\Exception\BookTypeNotFoundException;
use App\Repository\BookTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class UpdateBookTypeHandler implements UpdateBookTypeHandlerInterface
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly BookTypeRepository $bookTypeRepository
    )
    {
    }

    function handle(Request $request, int $id): void
    {
        $bookType = $this->bookTypeRepository->find($id);

        if (!$bookType) {
            throw new BookTypeNotFoundException(
                "No book type found for id " . $id
            );
        }

        $data = json_decode($request->getContent(), true);
        $bookType->setTitle($data['title']);
        $bookType->setSlug($data['title']); // пока так

        $this->entityManager->persist($bookType);
        $this->entityManager->flush();
    }

}
