@extends('base')

@php
    $user = session()->has('user')
    ? \App\Models\User::find(session('user'))
    : new \App\Models\User();

    //dd($article->subcategories);
@endphp

@section('title', $article->name)
@section('description', htmlspecialchars_decode(strip_tags($article->content)))

@section('og_title', $article->name)
@section('og_description', htmlspecialchars_decode(strip_tags($article->content)))
@section('og_image', asset($article->first_image))
@section('og_url', \Illuminate\Support\Facades\URL::current())
@section('og_type', 'article')


@section('twitter_title', $article->name)
@section('twitter_description', htmlspecialchars_decode(strip_tags($article->content)))
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
                <legend class="el-ref-article">Réf.: {{ $article->ugs }}</legend>
                <div class="el-container">
                    <article class="el-single-product">
                        <img class="el-big-picture" src="{{ asset(!isset($variantSelected) ? $article->images->first()->path : $variantSelected->document->path) }}" alt="{{ $article->name }}" />
                        @if($article->documents()->where('type','image')->count() > 0)
                            <div class="el-nav-picture owl-carousel">
                                @if($article->variant_is_color)

                                    @foreach($article->variants as $variantImageColor)
                                        <img src="{{ asset($variantImageColor->document->path) }}" data-src="{{ asset($variantImageColor->document->path) }}" data-id="{{ $variantImageColor->id }}" data-model="{{ \App\Models\Variant::class }}" alt="{{ $article->name }}">
                                    @endforeach

                                @endif

                                @if($article->variant_is_size)

                                    @foreach($article->variants as $variantImageSize)
                                        <img src="{{ asset($variantImageSize->document->path) }}" data-src="{{ asset($variantImageSize->document->path) }}" data-id="{{ $variantImageSize->id }}" data-model="{{ \App\Models\Variant::class }}" alt="{{ $article->name }}">
                                    @endforeach

                                @endif

                                @foreach($article->documents()->where('type', 'image')->get() as $document)
                                    <img src="{{ asset($document->path) }}" data-src="{{ asset($document->path) }}" data-id="{{ $article->id }}" data-model="{{ \App\Models\Article::class }}" alt="{{ $article->name }}">
                                @endforeach

                            </div>
                        @endif
                    </article>
                    <article class="el-info-article">
                        <div class="accordion">
                            <h3>Informations sur le produit ?</h3>
                            <div>
                                <h2>Details:</h2>
                                <p>{!! $article->content !!}</p>
                                @if($article->variant_is_color && !$article->variant_is_size)
                                    <h2>Couleur:</h2>
                                    <div id="el-container-variants">

                                        @foreach($article->variants as $variantChoiseColor)

                                            <a href="{{ route('variant.show', [
                                                    'articleSlug' => $variantChoiseColor->article->slug,
                                                    'articleRef' => $variantChoiseColor->article->ugs,
                                                    'variant'=> $variantChoiseColor->id
                                                ]) }}" class="el-variant-color">
                                                <img src="{{ asset($variantChoiseColor->color->document->path) }}" />
                                                <span>{{ \Illuminate\Support\Str::title($variantChoiseColor->color->name) }}</span>
                                            </a>

                                        @endforeach

                                    </div>

                                @elseif(!$article->variant_is_color && $article->variant_is_size)
                                    <h2>Taille:</h2>
                                    <div id="el-container-variants">

                                        @foreach($article->variants as $variantChoiseSize)

                                            <a href="{{ route('variant.show', [
                                                    'articleSlug' => $variantChoiseSize->article->slug,
                                                    'articleRef' => $variantChoiseSize->article->ugs,
                                                    'variant'=> $variantChoiseSize->id
                                                ]) }}" class="el-variant-size">
                                                <span>{{ \Illuminate\Support\Str::title($variantChoiseSize->size->name) }}</span>
                                            </a>

                                        @endforeach

                                    </div>
                                {{--@elseif($article->variant_is_color && $article->variant_is_size)
                                    <h2>Couleur:</h2>
                                    <select name="color_id" id="color_id">
                                        <option value="">Couleur ?</option>
                                        @foreach($article->variants as $variant)
                                            <option value="{{ $variant->color->id }}">{{ $variant->color->name }}</option>
                                        @endforeach
                                    </select>
                                    <h2>Taille:</h2>
                                    <select name="size_id" id="size_id">
                                        <option value="">Taille ?</option>
                                        @foreach($article->variants as $variant)
                                            <option value="{{ $variant->size->id }}">{{ $variant->size->name }}</option>
                                        @endforeach
                                    </select>--}}
                                @endif
                                <p class="el-disponibility">{{ $article->availability ? \Illuminate\Support\Str::title($article->availability->name) : '' }}</p>
                                <h2>Quantité désirée</h2>
                                <input type="number" name="quantity" id="quantity" min="1" value="1" />
                            </div>
                        </div>

                        <a @if(isset($variantSelected)) href="{{ route('addWishlist.page', ['id' => $variantSelected->id, 'model' => \App\Models\Variant::class]) }}"
                           @else href="{{ route('addWishlist.page', ['id' => $article->id, 'model' => \App\Models\Article::class]) }}" @endif
                           class="el-btn"
                            id="el-btn-favorite">
                            <span>
                                @php
                                    /**
                                     * @var \App\Models\User $user
                                     */
                                    $user = \App\Models\User::findOrfail(session('user'));
                                    $wishlist = $user->wishlist;
                                    $isInWishlist = collect([]);
                                    if($wishlist){

                                        $ids = collect([]);
                                        $ids->push($article->id);
                                            if(!empty($article->variants->count())){
                                                $article->variants->map(function ($item) use ($ids){
                                                    $ids->push($item->id);
                                                });
                                            }
                                            $isInWishlist = $wishlist->items()->whereIn('wishlistable_id', $ids->toArray())->get();
                                    }

                                @endphp
                                <i class="{{ empty($isInWishlist->count()) ? 'far' : 'fas' }} fa-heart"></i>
                            </span>
                            Ajouter à la liste de favoris
                        </a>
                        <a @if(isset($variantSelected)) href="{{ route('addCatalog.page', ['id' => $variantSelected->id, 'model' => \App\Models\Variant::class]) }}" @else href="{{ route('addCatalog.page', ['id' => $article->id, 'model' => \App\Models\Article::class]) }}" @endif  id="el-add-catalog" class="el-btn">
                            <i class="fas fa-list"></i>
                            Ajouter au catalogue
                        </a>
                        <a @if(isset($variantSelected)) href="{{ route('addCart.page', ['id' => $variantSelected->id, 'model' => \App\Models\Variant::class]) }}" @else href="{{ route('addCart.page', ['id' => $article->id, 'model' => \App\Models\Article::class]) }}" @endif  id="el-add-cart" class="el-btn">
                            <i class="fas fa-file-alt"></i>
                            Ajouter au devis
                        </a>

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
            let id = $(this).attr("data-id");
            let model = $(this).attr("data-model");

            $(".el-big-picture").attr("src", newSrc);

            $("#el-add-catalog").attr("href", `/add/${id}/${model}/catalog`);
            $("#el-add-cart").attr("href", `/add/${id}/${model}/cart`);

            console.log(id, $("#el-add-catalog").attr("href"))
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

            //*************** C'EST LE BON ***************************
            /*$.ajax({
                url: "",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                /!*data: {
                    color_id: selectedColors,
                    size_id: selectedSize,
                },*!/
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
            });*/

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
@endsection
