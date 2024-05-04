@extends('template')
@section('transaction')
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
            <a href="{{ route('page-add-transaction') }}">
                <button type="button" class="btn btn-primary mb-3">
                    Add Transaction
                </button>
            </a>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="table-active">
                            <th class="p-1 text-center">No</th>
                            <th class="p-1 text-center">
                                Customer Name
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'customer_name' ? 'brown' : '' }};"
                                    class="btnCustomerDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'customer_name' ? 'brown' : '' }};"
                                    class="btnCustomerAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center">
                                Total Amount
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'total_amount' ? 'brown' : '' }};"
                                    class="btnAmountDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'total_amount' ? 'brown' : '' }};"
                                    class="btnAmountAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center">Detail Transaction</th>
                            <th class="p-1 text-center">
                                Transaction Date
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'transaction_inserted_at' ? 'brown' : '' }};"
                                    class="btnInsertDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'transaction_inserted_at' ? 'brown' : '' }};"
                                    class="btnInsertAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center">Inserted By</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $no = $limit * $page - $limit;
                        ?>
                        @if ($data->isEmpty())
                            <tr>
                                <td colspan="4" style="text-align: center">No data</td>
                            </tr>
                        @else
                            @foreach ($data as $item)
                                <tr>
                                    <td style="font-size: 14px;" class="p-2 text-center">{{ ++$no }}</td>
                                    <td style="font-size: 14px;" class="p-2 text-center">{{ $item->customer_name }}</td>
                                    <td style="font-size: 14px;" class="p-2 text-center">
                                        {{ 'Rp. ' . number_format($item->total_amount, 0, ',', '.') }}</td>
                                    <td style="font-size: 14px;" class="p-2 text-center"><a data-bs-toggle="modal"
                                            href="#modalDetail" data-bs-target="#modalDetail"
                                            class="detail_modal btn btn-sm btn-primary"
                                            data-id="{{ $item->id_transaction }}">
                                            Detail
                                        </a></td>
                                    <td style="font-size: 14px;" class="p-2 text-center">
                                        {{ date('d M Y', strtotime($item->transaction_inserted_at)) }}
                                    </td>
                                    <td style="font-size: 14px;" class="p-2 text-center">{{ $item->first_name }}</td>

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
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Detail Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="detail_table" class="table table-bordered mt-4">
                        <thead>
                            <tr>
                                <th style="font-size: 12px;">Item Name</th>
                                <th style="font-size: 12px;">Quantity</th>
                                <th style="font-size: 12px;">Price</th>
                                <th style="font-size: 12px;">Total</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
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
            $('#accordionExample').val('');
            $('#search_form').submit();
        });
        $('.btnCustomerDesc').click(function() {
            $('#order_name').val('customer_name');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnCustomerAsc').click(function() {
            $('#order_name').val('customer_name');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        $('.btnAmountDesc').click(function() {
            $('#order_name').val('total_amount');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnAmountAsc').click(function() {
            $('#order_name').val('total_amount');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });
        $('.btnInsertDesc').click(function() {
            $('#order_name').val('transaction_inserted_at');
            $('#order_type').val('DESC');
            $('#search_form').submit();
        });
        $('.btnInsertAsc').click(function() {
            $('#order_name').val('transaction_inserted_at');
            $('#order_type').val('ASC');
            $('#search_form').submit();
        });

        function formatCurrency(value) {
            return 'Rp ' + String(value).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        $(".detail_modal").click(function() {
            var id_trans = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{ url('detail-by-transaction/') }}/" + id_trans,
                success: function(data) {
                    console.log(data);
                    $('#detail_table tbody').empty(); // Kosongkan tabel sebelum menambahkan data baru
                    $.each(data, function(index, element) {
                        // Membuat baris baru untuk setiap data
                        var row = "<tr>" +
                            "<td>" + element.item_name + "</td>" +
                            "<td>" + element.qty + "</td>" +
                            "<td>" + formatCurrency(element.price) + "</td>" +
                            "<td>" + formatCurrency(element.total_price) + "</td>" +
                            "</tr>";

                        // Menambahkan baris baru ke dalam tabel
                        $('#detail_table tbody').append(row);
                    });
                }
            });
        });
    </script>
@endsection
