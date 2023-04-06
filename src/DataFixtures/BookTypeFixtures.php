<?php

namespace App\DataFixtures;

use App\Entity\BookType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist((new BookType())->setTitle('Монография')->setSlug('monografiya'));
        $manager->persist((new BookType())->setTitle('Научный журнал')->setSlug('nauchnyy-zhurnal'));
        $manager->persist((new BookType())->setTitle('Учебное пособие')->setSlug('uchebnoe-posobie'));

        $manager->flush();
    }
}
