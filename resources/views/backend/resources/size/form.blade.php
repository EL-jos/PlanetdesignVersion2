@extends('backend.pages.base')

@section("heads")
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/backend/dist/css/adminlte.min2167.css?v=3.2.0')}}">
    <script nonce="677aa08b-50ff-4093-9409-9f9322a7957e">(function(w,d){!function(L,M,N,O){L[N]=L[N]||{};L[N].executed=[];L.zaraz={deferred:[],listeners:[]};L.zaraz.q=[];L.zaraz._f=function(P){return async function(){var Q=Array.prototype.slice.call(arguments);L.zaraz.q.push({m:P,a:Q})}};for(const R of["track","set","debug"])L.zaraz[R]=L.zaraz._f(R);L.zaraz.init=()=>{var S=M.getElementsByTagName(O)[0],T=M.createElement(O),U=M.getElementsByTagName("title")[0];U&&(L[N].t=M.getElementsByTagName("title")[0].text);L[N].x=Math.random();L[N].w=L.screen.width;L[N].h=L.screen.height;L[N].j=L.innerHeight;L[N].e=L.innerWidth;L[N].l=L.location.href;L[N].r=M.referrer;L[N].k=L.screen.colorDepth;L[N].n=M.characterSet;L[N].o=(new Date).getTimezoneOffset();if(L.dataLayer)for(const Y of Object.entries(Object.entries(dataLayer).reduce(((Z,$)=>({...Z[1],...$[1]})),{})))zaraz.set(Y[0],Y[1],{scope:"page"});L[N].q=[];for(;L.zaraz.q.length;){const ba=L.zaraz.q.shift();L[N].q.push(ba)}T.defer=!0;for(const bb of[localStorage,sessionStorage])Object.keys(bb||{}).filter((bd=>bd.startsWith("_zaraz_"))).forEach((bc=>{try{L[N]["z_"+bc.slice(7)]=JSON.parse(bb.getItem(bc))}catch{L[N]["z_"+bc.slice(7)]=bb.getItem(bc)}}));T.referrerPolicy="origin";T.src="../../../../cdn-cgi/zaraz/sd0d9.js?z="+btoa(encodeURIComponent(JSON.stringify(L[N])));S.parentNode.insertBefore(T,S)};["complete","interactive"].includes(M.readyState)?zaraz.init():L.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document);</script>
@endsection

@section('main-content')
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">General Elements</h3>
        </div>
        <div class="card-body">
            <form action="{{ $size->exists ? route('size.update', $size) : route('size.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method($size->exists ? 'PUT' : 'POST')
                <div class="form-group">
                    @if(isset($errors))
                        <label class="col-form-label" for="name">
                            <i class="fas fa-check"></i> Input with success
                        </label>
                    @endif

                    <input type="text" class="form-control is-valid" name="name" id="value" placeholder="Valeur ..." value="{{ $size->exists ? $size->name : old('name') }}">
                </div>
                <div style="padding: 0" class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        @if($size->exists)
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
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endsection
