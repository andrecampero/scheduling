<?php
namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

class ScAgendamentosServicos extends Eloquent
{
    protected $table = 'sc_agendamentos_servicos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $dates = [
        'data_registro'
    ];

    protected $fillable = [
        'id_agendamento',
        'id_servicos',
        'ativo',
        'data_registro'

    ];
    public $rules = [
        'id_agendamento' => 'required'
    ];

    public $messages = [
        'id_agendamento.required' => 'O agendamento é obrigatório',
    ];
}
