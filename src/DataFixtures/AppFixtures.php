<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Sale;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private const COMPANIES = [
        'Super Insurers' => [
            '0.50',
            '1.22',
        ],
        'Quality Insurance Co' => [],
        'Insure-u-like' => [
            '0.77',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::COMPANIES as $name => $salesAmount) {
            $company = new Company();
            $company->setName($name);

            $manager->persist($company);

            foreach ($salesAmount as $saleAmount) {
                $sale = new Sale();
                $sale->setAmount($saleAmount);

                $manager->persist($sale);
                $company->addSale($sale);
            }
        }

        $manager->flush();
    }
}
