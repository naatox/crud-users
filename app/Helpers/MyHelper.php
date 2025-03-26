<?php


use Carbon\Carbon;
use App\Models\Ticket;
use Illuminate\Support\Str;


function makeMessages()
{
    $messages = [
        'email.required' => 'debe ingresar el correo electrónico ',
        'email.email' => 'debe ingresar un correo electrónico válido',
        'name.required' => 'debe ingresar su nombre',
        'password.required' => 'debe ingresar su contraseña',

    ];

    return $messages;
}

