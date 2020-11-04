<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CustomerController extends AbstractController
{
    /**
     * @Route("/api/customers/search", name="customer")
     */
    public function index(Request $request, CustomerRepository $customerRepository,  SerializerInterface $serializer)
    {

        $query = $request->query->get('query');
        $customers = $customerRepository->findAll();
        if (isset($query)){
            $customers = $customerRepository->findBy(["lastName" => $query]);
        }

       $customerData = [];
        foreach ($customers as $customer){
                $customerData[] = [
                    'id' => $customer->getId(),
                    'name' => $customer->getFirstName() . ' ' . $customer->getLastName(),
                ];
        }

        $json = $serializer->serialize($customerData, 'json');
        return new Response($json);
    }
}
