<x-admin>
    @section('title')  {{ $title }} @endsection
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ route('admin.vat.create') }}" class="btn btn-sm btn-primary">Add New</a>
            </div>
        </div>
        <div class="card-body">
         <table id="dataTable" class="table" width="100%">
            <thead>
               <tr>
                  <th class="th-sm">Name</th>
                  <th class="th-sm">Rate (%)</th>
                  <th class="th-sm">Created By</th>
                  <th class="th-sm">Created At</th>
                  <th class="th-sm">Status</th>
                  <th class="th-sm"></th>
               </tr>
            </thead>
            <tbody>
               @foreach ($data as $value)
               <tr>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->value }}</td>
                    <td>{{ $value->created_user->name }}</td>
                    <td>{{ date('Y-m-d H:i:s', strtotime($value->created_at)) }}</td>
                    <td>
                        @if($value->status == 1)
                        <span class="badge badge-success">Active</span>
                        @else 
                        <span class="badge badge-warning">Deactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.vat.edit',encrypt($value->id)) }}" class="btn btn-sm btn-secondary">
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
                    "responsive": true,
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 5] }, 
                    ]
                });
            });
        </script>
    @endsection
</x-admin>