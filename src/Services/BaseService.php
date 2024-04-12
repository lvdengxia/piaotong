<?php

namespace Cooper\Piaotong\Services;

use Cooper\Piaotong\Contracts\ServiceInterface;
use Cooper\Piaotong\Supports\Str;
use GuzzleHttp\Client;


abstract class BaseService implements ServiceInterface
{
    protected string $path;

    public string $platformCode;

    public string $platformName;

    public string $key;

    public string $publicKey;

    public string $privateKey;

    public ?Client $httpClient;

    abstract public function getPath(): string;

    public function __construct($config)
    {
        // 这里的config 是企业信息
//        $this->config = $config;
        // 企业信息等是公用的，所以要放到公共部分
        $this->platformCode = $config['platformCode'];
        $this->platformName = $config['platformName'];
        $this->key = $config['key'];
        $this->publicKey = $config['publicKey'];
        $this->privateKey = $config['privateKey'];

        // 这里还要new client
        $this->httpClient = new Client([
            'base_uri' => $config['host'],
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ]);

    }

    public function send(array $payload)
    {
        // 先3des-ecb加密
        $content = $this->encrypt($this->key, json_encode($payload));

        // 再rsa签名
        $data = [
            "platformCode" => $this->platformCode,
            "signType" => "RSA",
            "format" => "JSON",
            "timestamp" => date("Y-m-d H:i:s", time()),
            "version" => "1.0",
            "serialNo" => $this->generateSerialNumber(),
            "content" => $content
        ];

        $signature = $this->generateSignature($data);

        $data['sign'] = $signature;

        $response = $this->httpClient->post($this->getPath(), [
            "json" => $data
        ])->getBody()->getContents();

        $response = json_decode($response, true);

        $content = $this->decrypt($this->key, $response['content']);

        $response['content'] = json_decode($content, true);

        return $response;
    }

    public function getSignContent(array $data): string
    {
        ksort($data);

        $buff = '';

        foreach ($data as $k => $v) {
            $buff .= ('sign' != $k && '' != $v && !is_array($v)) ? $k . '=' . $v . '&' : '';
        }

        return trim($buff, '&');
    }

    public function generateSignature(array $data): string
    {
        $signString = $this->getSignContent($data);

        if (Str::endsWith($this->privateKey, '.pem')) {
            $privateKey = openssl_pkey_get_private(
                Str::startsWith($this->privateKey, 'file://') ? $this->privateKey : 'file://' . $this->privateKey
            );
        } else {
            $privateKey = "-----BEGIN PRIVATE KEY-----\n" .
                wordwrap($this->privateKey, 64, "\n", true) .
                "\n-----END PRIVATE KEY-----";
        }

        openssl_sign($signString, $sign, $privateKey, OPENSSL_ALGO_SHA1);

        $signature = base64_encode($sign);

        if (is_resource($privateKey)) {
            openssl_free_key($privateKey);
        }

        return $signature;
    }

    public function generateSerialNumber(): string
    {
        $string = $this->platformName . date("YmdHis", time());

        try {
            $bytes = random_bytes(8);
            $string .= substr(str_replace(['/', '+', '='], '', bin2hex($bytes)), 0, 8);
        } catch (\Exception $e) {
            $string .= "1A2B3C4D";
        }

        return $string;
    }

    public function encrypt(string $key, string $data): string
    {
        $encrypted = openssl_encrypt($data, 'DES-EDE3-ECB', $key, OPENSSL_RAW_DATA);

        return base64_encode($encrypted);
    }

    public function decrypt(string $key, string $data): string
    {
        return openssl_decrypt(base64_decode($data), 'DES-EDE3-ECB', $key,OPENSSL_RAW_DATA);
    }

    public function verifySignature(array $data): bool
    {
        if (Str::endsWith($this->publicKey, '.crt')) {
            $publicKey = file_get_contents($this->publicKey);
        } elseif (Str::endsWith($this->publicKey, '.pem')) {
            $publicKey = openssl_pkey_get_public(
                Str::startsWith($this->publicKey, 'file://') ? $this->publicKey : 'file://' . $this->publicKey
            );
        } else {
            $publicKey = "-----BEGIN PUBLIC KEY-----\n" .
                wordwrap($this->publicKey, 64, "\n", true) .
                "\n-----END PUBLIC KEY-----";
        }

        $signature = $data['sign'];
        unset($data['sign']);
        $signString = $this->getSignContent($data);

        $isVerify = 1 === openssl_verify($signString, base64_decode($signature), $publicKey, OPENSSL_ALGO_SHA1);

        if (is_resource($publicKey)) {
            openssl_free_key($publicKey);
        }

        return $isVerify;
    }
}