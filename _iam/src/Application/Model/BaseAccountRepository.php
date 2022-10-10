<?php declare(strict_types=1);

namespace Iam\Application\Model;

use Iam\Application\ApplicationPort;

interface BaseAccountRepository extends ApplicationPort
{
    public function save(BaseAccount $baseAccount): void;
}
