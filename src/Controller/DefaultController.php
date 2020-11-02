<?php

namespace App\Controller;

use App\Entity\Computer;
use App\Repository\ComputerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

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
     * @Route("/api/computers", name="computers_list")
     */
    public function ComputerList(ComputerRepository $computerRepository, SerializerInterface $serializer)
    {
        $computers = $computerRepository->findAll();
        $json = $serializer->serialize($computers, 'json');

       return new Response($json);
    }
}
