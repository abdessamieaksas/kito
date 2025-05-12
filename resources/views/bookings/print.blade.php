<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booking #{{ $booking->id }} - PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #222; margin: 0; padding: 0; }
        .container { max-width: 700px; margin: 30px auto; border: 1px solid #e5e7eb; border-radius: 10px; box-shadow: 0 1px 3px #0001; background: #fff; padding: 32px; }
        .header { background: #1e40af; color: #fff; padding: 24px 32px; border-radius: 10px 10px 0 0; }
        .header h1 { margin: 0 0 8px 0; font-size: 2em; }
        .status { font-weight: bold; padding: 4px 12px; border-radius: 6px; display: inline-block; margin-bottom: 8px; }
        .status.pending { background: #fef9c3; color: #b45309; }
        .status.confirmed { background: #bbf7d0; color: #166534; }
        .status.cancelled { background: #fecaca; color: #991b1b; }
        .section { margin-bottom: 24px; }
        .section-title { font-size: 1.1em; font-weight: bold; margin-bottom: 8px; color: #1e40af; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .info-table td { padding: 6px 0; vertical-align: top; }
        .info-label { font-weight: bold; width: 180px; color: #374151; }
        .info-value { color: #222; }
        .summary-table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        .summary-table th, .summary-table td { border: 1px solid #e5e7eb; padding: 8px; text-align: right; }
        .summary-table th { background: #f1f5f9; color: #1e40af; font-size: 0.95em; }
        .summary-table td.label { text-align: left; font-weight: bold; color: #374151; }
        .footer { font-size: 0.9em; color: #6b7280; text-align: right; margin-top: 32px; border-top: 1px solid #e5e7eb; padding-top: 12px; }
        .watermark { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); font-size: 5em; color: #f3f4f6; opacity: 0.3; z-index: 0; pointer-events: none; white-space: nowrap; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Watermark -->
        @if($booking->status === 'confirmed')
            <div class="watermark">CONFIRMED</div>
        @elseif($booking->status === 'cancelled')
            <div class="watermark">CANCELLED</div>
        @elseif($booking->status === 'pending')
            <div class="watermark">PENDING</div>
        @endif

        <div class="header">
            <h1>Booking #{{ $booking->id }}</h1>
            <div class="status {{ $booking->status }}">{{ ucfirst($booking->status) }}</div>
            <div style="font-size: 0.95em; margin-top: 8px;">Booking Date: {{ $booking->created_at->format('F d, Y') }}</div>
        </div>

        <div class="section">
            <div class="section-title">Guest Information</div>
            <table class="info-table">
                <tr><td class="info-label">Name:</td><td class="info-value">{{ $booking->user->name }}</td></tr>
                <tr><td class="info-label">Email:</td><td class="info-value">{{ $booking->user->email }}</td></tr>
                <tr><td class="info-label">Phone:</td><td class="info-value">{{ $booking->user->phone ?? 'Not provided' }}</td></tr>
                <tr><td class="info-label">Booking Date:</td><td class="info-value">{{ $booking->created_at->format('M d, Y') }}</td></tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Room Information</div>
            <table class="info-table">
                <tr><td class="info-label">Room Number:</td><td class="info-value">{{ $booking->room->room_number }}</td></tr>
                <tr><td class="info-label">Room Type:</td><td class="info-value">{{ ucfirst($booking->room->type) }}</td></tr>
                <tr><td class="info-label">Price per Night:</td><td class="info-value">${{ number_format($booking->room->price, 2) }}</td></tr>
                <tr><td class="info-label">Total Nights:</td><td class="info-value">{{ $booking->check_in->diffInDays($booking->check_out) }}</td></tr>
                <tr><td class="info-label">Check-in:</td><td class="info-value">{{ $booking->check_in->format('M d, Y') }}</td></tr>
                <tr><td class="info-label">Check-out:</td><td class="info-value">{{ $booking->check_out->format('M d, Y') }}</td></tr>
                <tr><td class="info-label">Total Room Cost:</td><td class="info-value">${{ number_format($booking->room->price * $booking->check_in->diffInDays($booking->check_out), 2) }}</td></tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Payment Summary</div>
            <table class="summary-table">
                <tr><th class="label">Description</th><th>Amount</th></tr>
                <tr><td class="label">Total Paid</td><td>${{ number_format($booking->payments->sum('amount'), 2) }}</td></tr>
                @php $total = $booking->room->price * $booking->check_in->diffInDays($booking->check_out); @endphp
                @if($total > $booking->payments->sum('amount'))
                    <tr><td class="label">Balance Due</td><td style="color:#b91c1c; font-weight:bold;">${{ number_format($total - $booking->payments->sum('amount'), 2) }}</td></tr>
                @else
                    <tr><td class="label" colspan="2" style="color:#166534; font-weight:bold; text-align:center;">Paid in Full</td></tr>
                @endif
            </table>
        </div>

        @if(isset($booking->special_requests) && !empty($booking->special_requests))
        <div class="section">
            <div class="section-title">Special Requests</div>
            <div style="background:#f3f4f6; border-radius:6px; padding:10px 14px; color:#374151;">{{ $booking->special_requests }}</div>
        </div>
        @endif

        <div class="footer">
            Generated on {{ now()->format('F d, Y H:i') }}<br>
            Booking Reference: #{{ $booking->id }}<br>
            Document ID: {{ md5($booking->id . $booking->created_at) }}
        </div>
    </div>
</body>
</html>