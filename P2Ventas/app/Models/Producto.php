<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada al modelo
    protected $table = 'productos';

    // Nombre del campo clave primaria personalizado
    protected $primaryKey = 'id_producto';

    // Los atributos que son asignables en masa.
    protected $fillable = [
        'nombre',
        'id_categoria',
        'pv',
        'pc',
        'fecha_compra',
        'colores',
        'descripcion_corta',
        'descripcion_larga'
    ];

    // Define la relación "pertenece a" con la categoría del producto
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }
}
