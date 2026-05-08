<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $order->id }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #2d3748;
            line-height: 1.4;
            background: #f8fafc;
            font-size: 14px;
        }

        .invoice-container {
            max-width: 1000px;
            margin: 20px auto;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .header .invoice-info {
            background: rgba(255,255,255,0.2);
            padding: 15px 25px;
            border-radius: 8px;
            display: inline-block;
            backdrop-filter: blur(10px);
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #e2e8f0;
            padding: 15px;
            text-align: left;
            vertical-align: top;
        }

        .invoice-table th {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            font-weight: 600;
            color: #4a5568;
            font-size: 16px;
            border-bottom: 2px solid #667eea;
        }

        .section-header {
            background: #f1f5f9 !important;
            font-weight: 700 !important;
            font-size: 18px !important;
            color: #2d3748 !important;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .client-info,
        .billing-info,
        .shipping-info {
            background: #fefefe;
        }

        .client-info td,
        .billing-info td,
        .shipping-info td {
            padding: 20px;
        }

        .client-name {
            font-size: 18px;
            font-weight: 600;
            color: #2d3748;
        }

        .client-email {
            color: #718096;
            font-style: italic;
        }

        .address-block {
            line-height: 1.6;
        }

        .address-block strong {
            color: #4a5568;
        }

        .summary-row {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
        }

        .summary-row th,
        .summary-row td {
            background: transparent;
            color: white;
            border-color: rgba(255,255,255,0.3);
            font-size: 16px;
            font-weight: 600;
        }

        .total-amount {
            font-size: 24px !important;
            font-weight: 700 !important;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: #fbb6ce;
            color: #9c1748;
        }

        .status-completed {
            background: #c6f6d5;
            color: #22543d;
        }

        .status-cancelled {
            background: #fed7d7;
            color: #742a2a;
        }

        .footer {
            background: #2d3748;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 13px;
        }

        .footer p {
            margin: 5px 0;
        }

        @media print {
            body {
                background: white !important;
            }
            .invoice-container {
                box-shadow: none !important;
                margin: 0 !important;
            }
        }

        @media (max-width: 768px) {
            .invoice-container {
                margin: 10px;
            }
            .header {
                padding: 20px;
            }
            .header h1 {
                font-size: 28px;
            }
            .invoice-table th,
            .invoice-table td {
                padding: 10px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <h1>🧾 FACTURE</h1>
            <div class="invoice-info">
                <p><strong>Commande #{{ $order->id }}</strong></p>
                <p>📅 Date: {{ $order->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <table class="invoice-table">
            <tr>
                <th class="section-header" colspan="2">👤 INFORMATIONS CLIENT</th>
            </tr>
            <tr class="client-info">
                <td width="30%"><strong>Nom du client:</strong></td>
                <td class="client-name">{{ $user->name }}</td>
            </tr>
            <tr class="client-info">
                <td><strong>Email:</strong></td>
                <td class="client-email">{{ $user->email }}</td>
            </tr>

            <tr>
                <th class="section-header" colspan="2">🏠 ADRESSE DE FACTURATION</th>
            </tr>
            <tr class="billing-info">
                <td colspan="2">
                    <div class="address-block">
                        <strong>{{ $billing['address'] ?? 'N/A' }}</strong><br>
                        {{ $billing['city'] ?? '' }} {{ $billing['zip'] ?? '' }}<br>
                        {{ $billing['country'] ?? '' }}
                    </div>
                </td>
            </tr>

            <tr>
                <th class="section-header" colspan="2">🚚 ADRESSE DE LIVRAISON</th>
            </tr>
            <tr class="shipping-info">
                <td colspan="2">
                    <div class="address-block">
                        <strong>{{ $shipping['address'] ?? 'N/A' }}</strong><br>
                        {{ $shipping['city'] ?? '' }} {{ $shipping['zip'] ?? '' }}<br>
                        {{ $shipping['country'] ?? '' }}
                    </div>
                </td>
            </tr>

            <tr class="summary-row">
                <th>💰 MONTANT TOTAL</th>
                <td class="total-amount">{{ number_format($order->total_amount, 2, ',', ' ') }} €</td>
            </tr>
            <tr class="summary-row">
                <th>📊 STATUT</th>
                <td><span class="status-badge status-{{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span></td>
            </tr>
        </table>

        <div class="footer">
            <p>🎉 Merci pour votre confiance !</p>
            <p>E-commerce - Votre boutique en ligne de confiance</p>
            <p>📞 Support: support@ecommerce.com | 📧 contact@ecommerce.com</p>
        </div>
    </div>
</body>
</html>
