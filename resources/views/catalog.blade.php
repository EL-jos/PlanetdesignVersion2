@extends('base')

@php
    $user = session()->has('user')
    ? \App\Models\User::find(session('user'))
    : new \App\Models\User();
@endphp

@section('title', "Mon Catalogue")

@section('head')
    <!-- JQUERY UI -->
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/af-2.4.0/fh-3.2.4/kt-2.7.0/r-2.3.0/rg-1.2.0/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/sr-1.1.1/datatables.min.css"/>
    <!-- TOM SELECT -->
    <link href="{{ asset('css/tom-select.css') }}" rel="stylesheet">
    <script src="{{ asset('js/tom-select.complete.min.js') }}"></script>
    @parent
@endsection

@section('main-content')
    <section id="el-path" class="el-center-box">
        <div class="el-content-area">
            <ul>
                <li><a href="{{ route('home.page') }}">Accueil</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li><span>Catalogue</span></li>
            </ul>
        </div>
    </section>
    <section id="el-favoris" class="el-center-box">
        <div class="el-content-area">
            <div class="el-grid-favoris">
                @if($user->catalog)
                    <a href="{{ route("generate.catalog", $user) }}" target="_blank" class="el-download-catalog"><i class="fas fa-download"></i> Télécharger le catalogue</a>
                @endif
                    <div class="el-container-table">
                    <table id="table_id">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($user->catalog)
                            @foreach($user->catalog->items as $item)

                                @php
                                    switch($item->catalogable_type){
                                        case "App/Models/Variant":
                                            $variant = \App\Models\Variant::find($item->catalogable_id);
                                            $article = $variant->article;
                                            $filename = $variant->document()->where('type','image')->first()
                                                        ? $variant->document()->where('type','image')->first()->path
                                                        : $variant->article->documents()->where('type','image')->first()->path;
                                            break;
                                        default:
                                            $article = \App\Models\Article::find($item->catalogable_id);
                                            $filename = $article->documents()->where('type','image')->first()->path;
                                            break;
                                    }
                                @endphp
                                <tr>
                                    <td><img src="{{ asset($filename) }}" alt=""></td>
                                    <td>
                                        <h4><a href="{{ route('article.show', ['articleSlug' => $article->slug, 'articleRef' => $article->ugs]) }}">{{ $article->name }}</a></h4>
                                        @if(isset($variant))

                                            @if($variant->color)
                                                <li style="margin: 1rem 0 0 1rem;">{{ $variant->color->name }} ({{ \Illuminate\Support\Str::upper($variant->ugs) }})</li>
                                            @elseif($variant->size)
                                                <li style="margin: 1rem 0 0 1rem;">{{ $variant->size->name}}< ({{ \Illuminate\Support\Str::upper($variant->ugs) }})/li>
                                            @endif

                                        @endif
                                    </td>
                                    <td class="el-controls">
                                        <a href="javascript:;" onclick="document.getElementById('el-delete-catalog-{{ $item->id }}').submit()" class="el-btn el-danger el-center-box">
                                            <form action="{{ route("catalog.remove", $item) }}" method="POST" id="el-delete-catalog-{{ $item->id }}">
                                                @csrf
                                                @method("DELETE")
                                            </form>
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @foreach($tab_catalogs as $catalog)
                                <tr>
                                    <td><img src="{{ asset($catalog->article->first_image) }}" alt=""></td>
                                    <td>
                                        <h4><a href="{{ route('article.show', ['articleSlug' => $catalog->article->slug, 'articleRef' => $catalog->article->reference]) }}">{{ $catalog->article->name }}</a></h4>
                                        <ul>
                                            @foreach($catalog->colors as $color)
                                                <li>{{ $color->name }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="el-controls">
                                        <a href="javascript:;" onclick="document.getElementById('el-delete-catalog-{{ $catalog->id }}').submit()" class="el-btn el-danger el-center-box">
                                            <form action="{{ route("catalog.destroy", $catalog) }}" method="POST" id="el-delete-catalog-{{ $catalog->id }}">
                                                @csrf
                                                @method("DELETE")
                                            </form>
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="el-container-back-and-share">
                    <a href="" class="el-back">Continuer le Shopping</a>
                    <div class="el-container-share">
                        <p>Partager sur:</p>
                        {!! $socialNetworks !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    @parent
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery-migrate-1.2.1.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/af-2.4.0/fh-3.2.4/kt-2.7.0/r-2.3.0/rg-1.2.0/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/sr-1.1.1/datatables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#table_id').DataTable({
                paging: false,
                searching: false,
                select: true,
                scrollY: 370,
                /* language: {
                    info: "Horaire de prière pour le mois en cours",
                }, */
                responsive: true
            });
        } );
    </script>
    <script>
        const selectsMultiple = document.querySelectorAll("select[multiple]");
        selectsMultiple.forEach(select => {
            new TomSelect(select, {plugins: {remove_button: {title: 'Supprimer'}}})
        });
    </script>
@endsection
