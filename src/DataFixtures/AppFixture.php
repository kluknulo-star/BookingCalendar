<?php

namespace App\DataFixtures;

use App\Entity\BookingRequest;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixture extends Fixture
{
    protected $faker;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 1; $i++)
        {
            $booking = new BookingRequest();
            $booking->setTitle($faker->sentence());
            $booking->setDescription($faker->realText());
            $booking->setDateStart($faker->dateTimeBetween($startDate = '-1 day', $endDate = 'now', $timezone = null));
            $booking->setDateFinish($faker->dateTimeBetween($startDate = 'now', $endDate = '+1 day', $timezone = null));
            $booking->setFullName($faker->name);
            $booking->setPhone($faker->e164PhoneNumber);
            $booking->setIdRoom(rand(1,3));
            $booking->setIdUserCreate(0);

            $manager->persist($booking);
//            dump($booking);
        }

        $manager->flush();

    }
}
