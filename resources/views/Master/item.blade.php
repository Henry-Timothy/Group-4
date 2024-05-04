@extends('template')
@section('item')
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
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addItem">
                Add New
            </button>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="table-active">
                            <th class="p-1 text-center" style="width: 5%;">No</th>
                            <th class="p-1 text-center" style="width: 15%;">
                                Item Name
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'item_name' ? 'brown' : '' }};"
                                    class="btnItemDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'item_name' ? 'brown' : '' }};"
                                    class="btnItemAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center" style="width: 10%;">
                                Description
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'description' ? 'brown' : '' }};"
                                    class="btnDescriptionDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'description' ? 'brown' : '' }};"
                                    class="btnDescriptionAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center" style="width: 10%;">
                                Stock
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'unit' ? 'brown' : '' }};"
                                    class="btnUnitDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'unit' ? 'brown' : '' }};"
                                    class="btnUnitAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center" style="width: 10%;">
                              Sell  Price
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'price' ? 'brown' : '' }};"
                                    class="btnPriceDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'price' ? 'brown' : '' }};"
                                    class="btnPriceAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center" style="width: 15%;">
                                Supplier
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'id_supplier' ? 'brown' : '' }};"
                                    class="btnSupplierDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'id_supplier' ? 'brown' : '' }};"
                                    class="btnSupplierAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center" style="width: 10%;">
                                Inserted At
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'item_inserted_at' ? 'brown' : '' }};"
                                    class="btnInsertDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'item_inserted_at' ? 'brown' : '' }};"
                                    class="btnInsertAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center" style="width: 10%;">
                                Updated At
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'item_last_updated' ? 'brown' : '' }};"
                                    class="btnUpdatedDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'item_last_updated' ? 'brown' : '' }};"
                                    class="btnUpdatedAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center" style="width: 10%;">
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
                                <td colspan="9" style="text-align: center">No data</td>
                            </tr>
                        @else
                            @foreach ($data as $item)
                                <tr>
                                    <td style="font-size: 14px;" class="p-2">{{ ++$no }}</td>
                                    <td style="font-size: 14px;" class="p-2">{{ $item->item_name }}</td>
                                    <td style="font-size: 14px;" class="p-2">{{ $item->description }}</td>
                                    <td style="font-size: 14px;" class="p-2">{{ $item->unit }}</td>
                                    <td style="font-size: 14px;" class="p-2">
                                        {{ 'Rp. ' . number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td style="font-size: 14px;" class="p-2">{{ $item->supplier_name }}</td>
                                    <td style="font-size: 14px;" class="p-2">
                                        {{ date('d F Y h:i:s', strtotime($item->item_inserted_at)) }}
                                    </td>
                                    <td style="font-size: 14px;" class="p-2">
                                        {{ date('d F Y h:i:s', strtotime($item->item_last_updated)) }}
                                    </td>
                                    <td style="font-size: 14px;" class="p-2">
                                        <button type="button" value="{{ $item->id_item }}"
                                            class="btn rounded-pill btn-icon btn-danger deleteBtn">
                                            <span class="fas fa-trash-alt fa-2xs"></span>
                                        </button>
                                        <button type="button" value="{{ $item->id_item }}"
                                            class="btn rounded-pill btn-icon btn-warning ms-2 editBtn">
                                            <span class="fas fa-edit fa-2xs"></span>
                                        </button>
                                    </td>
                                </tr>
                                <input type="hidden" id="data_id_supplier<?= $item->id_item ?>"
                                    value="<?= $item->id_supplier ?>">
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
    <div class="modal fade" id="addItem" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Add {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('item/add_item') }}"method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Item Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="item_name" name="item_name"
                                    placeholder="Insert item name">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Description</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="description" name="description"
                                    placeholder="Insert description">
                            </div>
                        </div>
                        {{-- <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Unit</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="unit" name="unit"
                                    placeholder="Insert unit">
                            </div>
                        </div> --}}
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Sell Price</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="price" name="price"
                                    placeholder="Insert price">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Supplier</label>
                            <div class="col-sm-8">
                                <select class="form-select id_supplier" id="id_supplier" name="id_supplier"
                                    style="width: 100% ! important;">
                                    <option hidden value="">Select Supplier</option>
                                    @foreach ($supplier as $data)
                                        <option value="{{ $data->id_supplier }}">
                                            {{ $data->supplier_name }}</option>
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
    <div class="modal fade" id="editItem" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Edit {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('item/edit_item') }}"method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_item" id="id_item">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Item Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_item_name" name="edit_item_name"
                                    placeholder="Insert item name" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Description</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_description" name="edit_description"
                                    placeholder="Insert description" required>
                            </div>
                        </div>
                        {{-- <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Unit</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_unit" name="edit_unit"
                                    placeholder="Insert unit" required>
                            </div>
                        </div> --}}
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Sell Price</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_price" name="edit_price"
                                    placeholder="Insert price">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Supplier</label>
                            <div class="col-sm-8">
                                <select class="form-select edit_id_supplier" id="edit_id_supplier"
                                    name="edit_id_supplier" style="width: 100% ! important;" value="">
                                    <option hidden value="">Select Supplier</option>
                                    <?php
                                    ?>
                                    @foreach ($supplier as $data)
                                        <option value="{{ $data->id_supplier }}"
                                            {{ $data->id_supplier == $data->id_supplier ? 'selected' : '' }}>
                                            {{ $data->supplier_name }}</option>
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
    <div class="modal fade" id="deleteItem" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Delete {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('item/delete_item') }}"method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <input type="hidden" id="id_item_delete" name="id_item_delete">
                            <label class="form-label" style="text-transform: uppercase">Are you sure
                                want to delete <span id="item_name_delete" style="font-weight:bold"></span>?</label>
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
        $('.btnItemDesc').click(function() {
            $('#order_name').val('item_name');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnItemAsc').click(function() {
            $('#order_name').val('item_name');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        $('.btnDescriptionDesc').click(function() {
            $('#order_name').val('description');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnDescriptionAsc').click(function() {
            $('#order_name').val('description');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        // $('.btnUnitDesc').click(function() {
        //     $('#order_name').val('unit');
        //     $('#order_type').val('DESC');
        //     $('#search_form').submit();
        // });
        // $('.btnUnitAsc').click(function() {
        //     $('#order_name').val('unit');
        //     $('#order_type').val('ASC');
        //     $('#search_form').submit();
        // });
        $('.btnPriceDesc').click(function() {
            $('#order_name').val('price');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnPriceAsc').click(function() {
            $('#order_name').val('price');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        $('.btnSupplierDesc').click(function() {
            $('#order_name').val('id_supplier');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnSeupplierAsc').click(function() {
            $('#order_name').val('id_supplier');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        $('.btnInsertDesc').click(function() {
            $('#order_name').val('item_inserted_at');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnInsertAsc').click(function() {
            $('#order_name').val('item_inserted_at');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        $('.btnUpdatedDesc').click(function() {
            $('#order_name').val('item_last_updated');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnUpdatedAsc').click(function() {
            $('#order_name').val('item_last_updated');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        // Edit Item
        $(document).ready(function() {
            $(document).on('click', '.editBtn', function() {
                var id_item = $(this).val();
                console.log(id_item);

                $('#editItem').modal('show')

                $.ajax({
                    type: 'GET',
                    url: "{{ url('get_id_item') }}/" + id_item,
                    success: function(response) {
                        console.log(response)
                        $('#edit_item_name').val(response.item.item_name)
                        $('#edit_description').val(response.item.description)
                        // $('#edit_unit').val(response.item.unit)
                        $('#edit_price').val(response.item.price)
                        $('#edit_id_supplier').val($('#data_id_supplier' + id_item).val())
                            .trigger(
                                "change");
                        $('#id_item').val(response.item.id_item)
                    }
                })
            })
        });

        // Delete Item
        $(document).ready(function() {
            $(document).on('click', '.deleteBtn', function() {
                var id_item = $(this).val();
                console.log(id_item);

                $('#deleteItem').modal('show')

                $.ajax({
                    type: 'GET',
                    url: "{{ url('get_id_item') }}/" + id_item,
                    success: function(response) {
                        console.log(response)
                        $('#id_item_delete').val(response.item.id_item)
                        document.getElementById("item_name_delete").textContent =
                            response.item
                            .item_name;
                    }
                })
            })
        });

        $(document).ready(function() {
            $('.id_supplier').select2({
                placeholder: 'Select Supplier',
                dropdownParent: $("#addItem")

            });
            $('.edit_id_supplier').select2({
                placeholder: 'Select Supplier',
                dropdownParent: $("#editItem")

            });
            $('.filter_supplier').select2({
                placeholder: 'Select Supplier',

            });
        });

        function formatRupiah(angka) {
            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

           
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        document.getElementById('price').addEventListener('keyup', function(e) {
          
            var price = this.value;
            price = price.replace(/[^\d]/g, '');
            this.value = formatRupiah(price);
        });

        document.getElementById('edit_price').addEventListener('keyup', function(e) {
           
            var edit_price = this.value;
            edit_price = edit_price.replace(/[^\d]/g, '');
            this.value = formatRupiah(edit_price);
        });
    </script>
@endsection
