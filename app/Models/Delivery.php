<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $table = "Deliveries";
    protected $primaryKey = "DeliveryID";

    protected $guarded = [];

    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'CustomerID', 'CustomerID');
    }

}
