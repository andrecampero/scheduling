<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Reliese\Database\Eloquent\Model as Eloquent;

class ScPerfil extends Eloquent
{
    protected $table = 'sc_perfil';
    public $timestamps = false;

    use SoftDeletes;
    protected $casts = [
        'admin' => 'int'
    ];

    protected $fillable = [
        'nome',
        'tipo',
        'permissao',
        'admin',
        'relacionado'
    ];

    public function tb_usuarios()
    {
        return $this->hasMany(\App\Models\TbUsuario::class, 'perfil');
    }

    public $rules = [
        'nome' => 'required'
    ];

    public $messages = [
        'nome.required' => 'O nome é obrigatório'
    ];
}
