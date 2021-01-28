<?php

namespace CuongDev\Larab\Abstraction\Core\Controllers;

use CuongDev\Larab\Abstraction\__Trait\ApiTrait;
use CuongDev\Larab\Abstraction\Object\ApiResponse;
use App\Http\Controllers\Controller;

abstract class ABaseApiController extends Controller
{
    use ApiTrait;

    protected $apiResponse;

    public function __construct()
    {
        $this->apiResponse = new ApiResponse();
    }
}
