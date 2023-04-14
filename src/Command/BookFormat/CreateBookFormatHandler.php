<?php

namespace App\Command\BookFormat;

use App\Entity\BookFormat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CreateBookFormatHandler implements CreateBookFormatHandlerInterface
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    function handle(Request $request): void
    {
        $bookFormat = new BookFormat();

        $data = json_decode($request->getContent(), true);
        $bookFormat->setTitle($data['title']);
        $bookFormat->setSize($data['size']);
        $bookFormat->setSlug($data['title']); // пока так

        $this->entityManager->persist($bookFormat);
        $this->entityManager->flush();
    }
}
