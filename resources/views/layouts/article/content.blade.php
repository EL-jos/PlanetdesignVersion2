@if($article->variants->count() >= 1 || $article->documents()->where('type', 'image')->get()->count() >= 1 )
    <div class="owl-carousel">
        @foreach($article->documents()->where('type', 'image')->get() as $document)
            <img src="{{ asset($document->path) }}" data-src="{{ asset($document->path) }}" alt="{{ $article->name }}">
        @endforeach
        @foreach($article->variants as $variant)
            <img src="{{ asset($variant->image->path) }}" data-src="{{ asset($variant->image->path) }}" data-id="{{ $variant->id }}" data-model="{{ \App\Models\Variant::class }}" alt="{{ $article->name }}">
        @endforeach
    </div>
@endif
<div class="el-footer-article">
    <h3 class="el-ref-article">Réf.: {{ $article->ugs }}</h3>
    <a title="Ajouter au devis"
       href="{{ route('addCart.page', ['id' => $article->id, 'model' => \App\Models\Article::class]) }}"
       class="el-add-devis"><img src="{{ asset('assets/img/Add2devis-2.png') }}" alt=""></a>
    <a title="Ajouter au catalogue"
       href="{{ route('addCatalog.page', ['id' => $article->id, 'model' => \App\Models\Article::class]) }}"
       class="el-add-catalogue"><img src="{{ asset('assets/img/add2wish.png') }}" alt=""></a>
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
