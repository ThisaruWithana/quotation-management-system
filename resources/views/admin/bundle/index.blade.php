<x-admin>
   @section('title')  {{ 'Bundle Management' }} @endsection
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ route('admin.bundle.create') }}" class="btn btn-sm btn-primary">Add New</a>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table" id="dataTable">
                <thead>
                    <tr>
                        <th class="th-sm">Bundle Name</th>
                        <th class="th-sm">Remark</th>
                        <th class="th-sm">Bundle Cost</th>
                        <th class="th-sm">Bundle Retail</th>
                        <th class="th-sm">Total Cost</th>
                        <th class="th-sm">Difference</th>
                        <th class="th-sm">Status</th>
                        <th class="th-sm"></th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach ($data as $value)
                        <tr>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->remark }}</td>
                            <td>{{ number_format($value->bundle_cost, 2) }}</td>
                            <td>{{ number_format($value->total_retail, 2) }}</td>
                            <td>{{ number_format($value->total_cost, 2) }}</td>
                            <td>{{ number_format($value->bundle_cost - $value->total_cost, 2) }}</td>
                            <td>
                                @if($value->status == 1)
                                <span class="badge badge-success">Active</span>
                                @else 
                                <span class="badge badge-warning">Deactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.bundle.edit',encrypt($value->id)) }}" class="btn btn-sm btn-secondary">
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
                     <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
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
                        { "bSortable": false, "aTargets": [ 7 ]},
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
                            url: "{{ url('admin/bundle/change-status') }}",
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