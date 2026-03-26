<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { border-bottom: 2px solid #ad68e4; padding-bottom: 20px; margin-bottom: 30px; }
        .brand { color: #ad68e4; font-size: 24px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f9fafb; text-align: left; padding: 12px; font-size: 12px; color: #6b7280; text-transform: uppercase; }
        td { padding: 12px; border-bottom: 1px solid #f3f4f6; font-size: 13px; }
        .total-box { margin-top: 30px; text-align: right; padding: 20px; background: #fdfaff; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <span class="brand">OPLANLA</span>
        <div style="float: right; text-align: right;">
            <p style="margin: 0; font-size: 14px;"><strong>{{ $title }}</strong></p>
            <p style="margin: 0; font-size: 12px; color: #666;">Issued: {{ $date }}</p>
        </div>
    </div>

    <p><strong>Filter Scope:</strong> {{ $filter_tenant }}</p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Tenant</th>
                <th>Room</th>
                <th>Reference</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->verified_at->format('d M Y') }}</td>
                <td>{{ $payment->tenant->name }}</td>
                <td>{{ $payment->tenant->room->room_number }}</td>
                <td style="font-family: monospace;">{{ $payment->invoice_number }}</td>
                <td style="text-align: right;">R {{ number_format($payment->amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        <span style="color: #666;">Total Collected:</span>
        <span style="font-size: 20px; font-weight: bold; color: #ad68e4; margin-left: 10px;">R {{ number_format($total, 2) }}</span>
    </div>
</body>
</html>