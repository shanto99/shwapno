<?php

namespace App\Services;

use App\Models\Customer;

class CustomerService {
    public function createCustomer($customerName, $customerPhone, $customerAddress)
    {
        return Customer::create([
           'CustomerName' => $customerName,
           'CustomerPhone' => $customerPhone,
           'CustomerAddress' => $customerAddress
        ]);
    }
}
