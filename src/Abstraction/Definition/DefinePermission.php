<?php

namespace CuongDev\Larab\Abstraction\Definition;

class DefinePermission
{
    const USER_VIEW_LIST = 'user__view_list';
    const USER_VIEW_DETAIL = 'user__view_detail';
    const USER_CREATE = 'user__create';
    const USER_EDIT = 'user__edit';
    const USER_DELETE = 'user__delete';
    const USER_SYNC_ROLES = 'user__sync_roles';
    const USER_SYNC_PERMISSIONS = 'user__sync_permissions';

    const ROLE_VIEW_LIST = 'role__view_list';
    const ROLE_VIEW_DETAIL = 'role__view_detail';
    const ROLE_CREATE = 'role__create';
    const ROLE_EDIT = 'role__edit';
    const ROLE_DELETE = 'role__delete';
    const ROLE_SYNC_PERMISSIONS = 'role__sync_permissions';

    const PERMISSION_VIEW_LIST = 'permission__view_list';
    const PERMISSION_VIEW_DETAIL = 'permission__view_detail';
    const PERMISSION_CREATE = 'permission__create';
    const PERMISSION_EDIT = 'permission__edit';
    const PERMISSION_DELETE = 'permission__delete';

    const PERMISSION_GROUP_VIEW_LIST = 'permission_group__view_list';
    const PERMISSION_GROUP_VIEW_DETAIL = 'permission_group__view_detail';
    const PERMISSION_GROUP_CREATE = 'permission_group__create';
    const PERMISSION_GROUP_EDIT = 'permission_group__edit';
    const PERMISSION_GROUP_DELETE = 'permission_group__delete';

    private $permissions = [
        self::USER_VIEW_LIST        => 'Người dùng: Xem danh sách',
        self::USER_VIEW_DETAIL      => 'Người dùng: Xem chi tiết',
        self::USER_CREATE           => 'Người dùng: Tạo mới',
        self::USER_EDIT             => 'Người dùng: Chỉnh sửa',
        self::USER_DELETE           => 'Người dùng: Xóa',
        self::USER_SYNC_ROLES       => 'Người dùng: Gán vai trò',
        self::USER_SYNC_PERMISSIONS => 'Người dùng: Gán quyền hạn',

        self::ROLE_VIEW_LIST        => 'Vai trò: Xem danh sách',
        self::ROLE_VIEW_DETAIL      => 'Vai trò: Xem chi tiết',
        self::ROLE_CREATE           => 'Vai trò: Tạo mới',
        self::ROLE_EDIT             => 'Vai trò: Chỉnh sửa',
        self::ROLE_DELETE           => 'Vai trò: Xóa',
        self::ROLE_SYNC_PERMISSIONS => 'Vai trò: Gán quyền hạn',

        self::PERMISSION_VIEW_LIST   => 'Quyền hạn: Xem danh sách',
        self::PERMISSION_VIEW_DETAIL => 'Quyền hạn: Xem chi tiết',
        self::PERMISSION_CREATE      => 'Quyền hạn: Tạo mới',
        self::PERMISSION_EDIT        => 'Quyền hạn: Chỉnh sửa',
        self::PERMISSION_DELETE      => 'Quyền hạn: Xóa',

        self::PERMISSION_GROUP_VIEW_LIST   => 'Nhóm quyền hạn: Xem danh sách',
        self::PERMISSION_GROUP_VIEW_DETAIL => 'Nhóm quyền hạn: Xem chi tiết',
        self::PERMISSION_GROUP_CREATE      => 'Nhóm quyền hạn: Tạo mới',
        self::PERMISSION_GROUP_EDIT        => 'Nhóm quyền hạn: Chỉnh sửa',
        self::PERMISSION_GROUP_DELETE      => 'Nhóm quyền hạn: Xóa',
    ];

    const PERMISSION_GROUP_OTHER = 'other';
    const PERMISSION_GROUP_USER = 'user';
    const PERMISSION_GROUP_ROLE = 'role';
    const PERMISSION_GROUP_PERMISSION = 'permission';
    const PERMISSION_GROUP_PERMISSION_GROUP = 'permission_group';

    private $permissionGroups = [
        self::PERMISSION_GROUP_OTHER            => 'Khác',
        self::PERMISSION_GROUP_USER             => 'Người dùng',
        self::PERMISSION_GROUP_ROLE             => 'Vai trò',
        self::PERMISSION_GROUP_PERMISSION       => 'Quyền hạn',
        self::PERMISSION_GROUP_PERMISSION_GROUP => 'Nhóm quyền hạn',
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
        $this->permissions = array_merge($this->permissions, $permissions);
    }

    /**
     * @return string[]
     */
    public function getPermissionGroups(): array
    {
        return $this->permissionGroups;
    }

    /**
     * @param string[] $permissionGroups
     */
    public function setPermissionGroups(array $permissionGroups): void
    {
        $this->permissionGroups = array_merge($this->permissionGroups, $permissionGroups);
    }

}
