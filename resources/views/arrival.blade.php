@extends('base')

@php
    $user = session()->has('user')
    ? \App\Models\User::find(session('user'))
    : new \App\Models\User();
@endphp

@section('title', $title)

@section('head')
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
                <li><a href="{{ route('home.page') }}">Accueil</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li><span>{{ $title }}</span></li>
            </ul>
        </div>
    </section>
    <section id="el-about-categorie" class="el-center-box">
        <div class="el-content-area">
            <h2 class="el-title-categorie">{{ $title }}</h2>
            <div class="el-description-categorie">{!! $description !!}</div>
        </div>
    </section>
    @include('layouts.article.filter', ['colors' => $colors, 'materials' => $materials])
    <section id="el-articles" class="el-center-box">
        <div class="el-content-area">
            <div class="el-grid-articles">
                @include('layouts.article.component', ['articles' => $articles, 'user' => $user])
            </div>
            <div class="el-paginator">
                {{ $articles->links() }}
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    @parent
    @include('layouts.scripts.filter-article')
@endsection
