<?php

namespace MTai\Services\Rest\Department;

use \CModule;
use \CIBlockSection;
use \Bitrix\Rest\RestException;

class Update extends Base
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

            $arDept = self::getDepartment($params['ID']);
            if(is_array($arDept))
            {
                $arFields = array();

                if(isset($params['NAME']))
                    $arFields['NAME'] = $params['NAME'];
                if(isset($params['SORT']))
                    $arFields['SORT'] = $params['SORT'];
                if(isset($params['PARENT']))
                    $arFields['IBLOCK_SECTION_ID'] = $params['PARENT'];

                foreach ($params as $key => $val){
                    if(str_starts_with($key, "UF_") || $key == "XML_ID")
                        $arFields[$key] = $val;
                }

                if(count($arFields) > 0)
                {
                    $ob = new CIBlockSection();
                    if(!$ob->Update($arDept['ID'], $arFields))
                    {
                        throw new RestException($ob->LAST_ERROR);
                    }
                }

                return true;
            }
            else
            {
                throw new RestException('Department not found');
            }
        }
        else
        {
            throw new RestException('Access denied!');
        }
    }
}