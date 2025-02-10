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
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/summernote/summernote-bs4.min.css')}}">

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
        .filepond--list {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            height: 500px;
        }
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
            <form action="{{ $subcategory->exists ? route('subcategory.update', $subcategory) : route('subcategory.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method($subcategory->exists ? 'PUT' : 'POST')
                {{--<div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Text</label>
                            <input type="text" class="form-control" placeholder="Enter ...">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Text Disabled</label>
                            <input type="text" class="form-control" placeholder="Enter ..." disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Textarea</label>
                            <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Textarea Disabled</label>
                            <textarea class="form-control" rows="3" placeholder="Enter ..." disabled></textarea>
                        </div>
                    </div>
                </div>--}}

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" class="form-control is-valid" name="name" id="name" placeholder="Nom ..." value="{{ $subcategory->exists ? $subcategory->name : old('name') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="el-select2">
                            <select id="category_id" name="category_id"  class="form-control el-select">
                                <option value="">Menu ?</option>
                                @foreach($categories as $category)
                                    @if($subcategory->exists && $subcategory->category && $subcategory->category->id === $category->id)
                                        <option selected value="{{ $category->id }}">{{ \Illuminate\Support\Str::title($category->name) }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ \Illuminate\Support\Str::title($category->name) }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                @if($subcategory->exists)
                    @if($subcategory->document)
                        <div class="el-container-grid-column-document">
                            <div id="el-container-picture" style="width: 100%;">
                                <div class="el-container">
                                    <img src="{{ asset($subcategory->document->path) }}" alt="..." class="img-thumbnail">
                                    <button class="el-remove"
                                            hx-delete="{{ route('document.destroy', ['document' => $subcategory->document, 'isMultiple' => 0]) }}"
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

                <div class="row">
                    <div class="col-12">
                        <textarea id="summernote" name="content"> {{ $subcategory->content ?? old('content') }} </textarea>
                    </div>
                </div>

                <div style="padding: 0" class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        @if($subcategory->exists)
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
    <script src="{{ asset('assets/backend/plugins/summernote/summernote-bs4.min.js')}}"></script>
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
                placeholder: 'Catégorie ?'
            });

            $('#summernote').summernote();
        });
    </script>
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
