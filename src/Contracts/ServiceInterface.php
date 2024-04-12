<?php

namespace Cooper\Piaotong\Contracts;

/**
 * Interface ServiceInterface.
 */
interface ServiceInterface
{
    /**
     * Send request.
     *
     * @param string $uri
     * @param array $payload
     * @return array
     * @author cooper <15731208870@163.com>
     */
    public function send(array $payload);
}