<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .receipt {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #dc2626;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #dc2626;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .hotel-name {
            color: #dc2626;
            font-size: 24px;
            font-weight: bold;
        }
        .details {
            margin-bottom: 20px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details th, .details td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <div class="hotel-name">Hotel Management System</div>
            <div>Payment Receipt</div>
        </div>

        <div class="details">
            <table>
                <tr>
                    <th>Receipt No:</th>
                    <td>{{ $payment->id }}</td>
                    <th>Date:</th>
                    <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                </tr>
                <tr>
                    <th>Guest Name:</th>
                    <td>{{ $client->first_name }} {{ $client->last_name }}</td>
                    <th>Room No:</th>
                    <td>{{ $room->room_number }}</td>
                </tr>
                <tr>
                    <th>Check In:</th>
                    <td>{{ $booking->check_in_date->format('M d, Y') }}</td>
                    <th>Check Out:</th>
                    <td>{{ $booking->check_out_date->format('M d, Y') }}</td>
                </tr>
                <tr>
                    <th>Payment Method:</th>
                    <td>{{ ucfirst($payment->payment_method) }}</td>
                    <th>Status:</th>
                    <td>Paid</td>
                </tr>
            </table>
        </div>

        <div class="total">
            Total Amount: ${{ number_format($payment->amount, 2) }}
        </div>

        <div class="footer">
            Thank you for choosing our hotel!
            <br>
            For any queries, please contact us at support@hotel.com
        </div>
    </div>
</body>
</html> 