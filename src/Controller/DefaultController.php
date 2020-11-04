<?php

namespace App\Controller;

use App\Entity\Attribution;
use App\Entity\Computer;
use App\Repository\AttributionRepository;
use App\Repository\ComputerRepository;
use App\Repository\CustomerRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/api/computers", name="computers_list", methods={"GET"})
     */
    public function ComputerList(ComputerRepository $computerRepository, SerializerInterface $serializer, AttributionRepository $attributionRepository)
    {
        $computers = $computerRepository->findAll();
        $computerData = [];
        foreach ($computers as $computer){
        $attributions = [];

            foreach ($computer->getAttributions() as $computerAttr){
                $attributions[] = [
                    "id" => $computerAttr->getId(),
                    "customer" => $computerAttr->getCustomer()->getFirstName() . " " . $computerAttr->getCustomer()->getLastName() ,
                    "hour" => $computerAttr->getHour()
                ];
            }

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
    public function ComputerCreate(Request $request, ComputerRepository $computerRepository, AttributionRepository $attributionRepository, SerializerInterface $serializer)
    {

        $computer = new Computer();
        $data = json_decode($request->getContent(), true);
        $computer_name = $data['name'];

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
     * @Route("/api/computers/delete", name="computers_delete", methods={"POST"})
     */
    public function ComputerDelete()
    {

    }
    /**
     * @Route("/api/attributions", name="attribution_create", methods={"POST"})
     */
    public function getAttribution(Request $request, CustomerRepository  $customerRepository, ComputerRepository $computerRepository, SerializerInterface $serializer): Response
    {
        $attribution = new Attribution();
        $data = json_decode($request->getContent(), true);

        $customer = $customerRepository->find($data['id_client']);
        $computer = $computerRepository->find($data['id_ordinateur']);
        $attribution->setComputer($computer);
        $attribution->setCustomer($customer);
        $attribution->setHour($data['horaire']);

        $date = DateTime::createFromFormat('Y-m-d', $data['date']);
        $attribution->setDate($date);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($attribution);
        $entityManager->flush();

        $attributionData['attribution'] = [
            'id' => $attribution->getId(),
            'customer' => $attribution->getCustomer(),
            'computer' => $attribution->getComputer(),
            'date' => $attribution->getDate(),
            'hour' => $attribution->getHour()
            ];

        $computerData[] = [
            "id" => $attribution->getId(),
            'hour' => $attribution->getHour(),
            'customer' => $attribution->getCustomer()->getFirstName() . " " . $attribution->getCustomer()->getLastName(),
        ];

        $json = $serializer->serialize($computerData, 'json');
        return new Response($json);
    }
}
