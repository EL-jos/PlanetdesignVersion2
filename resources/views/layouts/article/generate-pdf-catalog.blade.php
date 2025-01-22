<!DOCTYPE html>
<html>
<head>
    <style>
        .el-p *{
            font-family: sans-serif !important;
        }
    </style>
</head>
<body>
    <h1 style="font-family: sans-serif; font-size: 1.5rem; text-align: center">{{ $article->name }}</h1>
    <p style="font-family: sans-serif;"><span style="font-weight: bold">Réf:</span> {{ $article->reference }}</p>
    <p style="text-align: center; margin: 2rem 0;"><img src="{{ $article->compressImage(500, 500) }}" alt="Article Image"></p>
    <h2 style="font-family: sans-serif; text-align: center; font-size: 1.2rem;">Déscription du produit</h2>
    <p class="el-p">{!! htmlspecialchars_decode($article->description) !!}</p>
</body>
</html>
