<?php

namespace MTai\Services\Rest\Department;

use \CIntranetRestService;
use \Bitrix\Rest\RestException;

abstract class Base extends CIntranetRestService
{
    /**
     * @throws RestException
     */
    abstract public static function process($params);

    protected static function prepareSort($query): array
    {
        $query = array_change_key_case($query, CASE_UPPER);
        $sort = ['LEFT_MARGIN' => 'ASC'];

        if (isset($query['SORT']) && is_string($query['SORT']))
        {
            $sortField = mb_strtoupper($query['SORT']);
            if(
                in_array($sortField, self::$arAllowedDepartmentFields)
                || str_starts_with($sortField, "UF_") || $sortField == "XML_ID"
            )
            {
                $order = isset($query['ORDER']) && is_string($query['ORDER']) ? mb_strtoupper($query['ORDER']) : '';
                if ($order != 'DESC')
                    $order = 'ASC';

                $sort = [$sortField => $order];
            }
        }
        return $sort;
    }

    protected static function prepareDeptData($arData): array
    {
        $arDept = array(
            'IBLOCK_ID' => self::getDeptIblock(),
            'GLOBAL_ACTIVE' => 'Y'
        );

        foreach($arData as $key => $value)
        {
            if(
                in_array($key, self::$arAllowedDepartmentFields)
                || str_starts_with($key, "UF_") || $key == "XML_ID"
            )
            {
                $dkey = $key == 'PARENT' ? 'SECTION_ID' : $key;
                $arDept[$dkey] = $value;
            }
        }

        if(isset($arDept['ID']))
        {
            if(is_array($arDept['ID']))
                $arDept['ID'] = array_map("intval", $arDept['ID']);
            else
                $arDept['ID'] = intval($arDept['ID']);
        }

        if(isset($arDept['SORT']))
        {
            $arDept['SORT'] = intval($arDept['SORT']);
        }

        if(isset($arDept['SECTION_ID']))
        {
            if(is_array($arDept['SECTION_ID']))
                $arDept['SECTION_ID'] = array_map("intval", $arDept['SECTION_ID']);
            else
                $arDept['SECTION_ID'] = intval($arDept['SECTION_ID']);
        }

        if(isset($arDept['UF_HEAD']))
        {
            if(is_array($arDept['UF_HEAD']))
                $arDept['UF_HEAD'] = array_map("intval", $arDept['UF_HEAD']);
            else
                $arDept['UF_HEAD'] = intval($arDept['UF_HEAD']);
        }

        return $arDept;
    }

    protected static function getDeptData($arDept): array
    {
        $res = array();
        foreach($arDept as $key => $val)
        {
            switch($key)
            {
                case 'SORT':
                    $res[$key] = intval($val);
                    break;
                case 'IBLOCK_SECTION_ID':
                    $res['PARENT'] = $val;
                    break;
                default:
                    $res[$key] = $val;
            }
        }

        return $res;
    }
}