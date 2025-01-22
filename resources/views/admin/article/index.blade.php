@extends('admin.rubrique')

@section('main-content')
    @if(session('success'))
        <div class="alert alert-success">
            <p class="text-light">{{session('success')}}</p>
        </div>
    @endif

    <div class="d-flex gap-2">
        <a class="btn btn-primary" href="{{ route('article.create') }}" role="button">Ajouter</a>
        <a class="btn btn-info" href="{{ route('article.deleted') }}" role="button">Article(s) supprimé(s)</a>
        <a class="btn btn-info" href="{{ route('article.export') }}" role="button">Expoter Articles</a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">List de tous les articles</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom</th>
{{--                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sous catégorie</th>--}}
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Modification</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($articles as $article)
                                    <tr data-article-id="{{ $article->id }}">
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="{{ asset($article->images->first()->path) }}" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $article->reference }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 text-sm">{{ $article->name }}</h6>
                                        </td>
{{--                                        <td class="align-middle text-center">--}}
{{--                                            <span class="text-secondary text-xs font-weight-bold">--}}
{{--                                                @foreach($article->subcategories as $subcategory)--}}
{{--                                                    @if($article->subcategories->count() === ($loop->index + 1))--}}
{{--                                                        {{ $subcategory->name }}.--}}
{{--                                                    @else--}}
{{--                                                        {{ $subcategory->name }},--}}
{{--                                                    @endif--}}
{{--                                                @endforeach--}}
{{--                                            </span>--}}
{{--                                        </td>--}}
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ date('d/m/Y à H:m:s', strtotime($article->updated_at)) }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex gap-2 w-100 justify-content-end">
                                                @if(!$article->trashed())
                                                <a href="{{route('article.edit', $article)}}" class="btn btn-primary" data-toggle="tooltip" data-original-title="Edit user">
                                                    Editer
                                                </a>
                                                <form action="{{ route('article.destroy', $article) }}" method="post">
                                                    @csrf
                                                    @method('delete')

                                                    <button class="btn btn-danger">Supprimer</button>
                                                </form>
                                            </div>
                                            @else
                                                <a href="{{ route('article.restore', $article) }}" class="btn btn-success">Restaurer</a>
                                                <a href="{{ route('article.remove', $article) }}" class="btn btn-danger">Supprimer définitivement</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var sortable = new Sortable(document.querySelector('table tbody'), {
                animation: 150, // Animation lors du déplacement
                swap: true,
                onEnd: function (event) {
                    // Code à exécuter lorsque le glisser-déposer est terminé
                    // event.oldIndex : index précédent de l'élément
                    // event.newIndex : nouvel index de l'élément
                    // event.item : élément déplacé
                    // Vous pouvez utiliser ces informations pour mettre à jour l'ordre des images dans votre base de données
                    //console.log(event)
                    var itemsIds = Array.from(sortable.el.children).map(function (element) {
                        return element.getAttribute('data-article-id');
                    });
                    var formData = new FormData();
                    formData.append('itemsIds', JSON.stringify(itemsIds));

                    axiosInstance = axios.create();
                    axiosInstance.defaults.onUploadProgress = function (progressEvent) {
                        var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);

                        // Afficher la progression dans un SweetAlert2
                        Swal.fire({
                            title: 'Envoi en cours...',
                            text: 'Progression : ' + percentCompleted + '%',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            showConfirmButton: false,
                            showCancelButton: false,
                            showCloseButton: false,
                            html: '<div class="progress"><div class="progress-bar" role="progressbar" style="width: ' + percentCompleted + '%;"></div></div>'
                        });
                    };

                    axiosInstance.post('{{ route('updateOrder.article') }}', formData, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ajoutez le jeton CSRF dans les headers de la requête
                        }
                    })
                        .then(function (response) {
                            // Fermer le SweetAlert2
                            Swal.close();

                            Swal.fire({
                                icon: 'success',
                                title: 'Valide',
                                text: `${response.message}`
                            });
                        })
                        .catch(function (error) {
                            Swal.close();
                            console.error('Erreur lors de la mise à jour de l\'ordre des images :', error);
                        });
                }
            });
        });
    </script>
@endsection
