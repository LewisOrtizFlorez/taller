<?php

namespace App\Repository;

use App\Entity\Operator;
use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Operator|null find($id, $lockMode = null, $lockVersion = null)
 * @method Operator|null findOneBy(array $criteria, array $orderBy = null)
 * @method Operator[]    findAll()
 * @method Operator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operator::class);
    }

    public function getAllOperators()
    {
        $sql = "SELECT O, P, R FROM App\Entity\Operator O JOIN O.person P JOIN P.role R WHERE P.status = true";
        $query = $this->getEntityManager()->createQuery($sql);
        return $query->getResult();
    }

    public function createOperator(array $data, Person $person): Operator
    {
        $operator = new Operator();
        $operator->setEmail($data['email']);
        $operator->setPassword($data['password']);
        $operator->setPerson($person);
        $em = $this->getEntityManager();
        $em->persist($operator);
        $em->flush();
        return $operator;
    }

    public function deleteOperator(int $id)
    {
        try {
            $operator = $this->findOneBy(['id' => $id]);
            $em = $this->getEntityManager();
            $em->remove($operator);
            $em->flush(); 
            return "Operator $id is deleted.";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    // /**
    //  * @return Operator[] Returns an array of Operator objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Operator
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
