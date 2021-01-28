<?php

namespace CuongDev\Larab\Abstraction\Definition;

class DefineRole
{
    const SUPER_ADMINISTRATOR = 'super_administrator';
    const ADMINISTRATOR = 'administrator';
    const CUSTOMER = 'customer';

    private $roles = [
        self::SUPER_ADMINISTRATOR => 'Quản trị viên cấp cao',
        self::ADMINISTRATOR       => 'Quản trị viên',
        self::CUSTOMER            => 'Khách hàng',
    ];

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }


}
