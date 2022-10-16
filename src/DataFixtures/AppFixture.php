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
        for ($i = 0; $i < 10; $i++)
        {
            $booking = new BookingRequest();
            $booking->setTitle($faker->title);
            $booking->setDescription($faker->realText());
            $dayStart = $faker->dateTime();
            $booking->setDateStart($dayStart);
            $booking->setDateEnd($dayStart+86400);
            $booking->setFio($faker->name);
            $booking->setTel($faker->e164PhoneNumber);


            dd($booking);
        }

    }
}
