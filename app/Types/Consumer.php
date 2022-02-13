<?php

namespace App\Types;

class Consumer
{
    private $callable;
    public function __construct($fn)
    {
        $this->callable = $fn;
    }
    public function accept(...$var)
    {
        call_user_func($this->callable, ...$var);
    }
}
