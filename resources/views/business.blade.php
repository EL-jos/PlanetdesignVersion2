@extends('base')

@section('title', "Bonnes Affaires")

@section('main-content')
    <section id="el-path" class="el-center-box">
        <div class="el-content-area">
            <ul>
                <li><a href="{{ route('home.page') }}">Accueil</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li><span>Bonnes affaires</span></li>
            </ul>
        </div>
    </section>
    <section id="el-about-categorie" class="el-center-box">
        <div class="el-content-area">
            <h2 class="el-title-categorie">les bonnes affaires</h2>
        </div>
    </section>
    <section id="el-catalogs" class="el-center-box">
        <div class="el-content-area">
            <div class="el-grid-catalogs">
                @foreach($deals as $deal)
                    <a target="_blank" href="{{ route('article.show', ['articleSlug' => $deal->article->slug, 'articleRef' => $deal->article->ugs]) }}" class="el-catalog">
                        <img src="{{ asset($deal->document ? $deal->document->path : '') }}" alt="{{ $deal->article->name }}">
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection
