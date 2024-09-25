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
                @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager') || Auth::user()->hasRole('sales'))
                    <a href="{{ route('admin.customer.create') }}" class="btn btn-sm btn-primary">Add New</a>
                    <a href="{{ URL('admin/report/import-data') }}/customer" class="btn btn-sm btn-warning">Import</a>
                @endif 
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ url('admin/customer') }}" id="frm-list">
                    <div class="form-group" style="float:left; margin-left:10px;">

                            <select name="pagesize" id="pagesize" class="custom-select tbl-sort-select"
                                onchange="selectPageSize(this.value)">
                                    <option value="10" {{ $pageSize == '10' ? 'selected="selected"' : '' }}>10
                                    </option>
                                    <option value="25" {{ $pageSize == '25' ? 'selected="selected"' : '' }}>25
                                    </option>
                                    <option value="50" {{ $pageSize == '50' ? 'selected="selected"' : '' }}>50
                                    </option>
                                    <option value="100" {{ $pageSize == '100' ? 'selected="selected"' : '' }}>100
                                    </option>
                            </select>
                    </div>

                    <div class="row" style="float:right;">
                        <div class="form-group" style="margin-left:10px; width: 310px;">
                            <input type="text" class="form-control" name="keyword" id="keyword" autocomplete="off"
                                placeholder="Code, Name, Postcode, Contact Person" value="{{ Request()->keyword }}">
                        </div>
                        <input type="hidden" name="form_action" value="search">
                        <div class="form-group text-right" style="margin-left:5px;">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
            </form>
            <br>
            
            <div class="table-responsive">
                <table class="table" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">ID</th>
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
                    @foreach ($listData as $value)
                            <tr>
                                <td>{{ $value->id }}</td>
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
                                    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager') || Auth::user()->hasRole('sales'))

                                        @if($value->status === 1)
                                            <a href="#" class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus({{ $value->id }}, {{ $value->status }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-sm btn-secondary" title="Activate" onclick="changeStatus({{ $value->id }}, {{ $value->status }})">
                                                <i class="fas fa-check-circle"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.customer.edit',encrypt($value->id)) }}" class="btn btn-sm btn-secondary" title="Edit">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="list_pagination" style="float: right;">{{ $listData->appends(Request::all())->links() }}</div>
        </div>
    </div>
    @section('js')
        <script>
            $(function() {
                $('#dataTable').DataTable({
                    "paging": false,
                    "searching": false,
                    "ordering": true,
                    "autoWidth":true,
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 11] },
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
        
        function selectPageSize(pageSize) {
            document.getElementById('frm-list').submit();
        }
        </script>
    @endsection
</x-admin>
