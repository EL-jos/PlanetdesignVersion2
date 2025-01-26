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
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    @php
                        switch($item->orderable_type){
                            case "App/Models/Variant":
                                $variant = \App\Models\Variant::find($item->orderable_id);
                                $article = $variant->article;
                                $filename = $variant->document()->where('type','image')->first()
                                            ? $variant->document()->where('type','image')->first()->path
                                            : $variant->article->documents()->where('type','image')->first()->path;
                                break;
                            default:
                                $article = \App\Models\Article::find($item->orderable_id);
                                $filename = $article->documents()->where('type','image')->first()->path;
                                break;
                        }
                    @endphp
                    <tr>
                        <td>{{ isset($variant) ? \Illuminate\Support\Str::upper($variant->ugs) : \Illuminate\Support\Str::upper($article->ugs) }}</td>
                        <td>{!! $article->content !!}</td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: center; vertical-align: middle;"> <img src="{{ isset($variant) ? $variant->compressImage(200, 200) : $article->compressImage(200, 200) }}" /> </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
