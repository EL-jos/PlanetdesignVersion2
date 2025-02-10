@foreach($articles as $article)
    <article class="el-article">
        <div class="el-boxImg">
            <a href="{{ route('article.show', ['articleSlug' => $article->slug, 'articleRef' => $article->ugs]) }}">
                <img src="{{ asset($article->first_image) }}" alt="{{ $article->name }}">
            </a>
            <a href="{{ route('addWishlist.page', ['id' => $article->id, 'model' => \App\Models\Article::class]) }}"
               class="el-favorite">
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
            </a>
        </div>
        <div class="el-content">
            <a href="{{ route('article.show', ['articleSlug' => $article->slug, 'articleRef' => $article->ugs]) }}">
                <h2 class="el-name-article">{{ \Illuminate\Support\Str::title($article->name) }}</h2>
            </a>
            <div id="el-content-{{$article->id}}">
                @include('layouts.article.content', ['article' => $article, 'user' => $user])
            </div>
        </div>
    </article>
@endforeach
