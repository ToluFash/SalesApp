<?php

namespace App\Tests\Integration\Repository;

use App\Entity\Company;
use App\Entity\Sale;
use App\Repository\CompanyRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CompanyRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private CompanyRepository $companyRepository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->companyRepository = $this->entityManager
            ->getRepository(Company::class);
    }

    public function testFindAllCompaniesSalesSummary(): void
    {
        // Create some test companies
        $company1 = new Company();
        $company1->setName('Company 1');

        $company2 = new Company();
        $company2->setName('Company 2');

        $this->entityManager->persist($company1);
        $this->entityManager->persist($company2);

        $sale1 = new Sale();
        $sale1->setAmount(100);

        $sale2 = new Sale();
        $sale2->setAmount(100);

        $sale3 = new Sale();
        $sale3->setAmount(2);

        $this->entityManager->persist($sale1);
        $this->entityManager->persist($sale2);
        $this->entityManager->persist($sale3);

        $company1->addSale($sale1);
        $company1->addSale($sale2);
        $company2->addSale($sale3);

        $this->entityManager->flush();

        $salesSummary = $this->companyRepository->fetchAllCompaniesSalesSummary();

        $this->assertCount(2, $salesSummary);
        $this->assertEquals(200, $salesSummary[0]['sales_total']);
        $this->assertEquals(2, $salesSummary[1]['sales_total']);
        $this->assertEquals(2, $salesSummary[0]['sales_count']);
        $this->assertEquals(1, $salesSummary[1]['sales_count']);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->truncateTables([
            'company',
            'sale'
        ]);

        $this->entityManager->close();
    }

    /**
     * @throws Exception
     */
    private function truncateTables(array $tables): void
    {
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();

        foreach ($tables as $table) {
            $connection->executeStatement($platform->getTruncateTableSQL($table, true /* whether to cascade */));
        }
    }
}
