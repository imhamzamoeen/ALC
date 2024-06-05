<?php

namespace App\Exceptions;

use Exception;

class ZoomClassException extends Exception
{
    public function render($request)
    {       
       
         return view()->first(['errors.499', 'errors.404'], ['message' => $this->message]);
 
    }
}
