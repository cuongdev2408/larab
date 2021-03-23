<?php

namespace CuongDev\Larab\Abstraction\Core\Controllers;

use App\Http\Controllers\Controller;
use CuongDev\Larab\Abstraction\__Trait\ApiTrait;
use CuongDev\Larab\Abstraction\Definition\DefineRoute;
use CuongDev\Larab\Abstraction\Object\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Route;

abstract class ABaseApiController extends Controller
{
    use ApiTrait;

    protected $apiResponse;

    public function __construct()
    {
        $this->apiResponse = new ApiResponse();

        if (Route::is(DefineRoute::$blacklist)) {
            throw new Exception('API này tạm khóa để nâng cấp tính năng!');
        }
    }
}
