<?php

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Notifications\MailResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;


class ScUsuarios extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'sc_usuarios';
    public $timestamps = false;

    protected $casts = [
        'id_perfil' => 'int',
        'ativo' => 'bool'
    ];

    protected $fillable = [
        'nome',
        'login',
        'senha'
    ];

    protected $hidden = [
        'senha', 'hash'
    ];


    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function tb_perfil()
    {
        return $this->belongsTo(\App\Models\ScPerfil::class, 'id_perfil');
    }

    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute) {
            parent::setAttribute($key, $value);
        }
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public $rules = [
        'login' => 'required',
        'senha' => 'required'
    ];

    public $messages = [
       'login.required' => 'O login é obrigatório',
       'senha.required' => 'A senha é obrigatória'
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }

}
