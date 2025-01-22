@extends("backend.pages.base")

@section("heads")
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">

    <link rel="stylesheet" href="{{ asset("assets/backend/plugins/fontawesome-free/css/all.min.css")}}">

    <link rel="stylesheet" href="{{ asset("assets/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css")}}">
    <link rel="stylesheet" href="{{ asset("assets/backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}">
    <link rel="stylesheet" href="{{ asset("assets/backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css")}}">

    <link rel="stylesheet" href="{{ asset("assets/backend/dist/css/adminlte.min2167.css?v=3.2.0")}}">
    @parent
@endsection

@section("main-content")
    <div class="row">
        <div class="col-12">
            @if(session()->has('success'))
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Valide</span>
                        <span class="info-box-number">{{ session()->get('success') }}</span>
                    </div>

                </div>
            @elseif(session()->has('error'))
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Erreur</span>
                        <span class="info-box-number">{{ session()->get('error') }}</span>
                    </div>

                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DataTable with default features</h3>
                </div>
                <div class="card-body">
                    <div class="el-btns-controls">
                        <a href="{{ route('article.create') }}" class="btn btn-block btn-primary">Ajouter</a>
                        <a href="{{ route('article.trashed') }}" class="btn btn-block btn-primary">Supprimées</a>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Catégorie</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                                <tr>
                                    <td>{{ $loop->index  + 1}}</td>
                                    <td> <img height="71px" src="{{ $article->documents()->where('type','image')->first() ? asset($article->documents()->where('type','image')->first()->path) : '' }}"></td>
                                    <td>{{ $article->name }}</td>
                                    <td>
                                        @foreach($article->subcategories as $subcategory)
                                            @if($loop->index + 1 !== $article->subcategories->count())
                                                <span>{{ \Illuminate\Support\Str::upper($subcategory->name) . '; ' }}</span>
                                            @else
                                                <span>{{ \Illuminate\Support\Str::upper($subcategory->name) }}</span>
                                            @endif

                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="d-flex" style="gap: .5rem;">
                                            @if(!$article->trashed())
                                                <a href="{{ route('article.edit', $article) }}" class="btn bg-gradient-warning"><i class="fas fa-edit"></i></a>
                                                <button class="btn bg-gradient-danger" onclick="document.getElementById('el-form-{{$article->id}}').submit()">
                                                    <form id="el-form-{{$article->id}}" action="{{ route('article.destroy', $article) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            @else
                                                <button onclick="document.getElementById('el-restore-form-{{ $article->id }}').submit()" class="btn bg-gradient-warning">
                                                    <form id="el-restore-form-{{ $article->id }}" action="{{ route('article.restore', $article) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <i class="fas fa-trash-restore"></i>
                                                </button>
                                                <button class="btn bg-gradient-danger" onclick="document.getElementById('el-form-{{$article->id}}').submit()">
                                                    <form id="el-form-{{$article->id}}" action="" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Catégorie</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>

        </div>

    </div>
@endsection

@section("scripts")
    <script src="{{ asset("assets/backend/plugins/jquery/jquery.min.js")}}"></script>

    <script src="{{ asset("assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>

    <script src="{{ asset("assets/backend/plugins/datatables/jquery.dataTables.min.js")}}"></script>
    <script src="{{ asset("assets/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js")}}"></script>
    <script src="{{ asset("assets/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js")}}"></script>
    <script src="{{ asset("assets/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js")}}"></script>
    <script src="{{ asset("assets/backend/plugins/datatables-buttons/js/dataTables.buttons.min.js")}}"></script>
    <script src="{{ asset("assets/backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js")}}"></script>
    <script src="{{ asset("assets/backend/plugins/jszip/jszip.min.js")}}"></script>
    <script src="{{ asset("assets/backend/plugins/pdfmake/pdfmake.min.js")}}"></script>
    <script src="{{ asset("assets/backend/plugins/pdfmake/vfs_fonts.js")}}"></script>
    <script src="{{ asset("assets/backend/plugins/datatables-buttons/js/buttons.html5.min.js")}}"></script>
    <script src="{{ asset("assets/backend/plugins/datatables-buttons/js/buttons.print.min.js")}}"></script>
    <script src="{{ asset("assets/backend/plugins/datatables-buttons/js/buttons.colVis.min.js")}}"></script>

    <script src="{{ asset("assets/backend/dist/js/adminlte.min2167.js?v=3.2.0")}}"></script>

    {{--<script src="{{ asset("dist/js/demo.js")}}"></script>--}}

    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
