<?php

namespace App\DataFixtures;

use App\Entity\BookingRequest;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixture extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    protected $faker;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $booking = new BookingRequest();
            $booking->setTitle($faker->sentence());
            $booking->setDescription($faker->realText());
            $booking->setDateStart($faker->dateTimeBetween($startDate = '-1 day', $endDate = 'now', $timezone = null));
            $booking->setDateFinish($faker->dateTimeBetween($startDate = 'now', $endDate = '+1 day', $timezone = null));
            $booking->setFullName($faker->name);
            $booking->setPhone($faker->e164PhoneNumber);
            $booking->setIdRoom(rand(1, 3));
            $booking->setIdUserCreate(0);

            $manager->persist($booking);
        }

        $userWithRoles = [
            [
                'email' => 'admin@admin.ru',
                'role' => "ROLE_ADMIN"],
            [
                'email' => 'user@user.ru',
                'role' => "ROLE_USER"],
            [
                'email' => 'manager@manager.ru',
                'role' => "ROLE_MANAGER"]
        ];

        foreach ($userWithRoles as $userWithRole) {
            $user = new User();
            $user->setEmail($userWithRole['email']);
            $user->setRoles([$userWithRole['role']]);

            $user->setPassword(
                $this->hasher->hashPassword(
                    $user,
                    $userWithRole['email']
                )
            );

            $manager->persist($user);
        }

        $manager->flush();

    }
}
