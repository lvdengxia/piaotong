<?php

namespace Cooper\Piaotong\Tests;

use Cooper\Piaotong\PiaoTong;
use Cooper\Piaotong\Services\RegisterService;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class PiaoTongTest extends TestCase
{
    public function testGetPiaoTong()
    {
        $client  = new Client();
//        $client->post("www.baidu.com",)
        $app = new PiaoTong([
            'platformCode' => '11111111',
            "platformName" => 'DEMO',
            "key" => "lsBnINDxtct8HZB7KCMyhWSJ",
//            "privateKey" => "MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAInn+kOUimxlD2OoNUyo0ds99+4Spvd86WX699eD4vxcsb09yVcL1WLr66CTy/NHo+716tzxGVtp/GPqXJUhxI07jAO7miiQ0vN63mfw30oPwB4QmzmpRGeFLf2RDaDqYMI3Ngz+/UaTtwbAtHk3BvUqa0XAe2EdVI+cQFGoclhXAgMBAAECgYEAhXqUIB9BEAONLq9bz3RDkwpa1AMXusobeoq8osvTwuHRY1LPc0JP6qxg547GRBXeVWePSQTPv0xJb0gjDnGdtIqeel0GFWaZ9xJxRRMPEJxS4QpgGM69r82oVJDXSldM8Jim9MughoQ3KnMs0mi8YnovH/9JC/xXt1GcAZq/f5ECQQDW7JlMCFa9Pw9Sw9gOa1cBtDAiUe25fojPghsOUm0jmDs3EVrw6WLp4SCWMEQqQRSFv+2h6CoQHtSm7V7NeRUPAkEApEMvzm+wAx0GALzVZzVgW5A6YQrc3ojDLSU19hgILQUavCq6KAvl3zzothV1sT4trvllHOdxtbAMHKnKBcjYOQJAe2y8TFGtnliMcDdP6Ff0S2IzEkKChrgH0UMiToM/ceWGfAVXeGpPB4jlsdpeCvX81yJ1UTmGjmNmM8a1XsJeOQJBAIIHBULeum/ce7H9yNgIMpyIkQ3ccXZewFFuUUbbQy2QCtfE4tNsh6ytJHFuj1mcpMELfnTg6OwvzYarCNaHZFECQHOYDF2GbO6uc4k6XCDH9vQFuJ0nTtZHe6j1sPSI5cLFO5oOSdgtRBcPkXHtPJNPB0/PYdcLkRM6RUsvEuIPhcI=",
//            "publicKey" => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCJ5/pDlIpsZQ9jqDVMqNHbPffuEqb3fOll+vfXg+L8XLG9PclXC9Vi6+ugk8vzR6Pu9erc8Rlbafxj6lyVIcSNO4wDu5ookNLzet5n8N9KD8AeEJs5qURnhS39kQ2g6mDCNzYM/v1Gk7cGwLR5Nwb1KmtFwHthHVSPnEBRqHJYVwIDAQAB",
            "privateKey" => "MIICdQIBADANBgkqhkiG9w0BAQEFAASCAl8wggJbAgEAAoGBAIVLAoolDaE7m5oMB1ZrILHkMXMF6qmC8I/FCejz4hwBcj59H3rbtcycBEmExOJTGwexFkNgRakhqM+3uP3VybWu1GBYNmqVzggWKKzThul9VPE3+OTMlxeG4H63RsCO1//J0MoUavXMMkL3txkZBO5EtTqek182eePOV8fC3ZxpAgMBAAECgYBp4Gg3BTGrZaa2mWFmspd41lK1E/kPBrRA7vltMfPj3P47RrYvp7/js/Xv0+d0AyFQXcjaYelTbCokPMJT1nJumb2A/Cqy3yGKX3Z6QibvByBlCKK29lZkw8WVRGFIzCIXhGKdqukXf8RyqfhInqHpZ9AoY2W60bbSP6EXj/rhNQJBAL76SmpQOrnCI8Xu75di0eXBN/bE9tKsf7AgMkpFRhaU8VLbvd27U9vRWqtu67RY3sOeRMh38JZBwAIS8tp5hgcCQQCyrOS6vfXIUxKoWyvGyMyhqoLsiAdnxBKHh8tMINo0ioCbU+jc2dgPDipL0ym5nhvg5fCXZC2rvkKUltLEqq4PAkAqBf9b932EpKCkjFgyUq9nRCYhaeP6JbUPN3Z5e1bZ3zpfBjV4ViE0zJOMB6NcEvYpy2jNR/8rwRoUGsFPq8//AkAklw18RJyJuqFugsUzPznQvad0IuNJV7jnsmJqo6ur6NUvef6NA7ugUalNv9+imINjChO8HRLRQfRGk6B0D/P3AkBt54UBMtFefOLXgUdilwLdCUSw4KpbuBPw+cyWlMjcXCkj4rHoeksekyBH1GrBJkLqDMRqtVQUubuFwSzBAtlc",
            "publicKey" => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCJkx3HelhEm/U7jOCor29oHsIjCMSTyKbX5rpoAY8KDIs9mmr5Y9r+jvNJH8pK3u5gNnvleT6rQgJQW1mk0zHuPO00vy62tSA53fkSjtM+n0oC1Fkm4DRFd5qJgoP7uFQHR5OEffMjy2qIuxChY4Au0kq+6RruEgIttb7wUxy8TwIDAQAB",
        ],true);
//        $res = $app->register([
//            "taxpayerNum" => "123456789123456789",
//            "enterpriseName" => "票通信息",//销方企业名称
//            "legalPersonName" => "AA",//法人名称
//            "contactsName" => "AA",//联系人名称
//            "contactsEmail" => "1121@qq.com",//联系人邮箱
//            "contactsPhone" => "15111111133",//联系人手机号
//            "regionCode" => "11",//地区编码
//            "cityName" => "海淀区",//市(区)名
//            "enterpriseAddress" => "地址",//详细地址
//            "taxRegistrationCertificate" => "sdddddddddddddddddddd",//证件图片base64
//        ]);
//
//        var_dump($res);
//
//        $res = $app->registerUser([
//            "taxpayerNum" => "500102201007206608",
//            "loginMethod" => "1",
//            "account" => "15731208870",
//            "password" => "lipishuai#123",
//            "identityType" => "",
//            "identityPwd" => "",
//            "phoneNum" => "",
//            "name" => "",
//            "operationType" => 1
//        ]);

        $resp = $app->blueInvoiceOpen([
            "taxpayerNum" => "500102201007206608",
            "invoiceReqSerialNo" => "DEMO" . date('YmdHis') . rand(11, 99),
            "buyerName" => "北京悦来电新能源科技有限公司", // 购买方名称
            "buyerTaxpayerNum" => "91110108MAC6ICGW4A",
            "itemList" => [
                [
                    "taxClassificationCode" => "1100101020000000000",//税收分类编码(可以按照Excel文档填写)
                    "quantity" => "1.00",//数量
                    "goodsName" => "电费",//货物名称
                    "unitPrice" => "8.85",//单价
                    "invoiceAmount" => "8.85",//金额
                    "taxRateValue" => "0.13",//税率(注:金税三期之后 不存在16% 与10%税率  16%自动会降为13% 10%自动降为9%)
                    "taxRateAmount" => "1.15", // 税额
                    "includeTaxFlag" => "0",//含税标识,naturalPersonFlag
                ],
                [
                    "taxClassificationCode" => "1100101020000000000",//税收分类编码(可以按照Excel文档填写)
                    "quantity" => "1.00",//数量
                    "goodsName" => "服务费",//货物名称
                    "unitPrice" => "1.77",//单价
                    "invoiceAmount" => "1.77",//金额
                    "taxRateValue" => "0.13",//税率(注:金税三期之后 不存在16% 与10%税率  16%自动会降为13% 10%自动降为9%)
                    "taxRateAmount" => "0.23", // 税额
                    "includeTaxFlag" => "0",//含税标识,
                ],
            ]
        ]);
        var_dump($resp);
        $this->assertArrayHasKey('sign', $resp);

        // 解密
//        $verify = $app->register([
//            "taxpayerNum" => "123456789123456789",
//        ])->verifySignature($res);
//
//        $service = new RegisterService([
//            'host' => '11',
//            'platformCode' => '11111111',
//            "platformName" => 'DEMO',
//            "key" => "lsBnINDxtct8HZB7KCMyhWSJ",
//            "privateKey" => "MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAInn+kOUimxlD2OoNUyo0ds99+4Spvd86WX699eD4vxcsb09yVcL1WLr66CTy/NHo+716tzxGVtp/GPqXJUhxI07jAO7miiQ0vN63mfw30oPwB4QmzmpRGeFLf2RDaDqYMI3Ngz+/UaTtwbAtHk3BvUqa0XAe2EdVI+cQFGoclhXAgMBAAECgYEAhXqUIB9BEAONLq9bz3RDkwpa1AMXusobeoq8osvTwuHRY1LPc0JP6qxg547GRBXeVWePSQTPv0xJb0gjDnGdtIqeel0GFWaZ9xJxRRMPEJxS4QpgGM69r82oVJDXSldM8Jim9MughoQ3KnMs0mi8YnovH/9JC/xXt1GcAZq/f5ECQQDW7JlMCFa9Pw9Sw9gOa1cBtDAiUe25fojPghsOUm0jmDs3EVrw6WLp4SCWMEQqQRSFv+2h6CoQHtSm7V7NeRUPAkEApEMvzm+wAx0GALzVZzVgW5A6YQrc3ojDLSU19hgILQUavCq6KAvl3zzothV1sT4trvllHOdxtbAMHKnKBcjYOQJAe2y8TFGtnliMcDdP6Ff0S2IzEkKChrgH0UMiToM/ceWGfAVXeGpPB4jlsdpeCvX81yJ1UTmGjmNmM8a1XsJeOQJBAIIHBULeum/ce7H9yNgIMpyIkQ3ccXZewFFuUUbbQy2QCtfE4tNsh6ytJHFuj1mcpMELfnTg6OwvzYarCNaHZFECQHOYDF2GbO6uc4k6XCDH9vQFuJ0nTtZHe6j1sPSI5cLFO5oOSdgtRBcPkXHtPJNPB0/PYdcLkRM6RUsvEuIPhcI=",
//            "publicKey" => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCJ5/pDlIpsZQ9jqDVMqNHbPffuEqb3fOll+vfXg+L8XLG9PclXC9Vi6+ugk8vzR6Pu9erc8Rlbafxj6lyVIcSNO4wDu5ookNLzet5n8N9KD8AeEJs5qURnhS39kQ2g6mDCNzYM/v1Gk7cGwLR5Nwb1KmtFwHthHVSPnEBRqHJYVwIDAQAB",
//        ]);
//        $verify = $app->verifySignature($res);


//        $this->assertTrue($verify);

    }
}