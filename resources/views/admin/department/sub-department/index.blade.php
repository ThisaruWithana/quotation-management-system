<x-admin>
@section('title')  {{ 'Sub Departments' }} @endsection
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
            <div class="card-tools">
                @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
                    <a href="{{ route('admin.department.sub.create') }}" class="btn btn-sm btn-primary">Add New</a>
                @endif
                <a href="{{ route('admin.department.index') }}" class="btn btn-sm btn-warning">Departments</a>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ url('admin/department/sub/index') }}" id="frm-list">
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
                        <div class="form-group" style="margin-left:10px;">
                            <input type="text" class="form-control" name="keyword" id="keyword" autocomplete="off"
                                placeholder="Name, Department" value="{{ Request()->keyword }}">
                        </div>

                        <input type="hidden" name="form_action" value="search">

                        <div class="form-group text-right" style="margin-left:5px;">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>

                    </div>
            </form>
            <br>
            
            <div class="table-responsive">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th class="th-sm w-50px">ID</th>
                            <th class="th-sm w-120px">Sub Department</th>
                            <th class="th-sm w-100px">Department</th>
                            <th class="th-sm w-100px">Created By</th>
                            <th class="th-sm w-100px">Created At</th>
                            <th class="th-sm w-100px">Last Updated</th>
                            <th class="th-sm w-100px">Status</th>
                                @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
                                    <th class="th-sm w-100px"></th>
                                @endif
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach ($listData as $value)
                            <tr>
                                <td>{{ $value->id }}</td>
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
                                @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
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
                                @endif
                            </tr>
                        <?php $i++; ?>
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
              "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 7] }, 
            ]
                });
            });
        
        function selectPageSize(pageSize) {
            document.getElementById('frm-list').submit();
        }

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