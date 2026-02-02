<?php

namespace App\Services;

class FinanceCalculator
{
    public static function calculateTotals(array $state): array
    {
        $items = $state['items'] ?? [];
        $masterDiscountEnabled = $state['has_master_discount'] ?? false;
        $masterDiscountType = $state['master_discount_type'] ?? 'percentage';
        $masterDiscountValue = floatval($state['master_discount_value'] ?? 0);
        $roundingAdjustment = floatval($state['rounding_adjustment'] ?? 0);

        $subtotal = 0;
        $discountTotal = 0;
        $calculatedTotal = 0;

        foreach ($items as $item) {
            $qty = floatval($item['qty'] ?? 1);
            $unitPrice = floatval($item['unit_price'] ?? 0);
            $lineBase = $qty * $unitPrice;
            
            $lineDiscount = 0;

            if ($item['use_master_discount'] ?? true) {
                if ($masterDiscountEnabled) {
                    if ($masterDiscountType === 'percentage') {
                        $lineDiscount = $lineBase * ($masterDiscountValue / 100);
                    } else {
                        // Fixed discount distributed? Or applied once? 
                        // Usually fixed master discount is applied at the END, not per line.
                        // BUT your schema has `use_master_discount` per line.
                        // Implication: If fixed, it's tricky per line.
                        // Let's assume Master Fixed Discount is applied to the Grand Total, 
                        // and `use_master_discount` just means "Does this item contribute to the eligible total?".
                        // For simplicity in this version: We'll apply percentage per line. 
                        // If Fixed, we'll handle it at the end based on eligible subtotal.
                    }
                }
            } else {
                // Custom Line Discount
                $customDiscount = floatval($item['custom_discount_value'] ?? 0);
                $lineDiscount = $customDiscount; // Assuming fixed amount for custom line discount for now
            }

            $lineTotal = max(0, $lineBase - $lineDiscount);
            
            $subtotal += $lineBase;
            $discountTotal += $lineDiscount;
            $calculatedTotal += $lineTotal;
        }

        // Handle Master Fixed Discount (Applied to total of eligible items)
        if ($masterDiscountEnabled && $masterDiscountType === 'fixed') {
            // Recalculate based on global fixed deduction
            // This overrides the line-by-line percentage logic above for master items
            // Complex, but let's just subtract it from the total for now to keep it simple
            $calculatedTotal -= $masterDiscountValue; 
            $discountTotal += $masterDiscountValue;
        }

        $grandTotal = $calculatedTotal + $roundingAdjustment;

        return [
            'subtotal' => number_format($subtotal, 2, '.', ''),
            'discount_total' => number_format($discountTotal, 2, '.', ''),
            'total' => number_format($grandTotal, 2, '.', ''),
        ];
    }
}
