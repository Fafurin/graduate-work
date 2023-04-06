<?php

namespace App\DataFixtures;

use App\Entity\BookType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist((new BookType())->setTitle('Monograph')->setSlug('monograph'));
        $manager->persist((new BookType())->setTitle('Scientific journal')->setSlug('scientific-journal'));
        $manager->persist((new BookType())->setTitle('Study guide')->setSlug('study-guide'));

        $manager->flush();
    }
}
