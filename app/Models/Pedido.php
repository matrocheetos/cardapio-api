<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedido';
    protected $primaryKey = 'id_pedido';
    protected $fillable = ['comanda', 'id_produto', 'observacao'];
    public $timestamps = true;

    const CREATED_AT = 'data_pedido';
    const UPDATED_AT = 'data_atualizacao';

    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'comanda', 'comanda');
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto', 'id_produto');
    }
}
