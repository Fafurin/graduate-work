<?php

namespace App\Service;

use App\Entity\BookType;
use App\Exception\BookTypeNotFoundException;
use App\Model\BookTypeListItem;
use App\Model\BookTypeListResponse;
use App\Repository\BookTypeRepository;
use Doctrine\Common\Collections\Criteria;

class BookTypeService implements BookTypeServiceInterface
{
    public function __construct(private readonly BookTypeRepository $bookTypeRepository){}

    public function getBookTypes(): BookTypeListResponse
    {
        $bookTypes = $this->bookTypeRepository->findBy(['isDeleted' => false], ['title' => Criteria::ASC]);
        $items = array_map(
            fn (BookType $bookType) => new BookTypeListItem(
                $bookType->getId(), $bookType->getTitle(), $bookType->getSlug()
            ),
            $bookTypes
        );

        return new BookTypeListResponse($items);
    }

    public function getBookType(string $slug): ?BookTypeListItem
    {
        $bookType = $this->bookTypeRepository->findOneBy(["slug" => $slug, 'isDeleted' => false]);
        if (!$bookType) {
            throw new BookTypeNotFoundException(
                "No book type found for slug " . $slug
            );
        }

        return $this->getTypeListItem($bookType);
    }

    public function getBookTypeById(int $id): ?BookTypeListItem
    {
        $bookType = $this->bookTypeRepository->find($id);
        if (!$bookType) {
            throw new BookTypeNotFoundException(
                "No book type found for id " . $id
            );
        }

        return $this->getTypeListItem($bookType);
    }

    private function getTypeListItem(BookType $bookType): BookTypeListItem
    {
        return new BookTypeListItem(
            $bookType->getId(),
            $bookType->getTitle(),
            $bookType->getSlug()
        );
    }
}
