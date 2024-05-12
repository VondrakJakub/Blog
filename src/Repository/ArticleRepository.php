<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

  /**
     * Vrací články patřící určitému autorovi.
     *
     * @param int $authorId ID autora článků
     * @return Article[] Pole článků patřících autorovi
     */
    public function findByAuthor(int $authorId): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.author = :authorId')
            ->setParameter('authorId', $authorId)
            ->getQuery()
           ->getResult();
    }

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
