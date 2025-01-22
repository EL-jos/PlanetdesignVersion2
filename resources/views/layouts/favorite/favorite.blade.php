@php
    $isFavorite = \App\Models\Favorite::where(['user_id' => $user->id, 'article_id' => $article->id])->exists();
@endphp
<i class="{{ $isFavorite ? 'fas' : 'far' }} fa-heart"></i>

@if(request()->attributes->has('htmx') && $user->exists)
    <script>
        document.getElementById('el-nb-favorite').textContent = '{{ $user->favorites->count() }}'
    </script>
@else
    <script>
        document.getElementById('el-nb-favorite').textContent = '{{ \App\Models\Favorite::where('ip_address', $_SERVER['REMOTE_ADDR'])
                                        ->whereAnd('user_agent', $_SERVER['HTTP_USER_AGENT'])
                                        ->get()->count() }}'
    </script>
@endif
