<?php

namespace Cooper\Piaotong\Services;

class BlueInvoiceStatService extends BaseService
{
    protected string $path = "/tp/openapi/queryAllEleBlueInvStatistics.pt";

    public function getPath(): string
    {
        return $this->path;
    }

    public function getDefault(): array
    {
        return [];
    }
}