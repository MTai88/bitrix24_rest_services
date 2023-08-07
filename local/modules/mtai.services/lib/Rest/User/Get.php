<?php

namespace MTai\Services\Rest\User;

class Get extends Base
{
    /**
     * @throws \Exception
     */
    public static function process($params, $nav = 0, \CRestServer $server = null)
    {
        return self::userGet($params, $nav, $server);
    }
}