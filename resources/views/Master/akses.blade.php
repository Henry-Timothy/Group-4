@extends('template')
@section('akses')
    <div class="card">
        <div class="card-body">
            <form class="row d-flex" id="search_form" method="GET">
                <input type="hidden" name="sortir" id="sortir" value="{{ request('sortir') }}">
                <input type="hidden" name="order_name" id="order_name" value="{{ request('order_name') }}">
                <input type="hidden" name="order_type" id="order_type" value="{{ request('order_type') }}">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Search</label>
                            <div class="col-sm-9">
                                <input value="{{ request('search') }}" class="form-control" type="text" name="search"
                                    id="search" value="" placeholder="Search...">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Major</label>
                            <div class="col-sm-9">
                                {{-- <input class="form-control" value="{{ request('specialist_name') }}" type="text"
                        placeholder="Enter Specialist..." id="specialist_name" name="specialist_name">
                    <input type="hidden" id="id_specialist" name="id_specialist"> --}}
                                <input class="form-control" value="{{ request('course_name') }}" type="text"
                                    placeholder="Enter Course..." id="course_name" name="course_name">
                                <input type="hidden" id="id_course" name="id_course">
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
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="table-active">
                            <th class="p-1 text-center">No</th>
                            <th class="p-1 text-center">
                                Nama Akses
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'NamaAkses' ? 'brown' : '' }};"
                                    class="btnAksesDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'NamaAkses' ? 'brown' : '' }};"
                                    class="btnAksesAsc fas fa-arrow-alt-circle-down"></a>
                            </th>
                            <th class="p-1 text-center">
                                Keterangan
                                <a style="color:{{ request('order_type') == 'DESC' && request('order_name') == 'Keterangan' ? 'brown' : '' }};"
                                    class="btnKeteranganDesc fas fa-arrow-alt-circle-up"></a>
                                <a style="color:{{ request('order_type') == 'ASC' && request('order_name') == 'Keterangan' ? 'brown' : '' }};"
                                    class="btnKeteranganAsc fas fa-arrow-alt-circle-down"></a>
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
                                <td colspan="4" style="text-align: center">No data</td>
                            </tr>
                        @else
                            @foreach ($data as $item)
                                <tr>
                                    <td style="font-size: 14px;" class="p-2">{{ ++$no }}</td>
                                    <td style="font-size: 14px;" class="p-2">{{ $item->NamaAkses }}</td>
                                    <td style="font-size: 14px;" class="p-2">{{ $item->Keterangan }}</td>
                                    <td style="font-size: 14px;" class="p-2">

                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="row mt-4 mb-4">
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
@endsection
@section('js')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
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
            // console.log("haloo");
            var nValue = $(this).val();
            $('#sortir').val(nValue);
            submitFilter(nValue);
        });
        $('.resetBtn').click(function() {
            $('#search').val('');
            $('#search_form').submit();
        });
    </script>
@endsection
