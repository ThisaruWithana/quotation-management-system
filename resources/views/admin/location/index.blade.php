<x-admin>
    @section('title')  {{ 'Product Locations' }} @endsection
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Product Locations</h3>
            <div class="card-tools">
                <a href="{{ route('admin.location.create') }}" class="btn btn-sm btn-primary">Add</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Action</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach ($data as $value)
                        <tr>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->created_at }}</td>
                            <td>
                                <a href="{{ route('admin.location.edit',encrypt($value->id)) }}" class="btn btn-sm btn-secondary">
                                    <i class="far fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger" onclick="changeStatus({{ $value->id }}, {{ $value->status }})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
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
                });
            });

            
        function changeStatus(id, status) {

            $.ajax({
                url: "{{ url('admin/location/change-status') }}",
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
        }
        </script>
    @endsection
</x-admin>