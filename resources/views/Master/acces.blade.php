@extends('template')
@section('acces')
    <div class="accordion mb-3" id="accordionExample">
        <div class="card accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                    data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne">
                    Filter
                </button>
            </h2>
            <div id="accordionOne" class="accordion-collapse collapse {{ request('search') ? 'show' : '' }}"
                data-bs-parent="#accordionExample" style="">
                <div class="accordion-body">
                    <form class="row d-flex" id="search_form" method="GET">
                        <input type="hidden" name="sortir" id="sortir" value="{{ request('sortir') }}">
                        <input type="hidden" name="order_name" id="order_name" value="{{ request('order_name') }}">
                        <input type="hidden" name="order_type" id="order_type" value="{{ request('order_type') }}">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Search</label>
                                    <div class="col-sm-9">
                                        <input value="{{ request('search') }}" class="form-control" type="text"
                                            name="search" id="search" value="" placeholder="Search...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-3 d-md-flex justify-content-md-end mb-3">
                            <button class="btn btn-secondary" id="btn_filter" type="submit">
                                Filter
                            </button>
                            <button type="button" class="btn btn-warning resetBtn">
                                Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAcces">
                Add New
            </button>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="table-active">
                            <th class="p-1 text-center">No</th>
                            <th class="p-1 text-center">
                                Acces Name
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'acces_name' ? 'brown' : '' }};"
                                    class="btnAccesDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'acces_name' ? 'brown' : '' }};"
                                    class="btnAccesAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center">
                                Inserted At
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'acces_inserted_at' ? 'brown' : '' }};"
                                    class="btnInsertDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'acces_inserted_at' ? 'brown' : '' }};"
                                    class="btnInsertAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center">
                                Updated At
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'acces_last_updated' ? 'brown' : '' }};"
                                    class="btnUpdatedDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'acces_last_updated' ? 'brown' : '' }};"
                                    class="btnUpdatedAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $no = $limit * $page - $limit;
                        ?>
                        @if ($data->isEmpty())
                            <tr>
                                <td colspan="5" style="text-align: center">No data</td>
                            </tr>
                        @else
                            @foreach ($data as $item)
                                <tr>
                                    <td style="font-size: 14px;" class="p-2">{{ ++$no }}</td>
                                    <td style="font-size: 14px;" class="p-2">{{ $item->acces_name }}</td>
                                    <td style="font-size: 14px;" class="p-2">
                                        {{ date('d F Y h:i:s', strtotime($item->acces_inserted_at)) }}
                                    </td>
                                    <td style="font-size: 14px;" class="p-2">
                                        {{ date('d F Y h:i:s', strtotime($item->acces_last_updated)) }}
                                    </td>
                                    <td style="font-size: 14px;" class="p-2">
                                        <button type="button" value="{{ $item->id_acces }}"
                                            class="btn rounded-pill btn-icon btn-danger deleteBtn">
                                            <span class="fas fa-trash-alt fa-2xs"></span>
                                        </button>
                                        <button type="button" value="{{ $item->id_acces }}"
                                            class="btn rounded-pill btn-icon btn-warning ms-2 editBtn">
                                            <span class="fas fa-edit fa-2xs"></span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="row mt-4">
                <div class="col-md-1 align-middle d-flex flex-column align-items-md-start">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ request('sortir') == null ? '10' : request('sortir') }}
                        </button>
                        <ul class="dropdown-menu" id="listSortir">
                            <li class="listAttr" value="10"><a class="dropdown-item text-small">10</a></li>
                            <li class="listAttr" value="20"><a class="dropdown-item" href="#">20</a>
                            </li>
                            <li class="listAttr" value="50"><a class="dropdown-item" href="#">50</a>
                            </li>
                            <li class="listAttr" value="100"><a class="dropdown-item" href="#">100</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-5 align-middle d-flex flex-column align-items-md-start mt-2" id="showing_page">
                    Showing
                    {!! $data->firstItem() !!} to
                    {!! $data->lastItem() !!} of {!! $data->total() !!} entries
                </div>
                <div class="col-md-6 d-flex flex-column align-items-md-end" id="showing_page">
                    {!! $data->appends(request()->all())->links() !!}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Add --}}
    <div class="modal fade" id="addAcces" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Add {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('acces/add_acces') }}"method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Acces Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="acces_name" name="acces_name"
                                    placeholder="Insert acces name" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="editAcces" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Edit {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('acces/edit_acces') }}"method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_acces" id="id_acces">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Acces Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_acces_name" name="edit_acces_name"
                                    placeholder="Insert acces name" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Delete --}}
    <div class="modal fade" id="deleteAcces" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Delete {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('acces/delete_acces') }}"method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <input type="hidden" id="id_acces_delete" name="id_acces_delete">
                            <label class="form-label" style="text-transform: uppercase">Are you sure
                                want to delete <span id="acces_name_delete" style="font-weight:bold"></span>?</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        var strQuery, strUrlParams, nSortir, nSearch, nPaginatorSelected, nValue;
        var form_type = '<?= request('form_type') ?>';
        $('#form_type').val(form_type);
        $(".listAttr").click(function() {
            var nValue = $(this).val();
            $('#sortir').val(nValue);
            $('#search_form').submit();
        });
        $(".listAttr").click(function() {
            var nValue = $(this).val();
            $('#sortir').val(nValue);
            submitFilter(nValue);
        });
        $('.resetBtn').click(function() {
            $('#search').val('');
            $('#order_name').val('');
            $('#order_type').val('');
            $('#search_form').submit();
        });
        $('.btnAccesDesc').click(function() {
            $('#order_name').val('acces_name');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnAccesAsc').click(function() {
            $('#order_name').val('acces_name');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        $('.btnInsertDesc').click(function() {
            $('#order_name').val('acces_inserted_at');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnInsertAsc').click(function() {
            $('#order_name').val('acces_inserted_at');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        $('.btnUpdatedDesc').click(function() {
            $('#order_name').val('acces_last_updated');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnUpdatedAsc').click(function() {
            $('#order_name').val('acces_last_updated');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        // Edit Acces
        $(document).ready(function() {
            $(document).on('click', '.editBtn', function() {
                var id_acces = $(this).val();
                console.log(id_acces);

                $('#editAcces').modal('show')

                $.ajax({
                    type: 'GET',
                    url: "{{ url('get_id_acces') }}/" + id_acces,
                    success: function(response) {
                        console.log(response)
                        $('#edit_acces_name').val(response.acces.acces_name)
                        $('#id_acces').val(response.acces.id_acces)
                    }
                })
            })
        });

        // Delete Acces
        $(document).ready(function() {
            $(document).on('click', '.deleteBtn', function() {
                var id_acces = $(this).val();
                console.log(id_acces);

                $('#deleteAcces').modal('show')

                $.ajax({
                    type: 'GET',
                    url: "{{ url('get_id_acces') }}/" + id_acces,
                    success: function(response) {
                        console.log(response)
                        $('#id_acces_delete').val(response.acces.id_acces)
                        document.getElementById("acces_name_delete").textContent =
                            response.acces
                            .acces_name;
                    }
                })
            })
        });
    </script>
@endsection
