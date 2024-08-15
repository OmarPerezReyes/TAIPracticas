<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'product_id', 'supplier_id', 'payment_method_id', 'quantity', 'cost_individual', 'discount', 'total',
    ];

    // Relación con el modelo Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relación con el modelo Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Relación con el modelo PaymentMethod
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    
}
