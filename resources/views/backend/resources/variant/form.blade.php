@extends('backend.pages.base')

@section("heads")
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/backend/dist/css/adminlte.min2167.css?v=3.2.0')}}">
    <script nonce="677aa08b-50ff-4093-9409-9f9322a7957e">(function(w,d){!function(L,M,N,O){L[N]=L[N]||{};L[N].executed=[];L.zaraz={deferred:[],listeners:[]};L.zaraz.q=[];L.zaraz._f=function(P){return async function(){var Q=Array.prototype.slice.call(arguments);L.zaraz.q.push({m:P,a:Q})}};for(const R of["track","set","debug"])L.zaraz[R]=L.zaraz._f(R);L.zaraz.init=()=>{var S=M.getElementsByTagName(O)[0],T=M.createElement(O),U=M.getElementsByTagName("title")[0];U&&(L[N].t=M.getElementsByTagName("title")[0].text);L[N].x=Math.random();L[N].w=L.screen.width;L[N].h=L.screen.height;L[N].j=L.innerHeight;L[N].e=L.innerWidth;L[N].l=L.location.href;L[N].r=M.referrer;L[N].k=L.screen.colorDepth;L[N].n=M.characterSet;L[N].o=(new Date).getTimezoneOffset();if(L.dataLayer)for(const Y of Object.entries(Object.entries(dataLayer).reduce(((Z,$)=>({...Z[1],...$[1]})),{})))zaraz.set(Y[0],Y[1],{scope:"page"});L[N].q=[];for(;L.zaraz.q.length;){const ba=L.zaraz.q.shift();L[N].q.push(ba)}T.defer=!0;for(const bb of[localStorage,sessionStorage])Object.keys(bb||{}).filter((bd=>bd.startsWith("_zaraz_"))).forEach((bc=>{try{L[N]["z_"+bc.slice(7)]=JSON.parse(bb.getItem(bc))}catch{L[N]["z_"+bc.slice(7)]=bb.getItem(bc)}}));T.referrerPolicy="origin";T.src="../../../../cdn-cgi/zaraz/sd0d9.js?z="+btoa(encodeURIComponent(JSON.stringify(L[N])));S.parentNode.insertBefore(T,S)};["complete","interactive"].includes(M.readyState)?zaraz.init():L.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document);</script>
    <!-- FILEPOND -->
    <link href="https://unpkg.com/filepond@4.26.0/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet"/>
    <!-- SELECT2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- SORTABLE -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <!-- AXIOS -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        .el-container-grid-column-document{
            display: flex;
            flex-direction: column;
            gap: 2rem;
            margin-bottom: 1rem;
        }
        .el-container-grid-column-document .el-container{
            margin-bottom: 0rem;
        }
        .el-container{
            position: relative;
            width: fit-content;
        }
        .el-container .el-remove{
            position: absolute;
            background: red;
            color: #F2F2F2;
            font-weight: bold;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
            top: 0;
            right: 0;
        }
        .el-select2{
            margin-bottom: 1rem;
            min-height: 38px;
        }
        #select2--container,
        .select2-container--default .select2-selection--single .select2-selection__arrow{
            position: absolute;
            top: 50% !important;
            transform: translateY(-50%);
        }.select2-container--default .select2-selection--single,
         .select2-container,
         .ts-control{
             min-height: 40px!important;
         }
        /*.filepond--list {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            height: 500px;
        }*/
        .filepond--item{
            width: 30% !important;
        }
        .filepond--root.picture.filepond--hopper{
            width: 100%;
        }
    </style>
@endsection

@section('main-content')
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">General Elements</h3>
        </div>
        <div class="card-body">
            <form action="{{ $variant->exists ? route('variant.update', $variant) : route('variant.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method($variant->exists ? 'PUT' : 'POST')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            @if(isset($errors))
                                <label class="col-form-label" for="name">
                                    <i class="fas fa-check"></i> Input with success
                                </label>
                            @endif
                            <input type="text" class="form-control is-valid" name="ugs" id="ugs" placeholder="UGS ..." value="{{ $variant->exists ? $variant->ugs : old('ugs') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="el-select2">
                            <select id="category_id" name="category_id"  class="form-control el-select">
                                <option value="">Catégorie ?</option>
                                @foreach($categories as $category)
                                    @if($variant->exists && $variant->article->subcategories->first()->category && $variant->article->subcategories->first()->category->id === $category->id)
                                        <option selected value="{{ $category->id }}">{{ \Illuminate\Support\Str::title($category->name) }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ \Illuminate\Support\Str::title($category->name) }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="el-select2">
                            <select id="subcategory_id" name="subcategory_id"  class="form-control el-select">
                                <option value="">Sous category ?</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="el-select2">
                            <select id="article_id" name="article_id"  class="form-control el-select">
                                @if($variant->exists)
                                    <option value="{{ $variant->article->id }}">{{ \Illuminate\Support\Str::title($variant->article->name) }}</option>
                                @else
                                    <option value="">Article ?</option>
                                @endif

                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="el-select2">
                            <select id="color_id" name="color_id"  class="form-control el-select">
                                <option value="">Couleur ?</option>
                                @foreach($colors as $color)
                                    @if($variant->exists && $variant->color && $variant->color->id === $color->id)
                                        <option selected value="{{ $color->id }}">{{ \Illuminate\Support\Str::title($color->name) }}</option>
                                    @else
                                        <option value="{{ $color->id }}">{{ \Illuminate\Support\Str::title($color->name) }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="el-select2">
                            <select id="size_id" name="size_id"  class="form-control el-select">
                                <option value="">Dimension ?</option>
                                @foreach($sizes as $size)
                                    @if($variant->exists && $variant->size && $variant->size->id === $size->id)
                                        <option selected value="{{ $size->id }}">{{ \Illuminate\Support\Str::title($size->name) }}</option>
                                    @else
                                        <option value="{{ $size->id }}">{{ \Illuminate\Support\Str::title($size->name) }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="el-select2">
                            <select id="availability_id" name="availability_id"  class="form-control el-select">
                                <option value="">Disponibilité ?</option>
                                @foreach($availabilities as $availability)
                                    @if($variant->exists && $variant->availability && $variant->availability->id === $availability->id)
                                        <option selected value="{{ $availability->id }}">{{ \Illuminate\Support\Str::title($availability->name) }}</option>
                                    @else
                                        <option value="{{ $availability->id }}">{{ \Illuminate\Support\Str::title($availability->name) }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                @if($variant->exists)
                    @if($variant->document)
                        <div class="el-container-grid-column-document">
                            <div id="el-container-picture" style="width: 100%;">
                                <div class="el-container">
                                    <img src="{{ asset($variant->document->path) }}" alt="..." class="img-thumbnail">
                                    <button class="el-remove"
                                            hx-delete="{{ route('document.destroy', ['document' => $variant->document, 'isMultiple' => 0]) }}"
                                            hx-target="#el-container-picture"
                                            hx-trigger="click">
                                        X
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        @include('backend.layouts.file', ['isMultiple' => false])
                    @endif
                @else
                    @include('backend.layouts.file', ['isMultiple' => false])
                @endif

                <div style="padding: 0" class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        @if($variant->exists)
                            Update
                        @else
                            Submit
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script src="{{ asset('assets/backend/dist/js/adminlte.min2167.js?v=3.2.0')}}"></script>
    <!-- SELECT2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- SWEET ALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- HTMLX -->
    <script src="https://unpkg.com/htmx.org@1.9.4" integrity="sha384-zUfuhFKKZCbHTY6aRR46gxiqszMk5tcHjsVFxnUo8VMus4kHGVdIYVbOYYNlKmHV" crossorigin="anonymous"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });

        $(document).ready(function() {

            $('select#category_id').select2({
                placeholder: 'Categorie ?'
            }).on('change', (e) => {

                let categoryId = e.target.options.selectedIndex;

                // Activer le sélecteur de catégorie et récupérer les catégories
                $('#subcategory_id').prop('disabled', false).trigger('change');

                $.ajax({
                    url: '{{ route('subcategory.getSubCategories') }}',
                    type: 'GET',
                    data: {
                        category_id: categoryId
                    },
                    success: (data) => {

                        let $subcategorySelect = $('select#subcategory_id');
                        $subcategorySelect.select2('destroy');
                        $subcategorySelect.empty();
                        $subcategorySelect.append($('<option>', {
                            value: '',
                            text: 'Sous Categorie ?'
                        }));

                        $.each(data, function (index, subcategory) {
                            $subcategorySelect.append($('<option>', {
                                value: subcategory.id,
                                text: subcategory.name
                            }));
                        });

                        $subcategorySelect.select2({
                            placeholder: 'Sous Categorie ?'
                        });

                        // Réinitialiser le sélecteur d'articles lorsque le menu change
                        $('#article_id').select2('destroy').empty().append($('<option>', {
                            value: '',
                            text: 'Article ?'
                        })).select2({
                            placeholder: 'Article ?'
                        });

                    },
                    error: (xhr, status, error) => {
                        console.log('Error: ', error);
                    }
                })

                // Désactiver le sélecteur d'articles
                @if($variant->exists)
                    $('#article_id').prop('disabled', false).val(null).trigger('change');
                @else
                    $('#article_id').prop('disabled', true).val(null).trigger('change');
                @endif


            });

            $('select#subcategory_id').select2({
                placeholder: 'Sous Category ?',
                disabled: true,
            }).on('change', (e) => {

                let subcategoriyId = e.target.options.selectedIndex;
                // Activer le sélecteur d'articles et récupérer les articles
                $('#article_id').prop('disabled', false).trigger('change');

                $.ajax({
                    url: '{{ route('subcategory.getArticles') }}',
                    type: 'GET',
                    data: {
                        subcategory_id: subcategoriyId,
                    },
                    success: (data) => {

                        let $articleSelect = $('select#article_id');
                        $articleSelect.select2('destroy');
                        $articleSelect.empty();
                        $articleSelect.append($('<option>', {
                            value: '',
                            text: ''
                        }));

                        $.each(data, (index, article) => {

                            $articleSelect.append($('<option>', {
                                value: article.id,
                                text: article.name
                            }));

                        });

                        $articleSelect.select2({
                            placeholder: 'Article ?'
                        });


                    }
                })

            });
            @if($variant->exists)
                $('select#article_id').select2({
                    placeholder: 'Article ?',
                    disabled:  false,
                });
            @else
                $('select#article_id').select2({
                    placeholder: 'Article ?',
                    disabled:  true,
                });
            @endif
            $('select#color_id').select2({
                placeholder: 'Couleur ?',
                //disabled: true,
            });
            $('select#size_id').select2({
                placeholder: 'Dimension ?',
                //disabled: true,
                tags: true,
            });

            $('select#availability_id').select2({
                placeholder: 'Disponibilité',

            });
        });
    </script>
    @if($variant->exists)
        <!-- FILEPOND -->
        <script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond@4.26.0/dist/filepond.js"></script>
        <script>
            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginImageEdit);
            document.addEventListener('DOMContentLoaded', function () {
                // Sélectionnez l'élément de téléchargement par sa classe
                const inputElement = document.querySelector('.picture');

                // Initialisation de FilePond dans le formulaire
                const pond = FilePond.create(inputElement, {
                    labelFileProcessingComplete: 'Votre Photo a bien été mise à jour, Veillez actualiser la page',
                    labelFileProcessingError: 'Impossible de mettre à jour votre Photo',
                    labelIdle: 'Glisser-déposer votre image ou <span class="filepond--label-action"> Parcourir </span>',
                    server: {
                        process: {
                            url: '{{ route("variant.uploadDocument", $variant) }}', // Remplacez par l'URL de votre action Laravel pour l'upload
                            method: 'POST',
                            withCredentials: false,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ajoutez le jeton CSRF dans les headers de la requête
                            }
                        },
                    }
                });
                // Charger l'aperçu de l'image actuelle
            });
        </script>
    @endif
    @if(session()->has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Valide',
                text: "{!! session('success') !!}"
            });
        </script>
    @elseif(session()->has('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: "{!! session('error') !!}"
            });
        </script>
    @elseif(session()->has('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Votre attention',
                text: "{!! session('warning') !!}"
            });
        </script>
    @elseif(session()->has('info'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Information',
                text: "{!! session('info') !!}"
            });
        </script>
    @elseif($errors->any())
        <script>
            var errorMessages = "<ul>";
            @foreach ($errors->all() as $error)
                errorMessages += "<li>{{ $error }}</li>";
            @endforeach
                errorMessages += "</ul>";

            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                html: errorMessages
            });
        </script>
    @endif
@endsection
