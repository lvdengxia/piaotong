<?php

namespace Cooper\Piaotong\Services;

/**
 *  快捷冲红数电发票(全额冲红)
 */
class RedInvoiceOpenService extends BaseService
{
    protected string $path = "/tp/openapi/invoiceRed.pt";

    public function getPath(): string
    {
        return $this->path;
    }
}