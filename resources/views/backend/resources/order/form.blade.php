@extends('backend.pages.base')

@section("heads")
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/backend/dist/css/adminlte.min2167.css?v=3.2.0')}}">
    <script nonce="677aa08b-50ff-4093-9409-9f9322a7957e">(function(w,d){!function(L,M,N,O){L[N]=L[N]||{};L[N].executed=[];L.zaraz={deferred:[],listeners:[]};L.zaraz.q=[];L.zaraz._f=function(P){return async function(){var Q=Array.prototype.slice.call(arguments);L.zaraz.q.push({m:P,a:Q})}};for(const R of["track","set","debug"])L.zaraz[R]=L.zaraz._f(R);L.zaraz.init=()=>{var S=M.getElementsByTagName(O)[0],T=M.createElement(O),U=M.getElementsByTagName("title")[0];U&&(L[N].t=M.getElementsByTagName("title")[0].text);L[N].x=Math.random();L[N].w=L.screen.width;L[N].h=L.screen.height;L[N].j=L.innerHeight;L[N].e=L.innerWidth;L[N].l=L.location.href;L[N].r=M.referrer;L[N].k=L.screen.colorDepth;L[N].n=M.characterSet;L[N].o=(new Date).getTimezoneOffset();if(L.dataLayer)for(const Y of Object.entries(Object.entries(dataLayer).reduce(((Z,$)=>({...Z[1],...$[1]})),{})))zaraz.set(Y[0],Y[1],{scope:"page"});L[N].q=[];for(;L.zaraz.q.length;){const ba=L.zaraz.q.shift();L[N].q.push(ba)}T.defer=!0;for(const bb of[localStorage,sessionStorage])Object.keys(bb||{}).filter((bd=>bd.startsWith("_zaraz_"))).forEach((bc=>{try{L[N]["z_"+bc.slice(7)]=JSON.parse(bb.getItem(bc))}catch{L[N]["z_"+bc.slice(7)]=bb.getItem(bc)}}));T.referrerPolicy="origin";T.src="../../../../cdn-cgi/zaraz/sd0d9.js?z="+btoa(encodeURIComponent(JSON.stringify(L[N])));S.parentNode.insertBefore(T,S)};["complete","interactive"].includes(M.readyState)?zaraz.init():L.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document);</script>
    <!-- FILEPOND -->
    <link href="https://unpkg.com/filepond@4.26.0/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet"/>
    <!-- SELECT2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/summernote/summernote-bs4.min.css')}}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <!-- SORTABLE -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <!-- AXIOS -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        .el-btns-controls{
            display: flex;
            align-items: center;
            gap: 1rem;
            width: fit-content;
            margin: 0 0 1.25rem 0;
        }
        .el-btns-controls a{
            margin: 0 !important;
        }

        .el-container-grid-column-document{
            display: flex;
            flex-direction: column;
            gap: 2rem;
            margin-bottom: 1rem;
        }
        .el-container-grid-column-document .el-container{
            margin-bottom: 0rem;
        }
        .el-container{
            position: relative;
            width: fit-content;
        }
        .el-container .el-remove{
            position: absolute;
            background: red;
            color: #F2F2F2;
            font-weight: bold;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
            top: 0;
            right: 0;
        }
        .filepond--list {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            height: 500px;
        }
        .filepond--item{
            width: 30% !important;
        }
        .filepond--root.picture.filepond--hopper{
            width: 100%;
        }
        .el-select2{
            margin-bottom: 1rem;
            min-height: 38px;
        }
        #select2--container,
        .select2-container--default .select2-selection--single .select2-selection__arrow{
            position: absolute;
            top: 50% !important;
            transform: translateY(-50%);
        }.select2-container--default .select2-selection--single,
         .select2-container,
         .ts-control{
             min-height: 40px!important;
         }
    </style>
@endsection

@section('main-content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Détails Commande n°<strong>{{ $order->id }}</strong></h3>
        </div>
        <div class="card-body">
            <form action="{{ $order->exists ? route('order.update', $order) : route('order.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method($order->exists ? 'PUT' : 'POST')
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Général</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Date de création:</label>
                                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime"/>
                                            <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>État:</label>
                                        <select class="form-control select2bs4" style="width: 100%;">
                                            <option value="">État</option>
                                            @foreach($statuses as $status)
                                                <option @if($order->status->id === $status->id) selected @endif value="{{ $status->id }}">{{ \Illuminate\Support\Str::title($status->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-4">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Facturation</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" placeholder="Prénom" value="{{ $order->user->firstname }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" placeholder="Nom" value="{{ $order->user->lastname }}" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" placeholder="Adresse" value="{{ $order->user->address }}" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" placeholder="Code postal" value="20330" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" placeholder="Ville" value="{{ $order->user->city }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" placeholder="Pays/région" value="La Réunion" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <input class="form-control" type="email" placeholder="E-mail" value="{{ $order->user->email }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="tel" placeholder="Téléphone" value="{{ $order->user->phone }}" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <select class="form-control select3ct5" style="width: 100%;">
                                                <option value="">Moyen de paiement</option>
                                                <option value="alma"> Payer en plusieurs fois  avec Alma </option>
                                                <option value="cod"> PAIEMENT EN 10X (à partir de 700€) </option>
                                                <option value="bacs"> VIREMENT BANCAIRE </option>
                                                <option value="etransactions_std_card_CB"> Paiement sécurisé via Crédit Agricole </option>
                                                <option value="other">Autre</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-4">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Expédition</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" placeholder="Prénom" value="{{ $order->user->firstname }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" placeholder="Nom" value="{{ $order->user->lastname }}" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" placeholder="Adresse" value="{{ $order->user->address }}" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" placeholder="Code postal" value="20330" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" placeholder="Ville" value="{{ $order->user->city }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" placeholder="Pays/région" value="La Réunion" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <input class="form-control" type="email" placeholder="E-mail" value="{{ $order->user->email }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="tel" placeholder="Téléphone" value="{{ $order->user->phone }}" required>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </form>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
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
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="{{ route('backend.invoice.print', $order) }}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                                    Payment
                                </button>
                                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                    <i class="fas fa-download"></i> Generate PDF
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script src="{{ asset('assets/backend/dist/js/adminlte.min2167.js?v=3.2.0')}}"></script>
    <script src="{{ asset('assets/backend/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- InputMask -->
    <script src="{{ asset('assets/backend/plugins/moment/moment.min.js')}}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('assets/backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
    <!-- HTMLX -->
    <script src="https://unpkg.com/htmx.org@1.9.4" integrity="sha384-zUfuhFKKZCbHTY6aRR46gxiqszMk5tcHjsVFxnUo8VMus4kHGVdIYVbOYYNlKmHV" crossorigin="anonymous"></script>
    </script>
    <!-- SELECT2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- SWEET ALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            //$('select').select2();
            $('select.select2bs4').select2({
                placeholder: 'État',
            });

            $('select.select3ct5').select2({
                placeholder: 'Moyen de paiement ?'
            });
            $('select#promotion_id').select2({
                placeholder: 'Promotion ?'
            });

            {{--$('#summernote').summernote();

            new TomSelect('select#category_id', {
                placeholder: 'Catégorie(s)',
                plugins: {remove_button: {title: 'Supprimer'}}
            });

            new TomSelect('select#color_id', {
                placeholder: 'Couleur(s)',
                plugins: {remove_button: {title: 'Supprimer'}}
            });

            new TomSelect('select#tag_id', {
                placeholder: 'Tag(s)',
                plugins: {remove_button: {title: 'Supprimer'}}
            });--}}
        });

    </script>
    <script>
        @php
            $date = \Carbon\Carbon::parse($order->created_at);
        @endphp
        //Date and time picker
        $('#reservationdatetime').datetimepicker({
            icons: { time: 'far fa-clock' } ,
            date: '{{ $date->format('Y-m-d H:i') }}',
        });
    </script>
    {{--@if($article->exists)
        <!-- FILEPOND -->
        <script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond@4.26.0/dist/filepond.js"></script>
        <script>
            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginImageEdit);
            document.addEventListener('DOMContentLoaded', function () {
                // Sélectionnez l'élément de téléchargement par sa classe
                const inputElement = document.querySelector('.picture');

                // Initialisation de FilePond dans le formulaire
                const pond = FilePond.create(inputElement, {
                    labelFileProcessingComplete: 'Votre Photo a bien été mise à jour, Veillez actualiser la page',
                    labelFileProcessingError: 'Impossible de mettre à jour votre Photo',
                    labelIdle: 'Glisser-déposer votre image ou <span class="filepond--label-action"> Parcourir </span>',
                    server: {
                        process: {
                            url: '{{ route("article.uploadDocument", $article) }}', // Remplacez par l'URL de votre action Laravel pour l'upload
                            method: 'POST',
                            withCredentials: false,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ajoutez le jeton CSRF dans les headers de la requête
                            }
                        },
                    }
                });
                // Charger l'aperçu de l'image actuelle
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var sortable = new Sortable(document.getElementById('sortable-images'), {
                    animation: 150, // Animation lors du déplacement
                    swap: true,
                    onEnd: function (event) {
                        // Code à exécuter lorsque le glisser-déposer est terminé
                        // event.oldIndex : index précédent de l'élément
                        // event.newIndex : nouvel index de l'élément
                        // event.item : élément déplacé
                        // Vous pouvez utiliser ces informations pour mettre à jour l'ordre des images dans votre base de données
                        //console.log(event)
                        var imageIds = Array.from(sortable.el.children).map(function (element) {
                            return element.getAttribute('data-image-id');
                        });
                        var formData = new FormData();
                        formData.append('imageIds', JSON.stringify(imageIds));
                        formData.append('article_id',' {{ $article->id }}');

                        axiosInstance = axios.create();
                        axiosInstance.defaults.onUploadProgress = function (progressEvent) {
                            var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);

                            // Afficher la progression dans un SweetAlert2
                            Swal.fire({
                                title: 'Envoi en cours...',
                                text: 'Progression : ' + percentCompleted + '%',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                showConfirmButton: false,
                                showCancelButton: false,
                                showCloseButton: false,
                                html: '<div class="progress"><div class="progress-bar" role="progressbar" style="width: ' + percentCompleted + '%;"></div></div>'
                            });
                        };

                        axiosInstance.post('{{ route('updateDocumentOrder.document') }}', formData, {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ajoutez le jeton CSRF dans les headers de la requête
                            }
                        })
                            .then(function (response) {

                                // Fermer le SweetAlert2
                                Swal.close();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Valide',
                                    text: `${response.data.message}`
                                });
                                console.log('Ordre des images mis à jour avec succès !');
                            })
                            .catch(function (error) {
                                Swal.close();
                                console.error('Erreur lors de la mise à jour de l\'ordre des images :', error);
                            });
                    }
                });
            });
        </script>
        @if(session()->has('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Valide',
                    text: "{!! session('success') !!}"
                });
            </script>
        @elseif(session()->has('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: "{!! session('error') !!}"
                });
            </script>
        @elseif(session()->has('warning'))
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Votre attention',
                    text: "{!! session('warning') !!}"
                });
            </script>
        @elseif(session()->has('info'))
            <script>
                Swal.fire({
                    icon: 'info',
                    title: 'Information',
                    text: "{!! session('info') !!}"
                });
            </script>
        @elseif($errors->any())
            <script>
                var errorMessages = "<ul>";
                @foreach ($errors->all() as $error)
                    errorMessages += "<li>{{ $error }}</li>";
                @endforeach
                    errorMessages += "</ul>";

                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    html: errorMessages
                });
            </script>
        @endif
    @endif--}}
@endsection
