@extends('template')
@section('page-add-transaction')
    <div class="row">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Select Item</label>
                        <div class="col-md-8">
                            <select class="form-select select_item" id="id_item" style="width: 100%"
                                onchange="gettingList()">
                                <option value=''>Select item</option>
                                @foreach ($item as $item)
                                    <option value="{{ $item->id_item }}">{{ $item->item_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="stock" class="form-text" style="color: maroon;"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Quantity</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="qty" placeholder="Input Quantity"
                                onchange="total()" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Price / Item</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="price_item" readonly />
                            <input type="hidden" name="price_asli" id="price_asli">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Total</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="total_nominal" readonly />
                            <input type="hidden" id="total_nominal_asli" name="total_nominal_asli" readonly />
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-primary" id="add_item" style="color: white">
                            <span class="fas fa-plus"></span>Add</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="table-responsive">
                        <label class="col-md-4 col-form-label">Select Customer</label>
                        <div class="col-md-8 mb-3">
                            <select class="form-select select_customer" style="width:48%" id="id_customer">
                                <option value=''>Select Customer</option>
                                @foreach ($customer as $cust)
                                    <option value="{{ $cust->id_customer }}">{{ $cust->customer_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="item_alert" class="form-text" style="color: maroon;">Please select item!
                            </div>
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                <?php $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
                                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                $no = $limit * $page - $limit;
                                ?>
                                @foreach ($detail_trans as $it)
                                    <tr>
                                        <td style="font-size: 14px;" class="text-center">{{ ++$no }}
                                        </td>
                                        <td style="font-size: 14px;" class="text-center">
                                            {{ $it->item_name }}</td>
                                        <td style="font-size: 14px;" class="text-center">
                                            {{ $it->qty }}</td>
                                        <td style="font-size: 14px;" class="text-center">
                                            {{-- {{ 'Rp. ' . number_format($it->price, 0, ',', '.') }} --}}
                                            {{'Rp. ' . $it->price}}
                                        <td style="font-size: 14px;" class="text-center">
                                            {{ 'Rp. ' . number_format($it->total_price, 0, ',', '.') }}</td>
                                        <td>
                                            <button onclick="delete_det_trans('{{ $it->id_detail_transaction }}')"
                                                type="button" class="btn rounded-pill btn-icon btn-danger">
                                                <span class="fas fa-trash-alt fa-2xs"></span>
                                            </button>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" onclick="save()" class="btn btn-primary">
                Save
            </button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        function delete_det_trans(nomer) {
            $.ajax({
                type: "POST",
                url: "{{ url('transaction/delete') }}/" + nomer,
                data: {
                    '_token': '{{ csrf_token() }}',
                },
                success: function(data) {
                    location.reload();
                }
            });
        }

        function save(nomer) {
            var id = document.getElementById('id_customer').value;
            if (!id) {
                $("#item_alert").css('display', '');
            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ url('trans/add') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id_customer': id
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            }
        }

        function formatCurrency(value) {
            return 'Rp ' + String(value).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function gettingList() {

            var id = document.getElementById('id_item').value;

            $.ajax({
                type: "GET",
                url: "{{ url('get-item') }}/" + id,
                success: function(data) {
                    // $('#price_item').val(data.price);
                    $('#price_item').val(formatCurrency(data.price));
                    $('#price_asli').val(parseInt(data.price.replace(".", "")));
                    console.log( $('#price_asli').val());
                    $('#stock').text("Stock : " + data.unit);
                    $('#overtime_price').val(formatCurrency(data.overtime_price));
                }
            });
        }

        function total() {

            var priceInput = $('#price_item').val();
            var qty = $('#qty').val();

            var priceString = priceInput.replace(/^Rp\s+|(\.)+/g, '');

            var total = priceString * qty;
            $('#total_nominal_asli').val(total);
            $('#total_nominal').val(formatCurrency(total));
        }

        $("#add_item").click(function() {
            $.ajax({
                type: "POST",
                url: "{{ url('transaction/add') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id_item': document.getElementById('id_item').value,
                    'qty': $('#qty').val(),
                    'price': $('#price_asli').val(),
                    'total_price': $('#total_nominal_asli').val(),
                },
                success: function(data) {
                    console.log(data);
                    location.reload();

                }
            });
        });


        $(document).ready(function() {
            $('.select_item').select2();
            $('.select_customer').select2();
            $("#item_alert").css('display', 'none');
        });
    </script>
@endsection
