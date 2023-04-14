<?php

namespace App\Command\BookFormat;

use App\Exception\BookFormatNotFoundException;
use App\Repository\BookFormatRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeleteBookFormatHandler implements DeleteBookFormatHandlerInterface
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly BookFormatRepository     $bookFormatRepository
    )
    {
    }

    function handle(int $id): void
    {
        $bookFormat = $this->bookFormatRepository->find($id);

        if (!$bookFormat) {
            throw new BookFormatNotFoundException(
                "No book format found for id " . $id
            );
        }
        $bookFormat->setIsDeleted(true);

        $this->entityManager->persist($bookFormat);
        $this->entityManager->flush();
    }

}
