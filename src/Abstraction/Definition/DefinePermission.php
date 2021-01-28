<?php

namespace CuongDev\Larab\Abstraction\Definition;

class DefinePermission
{
    const USER_VIEW_LIST = 'user_view_list';
    const USER_VIEW_DETAIL = 'user_view_detail';
    const USER_CREATE = 'user_create';
    const USER_EDIT = 'user_edit';
    const USER_DELETE = 'user_delete';

    const ROLE_VIEW_LIST = 'role_view_list';
    const ROLE_VIEW_DETAIL = 'role_view_detail';
    const ROLE_CREATE = 'role_create';
    const ROLE_EDIT = 'role_edit';
    const ROLE_DELETE = 'role_delete';

    const PERMISSION_VIEW_LIST = 'permission_view_list';
    const PERMISSION_VIEW_DETAIL = 'permission_view_detail';
    const PERMISSION_CREATE = 'permission_create';
    const PERMISSION_EDIT = 'permission_edit';
    const PERMISSION_DELETE = 'permission_delete';

    private $permissions = [
        self::USER_VIEW_LIST   => 'Người dùng: Xem danh sách',
        self::USER_VIEW_DETAIL => 'Người dùng: Xem chi tiết',
        self::USER_CREATE      => 'Người dùng: Tạo mới',
        self::USER_EDIT        => 'Người dùng: Chỉnh sửa',
        self::USER_DELETE      => 'Người dùng: Xóa',

        self::ROLE_VIEW_LIST   => 'Vai trò: Xem danh sách',
        self::ROLE_VIEW_DETAIL => 'Vai trò: Xem chi tiết',
        self::ROLE_CREATE      => 'Vai trò: Tạo mới',
        self::ROLE_EDIT        => 'Vai trò: Chỉnh sửa',
        self::ROLE_DELETE      => 'Vai trò: Xóa',

        self::PERMISSION_VIEW_LIST   => 'Quyền hạn: Xem danh sách',
        self::PERMISSION_VIEW_DETAIL => 'Quyền hạn: Xem chi tiết',
        self::PERMISSION_CREATE      => 'Quyền hạn: Tạo mới',
        self::PERMISSION_EDIT        => 'Quyền hạn: Chỉnh sửa',
        self::PERMISSION_DELETE      => 'Quyền hạn: Xóa',
    ];

    /**
     * @return string[]
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @param string[] $permissions
     */
    public function setPermissions(array $permissions): void
    {
        $this->permissions = $permissions;
    }


}
