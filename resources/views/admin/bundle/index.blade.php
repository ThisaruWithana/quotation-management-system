<x-admin>
   @section('title')  {{ 'Bundle Management' }} @endsection
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ url('admin/bundle/create') }}" class="btn btn-sm btn-primary">Add New</a>
            </div>
        </div>
        <div class="card-body table-responsive">
        <form method="GET" action="{{ url('admin/bundle') }}" id="frm-list">

            <div class="row">
                <div class="form-group" style="margin-left:10px;">

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

                <div class="form-group" style="margin-left:10px; width: 250px;">
                    <input type="text" class="form-control" name="keyword" id="keyword" autocomplete="off"
                        placeholder="Name" value="{{ Request()->keyword }}">
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
                            <th class="th-sm w-50px">ID</th>
                            <th class="th-sm w-100px">Bundle Name</th>
                            <th class="th-sm w-100px">Remark</th>
                            <th class="th-sm w-100px">Bundle Cost</th>
                            <th class="th-sm w-100px">Bundle Retail</th>
                            <th class="th-sm w-100px">Total Cost</th>
                            <th class="th-sm w-100px">Difference</th>
                            <th class="th-sm w-100px">Status</th>
                            <th class="th-sm w-100px"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($listData as $value)
                        <tr>
                            <td>{{ $value->id }}</td>
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
                                @if($value->status === 1)
                                    <a href="#" class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus({{ $value->id }}, {{ $value->status }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                @else
                                    <a href="#" class="btn btn-sm btn-secondary" title="Activate" onclick="changeStatus({{ $value->id }}, {{ $value->status }})">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                @endif
                                @if($value->status === 1)
                                    <a href="{{ route('admin.bundle.edit',encrypt($value->id)) }}" class="btn btn-sm btn-secondary">
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
                    "bPaginate": false,
                    "searching": false,
                    "ordering": true,
                    "autoWidth":true,
                    "fixedHeader": {
                        "header": true,
                    },
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 8 ]},
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

        function selectPageSize(pageSize) {
            document.getElementById('frm-list').submit();
        }
        </script>
    @endsection
</x-admin>
