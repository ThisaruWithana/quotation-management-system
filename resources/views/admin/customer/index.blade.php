<x-admin>
   @section('title')  {{ 'Customers' }} @endsection
       <style>
           .dataTables_scrollHeadInner{
               width: 100% !important;
           }
           .dataTables_scrollHeadInner  .table{
               width: 100% !important;
           }
           div.dataTables_wrapper div.dataTables_info {
               padding-top: .85em;
               text-align: left;
               padding-bottom: 30px;
           }
       </style>
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ route('admin.customer.create') }}" class="btn btn-sm btn-primary">Add New</a>
            </div>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">Code</th>
                            <th class="th-sm w-100px">Name</th>
                            <th class="th-sm w-120px">Contact Person</th>
                            <th class="th-sm w-100px">Address</th>
                            <th class="th-sm">Telephone</th>
                            <th class="th-sm w-100px">Email</th>
                            <th class="th-sm">Type</th>
                            <th class="th-sm w-120px">Symbol Group</th>
                            <th class="th-sm w-100px">Created At</th>
                            <th class="th-sm">Status</th>
                            <th class="th-sm w-100px"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $value)
                            <tr>
                                <td>{{ $value->code }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->contact_person }}</td>
                                <td>{{ $value->address }} {{ $value->postal_code }}</td>
                                <td>{{ $value->tel }}</td>
                                <td>{{ $value->email }}</td>
                                <td>{{ $value->type }}</td>
                                <td>{{ $value->symbol_group }}</td>
                                <td>{{ date('Y-m-d H:i:s', strtotime($value->created_at)) }}</td>
                                <td>
                                    @if($value->status == 1)
                                    <span class="badge badge-success">Active</span>
                                    @else
                                    <span class="badge badge-warning">Deactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.customer.edit',encrypt($value->id)) }}" class="btn btn-sm btn-secondary">
                                        <i class="far fa-edit"></i>
                                    </a>

                                    @if($value->status === 1)
                                        <a href="#" class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus({{ $value->id }}, {{ $value->status }})">
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
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "autoWidth":true,
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 10] },
                    ]
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
                            url: "{{ url('admin/customer/change-status') }}",
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
