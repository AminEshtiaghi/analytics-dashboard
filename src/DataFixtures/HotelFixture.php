<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Hotel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HotelFixture extends Fixture
{
    private const MAX_HOTELS_COUNT = 10;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($index = 0; $index < self::MAX_HOTELS_COUNT; $index++) {
            $hotel = new Hotel();
            $hotel->setName($faker->company());

            $manager->persist($hotel);
        }

        $manager->flush();
    }
}
