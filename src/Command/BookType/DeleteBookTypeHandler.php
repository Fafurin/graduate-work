<?php

namespace App\Command\BookType;

use App\Exception\BookTypeNotFoundException;
use App\Repository\BookTypeRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeleteBookTypeHandler implements DeleteBookTypeHandlerInterface
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly BookTypeRepository     $bookTypeRepository
    )
    {
    }

    function handle(int $id): void
    {
        $bookType = $this->bookTypeRepository->find($id);

        if (!$bookType) {
            throw new BookTypeNotFoundException(
                "No book type found for id " . $id
            );
        }
        $bookType->setIsDeleted(true);

        $this->entityManager->persist($bookType);
        $this->entityManager->flush();
    }

}
