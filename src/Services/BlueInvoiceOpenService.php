<?php

namespace Cooper\Piaotong\Services;

/**
 * 开具蓝字数电发票
 */
class BlueInvoiceOpenService extends BaseService
{
    protected string $path = "/tp/openapi/invoiceBlue.pt";

    public function getPath(): string
    {
        return $this->path;
    }
}