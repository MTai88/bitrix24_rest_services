<?php

namespace MTai\Services\Rest\User;

use \Bitrix\Rest\Api\User;

abstract class Base extends User
{
    abstract public static function process($params);

    protected static function checkAllowedFields(): void
    {
        global $USER_FIELD_MANAGER;

        $fields = $USER_FIELD_MANAGER->GetUserFields("USER");

        foreach(static::getDefaultAllowedUserFields() as $key => $field)
        {
            if(mb_substr($field, 0, 3) === 'UF_' && !array_key_exists($field, $fields))
            {
                static::unsetDefaultAllowedUserField($key);
            }
        }

        foreach ($fields as $code => $field)
        {
            static::setDefaultAllowedUserField($code);
        }
    }
}