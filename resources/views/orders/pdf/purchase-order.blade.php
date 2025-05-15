<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase Order #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            padding: 20px 0;
            border-bottom: 2px solid #4b6cb7;
            margin-bottom: 30px;
            position: relative;
            height: 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo-text {
            font-size: 32px;
            font-weight: 800;
            color: #000;
            margin: 0;
            letter-spacing: 1px;
        }
        .logo-tagline {
            font-size: 12px;
            color: #666;
            margin: 0;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .company-info {
            text-align: right;
        }
        .company-info h2 {
            color: #000;
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .company-info p {
            margin: 3px 0;
            font-size: 12px;
            color: #666;
        }
        .gradient-bar {
            height: 8px;
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            margin-bottom: 30px;
        }
        .document-title {
            text-align: center;
            color: #000;
            font-size: 28px;
            margin: 30px 0;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 2px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .order-info {
            margin: 30px 0;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            border-left: 5px solid #4b6cb7;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .order-info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            border-bottom: 1px dotted #eee;
            padding-bottom: 8px;
        }
        .order-info-label {
            font-weight: 600;
            width: 40%;
            color: #555;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        .order-info-value {
            width: 60%;
            font-size: 14px;
        }
        .order-items {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .order-items th {
            background-color: #4b6cb7;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .order-items td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
        }
        .order-items tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total-row {
            background-color: #f1f3f7 !important;
            font-weight: bold;
        }
        .total-label {
            text-align: right;
            padding-right: 20px;
            text-transform: uppercase;
            font-size: 14px;
        }
        .total-value {
            color: #4b6cb7;
            font-size: 18px;
            font-weight: 700;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 11px;
            text-align: center;
            color: #888;
        }
        .signature-section {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 45%;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            text-align: center;
        }
        .signature-title {
            font-size: 12px;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 30px;
        }
        .page-number {
            text-align: center;
            font-size: 10px;
            color: #999;
            margin-top: 30px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="gradient-bar"></div>

        <div class="header">
            <div class="logo-container">
                <div>
                    <h1 class="logo-text">ANNISTOCK</h1>
                    <p class="logo-tagline">Inventory Management</p>
                </div>
            </div>
            <div class="company-info">
                <h2>ANNISTOCK Inc.</h2>
                <p>Enterprise Analytics</p>
                <p>Stock Management System</p>
                <p>support@annistock.com</p>
            </div>
        </div>

        <h1 class="document-title">Purchase Order</h1>

        <div class="order-info">
            <div class="order-info-row">
                <div class="order-info-label">Order Number:</div>
                <div class="order-info-value">#{{ $order->id }}</div>
            </div>
            <div class="order-info-row">
                <div class="order-info-label">Order Name:</div>
                <div class="order-info-value">{{ $order->getDisplayName() }}</div>
            </div>
            <div class="order-info-row">
                <div class="order-info-label">Date Issued:</div>
                <div class="order-info-value">{{ $order->created_at->format('F d, Y') }}</div>
            </div>
            <div class="order-info-row">
                <div class="order-info-label">Customer:</div>
                <div class="order-info-value">{{ $order->user->name }}</div>
            </div>
            <div class="order-info-row">
                <div class="order-info-label">Status:</div>
                <div class="order-info-value">{{ ucfirst($order->status) }}</div>
            </div>
            @if($order->notes)
            <div class="order-info-row">
                <div class="order-info-label">Notes:</div>
                <div class="order-info-value">{{ $order->notes }}</div>
            </div>
            @endif
        </div>

        <table class="order-items">
            <thead>
                <tr>
                    <th style="width: 40%;">Product</th>
                    <th style="width: 20%;">Unit Price</th>
                    <th style="width: 15%;">Quantity</th>
                    <th style="width: 25%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" class="total-label">Total Amount:</td>
                    <td class="total-value">${{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="signature-section">
            <div class="signature-box">
                <p class="signature-title">Customer Signature</p>
                <div style="height: 40px;"></div>
                <p>{{ $order->user->name }}</p>
            </div>
            <div class="signature-box">
                <p class="signature-title">Authorized Signature</p>
                <div style="height: 40px;"></div>
                <p>ANNISTOCK Representative</p>
            </div>
        </div>

        <div class="footer">
            <p>This document was automatically generated by the ANNISTOCK System.</p>
            <p>All products listed in this purchase order are subject to our standard terms and conditions.</p>
            <p>© {{ date('Y') }} ANNISTOCK - All Rights Reserved</p>
        </div>

        <div class="page-number">
            Page 1 of 1 | Generated on {{ date('F d, Y') }}
        </div>
    </div>
</body>
</html>
