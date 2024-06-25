<?php

namespace App\Domains\Paintings\Exceptions;

use Exception;

class PaintingNotFoundException extends Exception
{
    protected $message = 'Painting not found';

}
