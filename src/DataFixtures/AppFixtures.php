<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Autorisation;
use App\Entity\Employee;
use App\Entity\Notification;
use App\Entity\Societe;
use App\Repository\EmploiyeeRepository;
use App\Repository\EmployeeRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher,EmployeeRepository $emploiyeeRepository)
    {
        $this->hasher = $hasher;
        $this->emploiyeeRepository=$emploiyeeRepository;
    }
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create("fr_FR");
        for ($i = 0; $i <= 50; $i++) {
            $societe = new Societe();
            $societe
                ->setNom($faker->name)
                ->setHeureDebutTravail($faker->dateTime)
                ->setHeureFinTravail($faker->dateTime)
                ->setDureePause("de 12h a 13h")
                ->setLocalisation("Tunisie")
                ->setNombreEmloyee(51);
            $manager->persist($societe);

                $employee=new Employee();
                $password = $this->hasher->hashPassword($employee, '90145781');
                $employee
                    ->setRoles(['ROLE_EMPLOYEE'])
                    ->setEmail($faker->email)
                    ->setPassword($password)
                    ->setNom($faker->firstName)
                    ->setPrenom($faker->lastName)
                    ->setNaissance($faker->dateTime);
                $manager->persist($employee);


            }


            $manager->flush();
        }
    }
