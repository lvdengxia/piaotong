<?php

namespace Cooper\Piaotong\Services;

use Cooper\Piaotong\Contracts\NotifyInterface;

class NotifyService implements NotifyInterface
{
    public function __construct($config)
    {
        // 这里的config 是企业信息
        $this->key = $config['key'];
    }

    public function parse(string $string)
    {
        return $this->decrypt($this->key, $string);
    }

    public function decrypt(string $key, string $data): string
    {
        return openssl_decrypt(base64_decode($data), 'DES-EDE3-ECB', $key,OPENSSL_RAW_DATA);
    }
}