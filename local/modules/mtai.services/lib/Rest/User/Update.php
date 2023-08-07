<?php

namespace MTai\Services\Rest\User;

class Update extends Base
{
    /**
     * @throws \Exception
     */
    public static function process($params, $nav = 0, \CRestServer $server = null)
    {
        return self::userUpdate($params, $nav, $server);
    }
}