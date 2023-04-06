<?php

namespace App\Service;

use App\Entity\BookType;
use App\Model\BookTypeListItem;
use App\Model\BookTypeListResponse;
use App\Repository\BookTypeRepository;
use Doctrine\Common\Collections\Criteria;

class BookTypeService implements BookTypeServiceInterface
{
    public function __construct(private readonly BookTypeRepository $bookTypeRepository)
    {
    }

    public function getBookTypes(): BookTypeListResponse
    {
        $bookTypes = $this->bookTypeRepository->findBy([], ['title' => Criteria::ASC]);
        $items = array_map(
            fn (BookType $bookType) => new BookTypeListItem(
                $bookType->getId(), $bookType->getTitle(), $bookType->getSlug()
            ),
            $bookTypes
        );

        return new BookTypeListResponse($items);
    }
}
