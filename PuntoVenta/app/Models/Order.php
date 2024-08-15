<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'employee_id', 'total', 'paid', 'change'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function payments()
    {
        return $this->hasMany(OrderPayment::class);
    }

    public function orderPayments()
    {
        return $this->hasMany(OrderPayment::class);
    }

    public function paymentMethod()
    {
        // Asumiendo que cada orden tiene un solo método de pago
        return $this->hasOneThrough(
            PaymentMethod::class, 
            OrderPayment::class, 
            'order_id', // Foreign key on OrderPayment table
            'id', // Foreign key on PaymentMethod table
            'id', // Local key on Order table
            'payment_method_id' // Local key on OrderPayment table
        );
    }

    public function details()
    {
        return $this->hasMany(DetailsOrder::class);
    }
}
