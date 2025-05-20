<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase Order #{{ $order->id }}</title>
    <style>
        /* Base Styles - Optimized for single page */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.3;
            margin: 0;
            padding: 0;
            background-color: #fff;
            font-size: 10pt;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 10px;
        }

        /* Header Styles - Compact for single page */
        .header {
            padding: 10px 0;
            border-bottom: 2px solid #4b6cb7;
            margin-bottom: 10px;
            position: relative;
            height: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 800;
            color: #000;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .logo-tagline {
            font-size: 9px;
            color: #666;
            margin: 0;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .company-info {
            text-align: right;
            border-left: 1px solid #eee;
            padding-left: 15px;
        }

        .company-info h2 {
            color: #000;
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .company-info p {
            margin: 2px 0;
            font-size: 9px;
            color: #666;
        }

        /* Document Title - Compact */
        .document-title {
            text-align: center;
            color: #000;
            font-size: 18px;
            margin: 10px 0;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 1px;
            border-bottom: 1px solid #4b6cb7;
            padding-bottom: 5px;
            background-color: #f8f9fa;
            padding: 8px;
            border-radius: 4px 4px 0 0;
        }

        /* Order Information Section - Compact */
        .order-info-container {
            display: flex;
            justify-content: space-between;
            margin: 10px 0 15px 0;
        }

        .order-info {
            width: 48%;
            padding: 8px;
            background-color: #f9f9f9;
            border-radius: 4px;
            border-left: 3px solid #4b6cb7;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .order-info h3 {
            margin-top: 0;
            color: #4b6cb7;
            font-size: 12px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
            margin-bottom: 8px;
        }

        .order-info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            border-bottom: 1px dotted #eee;
            padding-bottom: 4px;
        }

        .order-info-label {
            font-weight: 600;
            width: 40%;
            color: #555;
            text-transform: uppercase;
            font-size: 8px;
            letter-spacing: 0.5px;
        }

        .order-info-value {
            width: 60%;
            font-size: 9px;
        }

        /* Order Items Table - Compact */
        .order-items-container {
            margin: 10px 0;
        }

        .order-items-title {
            font-size: 12px;
            color: #4b6cb7;
            margin-bottom: 5px;
            font-weight: 600;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
        }

        .order-items {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #ddd;
        }

        .order-items th {
            background-color: #4b6cb7;
            color: white;
            padding: 5px 8px;
            text-align: left;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .order-items td {
            padding: 5px 8px;
            border-bottom: 1px solid #eee;
            font-size: 9px;
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
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #4b6cb7;
        }

        .total-value {
            font-size: 10px;
            color: #4b6cb7;
            font-weight: bold;
        }

        /* Signature Section - Compact */
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
        }

        .signature-box {
            width: 45%;
            border-top: 1px solid #ddd;
            padding-top: 5px;
            text-align: center;
        }

        .signature-title {
            font-size: 8px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #555;
        }

        /* Footer - Compact */
        .footer {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-size: 7px;
            color: #777;
            text-align: center;
        }

        .footer p {
            margin: 2px 0;
        }

        .page-number {
            text-align: right;
            font-size: 7px;
            color: #999;
            margin-top: 5px;
        }

        /* Additional Elements - Compact */
        .gradient-bar {
            height: 4px;
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            margin-bottom: 10px;
            border-radius: 2px;
        }

        .section-title {
            font-size: 10px;
            color: #4b6cb7;
            margin: 10px 0 5px 0;
            font-weight: 600;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
        }

        .notes-section {
            margin: 10px 0;
            padding: 8px;
            background-color: #f9f9f9;
            border-radius: 4px;
            border-left: 3px solid #4b6cb7;
        }

        .notes-title {
            font-size: 9px;
            font-weight: 600;
            margin-top: 0;
            margin-bottom: 5px;
            color: #4b6cb7;
        }

        .notes-content {
            font-size: 8px;
            color: #555;
            font-style: italic;
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
                    <p class="logo-tagline">{{ $company['tagline'] }}</p>
                </div>
            </div>
            <div class="company-info">
                <h2>{{ $company['name'] }}</h2>
                <p>{{ $company['address'] }}</p>
                <p>Stock Management System</p>
                <p>{{ $company['email'] }}</p>
            </div>
        </div>

        <h1 class="document-title">Purchase Order</h1>

        <!-- Order Information in Two Columns -->
        <div class="order-info-container">
            <!-- Left Column - Order Details -->
            <div class="order-info">
                <h3>Order Information</h3>
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
                    <div class="order-info-label">Status:</div>
                    <div class="order-info-value">{{ ucfirst($order->status) }}</div>
                </div>
            </div>

            <!-- Right Column - Customer Details -->
            <div class="order-info">
                <h3>Customer Information</h3>
                <div class="order-info-row">
                    <div class="order-info-label">Customer:</div>
                    <div class="order-info-value">{{ $order->user->name }}</div>
                </div>
                <div class="order-info-row">
                    <div class="order-info-label">Email:</div>
                    <div class="order-info-value">{{ $order->user->email }}</div>
                </div>
                <div class="order-info-row">
                    <div class="order-info-label">Role:</div>
                    <div class="order-info-value">{{ ucfirst($order->user->role) }}</div>
                </div>
                <div class="order-info-row">
                    <div class="order-info-label">Date Joined:</div>
                    <div class="order-info-value">{{ $order->user->created_at->format('F d, Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Order Items Section -->
        <div class="order-items-container">
            <h3 class="order-items-title">Order Items</h3>
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
        </div>

        <!-- Notes Section (if order has notes) -->
        @if($order->notes)
        <div class="notes-section">
            <h4 class="notes-title">Order Notes</h4>
            <div class="notes-content">{{ $order->notes }}</div>
        </div>
        @endif

        <div class="signature-section">
            <div class="signature-box">
                <p class="signature-title">Customer Signature</p>
                <div style="height: 20px;"></div>
                <p style="font-size: 8px;">{{ $order->user->name }}</p>
            </div>
            <div class="signature-box">
                <p class="signature-title">Authorized Signature</p>
                <div style="height: 20px;"></div>
                <p style="font-size: 8px;">ANNISTOCK Representative</p>
            </div>
        </div>

        <div class="footer">
            <p>This document was automatically generated by the ANNISTOCK System.</p>
            <p>All products listed in this purchase order are subject to our standard terms and conditions.</p>
            <p>© {{ date('Y') }} ANNISTOCK - All Rights Reserved</p>
        </div>

        <div class="page-number">
            Page 1 of 1 | Generated on {{ $generated_at }}
        </div>
    </div>
</body>
</html>
