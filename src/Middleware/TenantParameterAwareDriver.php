<?php declare(strict_types=1);

namespace App\Middleware;

use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Driver\Middleware\AbstractDriverMiddleware;

class TenantParameterAwareDriver extends AbstractDriverMiddleware
{

    public function connect(array $params): Connection
    {
        $conn = parent::connect($params);

        if ($params['user'] == 'application') {
            $conn->exec("SET app.current_tenant TO DEFAULT;");
        }

        return $conn;
    }

}
