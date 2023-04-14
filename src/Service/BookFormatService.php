<?php

namespace App\Service;

use App\Entity\BookFormat;
use App\Exception\BookFormatNotFoundException;
use App\Model\BookFormatListItem;
use App\Model\BookFormatListResponse;
use App\Repository\BookFormatRepository;
use Doctrine\Common\Collections\Criteria;

class BookFormatService implements BookFormatServiceInterface
{
    public function __construct(private readonly BookFormatRepository $bookFormatRepository){}

    public function getBookFormats(): BookFormatListResponse
    {
        $bookFormats = $this->bookFormatRepository->findBy(['isDeleted' => false], ['title' => Criteria::ASC]);
        $items = array_map(
            fn (BookFormat $bookFormat) => new BookFormatListItem(
                $bookFormat->getId(), $bookFormat->getTitle(), $bookFormat->getSize(), $bookFormat->getSlug()
            ),
            $bookFormats
        );

        return new BookFormatListResponse($items);
    }

    public function getBookFormat(string $slug): ?BookFormatListItem
    {
        $bookFormat = $this->bookFormatRepository->findOneBy(["slug" => $slug, 'isDeleted' => false]);
        if (!$bookFormat) {
            throw new BookFormatNotFoundException(
                "No book format found for slug " . $slug
            );
        }

        return $this->getFormatListItem($bookFormat);
    }

    public function getBookFormatById(int $id): ?BookFormatListItem
    {
        $bookFormat = $this->bookFormatRepository->find($id);
        if (!$bookFormat) {
            throw new BookFormatNotFoundException(
                "No book format found for id " . $id
            );
        }

        return $this->getFormatListItem($bookFormat);
    }

    private function getFormatListItem(BookFormat $bookFormat): BookFormatListItem
    {
        return new BookFormatListItem(
            $bookFormat->getId(),
            $bookFormat->getTitle(),
            $bookFormat->getSize(),
            $bookFormat->getSlug()
        );
    }
}
