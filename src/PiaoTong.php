<?php

namespace Cooper\Piaotong;

use Cooper\Piaotong\Contracts\NotifyInterface;
use Cooper\Piaotong\Contracts\ServiceInterface;
use Cooper\Piaotong\Exceptions\InvalidGatewayException;
use Cooper\Piaotong\Supports\Str;


/**
 * @method register(array $payload) 企业注册
 * @method registerUser(array $payload) 用户登记
 * @method blueInvoiceOpen(array $payload) 开具蓝色数电发票
 * @method blueInvoiceStat(array $payload) 统计蓝色数电发票
 * @method resendEmail(array $payload) 统计蓝色数电发票
 */
class PiaoTong
{
    public array $config = [];

    private static ?PiaoTong $instance;

    public function __construct(array $config, $dev = false)
    {
        $config['host'] = $dev ? 'http://fpkj.testnw.vpiaotong.cn' : 'https://fpkj.vpiaotong.com';

        $this->config = $config;
    }

    public function __call($method, $arguments)
    {
        $service = __NAMESPACE__ . '\\Services\\' . Str::studly($method) . 'Service';

        if (class_exists($service)) {
            $app = new $service($this->config);

            if ($app instanceof ServiceInterface) {
                return $app->send(array_filter($arguments[0], function ($value) {
                    return '' !== $value && !is_null($value);
                }));
            }

            if ($app instanceof NotifyInterface) {
                return $app->parse($arguments[0]);
            }
        }
        throw new InvalidGatewayException("Send Gateway [{$service}] Not Exists");
    }

    static public function getInstance(array $config): PiaoTong
    {
        if (!self::$instance instanceof self){
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    public function getSignContent(array $data): string
    {
        ksort($data);

        $buff = '';

        foreach ($data as $k => $v) {
            $buff .= ('sign' != $k && '' != $v && !is_array($v)) ? $k.'='.$v.'&' : '';
        }

        return trim($buff, '&');
    }


    public function verifySignature(array $data) :bool
    {
        if (Str::endsWith($this->config['publicKey'], '.crt')) {
            $publicKey = file_get_contents($this->config['publicKey']);
        } elseif (Str::endsWith($this->config['publicKey'], '.pem')) {
            $publicKey = openssl_pkey_get_public(
                Str::startsWith($this->config['publicKey'], 'file://') ? $this->config['publicKey'] : 'file://'.$this->config['publicKey']
            );
        } else {
            $publicKey = "-----BEGIN PUBLIC KEY-----\n".
                wordwrap($this->config['publicKey'], 64, "\n", true).
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