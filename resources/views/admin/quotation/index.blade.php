<x-admin>
   @section('title')  {{ 'Quotation Management' }} @endsection
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ url('admin/quotation/create') }}" class="btn btn-sm btn-primary">Add New</a>
            </div>
        </div>
        <div class="card-body table-responsive">
        <form method="GET" action="{{ url('admin/quotation') }}" id="frm-list">

            <div class="row">
                <div class="form-group" style="margin-left:10px;">

                        <select name="pagesize" id="pagesize" class="custom-select tbl-sort-select"
                            onchange="selectPageSize(this.value)">
                                <option value="10" {{ $pageSize == '10' ? 'selected="selected"' : '' }}>10
                                </option>
                                <option value="3" {{ $pageSize == '3' ? 'selected="selected"' : '' }}>25
                                </option>
                                <option value="50" {{ $pageSize == '50' ? 'selected="selected"' : '' }}>50
                                </option>
                                <option value="100" {{ $pageSize == '100' ? 'selected="selected"' : '' }}>100
                                </option>
                        </select>
                </div>
                    
                <div class="form-group" style="margin-left:10px;">
                    <select id="customer" name="customer" class="selectpicker show-tick" data-live-search="true">
                        <option value="">Customer</option>        
                        @foreach ($customers as $value)
                            <option value="{{ $value->id }}" @if(Request()->customer == $value->id) selected @endif>{{ $value->name }}</option>
                        @endforeach 
                    </select>
                </div>
                    
                <input type="hidden" name="form_action" value="search">

                <div class="form-group text-right" style="margin-left:10px;">
                    <button class="btn btn-primary" type="submit">Filter</button>
                </div>
                </div>
            </form>
            <br>
            <div>
                <table class="table" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">Quot.Ref</th>
                            <th class="th-sm" style="width:200px;">Customer Name</th>
                            <th class="th-sm">Description</th>
                            <th class="th-sm" style="width:150px;">Quotation Price</th>
                            <th class="th-sm">Discount</th>
                            <th class="th-sm">Status</th>
                            <th class="th-sm" style="width:80px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($listData as $value)
                            <tr>
                                <td>{{ $value->ref }}</td>
                                <td>{{ $value->customer->name }}</td>
                                <td>{{ $value->description }}</td>
                                <td>{{ number_format($value->price, 2) }}</td>
                                <td>{{ $value->discount }}</td>
                                <td>
                                    @if($value->status == 1)
                                    <span class="badge badge-success">Active</span>
                                    @else 
                                    <span class="badge badge-warning">Deactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('admin/quotation/edit',encrypt($value->id)) }}" class="btn btn-sm btn-secondary">
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
                    "searching": true,
                    "ordering": true,
                    "responsive": true,
                    "scrollX": true,
                    "autoWidth":true,
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 6 ]},
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