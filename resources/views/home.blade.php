@extends('base')

@section('main-content')
    <section id="el-slider" class="el-center-box">
        <div class="el-content-area">
            <div class="owl-carousel">
                <img src="{{ asset('assets/sliders/BUREAU_EVENT.png')}}" alt="Bureau-events">
                <img src="{{ asset('assets/sliders/ECRITURE.png')}}?v=1.0.0" alt="ECRITURE">
                <img src="{{ asset('assets/sliders/LOISIRS.png')}}" alt="Loisirs">
                <img src="{{ asset('assets/sliders/PAUS_GOURMANDE.png')}}" alt="PAUSE-GOURMANDE">
                <img src="{{ asset('assets/sliders/TECHNOLOGIE.png')}}" alt="Téchnologie">
                <img src="{{ asset('assets/sliders/Tixtile.png')}}" alt="Textile">
            </div>
        </div>
    </section>
    <section id="el-offres" class="el-center-box">
        <div class="el-content-area">
            <h2 class="el-title">nos offres</h2>
            <div class="el-container">
                <div class="el-grid-offres">
                    <article class="el-offre">
                        <a href="{{ route('catalogs.page') }}">
                            <img class="el-img" src="{{ asset('assets/img/offres/CATALOGUES-2024.png') }}" alt="Nos catalogues" />
                        </a>
                    </article>
                    <article class="el-offre"><a href="{{ route('arrival.page') }}">
                            <img class="el-img" src="{{ asset('assets/img/offres/Nouvel-arrivage.jpg') }}" alt="Nouvel arrivage" />
                        </a></article>
                    <article class="el-offre"><a href="{{ route('destocking.page') }}">
                            <img class="el-img" src="{{ asset('assets/img/offres/Destockage.png') }}" alt="Déstockage" />
                        </a></article>
                </div>
                <aside>
                    <div class="owl-carousel">
                        <img src="{{ asset("assets/img/offres/01.png")}}" alt="">
                        <img src="{{ asset("assets/img/offres/02.png")}}" alt="">
                        <img src="{{ asset("assets/img/offres/03.png")}}" alt="">
                        <img src="{{ asset("assets/img/offres/04.png")}}" alt="">
                    </div>
                    <div class="el-content">
                        <div class="el-icon el-center-box"><i class="far fa-heart"></i></div>
                        <h3>les bonnes affaires</h3>
                        <p>Des remises exceptionnelles d’objets publicitaires à découvrir dans cette rubrique. </p>
                        <a href="{{ route('business.page') }}" class="el-btn">JE DÉCOUVRE <i class="fas fa-chevron-right"></i></a>
                    </div>
                </aside>
            </div>
        </div>
    </section>
    <section id="el-categories" class="el-center-box">
        <div class="el-content-area">
            <h2 class="el-title">nos catégories</h2>
            <div class="el-grid-categories">
                @foreach($offers as $offer)
                    <article class="el-categorie">
                        <img src="{{ asset($offer->document()->where('type','image')->first()->path) }}" alt="{{ $offer->title }}" class="el-img">
                        <div class="el-nom-categorie">
                            <h2>{{ $offer->title }}</h2>
                        </div>
                        <div class="el-content">
                            <h2>{{ $offer->name }}</h2>
                            <p>{!! substr(htmlspecialchars_decode($offer->description), 0, 200) . '...' !!}</p>
                            <a href="{{ $offer->url }}" class="el-btn">DÉCOUVRE</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    <section id="el-about" class="el-center-box">
        <div class="el-content-area">
            <div class="el-container">
                <article class="el-presentation">
                    <div class="el-container-title">
                        <h2>
                            À PROPOS DE NOUS
                            <span>Nous connaitre</span>
                        </h2>
                        <div class="el-carre"></div>
                    </div>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quasi a saepe alias, nulla earum fuga tenetur praesentium numquam ipsa adipisci voluptatem, nostrum voluptas voluptate cupiditate nihil maxime quam ipsam ad?</p>
                    <a href="" class="el-btn">Voir plus</a>
                </article>
                <article class="el-container-img">
                    <img src="./assets/img/2.png?v=1" alt="Planet Design">
                </article>
            </div>
            <div class="el-container-countdown">
                <div class="el-countdown">
                    <h2>2751</h2>
                    <p>Clients Satisfaits</p>
                </div>
                <div class="el-countdown">
                    <h2>5034</h2>
                    <p>Commandes</p>
                </div>
                <div class="el-countdown">
                    <h2>10460</h2>
                    <p>Articles Vendus</p>
                </div>
                <div class="el-countdown">
                    <h2>300</h2>
                    <p>Clients Satisfaits</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    @parent
    <script src="{{ asset('js/cdnjs.cloudflare.com_ajax_libs_waypoints_2.0.3_waypoints.min.js') }}"></script>
    <!-- COUNTER UP -->
    <script src="{{ asset('js/cdnjs.cloudflare.com_ajax_libs_Counter-Up_1.0.0_jquery.counterup.min.js') }}"></script>
    <script>
        $(".el-container-countdown h2").counterUp({
            delay: 10,
            time: 2000
        });
    </script>
@endsection
