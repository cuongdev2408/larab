<?php


namespace CuongDev\Larab\App\Http\Controllers\Api;


use CuongDev\Larab\Abstraction\Core\Controllers\AApiCrudController;
use CuongDev\Larab\App\Services\SystemOptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SystemOptionController extends AApiCrudController
{

    public function __construct(SystemOptionService $systemOptionService)
    {
        parent::__construct();
        $this->baseService = $systemOptionService;
    }
}
