<x-admin>
   @section('title')  {{ 'Stock Management- Stock Adjustment' }} @endsection
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ url('admin/stock/create-adjustment') }}" class="btn btn-sm btn-primary">Add New</a>
            </div>
        </div>
        <div class="card-body">
            <divv class="table-responsive">
                <table class="table" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">#</th>
                            <th class="th-sm">Type</th>
                            <th class="th-sm">Comment</th>
                            <th class="th-sm w-100px">Total Retail</th>
                            <th class="th-sm w-100px">Total Cost</th>
                            <th class="th-sm w-100px">Created By</th>
                            <th class="th-sm w-100px">Created At</th>
                            <th class="th-sm w-150px"></th>
                        </tr>
                    </thead>
                    <tbody>
                @foreach ($listData as $value)
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->type }}</td>
                            <td>{{ $value->comment }}</td>
                            <td>{{ number_format($value->total_cost, 2) }}</td>
                            <td>{{ number_format($value->total_retail, 2) }}</td>
                            <td>{{ $value->created_user->name }}</td>
                            <td>{{ date('Y-m-d H:i:s', strtotime($value->created_at)) }}</td>
                            <td>
                                <a href="{{ route('admin.stock.view',encrypt($value->id)) }}" class="btn btn-sm btn-secondary" title="View">
                                    <i class="far fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @section('js')
        <script>
            $(function() {

                $('#dataTable').DataTable({
                    "bPaginate": true,
                    "searching": true,
                    "ordering": true,
                    "autoWidth":true,
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 7 ]},
                    ],
                    "order": [0,'desc'],
                });
            });
        </script>
    @endsection
</x-admin>