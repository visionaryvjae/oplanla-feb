<?php

namespace App\Services;

use App\Models\Booking\Tariff;

class UtilityBillingService
{
    /**
     * Calculates the Rand value based on tiered blocks (IBT).
     */
    public function calculateCost($units, $utilityType)
    {
        $totalCost = 0;
        $remainingUnits = $units;

        // Fetch tiers for the specific utility (e.g., 'electricity')
        $tiers = Tariff::where('type', $utilityType)
                        ->orderBy('tier_level', 'asc')
                        ->get();

        foreach ($tiers as $tier) {
            if ($remainingUnits <= 0) break;

            // If block_limit is null, it's the final 'unlimited' tier
            $unitsInTier = ($tier->block_limit) 
                ? min($remainingUnits, $tier->block_limit) 
                : $remainingUnits;

            $totalCost += ($unitsInTier * $tier->price_per_unit);
            $remainingUnits -= $unitsInTier;
        }

        return $totalCost;
    }
}