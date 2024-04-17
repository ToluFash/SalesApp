<?php

namespace App\Repository;

use App\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Company>
 *
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function fetchAll(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    public function fetchAllCompaniesSalesSummary(): array
    {
       return $this->getEntityManager()->createQuery(
            'SELECT c.id, c.name, COUNT(s.id) as sales_count, COALESCE(SUM(s.amount), 0) as sales_total
                    FROM App\Entity\Company c
                    LEFT JOIN App\Entity\Sale s WITH c.id = s.company
                GROUP BY c.id
                ORDER BY c.id ASC'
        )->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    public function fetchCompanySalesSummary(int $companyId): array
    {
       return $this
           ->getEntityManager()
           ->createQuery(
            'SELECT c.name, COALESCE(SUM(s.amount), 0) as sales_total
                    FROM App\Entity\Company c
                    LEFT JOIN App\Entity\Sale s WITH c.id = s.company
                    WHERE c.id = :company_id
                GROUP BY c.id
                ORDER BY c.id ASC')
           ->setParameter('company_id', $companyId)
           ->getResult(AbstractQuery::HYDRATE_ARRAY);
    }
}
