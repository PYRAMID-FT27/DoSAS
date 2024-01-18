<?php

namespace App\Services;

use App\Contract\BaseServiceInterface;

class BaseService implements BaseServiceInterface
{

    private array $parameterBag = [];

    public function getParameters():array
    {
        return $this->parameterBag;
    }

    public function setParameters(array $parameters): BaseServiceInterface
    {
        $this->parameterBag = [];
    }
}
