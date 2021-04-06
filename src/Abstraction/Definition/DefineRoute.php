<?php


namespace CuongDev\Larab\Abstraction\Definition;


class DefineRoute
{
    /**
     * Auth API
     */
    const API_AUTH_LOGIN = 'api.auth.login';
    const API_AUTH_LOGOUT = 'api.auth.logout';
    const API_AUTH_REFRESH = 'api.auth.refresh';
    const API_AUTH_ME = 'api.auth.me';
    const API_AUTH_UPDATE = 'api.auth.update';

    /**
     * User API
     */
    const API_USER_LIST = 'api.user.list';
    const API_USER_FIND_ONE = 'api.user.find_one';
    const API_USER_DETAIL = 'api.user.detail';
    const API_USER_CREATE = 'api.user.create';
    const API_USER_UPDATE = 'api.user.update';
    const API_USER_DELETE = 'api.user.delete';
    const API_USER_SYNC_ROLES = 'api.user.sync_roles';
    const API_USER_SYNC_PERMISSIONS = 'api.user.sync_permissions';

    /**
     * Role API
     */
    const API_ROLE_LIST = 'api.role.list';
    const API_ROLE_DETAIL = 'api.role.detail';
    const API_ROLE_CREATE = 'api.role.create';
    const API_ROLE_UPDATE = 'api.role.update';
    const API_ROLE_DELETE = 'api.role.delete';
    const API_ROLE_SYNC_PERMISSIONS = 'api.role.sync_permissions';

    /**
     * Permission Group API
     */
    const API_PERMISSION_GROUP_LIST = 'api.permission_group.list';
    const API_PERMISSION_GROUP_DETAIL = 'api.permission_group.detail';
    const API_PERMISSION_GROUP_CREATE = 'api.permission_group.create';
    const API_PERMISSION_GROUP_UPDATE = 'api.permission_group.update';
    const API_PERMISSION_GROUP_DELETE = 'api.permission_group.delete';

    /**
     * Permission API
     */
    const API_PERMISSION_LIST = 'api.permission.list';
    const API_PERMISSION_DETAIL = 'api.permission.detail';
    const API_PERMISSION_CREATE = 'api.permission.create';
    const API_PERMISSION_UPDATE = 'api.permission.update';
    const API_PERMISSION_DELETE = 'api.permission.delete';

    private $blacklist = [
        self::API_ROLE_CREATE,
        self::API_ROLE_UPDATE,
        self::API_ROLE_DELETE,

        self::API_PERMISSION_GROUP_CREATE,
        self::API_PERMISSION_GROUP_UPDATE,
        self::API_PERMISSION_GROUP_DELETE,

        self::API_PERMISSION_CREATE,
        self::API_PERMISSION_UPDATE,
        self::API_PERMISSION_DELETE,
    ];

    /**
     * @return string[]
     */
    public function getBlacklist(): array
    {
        return $this->blacklist;
    }

    /**
     * @param string[] $blacklist
     */
    public function setBlacklist(array $blacklist): void
    {
        $this->blacklist = array_merge($this->blacklist, $blacklist);
    }
}
