<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria'; # Define el nombre del campo clave primaria personalizado (POR DEFAULT ID).

    protected $fillable = [
        'nombre'
    ];

     /**
     * Obtiene los productos asociados a la categoría.
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria');
    }
}
