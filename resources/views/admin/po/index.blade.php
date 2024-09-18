<x-admin>
   @section('title')  {{ 'Purchase Order' }} @endsection
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ url('admin/po/create') }}" class="btn btn-sm btn-primary">Add New</a>
            </div>
        </div>
        <div class="card-body">
        <form method="GET" action="{{ url('admin/po') }}" id="frm-list">
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
                        <select id="supplier" name="supplier" class="selectpicker show-tick" data-live-search="true">
                            <option value="">Suppliers</option>        
                            @foreach ($suppliers as $value)
                                <option value="{{ $value->id }}" @if(Request()->supplier == $value->id) selected @endif>{{ $value->name }}</option>
                            @endforeach 
                        </select>
                    </div>
                    
                    <input type="hidden" name="form_action" value="search">
                    
                    <div class="form-group text-right" style="margin-left:10px;">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
            <br>
            <div class="table-responsive">
                <table class="table" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">#</th>
                            <th class="th-sm">Type</th>
                            <th class="th-sm">Supplier</th>
                            <th class="th-sm w-100px">Order Date</th>
                            <th class="th-sm w-100px">Total Cost</th>
                            <th class="th-sm w-100px">Created At</th>
                            <th class="th-sm w-100px">Status</th>
                            <th class="th-sm w-120px"></th>
                        </tr>
                    </thead>
                    <tbody>
                @foreach ($listData as $value)
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->type }}</td>
                            <td>{{ $value->supplier['name'] }}</td>
                            <td>{{  $value->order_date != "" ? date('Y-m-d H:i:s', strtotime($value->order_date)) :  " " }}</td>
                            <td>{{ number_format($value->total_cost, 2) }}</td>
                            <td>{{ date('Y-m-d H:i:s', strtotime($value->created_at)) }}</td>
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
                                <a href="{{ route('admin.po.edit',encrypt($value->id)) }}" class="btn btn-sm btn-secondary" title="Edit">
                                    <i class="far fa-edit"></i>
                                </a>
                                
                                @if($value->status == 1)
                                    <a href="#" class="btn btn-sm btn-secondary" title="Send Order"  onclick="sendOrder({{ $value->id }})">
                                        <i class="fa fa-paper-plane"></i>
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
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 7 ]},
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
                            url: "{{ url('admin/po/change-status') }}",
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
            
        function sendOrder(id) {
    
            cuteAlert({
                type: "question",
                title: "Are you sure",
                message: "You want to send this order to deliveries ?",
                confirmText: "Yes",
                cancelText: "Cancel"
                }).then((e)=>{
                    if ( e == ("confirm")){
                            $.ajax({
                                url: "{{ url('admin/po/send-order') }}",
                                type: 'POST',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "po_id": id
                                },
                                success: function (data) {
                                    var result = JSON.parse(data);
                                    
                                    if (result['code'] == 1) {
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
                                                    // window.location.reload();
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