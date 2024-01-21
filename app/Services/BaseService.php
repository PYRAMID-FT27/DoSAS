<?php

namespace App\Services;

use App\Contract\BaseServiceInterface;

class BaseService implements BaseServiceInterface
{

    protected array $parameterBag = [];
    protected array $output = [];

    public function getParameters():array
    {
        return $this->parameterBag;
    }

    public function setParameters(array $parameters): BaseServiceInterface
    {
        $this->parameterBag = $parameters;
        return $this;
    }

    public function output(string $key)
    {
        return $this->output[$key];
    }
}
