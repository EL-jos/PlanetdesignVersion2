@extends('admin.form')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">{{ $size->exists ? "Modifier la taille" : "Ajouter une taille" }} </h6>
                    </div>
                </div>
                <div class="card-body pb-2">
                    <form method="post" action="{{ $size->exists ? route('size.update', $size) : route('size.store', $size) }}" enctype="multipart/form-data">
                        @csrf
                        @method($size->exists ? 'put' : 'post')
                        <div @class(["mb-3 input-group input-group-outline", "is-focused" => $size->exists])>
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') ?? $size->name }}" />
                        </div>

{{--                        <div class="mb-3 input-group input-group-outline">--}}
{{--                            <label>Description</label>--}}
{{--                            <textarea class="ckeditor form-control" id="description" name="description"> {{ old('description') ?? $size->description }} </textarea>--}}
{{--                        </div>--}}

                        <button type="submit" class="btn btn-primary">
                            @if($size->exists)
                                Modifier
                            @else
                                Ajouter
                            @endif
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- HTMLX -->
    <script src="https://unpkg.com/htmx.org@1.9.4" integrity="sha384-zUfuhFKKZCbHTY6aRR46gxiqszMk5tcHjsVFxnUo8VMus4kHGVdIYVbOYYNlKmHV" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <!-- CKEDITOR -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'ckeditor' );
    </script>
    @parent
@endsection
