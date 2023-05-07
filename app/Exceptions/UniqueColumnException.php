<?php

namespace App\Exceptions;

use Exception;

class UniqueColumnException extends Exception
{    
    public function __construct($message){
        $this->message = $message;
    }
}
