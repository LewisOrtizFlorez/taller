<?php

namespace App\Controller;

use App\Entity\Operator;
use App\Repository\OperatorRepository;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
    public function addOperator(Request $request, RoleRepository $roleRep, OperatorRepository $operatorRepo, UserRepository $userRepo): Response
    {
        // $operators = $operatorRep->findAll();
        $role = $roleRep->findOneBy(['name' => 'Technologist']);
        $user = $userRepo->createUser([
            "firstName" => $request->get('firstName', null),
            "lastName" => $request->get('lastName', null),
            "phone" => $request->get('phone', null),
        ], $role);
        $operator = $operatorRepo->createOperator([
            "email" => $request->get('email', null),
            "password" => $request->get('password', null),
        ], $user);
        return $this->json([
            'New opertator' => $operator,
        ]);
    }
}
