<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Hotel;
use App\Entity\Review;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ReviewFixture extends Fixture implements DependentFixtureInterface
{
    private const MAX_REVIEW_COUNT = 100000;

    public function load(ObjectManager $manager)
    {
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        $hotelIds = $this->getHotelIds($manager);

        $faker = Factory::create();

        for ($index = 0; $index < self::MAX_REVIEW_COUNT; $index++) {

            $hotelIndexer = rand(0, count($hotelIds)-1);
            $hotelId = $hotelIds[$hotelIndexer];

            $score = rand(0,10000)/100.00;

            $createdAt = $faker->dateTimeBetween('-2 years');

            $review = new Review();
            $review
                ->setHotelId($hotelId)
                ->setScore($score)
                ->setComment($faker->realText(512))
                ->setCreatedDate($createdAt);

            $manager->persist($review);
            $review = null;

            if ($index % 100 === 0) {
                $manager->flush();
                $manager->clear();
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            HotelFixture::class,
        ];
    }

    private function getHotelIds(ObjectManager $manager): array
    {
        $hotels = $manager->getRepository(Hotel::class)->findAll();

        $ids = [];

        /** @var Hotel $hotel */
        foreach ($hotels as $hotel) {
            $ids[] = $hotel->getId();
        }

        return $ids;
    }
}
