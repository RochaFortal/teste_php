<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

//use AppBundle\Repository\CustomerRepository;
use AppBundle\Service\CustomerService;
use AppBundle\Entity\Customer;
use AppBundle\Form\CustomerType;

/**
 * @Route("/customers")
 */
class CustomerController extends Controller
{
    /**
     * @var CustomerService
     */
    private $customerService;
    
    public function __construct(CustomerService $customerService) 
    {
        $this->customerService = $customerService;
    }
    
    /**
     * @Route("", methods={"GET"})
     */
    function indexAction(Request $request) 
    {
        $customers = $this->customerService->findAll();
        $customers = $this->get('jms_serializer')->serialize($customers, 'json');
        return new Response($customers);
    }
    
    /**
     * 
     * @Route("/{id}", methods={"GET"})
     */
    function findAction(Customer $customer)
    {
        $customer = $this->get('jms_serializer')->serialize($customer, 'json');
        return new Response($customer);
    }
    
    /**
     * @Route("", methods={"POST"})
     */
    function postAction(Request $request) 
    {
        $data = json_decode($request->getContent(), true);
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->submit($data);

        $dtNascimento = is_null($customer->getDataNascimento()) 
                    ? new \DateTime($data['dataNascimento'])
                    : NULL;
        
        $customer->setDataNascimento($dtNascimento);
        $this->customerService->save($form->getData());
        return new Response('OK');
    }
    
    /**
     * 
     * @Route("/{id}", methods={"PUT", "PATCH"})
     */
    function putAction(Customer $customer, Request $request) 
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(CustomerType::class, $customer);
        $form->submit($data);
        
        $this->customerService->save($customer);
        
        return new Response('OK');
    }
    
    /**
     * 
     * @Route("/{id}", methods={"DELETE"})
     */
    function deleteAction(Customer $customer)
    {
        $this->customerService->delete($customer);
        return new Response('OK');
    }
            
}

