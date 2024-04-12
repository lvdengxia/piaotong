<?php

namespace Cooper\Piaotong\Services;

class RegisterService extends BaseService
{
    protected string $path = "/tp/openapi/register.pt";

    public function getPath(): string
    {
        return $this->path;
    }
}