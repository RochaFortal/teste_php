<?php

namespace AppBundle\Service;

use AppBundle\Repository\ICustomerRepository;
use AppBundle\Entity\Customer;

final class CustomerService
{
    /**
     *
     * @var ICustomerRepository
     */
    private $customerRepository;
    
    public function __construct(ICustomerRepository $customerRepository) 
    {
        $this->customerRepository = $customerRepository;
    }
    
    public function findAll() 
    {
        return $this->customerRepository->findAll();
    }
    
    public function save(Customer $customer) 
    {
        return $this->customerRepository->save($customer);
    }
    
    public function delete(Customer $customer) 
    {
        return $this->customerRepository->delete($customer);
    }
}

