@extends('admin.form')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">{{ $subcategory->exists ? "Modifier la categorie" : "Ajouter une categorie" }} </h6>
                    </div>
                </div>
                <div class="card-body pb-2">
                    <form method="post" action="{{ $subcategory->exists ? route('subcategory.update', $subcategory) : route('subcategory.store', $subcategory) }}" enctype="multipart/form-data">
                        @csrf
                        @method($subcategory->exists ? 'put' : 'post')
                        <div class="d-flex gap-1">
                            <div @class(["mb-3 input-group input-group-outline", "is-focused" => $subcategory->exists])>
                                <label class="form-label">Nom</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') ?? $subcategory->name }}" />
                            </div>
                            <div class="mb-3 input-group input-group-outline">
                                <select class="form-control el-select" aria-label="Default select example" id="category_id" name="category_id">
                                    <option value="">Catégorie</option>
                                    @foreach($categories as $category)
                                        @if($subcategory->exists && $subcategory->category_id === $category->id)
                                            <option selected value="{{ $category->id }}">{{ $category->name }}</option>
                                        @else
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if($subcategory->exists)
                            @if($subcategory->image)
                                <div id="el-container-picture" style="width: 100%;">
                                    <div class="mb-3 el-container">
                                        <img src="{{ asset($subcategory->image->path) }}" alt="..." class="img-thumbnail">
                                        <button class="el-remove"
                                                hx-delete="{{ route('image.destroy', $subcategory->image) }}"
                                                hx-target="#el-container-picture"
                                                hx-trigger="click">
                                            X
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="mb-3">
                                    <input class="picture" type="file" name="picture">
                                </div>
                            @endif
                        @else
                            <div class="mb-3 input-group input-group-outline">
                                <input class="form-control" type="file" id="formFile" name="picture">
                            </div>
                        @endif

                        <div class="mb-3 input-group input-group-outline">
                            <label>Description</label>
                            <textarea class="ckeditor form-control" id="description" name="description"> {{ old('description') ?? $subcategory->description }} </textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            @if($category->exists)
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
    <!-- SELECT2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- CKEDITOR -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'ckeditor' );
    </script>
    <script>
        //$(document).ready(function() {
            $('select#category_id').select2({
                placeholder: 'Catégorie'
            });
        //});
    </script>
    @if($subcategory->exists)
        <!-- FILEPOND -->
        <script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond@4.26.0/dist/filepond.js"></script>
        <script>
            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginImageEdit);
        </script>
        <script>
            const initializedElements = new Set();

            function initializeFilepond(element) {
                if (!initializedElements.has(element)) {
                    FilePond.create(element, {
                        labelFileProcessingComplete: 'Votre Photo a bien été mise à jour, Veillez actualiser la page',
                        labelFileProcessingError: 'Impossible de mettre à jour votre Photo',
                        labelIdle: 'Glisser-déposer votre image ou <span class="filepond--label-action"> Parcourir </span>',
                        server: {
                            process: {
                                url: '{{ route("uploadPhoto.subcategory", $subcategory) }}', // Remplacez par l'URL de votre action Laravel pour l'upload
                                method: 'POST',
                                withCredentials: false,
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ajoutez le jeton CSRF dans les headers de la requête
                                }
                            },
                        }
                    });
                    initializedElements.add(element);
                }
            }

            function initializeAllFileponds() {
                const pictureMultiple = document.querySelectorAll(".picture");
                pictureMultiple.forEach(picture => {
                    initializeFilepond(picture);
                });
            }

            // Initialisation lors du chargement initial de la page
            initializeAllFileponds();

            document.addEventListener("htmx:afterOnLoad", function () {
                // Initialisation après chaque chargement htmx
                initializeAllFileponds();
            });
        </script>
    @endif

    @parent
@endsection
