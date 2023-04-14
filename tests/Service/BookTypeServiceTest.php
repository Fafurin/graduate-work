<?php

namespace App\Tests\Service;

use App\Entity\BookType;
use App\Model\BookTypeListItem;
use App\Model\BookTypeListResponse;
use App\Repository\BookTypeRepository;
use App\Service\BookTypeService;
use Doctrine\Common\Collections\Criteria;
use PHPUnit\Framework\TestCase;

class BookTypeServiceTest extends TestCase
{

    public function testGetBookTypes(): void
    {
        $repository = $this->createMock(BookTypeRepository::class);

        $repository->expects($this->once())
            ->method('findBy')
            ->with(['isDeleted' => false], ['title' => Criteria::ASC])
            ->willReturn([(new BookType())->setId(12)->setTitle('Test')->setSlug('test')]);

        $service = new BookTypeService($repository);

        $expectedResult = new BookTypeListResponse([new BookTypeListItem(12, 'Test', 'test')]);

        $this->assertEquals($expectedResult, $service->getBookTypes());

    }

    public function testGetBookType(): void
    {
        $repository = $this->createMock(BookTypeRepository::class);

        $repository->expects($this->once())
            ->method('findOneBy')
            ->with(['slug' => 'test', 'isDeleted' => false])
            ->willReturn((new BookType())->setId(12)->setTitle('Test')->setSlug('test'));

        $service = new BookTypeService($repository);

        $expectedResult = new BookTypeListItem(12, 'Test', 'test');

        $this->assertEquals($expectedResult, $service->getBookType('test'));
    }

    public function testGetBookTypeById(): void
    {
        $repository = $this->createMock(BookTypeRepository::class);

        $repository->expects($this->once())
            ->method('find')
            ->willReturn((new BookType())->setId(12)->setTitle('Test')->setSlug('test'));

        $service = new BookTypeService($repository);

        $expectedResult = new BookTypeListItem(12, 'Test', 'test');

        $this->assertEquals($expectedResult, $service->getBookTypeById(12));

    }

}
