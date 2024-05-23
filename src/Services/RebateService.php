<?php

namespace App\Services;

use App\Interfaces\RebateServiceInterface;

class RebateService implements RebateServiceInterface
{
    /**
     * Rabat procentowy
     */ 
    public function getRebate($terminId): int
    {
        // Implement logic to determine the rebate percentage based on $terminId
        // For example, we could use a database query, configuration file, or a calculation

        return 10;
    }
}
