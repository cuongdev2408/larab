<?php

namespace CuongDev\Larab\Abstraction\Core\Controllers;

use App\Http\Controllers\Controller;
use CuongDev\Larab\Abstraction\__Trait\ApiTrait;
use CuongDev\Larab\Abstraction\Definition\DefineRoute;
use CuongDev\Larab\Abstraction\Definition\Message;
use CuongDev\Larab\Abstraction\Object\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Route;

abstract class ABaseApiController extends Controller
{
    use ApiTrait;

    protected $apiResponse;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->apiResponse = new ApiResponse();
    }
}
