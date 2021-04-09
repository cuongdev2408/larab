# CuongDev Laravel Abstraction
#### CuongDev Laravel Abstraction for starter project
#### Bộ source code dùng làm base cho các project Laravel

```
https://github.com/cuongdev2408/larab
```

I. Bắt đầu

1. Cài đặt

- Cài đặt packages chính:

```
    - cuongdev/larab
```

- Các packages cần thiết đi kèm bên trong gồm:

```
    - prettus/l5-repository
    - tymon/jwt-auth
    - spatie/laravel-permission
```

- Cài thêm package mongodb nếu cần:

```
    - jenssegers/mongodb
```

#### Lưu ý:

#### - spatie/laravel-permission đang không hoạt động với jenssegers/mongodb

#### - Sau khi cài đặt xong các package, cần làm theo hướng dẫn cài đặt của các package đó.

- Cấu hình L5-repository

`https://github.com/andersao/l5-repository#installation`

- Cấu hình JWT Auth

`https://jwt-auth.readthedocs.io/en/develop/laravel-installation/`
`https://jwt-auth.readthedocs.io/en/develop/quick-start/`

- Cấu hình Spatie Laravel-permission

`https://spatie.be/docs/laravel-permission/v3/installation-laravel`

- Sửa config/queues.php để có thể sử dụng DB transaction (Nếu dùng mongodb)

`https://github.com/jenssegers/laravel-mongodb#queues`

- Thêm các Provider cần thiết vào `config/app.php`

```
    /*
     * Package Service Providers...
     */
    CuongDev\Larab\LarabServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
```

- Thêm JWT middleware vào app/Http/Kernel.php

```
  protected $routeMiddleware = [
        // Additional middleware
        'auth.jwt' => \Tymon\JWTAuth\Http\Middleware\Authenticate::class, // JWT middleware
    ];
```

- Chỉnh sửa file `config/auth.php`:

```
'defaults' => [
    'guard' => 'api',
    'passwords' => 'users',
],

...

'guards' => [
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
```

- Model User extends \CuongDev\Larab\App\Models\User


- Thêm biến môi trường vào file .env:

```
##### CuongDev Larab
# Admin account
SUPER_ADMIN_EMAIL=
SUPER_ADMIN_PASSWORD=

#Project Environment
JWT_SECRET=
JWT_PUBLIC_KEY=
JWT_PRIVATE_KEY=
JWT_PASSPHRASE=
JWT_TTL=
JWT_REFRESH_TTL=
JWT_ALGO=
JWT_LEEWAY=
JWT_BLACKLIST_ENABLED=
JWT_BLACKLIST_GRACE_PERIOD=
```

- Chaỵ lệnh:

```
    php artisan key:generate
    php artisan vendor:publish --provider "Prettus\Repository\Providers\RepositoryServiceProvider"
    php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
    php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
    php artisan jwt:secret
    
    // Development
    php artisan optimize:clear
    // Production
    php artisan optimize
    
    php artisan migrate
    php artisan db:seed --class=CuongDev\\Larab\\Database\\Seeders\\LarabSeeder
```

2. Cấu trúc
- CuongDev Larab xây dựng sẵn 1 bộ Core để bạn dễ dàng thừa kế, giúp nhanh chóng xây dựng tính năng, thao tác với cơ sở dữ liệu dễ dàng hơn.

```
Core: 
    - Controllers:
        - AApiCrudController
        - ABaseApiController
    - Models:
        - AAuthenticatableModel
        - AModel
        - AMongodbAuthenticatableModel
        - AMongodbModel 
    - Repositories:
        - ABaseRepository
    - Services:
        - ABaseService   
 
Abstraction:       
    Definition:
        - Constant
        - DefinePermission 
        - DefineRole 
        - DefineRoute 
        - Message
        - StatusCode 
        
    Library:
        - Helper
        
    Object:
        - ApiResponse
        - Result
```

3. Kế thừa

    a) Abstraction

- Tạo 1 thư mục Abstraction ở trong thư mục app của project

```
Abstraction:       
    Definition:
        - DefinePermission
        - DefineRole
        - DefineRoute

    Library:
        - Helper
```

- File app/Abstraction/DefinePermission

```
<?php

namespace App\Abstraction\Definition;

class DefinePermission extends \CuongDev\Larab\Abstraction\Definition\DefinePermission
{
    public function __construct()
    {
        $this->setPermissionGroups([

        ]);

        $this->setPermissions([

        ]);
    }
}

```

- File app/Abstraction/DefineRole

```
<?php

namespace App\Abstraction\Definition;

class DefineRole extends \CuongDev\Larab\Abstraction\Definition\DefineRole
{
    public function __construct()
    {
        $this->setRoles([

        ]);
    }
}
```

- File app/Abstraction/DefineRoute

```
<?php

namespace App\Abstraction\Definition;

class DefineRoute extends \CuongDev\Larab\Abstraction\Definition\DefineRoute
{
    public function __construct()
    {
        $this->setBlacklist([

        ]);
    }
}
```

    b) Seeders

- AclSeeder: File này được dùng để xây dựng hệ thống phân quyền. Ngoài những quyền mặc định được định nghĩa sẵn trong package, thì bạn có thể định nghĩa thêm các role, permission group, permission bằng cách tạo 1 seeder mới và extends AclSeeder
   + Dữ liệu truyền vào là mảng dạng:

```
[
   'key_name_1' => 'Display Name 1',
   'key_name_2' => 'Display Name 2',
]
```


```
<?php

namespace Database\Seeders;

use App\Abstraction\Definition\DefinePermission;
use App\Abstraction\Definition\DefineRole;
use CuongDev\Larab\Database\Seeders\AclSeeder;

class CustomAclSeeder extends AclSeeder
{
    public function __construct()
    {
        parent::__construct();
        $this->defineRole->setRoles((new DefineRole())->getRoles());
        $this->definePermission->setPermissionGroups((new DefinePermission())->getPermissionGroups());
        $this->definePermission->setPermissions((new DefinePermission())->getPermissions());
    }
}
```
