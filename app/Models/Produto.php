<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produto';
    protected $primaryKey = 'id_produto';
    protected $fillable = ['id_categoria', 'nome', 'descricao', 'imagem', 'preco', 'preco_desconto', 'eh_vegano', 'eh_sem_gluten', 'em_estoque', 'porcoes'];
    public $timestamps = false;

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
}
