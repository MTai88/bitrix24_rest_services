<?php

namespace MTai\Services\Rest;

use MTai\Services\Rest\Department\Add as DepartmentAdd;
use MTai\Services\Rest\Department\Update as DepartmentUpdate;
use MTai\Services\Rest\Department\Get as DepartmentGet;
use MTai\Services\Rest\User\Add as UserAdd;
use MTai\Services\Rest\User\Update as UserUpdate;
use MTai\Services\Rest\User\Get as UserGet;

final class ServiceRegister
{
    public static function onRestServiceBuildDescription(): array
    {
        return [
            'mtai' => array(
                'mtai.department.add' => array(DepartmentAdd::class, 'process'),
                'mtai.department.update' => array(DepartmentUpdate::class, 'process'),
                'mtai.department.get' => array(DepartmentGet::class, 'process'),
                'mtai.user.add' => array(UserAdd::class, 'process'),
                'mtai.user.update' => array(UserUpdate::class, 'process'),
                'mtai.user.get' => array(UserGet::class, 'process'),
            )
        ];
    }
}