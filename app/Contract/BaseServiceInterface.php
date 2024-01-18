<?php

namespace App\Contract;

interface BaseServiceInterface
{
    public function getParameters():array;
    public function setParameters(array $parameters):self;
}
