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
    @foreach($catalogs as $catalog)
        <tr>
            <td style="text-align: center; vertical-align: middle;">
                <div style="display: inline-block;">
                    <img src="{{ $catalog->article->compressImage(300, 300) }}" alt="">
                </div>
            </td>
            <td>
                <ul>
                    <li><span>{{ $catalog->article->reference }}</span></li>
                    <li class="el-item"><span>{{ $catalog->article->name }}</span> </li>
                    <li class="el-item el-description">{!! htmlspecialchars_decode($catalog->article->description) !!}</li>
                    @if($catalog->article->colors->count())
                        <li class="el-item"><span>Couleur(s):</span> <p style="text-transform: capitalize; font-size: 13px; color: #666;">
                                @foreach($catalog->article->colors as $color)
                                    @if($catalog->article->colors->count() === ($loop->index + 1))
                                        {{ $color->name }}.
                                    @else
                                        {{ $color->name }}; <!-- Utilisez le point-virgule au lieu du point ici -->
                                    @endif
                                @endforeach
                            </p>
                        </li>
                    @endif
                    @if($catalog->article->sizes->count())
                        <li class="el-item"><span>Taille(s):</span> <p style="text-transform: capitalize; font-size: 13px; color: #666;">
                                @foreach($catalog->article->sizes as $size)
                                    @if($catalog->article->sizes->count() === ($loop->index + 1))
                                        {{ $size->name }}.
                                    @else
                                        {{ $size->name }}; <!-- Utilisez le point-virgule au lieu du point ici -->
                                    @endif
                                @endforeach
                            </p>
                        </li>
                    @endif
                </ul>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
