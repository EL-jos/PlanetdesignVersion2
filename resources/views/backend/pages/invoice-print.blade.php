<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Led's run | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/backend/dist/css/adminlte.min2167.css')}}">
</head>
<body>
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-12 mb-4">
                <h4>
                    <img src="{{ asset('assets/img/logo-black.png') }}" width="200" height="55" />
                    @php
                        $date = \Illuminate\Support\Carbon::parse($order->created_at);
                    @endphp
                    <small class="float-right">Date: {{ $date->locale('fr')->translatedFormat('d/m/Y') }}</small>
                </h4>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-12">
                <h1>FACTURE</h1>
            </div>
            <div class="col-sm-4 invoice-col">
                De
                <address>
                    <strong>Led’s Run | Spécialiste des luminaires LED <br />à la Réunion pour les Pro</strong><br>
                    4, rue Vely ZI Bel Air<br>
                    • 97450 Saint-Louis •<br>
                    La Réunion <br>
                    Phone: +0262 77 17 21<br>
                    Email: contact@ledsrun.re
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                À
                <address>
                    <strong>{{ \Illuminate\Support\Str::title($order->user->firstname . ' ' . $order->user->lastname) }}</strong><br>
                    {{ $order->user->address }}<br>
                    Phone: {{ $order->user->phone }}<br>
                    Email: {{ $order->user->email }}
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Date de facture: {{ $date->locale('fr')->translatedFormat('F j, Y') }}</b><br>
                <br>
                <b>N° de commande:</b> {{ $order->id }}<br>
                <b>Date de commande:</b> {{ $date->locale('fr')->translatedFormat('F j, Y') }}<br>
                <b>Méthode de paiement:</b> 968-34567
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Qté</th>
                        <th>Produit</th>
                        <th>Série #</th>
                        <th>Prix</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>x{{ $item->quantity }}</td>
                            <td>
                                @if($item->orderable_type === \App\Models\Variant::class)
                                    {{ \Illuminate\Support\Str::title($item->orderable->article->name) }}
                                @else
                                    {{ \Illuminate\Support\Str::title($item->orderable->name) }}
                                @endif
                            </td>
                            <td>{{ $item->orderable->ugs }}</td>
                            <td>
                                @if($item->orderable_type === \App\Models\Variant::class)
                                    @if($item->orderable->promotion)
                                        <bdi style="text-decoration: line-through; margin-right: 1rem;">{{ $item->orderable->formatted_price }}</bdi>  <ins style="color: #E02B20">{{ number_format($item->orderable->discounted_price, 2, ',', ' ') . '€' }}&nbsp;</ins>
                                    @else
                                        <ins style="color: #E02B20">{{ $item->orderable->formatted_price }}&nbsp;</ins>
                                    @endif
                                @else
                                    @if($item->orderable->promotion)
                                        <bdi style="text-decoration: line-through; margin-right: 1rem;">{{ $item->orderable->formatted_price }}</bdi>  <ins style="color: #E02B20">{{ $item->orderable->discounted_price }}&nbsp;</ins>
                                    @else
                                        <ins style="color: #E02B20">{{ $item->orderable->formatted_price }}&nbsp;</ins>
                                    @endif
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">
                {{--<p class="lead">Payment Methods:</p>
                <img src="../../dist/img/credit/visa.png" alt="Visa">
                <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                <img src="../../dist/img/credit/american-express.png" alt="American Express">
                <img src="../../dist/img/credit/paypal2.png" alt="Paypal">--}}

                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">{{ $order->comment }}</p>
            </div>
            <!-- /.col -->
            <div class="col-6">

                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>{{ $order->total_amount }}&nbsp;€</td>
                        </tr>
                        <tr>
                            <th>Expédition</th>
                            <td>Click and Collect</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>{{ $order->total_amount }}&nbsp;€</td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
    window.addEventListener("load", window.print());
</script>
</body>
</html>
