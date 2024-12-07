<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_name', 'email', 'phone', 'premium_amount',
        'gst_percentage', 'gst_amount', 'total_premium_collected'
    ];
}
