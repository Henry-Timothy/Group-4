@extends('template')
@section('user')
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
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUser">
                Add New
            </button>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="table-active">
                            <th class="p-1 text-center">No</th>
                            <th class="p-1 text-center">
                                Name
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'first_name' ? 'brown' : '' }};"
                                    class="btnNameDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'first_name' ? 'brown' : '' }};"
                                    class="btnNameAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center">
                                Phone Number
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'phone_number' ? 'brown' : '' }};"
                                    class="btnPhoneDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'phone_number' ? 'brown' : '' }};"
                                    class="btnPhoneAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center">
                                Address
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'address' ? 'brown' : '' }};"
                                    class="btnAddressDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'address' ? 'brown' : '' }};"
                                    class="btnAddressAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center">
                                Access
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'id_acces' ? 'brown' : '' }};"
                                    class="btnAccesDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'id_acces' ? 'brown' : '' }};"
                                    class="btnAccesAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center">
                                Inserted At
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'user_inserted_at' ? 'brown' : '' }};"
                                    class="btnInsertDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'user_inserted_at' ? 'brown' : '' }};"
                                    class="btnInsertAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center">
                                Updated At
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'user_last_updated' ? 'brown' : '' }};"
                                    class="btnUpdatedDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'user_last_updated' ? 'brown' : '' }};"
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
                                <td colspan="7" style="text-align: center">No data</td>
                            </tr>
                        @else
                            @foreach ($data as $item)
                                <tr>
                                    <td style="font-size: 14px;" class="p-2">{{ ++$no }}</td>
                                    <td style="font-size: 14px;" class="p-2">
                                        {{ $item->first_name }} {{ $item->last_name }}
                                    </td>
                                    <td style="font-size: 14px;" class="p-2">{{ $item->phone_number }}</td>
                                    <td style="font-size: 14px;" class="p-2">{{ $item->address }}</td>
                                    <td style="font-size: 14px;" class="p-2">{{ $item->acces_name }}</td>
                                    <td style="font-size: 14px;" class="p-2">
                                        {{ date('d F Y h:i:s', strtotime($item->user_inserted_at)) }}
                                    </td>
                                    <td style="font-size: 14px;" class="p-2">
                                        {{ date('d F Y h:i:s', strtotime($item->user_last_updated)) }}
                                    </td>
                                    <td style="font-size: 14px;" class="p-2">
                                        <button type="button" value="{{ $item->id_user }}"
                                            class="btn rounded-pill btn-icon btn-danger deleteBtn">
                                            <span class="fas fa-trash-alt fa-2xs"></span>
                                        </button>
                                        <button type="button" value="{{ $item->id_user }}"
                                            class="btn rounded-pill btn-icon btn-warning ms-2 editBtn">
                                            <span class="fas fa-edit fa-2xs"></span>
                                        </button>
                                    </td>
                                </tr>
                                <input type="hidden" id="data_id_acces<?= $item->id_user ?>"
                                    value="<?= $item->id_acces ?>">
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
    <div class="modal fade" id="addUser" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Add {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user/add_user') }}"method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Username</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Insert username" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Insert password" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">First Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    placeholder="Insert first name" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Last Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    placeholder="Insert last name">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Phone Number</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="phone_number" name="phone_number"
                                    placeholder="Insert phone number" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Address</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="address" name="address" rows="3" placeholder="Inser address" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Acces</label>
                            <div class="col-sm-8">
                                <select class="form-select id_acces" id="id_acces" name="id_acces"
                                    style="width: 100% ! important;">
                                    <option hidden value="">Select Acces</option>
                                    @foreach ($acces as $data)
                                        <option value="{{ $data->id_acces }}">
                                            {{ $data->acces_name }}</option>
                                    @endforeach
                                </select>
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
    <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Edit {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user/edit_user') }}"method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_user" id="id_user">

                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Username</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_username" name="edit_username"
                                    placeholder="Insert username" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="edit_password" name="edit_password"
                                    placeholder="Insert password" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">First Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_first_name" name="edit_first_name"
                                    placeholder="Insert first name" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Last Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_last_name" name="edit_last_name"
                                    placeholder="Insert last name">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Phone Number</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="edit_phone_number"
                                    name="edit_phone_number" placeholder="Insert phone number" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Address</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="edit_address" name="edit_address" rows="3" placeholder="Inser address"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Acces</label>
                            <div class="col-sm-8">
                                <select class="form-select edit_id_acces" id="edit_id_acces" name="edit_id_acces"
                                    style="width: 100% ! important;" value="">
                                    <option hidden value="">Select Acces</option>
                                    <?php
                                    ?>
                                    @foreach ($acces as $data)
                                        <option value="{{ $data->id_acces }}"
                                            {{ $data->id_acces == $data->id_acces ? 'selected' : '' }}>
                                            {{ $data->acces_name }}</option>
                                    @endforeach
                                </select>
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
    <div class="modal fade" id="deleteUser" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Delete {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user/delete_user') }}"method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <input type="hidden" id="id_user_delete" name="id_user_delete">
                            <label class="form-label" style="text-transform: uppercase">Are you sure
                                want to delete <span id="name_delete" style="font-weight:bold"></span>?</label>
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
        $('.btnNameDesc').click(function() {
            $('#order_name').val('first_name');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnNameAsc').click(function() {
            $('#order_name').val('first_name');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        $('.btnPhoneDesc').click(function() {
            $('#order_name').val('phone_number');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnPhoneAsc').click(function() {
            $('#order_name').val('phone_number');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        $('.btnAddressDesc').click(function() {
            $('#order_name').val('address');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnAddressAsc').click(function() {
            $('#order_name').val('address');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        $('.btnAccesDesc').click(function() {
            $('#order_name').val('id_acces');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnAccesAsc').click(function() {
            $('#order_name').val('id_acces');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        $('.btnInsertDesc').click(function() {
            $('#order_name').val('user_inserted_at');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnInsertAsc').click(function() {
            $('#order_name').val('user_inserted_at');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        $('.btnUpdatedDesc').click(function() {
            $('#order_name').val('user_last_updated');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnUpdatedAsc').click(function() {
            $('#order_name').val('user_last_updated');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        // Edit Item
        $(document).ready(function() {
            $(document).on('click', '.editBtn', function() {
                var id_user = $(this).val();
                console.log(id_user);

                $('#editUser').modal('show')

                $.ajax({
                    type: 'GET',
                    url: "{{ url('detail_user') }}/" + id_user,
                    success: function(response) {
                        console.log(response)
                        $('#edit_username').val(response.user.username)
                        $('#edit_password').val(response.user.password)
                        $('#edit_first_name').val(response.user.first_name)
                        $('#edit_last_name').val(response.user.last_name)
                        $('#edit_phone_number').val(response.user.phone_number)
                        $('#edit_address').val(response.user.address)
                        $('#edit_id_acces').val($('#data_id_acces' + id_user).val()).trigger(
                            "change");
                        $('#id_user').val(response.user.id_user)
                    }
                })
            })
        });

        // Delete Item
        $(document).ready(function() {
            $(document).on('click', '.deleteBtn', function() {
                var id_user = $(this).val();
                console.log(id_user);

                $('#deleteUser').modal('show')

                $.ajax({
                    type: 'GET',
                    url: "{{ url('detail_user') }}/" + id_user,
                    success: function(response) {
                        console.log(response)
                        $('#id_user_delete').val(response.user.id_user)
                        document.getElementById("name_delete").textContent =
                            response.user
                            .first_name + " " + response.user.last_name;
                    }
                })
            })
        });

        $(document).ready(function() {
            $('.id_acces').select2({
                placeholder: 'Select Acces',
                dropdownParent: $("#addUser")

            });
            $('.edit_id_acces').select2({
                placeholder: 'Select Acces',
                dropdownParent: $("#editUser")

            });
        });
    </script>
@endsection
