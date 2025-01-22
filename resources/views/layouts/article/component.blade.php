@foreach($articles as $article)
    <article class="el-article">
        <div class="el-boxImg">
            <a href="{{ route('article.show', ['articleSlug' => $article->slug, 'articleRef' => $article->reference]) }}">
                <img src="{{ asset($article->images->first()->path) }}" alt="{{ $article->name }}">
            </a>
            @if($user->exists)
                <a href="javascript:;"
                   hx-get="{{ route('favorite', ['user' => $user, 'article' => $article]) }}"
                   hx-trigger="click"
                   class="el-favorite">
                    @include('layouts.favorite.favorite', ['user' => $user, 'article' => $article])
                </a>
            @else
                <a href="javascript:;"
                   hx-get="{{ route('favorite', ['article' => $article]) }}"
                   hx-trigger="click"
                   class="el-favorite">
                    @include('layouts.favorite.favorite', ['user' => $user, 'article' => $article])
                </a>
            @endif
        </div>
        <div class="el-content">
            <a href="{{ route('article.show', ['articleSlug' => $article->slug, 'articleRef' => $article->reference]) }}"><h2 class="el-name-article">{{ $article->name }}</h2></a>
            <div id="el-content-{{$article->id}}">
                @include('layouts.article.content', ['article' => $article, 'user' => $user])
            </div>
        </div>
    </article>
@endforeach
