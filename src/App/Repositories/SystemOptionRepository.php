<?php


namespace CuongDev\Larab\App\Repositories;


use CuongDev\Larab\Abstraction\Core\Repositories\ABaseRepository;
use CuongDev\Larab\App\Models\SystemOption;

class SystemOptionRepository extends ABaseRepository
{

    function model(): string
    {
        return SystemOption::class;
    }

}
