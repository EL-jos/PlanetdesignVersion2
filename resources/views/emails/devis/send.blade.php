@php
    function isGmailAddress($email) {
        // Récupérez le domaine de l'adresse e-mail
        $emailParts = explode('@', $email);
        $domain = end($emailParts);

        // Comparez le domaine avec "gmail.com" en ignorant la casse
        return strcasecmp($domain, 'gmail.com') === 0;
    }
@endphp
<!DOCTYPE html>
<html>
<head>
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
        <p>Nom: {{ $data->lastname . ' ' . $data->firstname }}</p>
        <p>E-mail: {{ $data->email }}</p>
        <p>Société: {{ $data->company }}</p>
    </div>

    <div class="info">
        <p>{{ $data->content }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Référence</th>
                <th>Désignation</th>
                <th>Couleur / Taille</th>
                <th>Quantité</th>
            </tr>
        </thead>
        <tbody>
        @foreach($quotes as $quote)
            <tr>
                <td>{{ $quote->article->reference }}</td>
                <td>{!! $quote->article->description !!}</td>
                <td> @if($quote->color && $quote->size) Coleur: {{ $quote->color->name }} <br> Taille: {{ $quote->size->name }} @elseif(!$quote->color && $quote->size) Taille: {{ $quote->size->name }} @elseif($quote->color && !$quote->size) Coleur: {{ $quote->color->name }} @endif </td>
                <td>{{ $quote->quantity }}</td>
            </tr>
            <tr>
                @if(isGmailAddress(env("MAIL_TO_ADDRESS")))
                    <td colspan="4" style="text-align: center; vertical-align: middle;"> <img style="width: 100%;" src="{{ asset($quote->article->images->first()->path) }}" /> </td>
                @else
                    <td colspan="4" style="text-align: center; vertical-align: middle;"> <img src="{{ $quote->article->compressImage(300, 300) }}" /> </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
