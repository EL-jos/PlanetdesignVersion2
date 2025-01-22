<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau devis de {{ $order->user->lastname }} {{ $order->user->firstname }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .header {
            text-align: right;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .info {
            width: 50%;
            float: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="invoice">

        <div class="header">
            <p>Nom: {{ $order->user->lastname . ' ' . $order->user->firstname }}</p>
            <p>E-mail: {{ $order->user->email }}</p>
            <p>Société: {{ $order->user->company }}</p>
        </div>

        <div class="info">
            <p>{{ $order->content }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Désignation</th>
                    <th>Couleur \ Taille</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->quotes as $quote)
                    <tr>
                        <td>{{ $quote->article->reference }}</td>
                        <td>{!! $quote->article->description !!}</td>
                        <td> @if($quote->colors->count() && $quote->sizes->count()) Couleur: {{ $quote->colors->first()->name }} <br> Taille: {{ $quote->sizes->first()->name }} @elseif(!$quote->colors->count() && $quote->sizes->count()) {{ $quote->sizes->first()->name }} @elseif($quote->colors->count() && !$quote->sizes->count()) {{ $quote->colors->first()->name }} @endif </td>
                        <td>{{ $quote->quantity }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: center; vertical-align: middle;"> <img src="{{ $quote->article->compressImage(300, 300) }}" /> </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
