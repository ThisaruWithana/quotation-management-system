<x-admin>
   @section('title')  {{ 'Stock Management - Stock Take' }} @endsection
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ url('admin/stock/create-stock-take') }}" class="btn btn-sm btn-primary">Add New</a>
            </div>
        </div>
        <div class="card-body table-responsive">
            <div>
                <table class="table" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">#</th>
                            <th class="th-sm">Comment</th>
                            <th class="th-sm w-100px">Total Retail</th>
                            <th class="th-sm w-100px">Total Cost</th>
                            <th class="th-sm w-100px">Created By</th>
                            <th class="th-sm w-100px">Created At</th>
                            <th class="th-sm w-100px">Status</th>
                            <th class="th-sm w-100px"></th>
                        </tr>
                    </thead>
                    <tbody>
                @foreach ($listData as $value)
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->comment }}</td>
                            <td>{{ number_format($value->total_cost, 2) }}</td>
                            <td>{{ number_format($value->total_retail, 2) }}</td>
                            <td>{{ $value->created_user->name }}</td>
                            <td>{{ date('Y-m-d H:i:s', strtotime($value->created_at)) }}</td>
                            <td>
                                @if($value->status == 1)
                                <span class="badge badge-success">Active</span>
                                @elseif($value->status == 0)
                                <span class="badge badge-warning">Suspended</span>
                                @else
                                <span class="badge badge-warning">Deleted</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.stock.take-edit',encrypt($value->id)) }}" class="btn btn-sm btn-secondary" title="Edit">
                                    <i class="far fa-edit"></i>
                                </a>
                                @if($value->status === 1)
                                    <a href="#" class="btn btn-sm btn-secondary" title="Suspend" onclick="changeStatus({{ $value->id }}, {{ $value->status }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                @else
                                    <a href="#" class="btn btn-sm btn-secondary" title="Activate" onclick="changeStatus({{ $value->id }}, {{ $value->status }})">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                @endif
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

            function changeStatus(id, status) {

                cuteAlert({
                    type: "question",
                    title: "Are you sure",
                    message: "You want to change the status of this item ?",
                    confirmText: "Yes",
                    cancelText: "Cancel"
                    }).then((e)=>{
                    if ( e == ("confirm")){
                            $.ajax({
                                url: "{{ url('admin/stock/take-change-status') }}",
                                type: 'POST',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "id": id,
                                    "status": status
                                },
                                success: function (data) {
                                    var result = JSON.parse(data);
                                    if (result == 1) {
                                        toastr.success(
                                            'Success',
                                            'Successfully Updated !',
                                            {
                                                timeOut: 1500,
                                                fadeOut: 1500,
                                                onHidden: function () {
                                                    window.location.reload();
                                                }
                                            });
                                    } else {
                                        toastr.error(
                                            'Error',
                                            'Something Went Wrong!',
                                            {
                                                timeOut: 1500,
                                                fadeOut: 1500,
                                                onHidden: function () {
                                                    window.location.reload();
                                                }
                                            }
                                        );
                                    }
                                }, error: function (data) {
                                        toastr.error(
                                            'Error',
                                            'Something Went Wrong!',
                                            {
                                                timeOut: 1500,
                                                fadeOut: 1500,
                                                onHidden: function () {
                                                    window.location.reload();
                                                }
                                            }
                                        );
                                }
                            });
                    } else {
                    }
                });
            }
        </script>
    @endsection
</x-admin>