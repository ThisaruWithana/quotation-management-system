<x-admin>
    @section('title')  {{ $title }} @endsection
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
            <div class="card-tools">
                <a href="{{ route('admin.vat.create') }}" class="btn btn-sm btn-primary">Add</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Rate (%)</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach ($data as $value)
                        <tr>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->value }}</td>
                            <td>
                                @if($value->status == 1)
                                <span class="label label-success">Active</span>
                                @else 
                                <span class="label label-danger">Deactive</span>
                                @endif
                            </td>
                            <td>{{ $value->created_user->name }}</td>
                            <td>{{ date('Y-m-d H:i:s', strtotime($value->created_at)) }}</td>
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