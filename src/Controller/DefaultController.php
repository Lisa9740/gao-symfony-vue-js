<?php

namespace App\Controller;

use App\Entity\Computer;
use App\Repository\ComputerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/computers", name="computers_list")
     */
    public function ComputerIndex(ComputerRepository $computerRepository)
    {
        $computers = $computerRepository->findAll();
        $computers->serialize =
        dump($computers);
        return new JsonResponse($computers, Response::HTTP_OK);
    }
}
