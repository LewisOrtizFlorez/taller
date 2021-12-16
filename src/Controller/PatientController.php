<?php

namespace App\Controller;

use App\Repository\PatientRepository;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
{
    /**
     * @Route("/patient", name="patient")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PatientController.php',
        ]);
    }
    /**
     * @Route("/patient", name="create_operator", methods={"POST"})
     */
    public function addPateint(Request $request, RoleRepository $roleRep, PatientRepository $patient, UserRepository $userRepo): Response
    {
        // $operators = $operatorRep->findAll();
        $role = $roleRep->findOneBy(['name' => 'Technologist']);
        $user = $userRepo->createUser([
            "firstName" => $request->get('firstName', null),
            "lastName" => $request->get('lastName', null),
            "phone" => $request->get('phone', null),
        ], $role);
        $operator = $patient->createPatient([
            "email" => $request->get('email', null),
            "password" => $request->get('password', null),
        ], $user);
        return $this->json([
            'New opertator' => $operator,
        ]);
    }
}
