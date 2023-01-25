<?php

namespace App\Factories;

use App\Entities\EntityInterface;
use Faker\Factory;
use Faker\Generator;

abstract class FakerFactory
{
    protected ?Generator $faker = null;

    public function __construct(?Factory $faker = null)
    {
        $this->faker = $faker ?? Factory::create();
    }

    abstract public function create(): EntityInterface;
}