<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room Statement - {{ $tenant->name }}</title>
    <style>
        @page { margin: 100px 25px; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #1a202c; line-height: 1.5; }
        
        /* OPLANLA Branding */
        .header { position: fixed; top: -60px; left: 0; right: 0; height: 50px; border-bottom: 2px solid #ad68e4; padding-bottom: 10px; }
        .brand { font-size: 24px; font-weight: bold; color: #ad68e4; letter-spacing: -1px; }
        .document-type { float: right; font-size: 14px; color: #718096; text-transform: uppercase; margin-top: 8px; }

        /* Information Grid */
        .info-section { margin-top: 20px; width: 100%; border-collapse: collapse; }
        .info-box { width: 50%; vertical-align: top; }
        .label { font-size: 10px; font-weight: bold; color: #a0aec0; text-transform: uppercase; margin-bottom: 4px; }
        .value { font-size: 14px; font-weight: bold; color: #2d3748; }

        /* Table Styling */
        table.transactions { width: 100%; border-collapse: collapse; margin-top: 40px; }
        th { background-color: #f7fafc; color: #4a5568; text-align: left; padding: 12px; font-size: 11px; text-transform: uppercase; border-bottom: 1px solid #edf2f7; }
        td { padding: 12px; border-bottom: 1px solid #edf2f7; font-size: 12px; color: #4a5568; }
        .text-right { text-align: right; }
        
        /* Summary Footer */
        .summary-wrapper { margin-top: 30px; margin-left: auto; width: 250px; background-color: #fdfaff; padding: 20px; border-radius: 12px; border: 1px solid #f3e8ff; }
        .summary-row { display: table; width: 100%; margin-bottom: 5px; }
        .summary-label { display: table-cell; font-size: 12px; color: #6b7280; }
        .summary-value { display: table-cell; text-align: right; font-size: 16px; font-weight: bold; color: #ad68e4; }

        .footer { position: fixed; bottom: -60px; left: 0; right: 0; height: 30px; font-size: 10px; color: #a0aec0; text-align: center; border-top: 1px solid #edf2f7; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <span class="brand">OPLANLA</span>
        <span class="document-type">Room Statement of Account</span>
    </div>

    <table class="info-section">
        <tr>
            <td class="info-box">
                <div class="label">Tenant Details</div>
                <div class="value">{{ $tenant->name }}</div>
                <div style="font-size: 12px; color: #718096;">{{ $tenant->email }}</div>
            </td>
            <td class="info-box" style="text-align: right;">
                <div class="label">Property & Unit</div>
                <div class="value">{{ $room->property->name ?? 'OPLANLA Property' }}</div>
                <div style="font-size: 12px; color: #718096;">Unit {{ $room->room_number }}</div>
            </td>
        </tr>
    </table>

    <table class="transactions">
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Reference</th>
                <th class="text-right">Amount (ZAR)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->verified_at ? $payment->verified_at->format('d M Y') : $payment->created_at->format('d M Y') }}</td>
                    <td>{{ $payment->payment_type === 'all' ? 'Aggregate Rent/Utility Settlement' : 'Room/Utility Charge' }}</td>
                    <td style="font-family: monospace; font-size: 11px;">{{ $payment->invoice_number }}</td>
                    <td class="text-right">R {{ number_format($payment->amount, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #a0aec0; padding: 30px;">No transaction history found for this period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary-wrapper">
        <div class="summary-row">
            <span class="summary-label">Total Settled:</span>
            <span class="summary-value">R {{ number_format($total_paid, 2) }}</span>
        </div>
        <div class="summary-row" style="margin-top: 10px; border-top: 1px dashed #e9d5ff; padding-top: 10px;">
            <span class="summary-label" style="font-size: 10px; font-weight: bold; text-transform: uppercase;">Status:</span>
            <span class="summary-value" style="font-size: 12px; color: #059669;">Statement Verified</span>
        </div>
    </div>

    <div class="footer">
        Generated on {{ now()->format('d M Y, H:i') }} - This is a digital financial record for OPLANLA and its associated property owners.
    </div>
</body>
</html>