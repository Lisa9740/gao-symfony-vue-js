<?php

namespace App\Controller;

use App\Entity\Computer;
use App\Repository\ComputerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ComputerController extends AbstractController
{
    /**
     * @Route("/computer", name="computer")
     */
    public function index(): Response
    {
        return $this->render('computer/index.html.twig', [
            'controller_name' => 'ComputerController',
        ]);
    }

    /**
     * @Route("/api/computers", name="computers_list", methods={"GET"})
     */
    public function ComputerList(Request $request, ComputerRepository $computerRepository, SerializerInterface $serializer)
    {

        $date = $request->query->get('date');
        $computerData = [];

        // get computers with its attributions
        $computers = $computerRepository->findAll();
        foreach ($computers as $computer){
            $attributions = [];
            foreach ($computer->getAttributions() as $attr){
                $attributionDate = $attr->getDate()->format('Y-m-d');
                $customerName    =  $attr->getCustomer()->getFirstName() . " " . $attr->getCustomer()->getLastName();

                if ($date === $attributionDate) {
                    $attributions[] = [
                        "id" => $attr->getId(),
                        "customer" => $customerName,
                        "hour" => $attr->getHour(),
                        "date" => $attributionDate
                    ];
                }
            }

            // format in array computer data
            $computerData[] = [
                'id' => $computer->getId(),
                'name' => $computer->getName(),
                'attributions' => $attributions
            ];

        }

        $json = $serializer->serialize($computerData, 'json');
        return new Response($json);
    }

    /**
     * @Route("/api/computers/create", name="computers_create", methods={"POST", "GET"})
     */
    public function ComputerCreate(Request $request, SerializerInterface $serializer)
    {
        $data = json_decode($request->getContent(), true);
        $computer_name = $data['name'];

        $computer = new Computer();
        $computer->setName($computer_name);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($computer);
        $entityManager->flush();

        $computerData = [
            'id' => $computer->getId(),
            'name' => $computer->getName(),
            'attributions' => 'undefined'
        ];

        $json = $serializer->serialize($computerData, 'json');
        return new Response($json);
    }

    /**
     * @Route("/api/computers/{id}/delete", name="computers_delete", methods={"POST"})
     */
    public function ComputerDelete()
    {

    }
}
