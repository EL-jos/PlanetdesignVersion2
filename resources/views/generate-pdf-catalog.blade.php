<!DOCTYPE html>
<html>
<head>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        body {
            display: grid;
            place-items: center;
            width: 100%;
            height: 100vh;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            max-width: 1000px;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            width: 50%;
            padding: 10px;
            text-align: center;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
            border-bottom: 1px solid #ccc;
        }

        td {
            border: 1px solid #ccc;
            text-align: left;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        span {
            font-weight: bold;
            color: #333;
        }

        .el-description * {
            color: #666;
            font-size: 13px;
        }.el-description ul{
            list-style: disc;
            margin: 0 2rem;
        }
        .el-item{
            margin-top: .5rem;
        }
    </style>
</head>
<body>
<h1>Mon Catalogue d'Articles</h1>
<table>
    <thead>
    <tr>
        <th>Article</th>
        <th>Description</th>
    </tr>
    </thead>
    <tbody>
    @foreach($catalog->items as $item)

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
            <td style="text-align: center; vertical-align: middle;">
                <div style="display: inline-block;">
                    <img src="{{ isset($variant) ? $variant->compressImage(200, 200) : $article->compressImage(200, 200) }}" alt="">
                </div>
            </td>
            <td>
                <ul>
                    <li><span>{{ isset($variant) ? \Illuminate\Support\Str::upper($variant->ugs) : \Illuminate\Support\Str::upper($article->ugs) }}</span></li>
                    <li class="el-item"><span>{{ $article->name }}</span> </li>
                    <li class="el-item el-description">{!! htmlspecialchars_decode($article->content) !!}</li>
                </ul>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
