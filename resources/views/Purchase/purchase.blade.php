@extends('template')
@section('purchase')
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
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPurchase">
                Add New
            </button>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="table-active">
                            <th class="p-1 text-center">No</th>
                            <th class="p-1 text-center">
                                Item Name
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'id_item' ? 'brown' : '' }};"
                                    class="btnItemDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'id_item' ? 'brown' : '' }};"
                                    class="btnItemAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center">
                                Purchase Amount
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'purchase_amount' ? 'brown' : '' }};"
                                    class="btnAmountDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'purchase_amount' ? 'brown' : '' }};"
                                    class="btnAmountAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center">
                                Price / Item
                            </th>
                            <th class="p-1 text-center">
                                Purchase Price
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'purchase_price' ? 'brown' : '' }};"
                                    class="btnPriceDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'purchase_price' ? 'brown' : '' }};"
                                    class="btnPriceAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center">
                                Inserted At
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'purchase_inserted_at' ? 'brown' : '' }};"
                                    class="btnInsertDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'purchase_inserted_at' ? 'brown' : '' }};"
                                    class="btnInsertAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center">
                                Inserted By
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'id_user' ? 'brown' : '' }};"
                                    class="btnIdUserDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'id_user' ? 'brown' : '' }};"
                                    class="btnIdUserAsc fas fa-arrow-alt-circle-down"></a>
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
                                    <td style="font-size: 14px;" class="p-2">{{ $item->item_name }}</td>
                                    <td style="font-size: 14px;" class="p-2">{{ $item->purchase_amount }}</td>
                                    <td>
                                        {{ 'Rp. ' . number_format(str_replace('.', '', $item->purchase_price) / $item->purchase_amount, 0, ',', '.') }}
                                    </td>
                                    <td style="font-size: 14px;" class="p-2">
                                        {{ 'Rp. ' . number_format(str_replace('.', '', $item->purchase_price), 0, ',', '.') }}
                                    </td>
                                    <td style="font-size: 14px;" class="p-2">
                                        {{ date('d F Y h:i:s', strtotime($item->purchase_inserted_at)) }}
                                    </td>
                                    <td style="font-size: 14px;" class="p-2">
                                        {{ $item->first_name }} {{ $item->last_name }}
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
    <div class="modal fade" id="addPurchase" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Add {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('purchase/add') }}"method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Item Name</label>
                            <div class="col-sm-8">
                                <select class="form-select id_item" id="id_item" name="id_item"
                                    style="width: 100% ! important;">
                                    <option hidden value="">Select Acces</option>
                                    @foreach ($list_item as $data)
                                        <option value="{{ $data->id_item }}">
                                            {{ $data->item_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Purchase Amount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="purchase_amount" name="purchase_amount"
                                    placeholder="Insert purchase amount" required>
                            </div>
                            <div class="col-sm-2">
                                pcs
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Purchase Price</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="purchase_price" name="purchase_price"
                                    placeholder="Insert purchase amount" required>
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
            $('#order_name').val('id_item');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnItemAsc').click(function() {
            $('#order_name').val('id_item');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        $('.btnAmountDesc').click(function() {
            $('#order_name').val('purchase_amount');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnAmountAsc').click(function() {
            $('#order_name').val('purchase_amount');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        $('.btnPriceDesc').click(function() {
            $('#order_name').val('purchase_price');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnPriceAsc').click(function() {
            $('#order_name').val('purchase_price');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        $('.btnInsertDesc').click(function() {
            $('#order_name').val('purchase_inserted_at');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnInsertAsc').click(function() {
            $('#order_name').val('purchase_inserted_at');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        $('.btnIdUserDesc').click(function() {
            $('#order_name').val('id_user');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnIdUserAsc').click(function() {
            $('#order_name').val('id_user');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });

        $(document).ready(function() {
            $('.id_item').select2({
                placeholder: 'Select Item',
                dropdownParent: $("#addPurchase")

            });
        });

        // Fungsi untuk mengubah format angka menjadi format mata uang Rupiah
        function formatRupiah(angka) {
            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // Tambahkan titik jika panjang karakter lebih dari 3
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        // Fungsi untuk memformat input saat memasukkan angka
        document.getElementById('purchase_price').addEventListener('keyup', function(e) {
            // Ambil nilai input
            var purchase_price = this.value;

            // Hapus karakter selain angka
            purchase_price = purchase_price.replace(/[^\d]/g, '');

            // Format angka menjadi Rupiah
            this.value = formatRupiah(purchase_price);
        });
    </script>

@endsection
