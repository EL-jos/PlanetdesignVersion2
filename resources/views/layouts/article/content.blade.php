@if($article->images->count() > 1)
    <div class="owl-carousel">
        @foreach($article->images as $image)
            <img src="{{ asset($image->path) }}" data-src="{{ asset($image->path) }}" alt="{{ $article->name }}">
        @endforeach
    </div>
@endif
<div class="el-footer-article">
    <h3 class="el-ref-article">Réf.: {{ $article->reference }}</h3>
    @if($user->exists)
        <a title="Ajouter au devis"
           hx-get="{{ route('addQuote.page', $article) }}"
           hx-trigger="click"
           hx-target=".el-article .el-content #el-content-{{$article->id}}"
           href="javascript:;" id="el-add-devis"><img src="{{ asset('assets/img/Add2devis-2.png') }}" alt=""></a>
        <a title="Ajouter au catalogue"
           hx-post="{{ route('addCatalog.article', $article) }}"
           hx-trigger="click"
           hx-target=".el-article .el-content #el-content-{{$article->id}}"
           hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
           href="javascript:;"
           id="el-add-catalogue"><img src="{{ asset('assets/img/add2wish.png') }}" alt=""></a>
    @else
        <a title="Ajouter au devis"
           hx-get="{{ route('addQuote.page', $article) }}"
           hx-trigger="click"
           hx-target=".el-article .el-content #el-content-{{$article->id}}"
           href="javascript:;" id="el-add-devis"><img src="{{ asset('assets/img/Add2devis-2.png') }}" alt=""></a>
        <a title="Ajouter au catalogue"
           hx-post="{{ route('addCatalog.article', $article) }}"
           hx-trigger="click"
           hx-target=".el-article .el-content #el-content-{{$article->id}}"
           hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
           href="javascript:;"
           id="el-add-catalogue"><img src="{{ asset('assets/img/add2wish.png') }}" alt=""></a>
    @endif
</div>

@if(request()->attributes->has('htmx'))
    <script>

        @switch($code)
            @case(0)
                Swal.fire({
                    icon: 'success',
                    title: 'Valide',
                    text: "{!! $message !!}"
                });
                @switch($is)
                    @case('devis')
                        document.getElementById("el-nb-quote").textContent = {!! $nb !!};
                        @break
                    @case('catalog')
                        document.getElementById("el-nb-catalog").textContent = {!! $nb !!};
                        @break
                @endswitch
                @break
            @case(1)
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: "{!! $message !!}"
                });
                @break
        @endswitch
    </script>
@elseif(isset($code) && isset($nb) && isset($message) && isset($is))
    <script>
        @switch($code)
            @case(0)
                Swal.fire({
            icon: 'success',
            title: 'Valide',
            text: "{!! $message !!}"
        });
                @switch($is)
                    @case('devis')
                        document.getElementById("el-nb-quote").textContent = {!! $nb !!};
                        @break
                    @case('catalog')
                        document.getElementById("el-nb-catalog").textContent = {!! $nb !!};
                        @break
                @endswitch
                @break
            @case(1)
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: "{!! $message !!}"
                });
                @break
        @endswitch
    </script>
@else
   {{-- <script>
        switch (parseInt(response.code)) {
            case 0:
                Swal.fire({
                    icon: 'success',
                    title: 'Valide',
                    text: `${response.message}`
                });
                if(response.is === 'catalog'){
                    document.getElementById("el-nb-catalog").textContent = response.nb;
                }
                break;
            case 1:
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: `${response.message}`
                });
                break;
        }
    </script>--}}
@endif
