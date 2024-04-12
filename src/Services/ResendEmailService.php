<?php

namespace Cooper\Piaotong\Services;

class ResendEmailService extends BaseService
{
    protected string $path = "/tp/openapi/resendEmailOrSMS.pt";

    public function getPath(): string
    {
        return $this->path;
    }
}