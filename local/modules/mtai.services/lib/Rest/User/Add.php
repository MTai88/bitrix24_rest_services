<?php

namespace MTai\Services\Rest\User;

class Add extends Base
{
    /**
     * @throws \Exception
     */
    public static function process($params, $nav = 0, \CRestServer $server = null)
    {
        return self::userAdd($params, $nav, $server);
    }
}