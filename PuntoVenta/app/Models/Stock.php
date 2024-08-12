<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'date',
        'movement',
        'reason',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scope para filtrado
    public function scopeFilter(Builder $query, array $filters)
    {
        if (isset($filters['search'])) {
            $query->whereHas('product', function ($q) use ($filters) {
                $q->where('product_name', 'like', "%{$filters['search']}%");
            });
        }
    }

    // Scope para ordenamiento
    public function scopeSortable(Builder $query)
    {
        return $query->orderBy(request('sort_by', 'date'), request('sort_order', 'desc'));
    }
}

