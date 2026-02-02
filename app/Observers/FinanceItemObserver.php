<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class FinanceItemObserver
{
    public function saving(Model $item): void
    {
        $qty = (float) $item->qty;
        $unitPrice = (float) $item->unit_price;
        $lineBase = $qty * $unitPrice;
        
        $lineDiscount = 0;

        // Check if we are handling a Quote Item or Invoice Item
        // And if it uses Master Discount logic.
        // Note: Master Discount calculation usually happens at the Header level for display,
        // BUT if `row_total` is stored, we need to know the effective price.
        
        // ISSUE: We don't have access to the Parent Header (Quote/Invoice) easily here 
        // to know the Master Discount % value without a query.
        
        // RE-THINKING:
        // Storing `row_total` implies storing the FINAL price.
        // If master discount changes on the header, all rows need updates.
        // This is complex for an Observer.
        
        // SIMPLER FIX for now:
        // Calculate `row_total` based on LOCAL columns only (qty * unit_price - custom_discount).
        // If `use_master_discount` is true, `row_total` might just be `qty * unit_price` (Gross),
        // and the Header subtracts the Master Discount from the SUM of Row Totals.
        
        // Let's adopt this: Row Total = Gross - Custom Discount.
        // Master Discount is applied to the Subtotal of eligible rows.
        
        if ($item->use_master_discount) {
            // No custom discount applied here. 
            // Row Total is effectively the Gross Amount for this line.
            // The Master Discount is deducted later from the Header Total.
            $lineDiscount = 0;
        } else {
            // Apply Custom Discount
            $customDiscount = (float) $item->custom_discount_value;
            // Assuming custom discount is a fixed amount for now (based on Schema)
            $lineDiscount = $customDiscount;
        }

        $item->row_total = max(0, $lineBase - $lineDiscount);
    }
}