<?php


namespace CuongDev\Larab\App\Services;


use CuongDev\Larab\Abstraction\Core\Services\ABaseService;
use CuongDev\Larab\App\Repositories\SystemOptionRepository;

class SystemOptionService extends ABaseService
{

    public function __construct()
    {
        parent::__construct();
        $this->baseRepository = resolve(SystemOptionRepository::class);

        $this->baseRepository->setComparableFields([
            'meta_key',
            'meta_value',
        ]);

        $this->baseRepository->setSearchableFields([
            'meta_key',
            'meta_value',
        ]);
    }
}
