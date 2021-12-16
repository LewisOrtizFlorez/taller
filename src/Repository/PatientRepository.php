<?php

namespace App\Repository;

use App\Entity\Patient;
use App\Entity\Person;
use App\Entity\PersonContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patient[]    findAll()
 * @method Patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patient::class);
    }

    public function getAllPatients()
    {
        $sql = "SELECT U, P, R FROM App\Entity\Patient U 
            JOIN U.person P 
            JOIN P.role R 
            WHERE P.status = true AND R.name = :role";
        $query = $this->getEntityManager()->createQuery($sql)->setParameter("role", "Patient");
        return $query->getResult();
    }

    public function createPatient($data, Person $person): Patient
    {
        $em = $this->getEntityManager();
        $patient = new Patient();
        $patient->setInsureNumber($data->insureNumber);
        $patient->setAddress($data->address);
        $patient->setDob($data->dob);
        $patient->setPerson($person);
        $em->persist($patient);        
        $em->flush();
        return $patient;
    }

    public function deletePatient(int $id)
    {
        try {
            $patient = $this->findOneBy(['id' => $id]);
            $em = $this->getEntityManager();
            $em->remove($patient);
            $em->flush(); 
            return "Patient $id is deleted.";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // /**
    //  * @return Patient[] Returns an array of Patient objects
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
    public function findOneBySomeField($value): ?Patient
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
