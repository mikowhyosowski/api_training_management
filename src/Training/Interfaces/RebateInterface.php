<?php

namespace App\Training\Interfaces;

interface RebateInterface
{
    /**
     * Get the rebate percentage for a given termin ID.
     *
     * @param int $terminId The ID of the termin
     * @return int The rebate percentage
     */
    public function getRebate($terminId): int;
}
