<?php declare(strict_types=1);

namespace App\Middleware;

use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Driver\Middleware;

class TenantParameterMiddleware implements Middleware
{
    public function wrap(Driver $driver): Driver
    {
        return new TenantParameterAwareDriver($driver);
    }
}

