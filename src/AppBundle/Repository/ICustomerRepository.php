<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Customer;

interface ICustomerRepository {
    
    public function findAll();
    
    public function save(Customer $customer);
    
    public function delete(Customer $customer);
}
