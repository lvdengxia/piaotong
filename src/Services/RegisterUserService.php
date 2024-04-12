<?php

namespace Cooper\Piaotong\Services;

class RegisterUserService extends BaseService
{
    protected string $path = "/tp/openapi/registerUser.pt";

    public function getPath(): string
    {
        return $this->path;
    }
}