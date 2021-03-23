<?php

namespace CuongDev\Larab\Abstraction\Core\Controllers;

use App\Http\Controllers\Controller;
use CuongDev\Larab\Abstraction\__Trait\ApiTrait;
use CuongDev\Larab\Abstraction\Object\ApiResponse;

abstract class ABaseApiController extends Controller
{
    use ApiTrait;

    protected $apiResponse;

    public function __construct()
    {
        $this->apiResponse = new ApiResponse();
    }
}
