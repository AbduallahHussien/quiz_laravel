<?php

namespace App\Domains\Customers\Exceptions;

use Exception;

class EmailIsAlreadyUsedException extends Exception
{
    protected $message = 'Email address is already used';

}
