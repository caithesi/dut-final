<?php

namespace App\Types;

use App\Types\Consumer;

class Functional
{
    private $callable;
    public function __construct($fn)
    {
        $this->callable = $fn;
    }
    public function apply($var)
    {
        return call_user_func(fn ($var) => ($this->callable)($var), $var);
    }
    public function andThen(Functional $after)
    {
        return new Functional(fn ($var) =>  $after->apply($this->apply($var)));
    }
    public function toConsumer(Consumer $consumer)
    {
        return new Consumer(function ($var) use ($consumer) {
            $consumer->accept($this->apply($var));
        });
    }
}
