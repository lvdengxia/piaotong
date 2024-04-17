<?php

namespace Cooper\Piaotong\Contracts;

/**
 * Interface NotifyInterface.
 */
interface NotifyInterface
{
    /**
     * parse notify.
     *
     * @param string $string
     * @return array
     * @author cooper <15731208870@163.com>
     */
    public function parse(string $string);
}