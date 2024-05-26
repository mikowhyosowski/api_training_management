<?php

namespace App\Training\Services;

use App\Training\Interfaces\RebateInterface;

/**
 * This class implements the RebateInterface and provides a simple example
 * for calculating a rebate percentage.
 *
 * In a real-world scenario, the logic to determine the rebate percentage
 * would likely involve querying a database, reading from a configuration file,
 * or performing more complex calculations based on business rules.
 */
class RebateService implements RebateInterface
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
