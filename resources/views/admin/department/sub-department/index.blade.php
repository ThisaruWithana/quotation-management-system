<x-admin>
@section('title')  {{ 'Sub Departments' }} @endsection
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
            <div class="card-tools">
                <a href="{{ route('admin.department.sub.create') }}" class="btn btn-sm btn-primary">Add New</a>
                <a href="{{ route('admin.department.index') }}" class="btn btn-sm btn-warning">Departments</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table" id="dataTable">
                <thead>
                    <tr>
                        <th class="th-sm">Sub Department</th>
                        <th class="th-sm">Department</th>
                        <th class="th-sm">Created By</th>
                        <th class="th-sm">Created At</th>
                        <th class="th-sm">Last Updated</th>
                        <th class="th-sm">Status</th>
                        <th class="th-sm"></th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach ($data as $value)
                        <tr>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->departments->name }}</td>
                            <td>{{ $value->created_user->name }}</td>
                            <td>{{ $value->created_at }}</td>
                            <td>{{ $value->updated_at }}</td>
                            <td>
                                @if($value->status == 1)
                                <span class="badge badge-success">Active</span>
                                @else 
                                <span class="badge badge-warning">Deactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.department.sub.edit',encrypt($value->id)) }}" class="btn btn-sm btn-secondary">
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
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "responsive": true,
              "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 6] }, 
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
                            url: "{{ url('admin/department/sub/change-status') }}",
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