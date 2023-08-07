<?php

namespace MTai\Services\Rest\Department;

use \CModule;
use \CIBlockSection;
use \Bitrix\Rest\RestException;

class Get extends Base
{
    /**
     * @throws RestException
     */
    public static function process($params, $nav = 0)
    {
        CModule::IncludeModule('iblock');

        if(isset($params['FILTER']) && is_array($params['FILTER']))
        {
            $params = $params['FILTER'];
        }

        $dbRes = CIBlockSection::GetList(
            self::prepareSort($params),
            self::prepareDeptData($params),
            false,
            ['*', 'UF_*'],
            self::getNavData($nav)
        );

        $result = array();
        while($arDept = $dbRes->NavNext(false))
        {
            $result[] = self::getDeptData($arDept);
        }

        return self::setNavData($result, $dbRes);
    }
}