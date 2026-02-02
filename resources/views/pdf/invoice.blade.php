@extends('pdf.layout')

@section('title', 'Invoice ' . $record->invoice_number)

@section('content')
    <table class="meta-table">
        <tr>
            <td width="50%">
                <strong>Bill To:</strong><br>
                {{ $record->business->name }}<br>
                {{ $record->business->billing_address ?? '' }}<br>
                {{ $record->business->owner->email ?? '' }}
            </td>
            <td width="50%" class="text-right">
                <h2 style="margin: 0; color: #444;">INVOICE</h2>
                <strong>Number:</strong> {{ $record->invoice_number }}<br>
                <strong>Date:</strong> {{ $record->created_at->format('d M, Y') }}<br>
                <strong>Due Date:</strong> {{ $record->due_date ? $record->due_date->format('d M, Y') : 'N/A' }}<br>
                <strong>Currency:</strong> {{ $record->currency }}
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Disc.</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($record->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td class="text-right">{{ $item->qty }}</td>
                    <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">
                        @if($item->use_master_discount)
                            <span style="color: #888;">(Master)</span>
                        @else
                            {{ number_format($item->custom_discount_value, 2) }}
                        @endif
                    </td>
                    <td class="text-right">{{ number_format($item->row_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width: 40%; margin-left: auto;">
        <tr>
            <td><strong>Subtotal:</strong></td>
            <td class="text-right">{{ number_format($record->subtotal, 2) }}</td>
        </tr>
        @if($record->has_master_discount)
        <tr>
            <td>
                <strong>Discount 
                    ({{ $record->master_discount_type === 'percentage' ? $record->master_discount_value . '%' : 'Fixed' }}):
                </strong>
            </td>
            <td class="text-right" style="color: red;">-{{ number_format($record->discount_total, 2) }}</td>
        </tr>
        @endif
        @if($record->tax_total > 0)
        <tr>
            <td><strong>Tax:</strong></td>
            <td class="text-right">{{ number_format($record->tax_total, 2) }}</td>
        </tr>
        @endif
        @if($record->rounding_adjustment != 0)
        <tr>
            <td><strong>Rounding:</strong></td>
            <td class="text-right">{{ number_format($record->rounding_adjustment, 2) }}</td>
        </tr>
        @endif
        <tr class="total-row" style="font-size: 16px;">
            <td><strong>Total:</strong></td>
            <td class="text-right">{{ number_format($record->total, 2) }} {{ $record->currency }}</td>
        </tr>
    </table>

    @if($record->notes)
        <div class="notes">
            <strong>Notes:</strong><br>
            {{ $record->notes }}
        </div>
    @endif
@endsection
