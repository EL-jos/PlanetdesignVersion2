<form method="POST" action="{{ route('addCatalog.article', $article) }}"
      hx-post="{{ route('addCatalog.article', $article) }}" hx-target=".el-article .el-content #el-content-{{$article->id}}">
    @csrf
    <div class="el-row">
        <div class="el-col">
            @php
                $variant = $article->variants->first();
            @endphp

            @if($variant->color)
                <select id="color_id" name="color_id[]" multiple>
                    @foreach($article->variants as $variant)
                        <option value="{{ $variant->color->id }}">{{ $variant->color->name }}</option>
                    @endforeach
                </select>
            @elseif($variant->size)
                <select id="size_id" name="size_id[]" multiple>
                    @foreach($article->variants as $variant)
                        <option value="{{ $variant->size->id }}">{{ $variant->size->name }}</option>
                    @endforeach
                </select>
            @endif

        </div>
    </div>
    <p class="el-disponibility">{{ $article->availability->name }}</p>
    <button type="submit" class="el-btn">Enregistrer</button>
</form>
