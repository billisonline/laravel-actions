<?php

namespace BYanelli\Actions\Tests\TestApp\Actions;

use BYanelli\Actions\Tests\TestApp\Services\InvokableResultService;

class TestInvokableAction
{
    /**
     * @var InvokableResultService
     */
    private $resultService;

    public function __construct(InvokableResultService $resultService)
    {
        $this->resultService = $resultService;
    }

    public function __invoke()
    {
        return $this->resultService->result();
    }
}
