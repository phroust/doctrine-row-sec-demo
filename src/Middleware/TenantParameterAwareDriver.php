<?php declare(strict_types=1);

namespace App\Middleware;

use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Driver\Middleware\AbstractDriverMiddleware;

class TenantParameterAwareDriver extends AbstractDriverMiddleware
{

    public function connect(array $params): Connection
    {
        $conn = parent::connect($params);

        # make sure the parameter is always present.
        # this allows queries to succeed and return an empty result instead of throwing an error
        $conn->exec('SET app.current_tenant TO DEFAULT;');

        # todo: override the ID from whatever source there might be
        # example:
        if (($tenantID = (int)getenv('TENANT_ID'))) {
            $conn->exec(sprintf('SET app.current_tenant TO %d;', $tenantID));
        }

        return $conn;
    }

}
