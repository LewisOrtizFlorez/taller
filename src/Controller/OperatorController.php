<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OperatorRepository;
use App\Repository\RoleRepository;
use App\Repository\PersonRepository;
use App\utilities\JsonResponse;
use App\utilities\ParseResponse;

class OperatorController extends AbstractController
{

    private $parseResponse;
    public function __construct()
    {
        $this->parseResponse = new ParseResponse();
    }

    /**
     * @Route("/operators", name="operators", methods={"GET"})
     */
    public function operators(OperatorRepository $operatorRepo): Response
    {
        $operators = $operatorRepo->getAllOperators();
        $data = $this->parseResponse->parseArray($operators, new JsonResponse());
        return $this->json($data);
    }

    /**
     * @Route("/operator/{id}", name="operator", methods={"GET"})
     */
    public function findOperator($id, OperatorRepository $operator): Response
    {
        $operator = $operator->findOneBy(['id'=>$id]);
        if(!$operator){
            return $this->json(['message'=>'Operator not found'], Response::HTTP_NOT_FOUND);
        }
        
        $data = $this->parseResponse->parseOne($operator, new JsonResponse());
        return $this->json($data);
    }

    /**
     * @Route("/operator", name="create_operator", methods={"POST"})
     */
    public function addOperator(Request $request, RoleRepository $roleRep, OperatorRepository $operatorRepo, PersonRepository $personRep): Response
    {
        $data = json_decode($request->getContent());
        $role = $roleRep->findOneBy(['name' => $data->role]);
        $person = $personRep->createPerson([
            "firstName" => $data->firstName,
            "lastName" => $data->lastName,
            "phone" => $data->phone,
        ], $role);

        $operator = $operatorRepo->createOperator([
            "email" => $data->email,
            "password" => $data->password,
        ], $person);
        $newOperator = $this->parseResponse->parseOne($operator, new JsonResponse());
        return $this->json([
            'New opertator' => $newOperator,
        ]);
    }

    /**
     * @Route("/operator/{id}", name="update_operator", methods={"PUT"})
     */
    public function updateOperator($id, Request $request, RoleRepository $roleRep, OperatorRepository $operatorRepo, PersonRepository $personRep, EntityManagerInterface $em): Response 
    {
        $data = json_decode($request->getContent());
        
        $role = $roleRep->findOneBy(['name' => $data->role]);
        $operator = $operatorRepo->findOneBy(['id'=>$id]);
        $operator->setEmail($data->email);
        $operator->setPassword($data->password);

        $person = $personRep->findOneBy(['id'=>$operator->getPerson()->getId()]);
        $person->setRole($role);
        $person->setFirstName($data->firstName);
        $person->setLastName($data->lastName);
        $person->setPhone($data->phone);
        
        $em->persist($operator);
        $em->persist($person);
        $em->flush();

        $newOperator = $this->parseResponse->parseOne($operator, new JsonResponse());

        return $this->json([
            'message'=>'Updated',
            'operator'=>$newOperator
        ]);
    }

    /**
     * @Route("/operator/{id}", name="delete_operator", methods={"DELETE"})
     */
    public function deleteOperator($id, OperatorRepository $operatorRepo): Response
    {
        $res = $operatorRepo->deleteOperator($id);
        return $this->json(['message' => $res]);
    }
}
