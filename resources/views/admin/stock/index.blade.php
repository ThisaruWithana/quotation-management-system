<x-admin>
   @section('title')  {{ 'Stock Management' }} @endsection
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ url('admin/stock/create-adjustment') }}" class="btn btn-sm btn-primary">Add New</a>
            </div>
        </div>
        <div class="card-body table-responsive">
            <div>
                <table class="table" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">#</th>
                            <th class="th-sm">Type</th>
                            <th class="th-sm">Comment</th>
                            <th class="th-sm">Total Retail</th>
                            <th class="th-sm">Total Cost</th>
                            <th class="th-sm">Created At</th>
                            <th class="th-sm"></th>
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
                            <td>{{ date('Y-m-d H:i:s', strtotime($value->created_at)) }}</td>
                            <td>
                                <a href="{{ route('admin.stock.edit',encrypt($value->id)) }}" class="btn btn-sm btn-secondary" title="Edit">
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
                    "responsive": true,
                    // "scrollX": false,
                    "autoWidth":true,
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 6 ]},
                    ],
                    "order": [0,'desc'],
                });
            });
        </script>
    @endsection
</x-admin>