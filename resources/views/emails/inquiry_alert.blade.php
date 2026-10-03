<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Product Inquiry Alert</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #334155; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f1f5f9; padding: 30px 0; }
        .main-card { max-width: 620px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
        .header { background: #07172A; padding: 32px 30px; text-align: center; border-bottom: 3px solid #2563eb; }
        .header h1 { margin: 0; color: #ffffff; font-size: 20px; font-weight: 800; letter-spacing: -0.5px; }
        .header p { margin: 6px 0 0; color: #94a3b8; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 50px; background: #eff6ff; color: #2563eb; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #bfdbfe; margin-bottom: 12px; }
        .content { padding: 30px; }
        .product-box { background: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #2563eb; border-radius: 10px; padding: 16px 20px; margin-bottom: 24px; }
        .product-title { font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0; }
        .product-sub { font-size: 12px; color: #64748b; margin: 0; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .info-table td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #f1f5f9; }
        .info-label { width: 35%; color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }
        .info-value { width: 65%; color: #0f172a; font-weight: 700; }
        .message-box { background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0; padding: 18px; margin-bottom: 28px; }
        .message-title { font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; margin: 0 0 8px 0; letter-spacing: 0.5px; }
        .message-body { font-size: 14px; line-height: 1.6; color: #1e293b; margin: 0; white-space: pre-line; }
        .actions { text-align: center; padding: 10px 0 20px; }
        .btn-primary { display: inline-block; background: #2563eb; color: #ffffff !important; padding: 12px 26px; border-radius: 8px; font-size: 13px; font-weight: 700; text-decoration: none; margin: 0 6px 8px; }
        .btn-secondary { display: inline-block; background: #0f172a; color: #ffffff !important; padding: 12px 22px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; margin: 0 6px 8px; }
        .footer { background: #f8fafc; padding: 20px 30px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 11px; color: #64748b; line-height: 1.6; }
        .footer strong { color: #0f172a; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="main-card">
            <!-- Header -->
            <div class="header">
                <h1>Adonis Chemical Industries Ltd</h1>
                <p>Commercial Division & Plant Inquiry Notification</p>
            </div>

            <!-- Content Area -->
            <div class="content">
                <div style="text-align: center;">
                    <span class="badge">🔔 New Customer Requirement</span>
                </div>

                <!-- Product Box -->
                <div class="product-box">
                    <p class="product-title">
                        {{ $inquiry->product ? $inquiry->product->name : ($inquiry->product_name ?: 'General Chemical / Formulation Requirement') }}
                    </p>
                    <p class="product-sub">
                        @if($inquiry->product && $inquiry->product->category)
                            Category: <strong>{{ $inquiry->product->category->name }}</strong> &bull; Code: <strong>{{ $inquiry->product->code }}</strong>
                        @elseif($inquiry->product_name)
                            Custom/Requested Item: <strong>{{ $inquiry->product_name }}</strong>
                        @else
                            Corporate Commercial Inquiry (Bulk / Distributorship / Contract Formulation)
                        @endif
                    </p>
                </div>

                <!-- Customer Details Table -->
                <table class="info-table">
                    <tr>
                        <td class="info-label">Customer Name</td>
                        <td class="info-value">{{ $inquiry->name }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Company / Salon</td>
                        <td class="info-value">{{ $inquiry->company ?: 'Not Specified' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Phone Number</td>
                        <td class="info-value">
                            <a href="tel:{{ $inquiry->phone }}" style="color: #2563eb; text-decoration: none;">{{ $inquiry->phone }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Email Address</td>
                        <td class="info-value">
                            <a href="mailto:{{ $inquiry->email }}" style="color: #2563eb; text-decoration: none;">{{ $inquiry->email }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Estimated Volume</td>
                        <td class="info-value">{{ $inquiry->quantity_requirement ?: ($inquiry->quantity ?: 'Not Specified') }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Submitted On</td>
                        <td class="info-value">{{ $inquiry->created_at ? $inquiry->created_at->format('M d, Y \a\t h:i A') : now()->format('M d, Y \a\t h:i A') }} (BST)</td>
                    </tr>
                    @if($inquiry->ip_address)
                    <tr>
                        <td class="info-label">IP Address</td>
                        <td class="info-value" style="font-family: monospace; font-size: 11px; color: #64748b;">{{ $inquiry->ip_address }}</td>
                    </tr>
                    @endif
                </table>

                <!-- Customer Message -->
                <div class="message-box">
                    <p class="message-title">Customer Message / Detailed Specifications:</p>
                    <p class="message-body">{{ $inquiry->message }}</p>
                </div>

                <!-- Quick Action Buttons -->
                <div class="actions">
                    <a href="{{ url('/admin/inquiries/' . $inquiry->id) }}" class="btn-primary" target="_blank">
                        View in Admin Panel &rarr;
                    </a>
                    <a href="mailto:{{ $inquiry->email }}?subject={{ urlencode('Regarding your inquiry with Adonis Chemical Industries Ltd') }}" class="btn-secondary">
                        Reply via Email
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p style="margin: 0 0 6px;">
                    <strong>Adonis Chemical Industries Ltd (ACIL)</strong><br>
                    Plant: Genda, Karnapara, Savar, Dhaka, Bangladesh<br>
                    Corporate Head Office: Adonis Tower, Sector 3, Uttara, Dhaka
                </p>
                <p style="margin: 0; color: #94a3b8; font-size: 10px;">
                    This automated alert was dispatched by the ACIL Portal to configured recipients ({{ env('INQUIRY_ALERT_EMAILS', 'sales@adonischemical.com') }}).
                </p>
            </div>
        </div>
    </div>
</body>
</html>
