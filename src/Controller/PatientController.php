<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PatientRepository;
use App\Repository\PersonContactRepository;
use App\Repository\PersonRepository;
use App\Repository\RoleRepository;
use App\utilities\JsonResponse;
use App\utilities\ParseResponse;
use Doctrine\ORM\EntityManagerInterface;

class PatientController extends AbstractController
{
    private $parseResponse;

    public function __construct()
    {
        $this->parseResponse = new ParseResponse();
    }

    /**
     * @Route("/patients", name="patient", methods={"GET"})
     */
    public function index(PatientRepository $patientRepo): Response
    {
        $patients = $patientRepo->getAllPatients();
        $data = $this->parseResponse->parseArray($patients, new JsonResponse());
        return $this->json($data);
    }

    /**
     * @Route("/patient/{id}", name="patient_show", methods={"GET"})
     */
    public function show($id, PatientRepository $patientRepo)
    {
        $patient = $patientRepo->findOneBy(['id'=>$id]);
        if(!$patient){
            return $this->json(['message'=>'Pateint not found'], Response::HTTP_NOT_FOUND);
        }
        $data = $this->parseResponse->parseOne($patient, new JsonResponse());
        return $this->json($data);
    }

    /**
     * @Route("/patient", name="create_patient", methods={"POST"})
     */
    public function addPatient(Request $request, RoleRepository $roleRep, PatientRepository $patientRepo, PersonRepository $personRep, PersonContactRepository $personContectRep): Response
    {
        $data = json_decode($request->getContent());
        $role = $roleRep->findOneBy(['name' => $data->role]);
        $person = $personRep->createPerson([
            "firstName" => $data->firstName,
            "lastName" => $data->lastName,
            "phone" => $data->phone,
        ], $role);
        $patient = $patientRepo->createPatient($data, $person);
        $personContectRep->createPersonContact($data, $patient);
        
        $newPatient = $patientRepo->findOneBy(['id'=>$patient->getId()]);
        return $this->json([
            'New patient' => $this->parseResponse->parseOne($newPatient, new JsonResponse()),
        ]);
    }

    /**
     * @Route("/patient/{id}", name="update_patient", methods={"PUT"})
     */
    public function updateOperator($id, Request $request, RoleRepository $roleRep, PatientRepository $patientRepo, PersonRepository $personRep, EntityManagerInterface $em): Response 
    {
        $data = json_decode($request->getContent());

        $role = $roleRep->findOneBy(['name' => $data->role]);

        $patient = $patientRepo->findOneBy(['id'=>$id]);

        $patient->setInsureNumber($data->insureNumber);
        $patient->setAddress($data->address);
        $patient->setDob($data->dob);

        $patient->getPersonContact()->setFirstName($data->personContact->firstName);
        $patient->getPersonContact()->setLastName($data->personContact->lastName);
        $patient->getPersonContact()->setPhone($data->personContact->phone);
        $patient->getPersonContact()->setAddress($data->personContact->address);

        $person = $personRep->findOneBy(['id'=>$patient->getPerson()->getId()]);
        $person->setRole($role);
        $person->setFirstName($data->firstName);
        $person->setLastName($data->lastName);
        $person->setPhone($data->phone);

        
        $em->persist($patient);
        $em->persist($person);
        $em->flush();
        $newPatien = $this->parseResponse->parseOne($patient, new JsonResponse());
        return $this->json([
            'message'=>'Updated',
            'Patient'=>$newPatien
        ], 200);
    }

    /**
     * @Route("/patient/{id}", name="delete_patient", methods={"DELETE"})
     */
    public function deletePatient($id, PatientRepository $patientRepo): Response
    {
        $res = $patientRepo->deletePatient($id);
        return $this->json(['message' => $res]);
    }
}
