<?php

namespace App\Imports;

use App\Customer;
use Maatwebsite\Excel\Concerns\ToModel;

class CustomersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Customer([
            'customer_name' => $row[0],
            'email' => $row[1],
            'phone' => $row[2],
            'premium_amount' => $row[3],
            'gst_percentage' => $row[4],
            'gst_amount' => $row[5],
            'total_premium_collected' => $row[6],
        ]);
    }
}
