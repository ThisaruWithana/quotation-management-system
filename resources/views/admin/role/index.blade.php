<x-admin>
    @section('title')  {{ 'User Roles' }} @endsection
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ route('admin.role.create') }}" class="btn btn-sm btn-primary">Add New</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table" id="dataTable">
                <thead>
                    <tr>
                        <th class="th-sm w-150px">Name</th>
                        <th class="th-sm w-120px">Created At</th>
                        <th class="th-sm w-120px">Status</th>
                        <th class="th-sm w-120px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->created_at }}</td>
                            <td>
                                @if($role->status == 1)
                                <span class="badge badge-success">Active</span>
                                @else 
                                <span class="badge badge-warning">Deactive</span>
                                @endif
                            </td>
                            <td>
                                @if($role->status === 1)
                                    <a href="#" class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus({{ $role->id }}, {{ $role->status }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                @else
                                    <a href="#" class="btn btn-sm btn-secondary" title="Activate" onclick="changeStatus({{ $role->id }}, {{ $role->status }})">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                @endif
                                <a href="{{ route('admin.role.edit',encrypt($role->id)) }}" class="btn btn-sm btn-secondary" title="Edit">
                                    <i class="far fa-edit"></i>
                                </a>
                            </td>
                        </tr>
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
              "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 3] }, 
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
                                url: "{{ url('admin/role/change-status') }}",
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