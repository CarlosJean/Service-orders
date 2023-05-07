<?php

namespace App\Exceptions;

use Exception;

class NoUserEmailException extends Exception
{
    public function __construct()
    {
        $this->message = 'Debe especificar un correo electrónico para poder crear el usuario de este empleado.';
    }
}
