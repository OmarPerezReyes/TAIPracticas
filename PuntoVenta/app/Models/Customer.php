<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Kyslik\ColumnSortable\Sortable;

class Customer extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'photo',
        'RFC',
        'razon_social',
        'codigo_postal',
        'regimen_fiscal',
    ];

    public $sortable = [
        'name',
        'email',
        'phone',
        'RFC',
        'razon_social',
    ];

    protected $guarded = [
        'id',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                         ->orWhere('razon_social', 'like', '%' . $search . '%')
                         ->orWhere('RFC', 'like', '%' . $search . '%');
        });
    }
}
