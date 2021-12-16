<?php

namespace App\Repository;

use App\Entity\Patient;
use App\Entity\PersonContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PersonContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonContact[]    findAll()
 * @method PersonContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonContact::class);
    }
    public function createPersonContact($data, Patient $patient): PersonContact
    {
        $em = $this->getEntityManager();
        $personContact = new PersonContact();
        $personContact->setFirstName($data->personContact->firstName);
        $personContact->setLastName($data->personContact->lastName);
        $personContact->setPhone($data->personContact->phone);
        $personContact->setAddress($data->personContact->address);    
        $personContact->setPatient($patient);
        $em->persist($personContact);
        $em->flush();
        return $personContact;
    }
    // /**
    //  * @return PersonContact[] Returns an array of PersonContact objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PersonContact
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
