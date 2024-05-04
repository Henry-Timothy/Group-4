@extends('template')
@section('dashboard')
    <div class="row">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card h-100">
                <div class="d-flex row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Hallo {{ $user->first_name }} {{ $user->last_name }} as
                                {{ $user->acces_name }}! 🎉</h5>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140"
                                alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <a href="{{ route('customer') }}">
                        <div class="card cards h-100">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}"
                                            alt="chart success" class="rounded">
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Total Customer</span>
                                <h3 class="card-title mb-2">{{ $total_customer }}</h3>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <a href="route{{ route('supplier') }}">
                        <div class="card cards h-100">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}" alt="Credit Card"
                                            class="rounded">
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Total Supplier</span>
                                <h3 class="card-title text-nowrap mb-1">{{ $total_supplier }}</h3>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7 mb-4 order-0">
            <div id="container" class="mt-3"></div>
        </div>
    </div>

    <table id="datatable" style="display: none;">
        <thead>
            <tr>
                <th>Item</th>
                <th>Selling Price</th>
                <th>Purchase Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $item_transaction = DB::table('tb_detail_transaction')->select('id_item')->groupBy('id_item')->get();
            ?>
            @foreach ($item_transaction as $data)
                <?php
                $total_terjual = DB::table('tb_detail_transaction')
                    ->where('id_item', $data->id_item)
                    ->sum('qty');
                $total_harga_terjual = DB::table('tb_detail_transaction')
                    ->where('id_item', $data->id_item)
                    ->sum('total_price');
                
                $harga_beli = DB::table('tb_purchase')
                    ->where('id_item', $data->id_item)
                    ->sum('purchase_price');
                $total_harga_beli = DB::table('tb_purchase')
                    ->where('id_item', $data->id_item)
                    ->sum('purchase_amount');
                
                $harga_beli_perbiji = $harga_beli / $total_harga_beli;
                
                $total_harga_beli = $harga_beli_perbiji * $total_terjual;
                
                // $untung = $total_harga_terjual - $total_harga_beli;
                
                // echo $untung;
                
                $item_name = DB::table('tb_item')
                    ->where('id_item', $data->id_item)
                    ->first();
                ?>
                <tr>
                    <th>{{ $item_name->item_name }}</th>
                    <td>{{ $total_harga_terjual }}</td>
                    <td>{{ $total_harga_beli }}</td>
            @endforeach
            </tr>
        </tbody>
    </table>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        Highcharts.chart('container', {
            data: {
                table: 'datatable'
            },
            chart: {
                type: 'column'
            },
            title: {
                text: 'Sales Profit'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Amount'
                }
            },
            credits: {
                enabled: false
            },
        });
    </script>
@endsection
