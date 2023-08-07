<?php

namespace MTai\Services\Rest\Department;

use \CModule;
use \CIBlockSection;
use \Bitrix\Rest\RestException;

class Add extends Base
{
    /**
     * @throws RestException
     */
    public static function process($params)
    {
        if(self::canEdit())
        {
            CModule::IncludeModule('iblock');

            $params = array_change_key_case($params, CASE_UPPER);

            $arFields = array(
                'IBLOCK_ID' => self::getDeptIblock(),
                'NAME' => $params['NAME'],
                'SORT' => $params['SORT'],
                'IBLOCK_SECTION_ID' => $params['PARENT'],
            );
            foreach ($params as $key => $val){
                if(str_starts_with($key, "UF_") || $key == "XML_ID")
                    $arFields[$key] = $val;
            }

            $ob = new CIBlockSection();
            $section = $ob->Add($arFields);
            if($section > 0)
            {
                return $section;
            }
            else
            {
                throw new RestException($ob->LAST_ERROR);
            }
        }
        else
        {
            throw new RestException('Access denied!');
        }
    }
}