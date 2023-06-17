<?php
namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

class ScServicos extends Eloquent
{
    protected $table = 'sc_servicos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $dates = [
        'data_registro'
    ];

    protected $fillable = [
        'servico',
        'valor',
        'ativo',
        'data_registro'
    ];
    public $rules = [
        'servico' => 'required'
    ];
    public $rulesLot = [
        'servico' => 'required'
    ];

    public $messages = [
        'servico.required' => 'O serviço é obrigatório',
    ];
}
