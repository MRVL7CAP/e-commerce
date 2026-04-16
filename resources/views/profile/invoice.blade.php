<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $order->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #222;
            line-height: 1.4;
        }
        .header {
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            font-size: 16px;
            margin-bottom: 8px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th,
        .table td {
            border: 1px solid #bbb;
            padding: 8px 10px;
            text-align: left;
        }
        .table th {
            background: #f3f4f6;
        }
        .invoice-meta {
            margin-top: 20px;
        }
        .invoice-meta strong {
            display: inline-block;
            width: 160px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Facture</h1>
        <p>Commande #: {{ $order->id }}</p>
        <p>Date: {{ $order->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="section">
        <h2>Client</h2>
        <p>{{ $user->name }}<br>{{ $user->email }}</p>
    </div>

    <div class="section">
        <h2>Adresse de facturation</h2>
        <p>
            {{ $billing['address'] ?? 'N/A' }}<br>
            {{ $billing['city'] ?? '' }} {{ $billing['zip'] ?? '' }}<br>
            {{ $billing['country'] ?? '' }}
        </p>
    </div>

    <div class="section">
        <h2>Adresse de livraison</h2>
        <p>
            {{ $shipping['address'] ?? 'N/A' }}<br>
            {{ $shipping['city'] ?? '' }} {{ $shipping['zip'] ?? '' }}<br>
            {{ $shipping['country'] ?? '' }}
        </p>
    </div>

    <div class="section invoice-meta">
        <p><strong>Montant total:</strong> {{ number_format($order->total_amount, 2, ',', ' ') }} €</p>
        <p><strong>Statut:</strong> {{ ucfirst($order->status) }}</p>
    </div>
</body>
</html>
