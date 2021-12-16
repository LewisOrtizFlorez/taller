<?php

namespace App\Controller;

use App\Repository\OperatorRepository;
use App\Repository\RoleRepository;
use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OperatorController extends AbstractController
{

    /**
     * @Route("/operator", name="operators", methods={"GET"})
     */
    public function operators(OperatorRepository $operatorRepo): Response
    {
        return $this->json($operatorRepo->getAllOperators(), 200, [], [
            'groups' => ['operator:read']
        ]);
    }

    /**
     * @Route("/operator/{id}", name="operator", methods={"GET"})
     */
    public function findOperator($id, OperatorRepository $operator): Response
    {
         return $this->json($operator->findOneBy(['id'=>$id]), 200, [], [
            'groups' => ['operator:read']
        ]);
    }

    /**
     * @Route("/operator", name="create_operator", methods={"POST"})
     */
    public function addOperator(Request $request, RoleRepository $roleRep, OperatorRepository $operatorRepo, PersonRepository $personRep): Response
    {
        $role = $roleRep->findOneBy(['name' => $request->request->get('role', null)]);
        $person = $personRep->createPerson([
            "firstName" => $request->get('firstName', null),
            "lastName" => $request->get('lastName', null),
            "phone" => $request->get('phone', null),
        ], $role);
        $operator = $operatorRepo->createOperator([
            "email" => $request->get('email', null),
            "password" => $request->get('password', null),
        ], $person);
        return $this->json([
            'New opertator' => $operator,
        ]);
    }
}
