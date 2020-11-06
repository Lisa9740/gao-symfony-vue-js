<?php

namespace App\Controller;

use App\Entity\Attribution;
use App\Entity\Customer;
use App\Repository\AttributionRepository;
use App\Repository\ComputerRepository;
use App\Repository\CustomerRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AttributionController extends AbstractController
{
    /**
     * @Route("/api/attributions", name="attribution_create", methods={"POST"})
     */
    public function getAttribution(Request $request, CustomerRepository  $customerRepository, ComputerRepository $computerRepository, SerializerInterface $serializer): Response
    {
        $attribution = new Attribution();
        $data = json_decode($request->getContent(), true);

        $entityManager = $this->getDoctrine()->getManager();

        if (!isset($data['id_client'])){
            $customer = new Customer();
            $customer->setFirstName($data['firstname'])
                ->setLastName($data['lastname']);
            $entityManager->persist($customer);
        }else {
            $customer = $customerRepository->find($data['id_client']);
        }

        $computer = $computerRepository->find($data['id_ordinateur']);
        $attribution->setComputer($computer)
            ->setCustomer($customer)
            ->setHour($data['horaire']);

        $date = DateTime::createFromFormat('Y-m-d', $data['date']);
        $attribution->setDate($date);


        $entityManager->persist($attribution);
        $entityManager->flush();

        $computerData[] = [
            "id" => $attribution->getId(),
            'hour' => $attribution->getHour(),
            'date' => $attribution->getDate(),
            'customer' => $attribution->getCustomer()->getFirstName() . " " . $attribution->getCustomer()->getLastName(),
        ];

        $json = $serializer->serialize($computerData, 'json');
        return new Response($json);
    }

    /**
     * @Route("/api/attributions/remove", name="attribution_delete")
     * @return Response
     */
    public function remove(Request $request, AttributionRepository $attributionRepository)
    {
        $data = json_decode($request->getContent(), true);
        $attribution = $attributionRepository->find($data['id']);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($attribution);
        $entityManager->flush();

        return new Response('ok');
    }
}
