<?php

namespace App\Command\BookFormat;

use App\Exception\BookFormatNotFoundException;
use App\Repository\BookFormatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class UpdateBookFormatHandler implements UpdateBookFormatHandlerInterface
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly BookFormatRepository $bookFormatRepository
    )
    {
    }

    function handle(Request $request, int $id): void
    {
        $bookFormat = $this->bookFormatRepository->find($id);

        if (!$bookFormat) {
            throw new BookFormatNotFoundException(
                "No book format found for id " . $id
            );
        }

        $data = json_decode($request->getContent(), true);
        $bookFormat->setTitle($data['title']);
        $bookFormat->setSize($data['size']);
        $bookFormat->setSlug($data['title']); // пока так

        $this->entityManager->persist($bookFormat);
        $this->entityManager->flush();
    }

}
