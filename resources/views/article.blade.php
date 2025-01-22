@extends('base')

@php
    $user = session()->has('user')
    ? \App\Models\User::find(session('user'))
    : new \App\Models\User();

    //dd($article->subcategories);
@endphp

@section('title', $article->name)
@section('description', htmlspecialchars_decode(strip_tags($article->description)))

@section('og_title', $article->name)
@section('og_description', htmlspecialchars_decode(strip_tags($article->description)))
@section('og_image', asset($article->first_image))
@section('og_url', \Illuminate\Support\Facades\URL::current())
@section('og_type', 'article')


@section('twitter_title', $article->name)
@section('twitter_description', htmlspecialchars_decode(strip_tags($article->description)))
@section('twitter_image', asset($article->first_image))
@section('twitter_url', \Illuminate\Support\Facades\URL::current())

@section('head')
    <!-- JQUERY UI -->
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <!-- TOM SELECT -->
    <link href="{{ asset('css/tom-select.css') }}" rel="stylesheet">
    <script src="{{ asset('js/tom-select.complete.min.js') }}"></script>
    <!-- SELECT2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @parent
@endsection

@section('main-content')
    <section id="el-path" class="el-center-box">
        <div class="el-content-area">
            <ul>
                <li><a href="">Accueil</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                @foreach($article->subcategories as $subcategory)
                    @if($article->subcategories->count() === ($loop->index + 1))
                        <li><a href="{{ route('category.show', ['categorySlug', $subcategory->category]) }}">{{ $subcategory->category->name }}</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li><a href="{{ route('subcategory.show', ['categorySlug' => $subcategory->category->slug, 'subcategorySlug' => $subcategory->slug]) }}">{{ $subcategory->name }}</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                    @else
                        <li><a href="{{ route('category.show', ['categorySlug', $subcategory->category]) }}">{{ $subcategory->category->name }}</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li><a href="{{ route('subcategory.show', ['categorySlug' => $subcategory->category->slug, 'subcategorySlug' => $subcategory->slug]) }}">{{ $subcategory->name }}</a></li>
                        <li>OU</li>
                    @endif
                @endforeach
                <li><span>{{ $article->name }}</span></li>
            </ul>
        </div>
    </section>
    <section id="el-details-article" class="el-center-box">
        <div class="el-content-area">
            <div class="el-grid-details-article">
                <h2 class="el-name-article">{{ $article->name }}</h2>
                <legend class="el-ref-article">Réf.: {{ $article->reference }}</legend>
                <div class="el-container">
                    <article class="el-single-product">
                        <img class="el-big-picture" src="{{ asset($article->images->first()->path) }}" alt="{{ $article->name }}">
                        @if($article->images->count() > 1)
                            <div class="el-nav-picture owl-carousel">
                                @foreach($article->images as $image)
                                    <img src="{{ asset($image->path) }}" data-src="{{ asset($image->path) }}" alt="{{ $article->name }}">
                                @endforeach
                            </div>
                        @endif
                    </article>
                    <article class="el-info-article">
                        <div class="accordion">
                            <h3>Informations sur le produit ?</h3>
                            <div>
                                <h2>Details:</h2>
                                <p>{!! $article->description !!}</p>
                                @if($article->colors->count() && !$article->sizes->count())
                                    <h2>Couleur:</h2>
                                    <select name="color_id" id="color_id">
                                        <option value="">Couleur ?</option>
                                        @foreach($article->colors as $color)
                                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                                        @endforeach
                                    </select>
                                @elseif(!$article->colors->count() && $article->sizes->count())
                                    <h2>Taille:</h2>
                                    <select name="size_id" id="size_id">
                                        <option value="">Taille ?</option>
                                        @foreach($article->sizes as $size)
                                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                @elseif($article->colors->count() && $article->sizes->count())
                                    <h2>Couleur:</h2>
                                    <select name="color_id" id="color_id">
                                        <option value="">Couleur ?</option>
                                        @foreach($article->colors as $color)
                                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                                        @endforeach
                                    </select>
                                    <h2>Taille:</h2>
                                    <select name="size_id" id="size_id">
                                        <option value="">Taille ?</option>
                                        @foreach($article->sizes as $size)
                                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                <p class="el-disponibility">{{ $article->availability ? $article->availability->name : '' }}</p>
                                <h2>Quantité désirée</h2>
                                <input type="number" name="quantity" id="quantity" min="1" value="1" />
                            </div>
                        </div>
                        @if($user->exists)
                            <a href="javascript:;"
                               hx-get="{{ route('favorite', ['user' => $user, 'article' => $article]) }}"
                               hx-trigger="click"
                               hx-target="#el-btn-favorite span"
                               class="el-btn"
                                id="el-btn-favorite">
                                <span>
                                    @include('layouts.favorite.favorite', ['user' => $user, 'article' => $article])
                                </span>
                                Ajouter à la liste de favoris
                            </a>
                            <a href="javascript:;" id="el-add-catalog" class="el-btn">
                                <i class="fas fa-list"></i>
                                Ajouter au catalogue
                            </a>
                            <a href="javascript:;" id="el-add-quote" class="el-btn">
                                <i class="fas fa-file-alt"></i>
                                Ajouter au devis
                            </a>
                        @else
                            <a href="javascript:;"
                               hx-get="{{ route('favorite', ['user' => $user, 'article' => $article]) }}"
                               hx-trigger="click"
                               hx-target="#el-btn-favorite span"
                               class="el-btn"
                               id="el-btn-favorite">
                                <span>
                                    @include('layouts.favorite.favorite', ['user' => $user, 'article' => $article])
                                </span>
                                Ajouter à la liste de favoris
                            </a>
                            <a href="javascript:;" id="el-add-catalog" class="el-btn">
                                <i class="fas fa-list"></i>
                                Ajouter au catalogue
                            </a>
                            <a id="el-request-for-quote" href="javascript:;" class="el-btn">
                                <i class="fas fa-file-alt"></i>
                                Ajouter au devis
                            </a>
                        @endif
                        <a href="{{ route('generate.pdf', $article) }}" target="_blank" class="el-btn">
                            <i class="fas fa-print"></i>
                            Imprimer fiche produit
                        </a>
                    </article>
                </div>
            </div>
        </div>
    </section>
    <style>
        /* Styles personnalisés pour que le popup prenne 100% de la largeur */
        .swal2-popup {
            max-width: 1000px;
            width: 100%;
        }
    </style>
@endsection

@section('scripts')
    @parent
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery-migrate-1.2.1.min.js') }}"></script>
    <!-- SELECT2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(".el-nav-picture.owl-carousel").owlCarousel({
            items: 3,
            loop: true,
            nav: true,
            dots: false,
            autoplay: true,
            autoplaySpeed: 1000,
            smartSpeed: 1500,
            autoplayHoverPause: true,
            margin: 5,
            center: true,
            responsive:{
                1400: {
                    items: 3,
                    center: true,
                    margin: 20,
                    nav: true
                },
            }
        });
        $(".el-nav-picture img").on("click", function () {
            var newSrc = $(this).attr("data-src");
            $(".el-big-picture").attr("src", newSrc);
        });
    </script>
    <script>
        const selectsMultiple = document.querySelectorAll("select[multiple]");
        selectsMultiple.forEach(select => {
            new TomSelect(select, {plugins: {remove_button: {title: 'Supprimer'}}})
        });
        $(document).ready(function() {
            //$('select').select2();
            $('select#color_id').select2({
                placeholder: 'Couleur ?',
                width: '100%'
            });
            $('select#size_id').select2({
                placeholder: 'Taille ?',
                width: '100%'
            });
        });
    </script>
    <script>
        $( function() {
            $( ".accordion" ).accordion({
                collapsible: true,
                heightStyle: "content"
            });
        });
    </script>
    <script>
        $('#el-add-catalog').on('click', function() {

            const selectedColors = $('#color_id').val();
            const selectedSize = $('#size_id').val();

            /*if(selectedColors && selectedSize){
                $.ajax({
                    url: "{{ route('addCatalog.article', $article) }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        color_id: selectedColors,
                        size_id: selectedSize,
                    },
                    success: function(response) {
                        if(response.code === 0){
                            Swal.fire({
                                icon: 'success',
                                title: 'Valide',
                                html: `${response.message}`
                            });
                            document.getElementById("el-nb-catalog").textContent = response.nb;
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error(errorThrown);
                    }
                });
            }else if(selectedColors){
                $.ajax({
                    url: "{{ route('addCatalog.article', $article) }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        color_id: selectedColors,
                    },
                    success: function(response) {
                        if(response.code === 0){
                            Swal.fire({
                                icon: 'success',
                                title: 'Valide',
                                html: `${response.message}`
                            });
                            document.getElementById("el-nb-catalog").textContent = response.nb;
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error(errorThrown);
                    }
                });
            }else if(selectedSize){
                $.ajax({
                    url: "{{ route('addCatalog.article', $article) }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        size_id: selectedSize,
                    },
                    success: function(response) {
                        if(response.code === 0){
                            Swal.fire({
                                icon: 'success',
                                title: 'Valide',
                                html: `${response.message}`
                            });
                            document.getElementById("el-nb-catalog").textContent = response.nb;
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error(errorThrown);
                    }
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    html: 'Veilliez selectionner une couleur'
                });
            }*/

            $.ajax({
                url: "{{ route('addCatalog.article', $article) }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                /*data: {
                    color_id: selectedColors,
                    size_id: selectedSize,
                },*/
                success: function(response) {
                    if(response.code === 0){
                        Swal.fire({
                            icon: 'success',
                            title: 'Valide',
                            html: `${response.message}`
                        });
                        document.getElementById("el-nb-catalog").textContent = response.nb;
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error(errorThrown);
                }
            });

        });

        $('#el-add-quote').on('click', function() {

            const selectedColors = $('#color_id').val();
            const selectedSize = $('#size_id').val();
            const quantity = $('#quantity').val();

            if(selectedColors && selectedSize && quantity >= 1){
                $.ajax({
                    url: "{{ route('addQuote.article', $article) }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        color_id: selectedColors,
                        size_id: selectedSize,
                        quantity: quantity
                    },
                    success: function(response) {
                        if(response.code === 0){
                            Swal.fire({
                                icon: 'success',
                                title: 'Valide',
                                html: `${response.message}`
                            });
                            document.getElementById("el-nb-quote").textContent = response.nb;
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error(errorThrown);
                    }
                });
            }else if(selectedSize && quantity >= 1){
                $.ajax({
                    url: "{{ route('addQuote.article', $article) }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        size_id: selectedSize,
                        quantity: quantity
                    },
                    success: function(response) {
                        if(response.code === 0){
                            Swal.fire({
                                icon: 'success',
                                title: 'Valide',
                                html: `${response.message}`
                            });
                            document.getElementById("el-nb-quote").textContent = response.nb;
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error(errorThrown);
                    }
                });
            }else if(selectedColors && quantity >= 1){
                $.ajax({
                    url: "{{ route('addQuote.article', $article) }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        color_id: selectedColors,
                        quantity: quantity
                    },
                    success: function(response) {
                        if(response.code === 0){
                            Swal.fire({
                                icon: 'success',
                                title: 'Valide',
                                html: `${response.message}`
                            });
                            document.getElementById("el-nb-quote").textContent = response.nb;
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error(errorThrown);
                    }
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    html: 'Veilliez selectionner une couleur ou une taille et une quantité'
                });
            }
        });
    </script>
    <script>
        const el_request_for_quote = document.getElementById('el-request-for-quote');
        el_request_for_quote.addEventListener('click', () => {

            const selectedColors = $('#color_id').val();
            const selectedSize = $('#size_id').val();
            const quantity = $('#quantity').val();

            // Afficher la boîte de dialogue de progression
            Swal.fire({
                title: 'Traitement en cours...',
                html: 'Veuillez patienter...',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
            if(selectedColors && selectedSize && quantity >= 1){
                // Effectuez une requête Ajax ici avec les données du formulaire
                // Exemple fictif d'une requête Ajax POST avec jQuery
                $.ajax({
                    url: '{{ route('devis.store') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        article_id: {{ $article->id }},
                        ip_address: '{{ $_SERVER['REMOTE_ADDR'] }}',
                        user_agent: '{{ $_SERVER['HTTP_USER_AGENT'] }}',
                        color_id: selectedColors,
                        size_id: selectedSize,
                        quantity: quantity
                    },
                    success: function (response) {
                        Swal.hideLoading();
                        if(parseInt(response.code)){
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                html: `${response.message}`
                            });
                        }else{
                            Swal.fire({
                                icon: 'success',
                                title: 'Valide',
                                html: `${response.message}`
                            });

                                document.getElementById("el-nb-quote").textContent = response.nb;

                        }
                    },
                    error: function () {
                        Swal.hideLoading();
                        Swal.fire('Erreur', 'Une erreur s\'est produite. Veuillez réessayer.', 'error');
                    }
                });
            }else if(selectedSize && quantity >= 1){
                // Effectuez une requête Ajax ici avec les données du formulaire
                // Exemple fictif d'une requête Ajax POST avec jQuery
                $.ajax({
                    url: '{{ route('devis.store') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        article_id: {{ $article->id }},
                        ip_address: '{{ $_SERVER['REMOTE_ADDR'] }}',
                        user_agent: '{{ $_SERVER['HTTP_USER_AGENT'] }}',
                        size_id: selectedSize,
                        quantity: quantity
                    },
                    success: function (response) {
                        Swal.hideLoading();
                        if(parseInt(response.code)){
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                html: `${response.message}`
                            });
                        }else{
                            Swal.fire({
                                icon: 'success',
                                title: 'Valide',
                                html: `${response.message}`
                            });

                                document.getElementById("el-nb-quote").textContent = response.nb;

                        }
                    },
                    error: function () {
                        Swal.hideLoading();
                        Swal.fire('Erreur', 'Une erreur s\'est produite. Veuillez réessayer.', 'error');
                    }
                });
            }else if(selectedColors && quantity >= 1){
                // Effectuez une requête Ajax ici avec les données du formulaire
                // Exemple fictif d'une requête Ajax POST avec jQuery
                $.ajax({
                    url: '{{ route('devis.store') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        article_id: {{ $article->id }},
                        ip_address: '{{ $_SERVER['REMOTE_ADDR'] }}',
                        user_agent: '{{ $_SERVER['HTTP_USER_AGENT'] }}',
                        color_id: selectedColors,
                        quantity: quantity
                    },
                    success: function (response) {
                        Swal.hideLoading();
                        if(parseInt(response.code)){
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                html: `${response.message}`
                            });
                        }else{
                            Swal.fire({
                                icon: 'success',
                                title: 'Valide',
                                html: `${response.message}`
                            });

                                document.getElementById("el-nb-quote").textContent = response.nb;

                        }
                    },
                    error: function () {
                        Swal.hideLoading();
                        Swal.fire('Erreur', 'Une erreur s\'est produite. Veuillez réessayer.', 'error');
                    }
                });
            }else{
                Swal.hideLoading();
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    html: 'Veilliez séléctionner une couleur ou une taille et une quantité'
                });
            }

        });
    </script>
@endsection
