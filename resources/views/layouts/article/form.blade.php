<form id="el-form-quote-{{ $article->id }}"
        @if($user->exists)
            method="POST"
            action="{{ route('addQuote.article', $article) }}"
            hx-post="{{ route('addQuote.article', $article) }}"
            hx-target=".el-article .el-content #el-content-{{$article->id}}"
        @else
            method="POST"
          action="{{ route('devis.store') }}"
          hx-post="{{ route('devis.store') }}"
          hx-target=".el-article .el-content #el-content-{{$article->id}}"
        @endif
>
    @csrf
    <input type="hidden" name="article_id" value="{{ $article->id }}" />
    <input type="hidden" name="ip_address" value="{{ $_SERVER['REMOTE_ADDR'] }}" />
    <input type="hidden" name="user_agent" value="{{ $_SERVER['HTTP_USER_AGENT'] }}" />
    <div class="el-row">
        <div class="el-col">
            @if($article->colors->count() && !$article->sizes->count())
                <select class="color_id" name="color_id">
                    <option value="">Couleur ?</option>
                    @foreach($article->colors as $color)
                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                    @endforeach
                </select>
            @elseif(!$article->colors->count() && $article->sizes->count())
                <select class="color_id" name="size_id">
                    <option value="">Taille ?</option>
                    @foreach($article->sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                    @endforeach
                </select>
            @elseif($article->colors->count() && $article->sizes->count())
                <select class="color_id" name="color_id">
                    <option value="">Couleur ?</option>
                    @foreach($article->colors as $color)
                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                    @endforeach
                </select>
                <select class="color_id" name="size_id">
                    <option value="">Taille ?</option>
                    @foreach($article->sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>
    <div class="el-row">
        <div class="el-col">
            <input style="padding-left: 5px;" type="number" min="1" name="quantity" value="1" placeholder="Quantité ?" />
        </div>
    </div>
    <p class="el-disponibility">{{ $article->availability->name }}</p>
    <button id="el-btn-submit-{{ $article->id }}" style="cursor: pointer;" type="submit" class="el-btn">Enregistrer</button>
</form>
