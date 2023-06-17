<?php
namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

class ScAgendamentos extends Eloquent
{
    protected $table = 'sc_agendamentos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $dates = [
        'data_agendamento'
    ];

    protected $fillable = [
        'id_usuario',
        'data_agendamento',
        'hora_agendamento',
        'ativo',
        'data_registro'
    ];
    public $rules = [
        'data_agendamento' => 'required'
    ];
    public $rulesLot = [
        'data_agendamento' => 'required'
    ];

    public $messages = [
        'data_agendamento.required' => 'A data chegada é obrigatório',
    ];
}
