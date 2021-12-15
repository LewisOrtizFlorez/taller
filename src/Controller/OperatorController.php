<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OperatorController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response{
        return $this->json([
            'message' => 'Welcome to the API :v'
        ]);
    }

    /**
     * @Route("/operator", name="operator")
     */
    public function operator(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/OperatorController.php',
        ]);
    }
}
