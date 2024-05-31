<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventario';
    protected $primaryKey = 'id_inventario'; # Define el nombre del campo clave primaria personalizado (POR DEFAULT ID).


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_producto',
        'id_categoria',
        'fecha_movimiento',
        'motivo',
        'movimiento',
        'cantidad',
    ];

    /**
     * Get the producto associated with the inventario.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }

    /**
     * Get the categoria associated with the inventario.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }
}
