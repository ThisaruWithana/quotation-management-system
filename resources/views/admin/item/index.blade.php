<x-admin>
    @section('title') {{ 'Item Maintainance' }} @endsection
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <!-- <a href="#" class="btn btn-sm btn-primary" >Bulck Edit</a> -->
                <a href="{{ route('admin.item.create') }}" class="btn btn-sm btn-primary" >Add New</a>
            </div>
        </div>
        <div class="card-body  table-responsive">
            
        <form method="GET" action="{{ route('admin.item.index') }}" id="frm-list">

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
                    <select id="status" name="status" class="selectpicker show-tick" data-live-search="false">
                        <option value="">Status</option>        
                        <option value="1" @if(Request()->status == '1') selected @endif>Active</option>     
                        <option value="0" @if(Request()->status == '0') selected @endif>Deactive</option> 
                    </select>
                    </div>

                    <div class="form-group" style="margin-left:10px;">
                        <select id="supplier" name="supplier" class="selectpicker show-tick" data-live-search="true" >
                            <option value="">Supplier</option>        
                            @foreach ($suppliers as $value)
                                <option value="{{ $value->id }}" @if(Request()->supplier == $value->id) selected @endif>{{ $value->name }}</option>
                            @endforeach 
                        </select>
                    </div>
                    
                    <div class="form-group" style="margin-left:10px;">
                        <select id="departments" name="departments" class="selectpicker show-tick" data-live-search="true">
                            <option value="">Departments</option>        
                            @foreach ($departments as $value)
                                <option value="{{ $value->id }}" @if(Request()->departments == $value->id) selected @endif>{{ $value->name }}</option>
                            @endforeach 
                        </select>
                    </div>
                    
                    <div class="form-group" style="margin-left:10px;">
                        <select id="sub_departments" name="sub_departments" class="selectpicker show-tick" data-live-search="true">
                            <option value="">Sub Departments</option>        
                            @foreach ($sub_departments as $value)
                                <option value="{{ $value->id }}"  @if(Request()->sub_departments == $value->id) selected @endif>{{ $value->name }}</option>
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
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th class="th-sm">ID</th>
                            <th class="th-sm">Name</th>
                            <th class="th-sm">Barcode</th>
                            <th class="th-sm" style="width: 100px;">Description</th>
                            <th class="th-sm" style="width: 100px;">Margin Type</th>
                            <th class="th-sm" style="width: 100px;">Supplier</th>
                            <th class="th-sm" style="width: 100px;">Department</th>
                            <th class="th-sm" style="width: 150px;">Sub Department</th>
                            <th class="th-sm" style="width: 100px;">Created By</th>
                            <th class="th-sm" style="width: 80px;">Created At</th>
                            <th class="th-sm">Status</th>
                            <th class="th-sm" style="width: 120px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach ($listData as $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->barcode['barcode'] }}</td>
                                <td>{{ $value->description }}</td>
                                <td>{{ $value->margin_type }}</td>
                                <td>
                                    @foreach($value->suppliers as $suppliers)
                                        {{ $suppliers['suppliername']['name'] }} 
                                    @endforeach
                                </td>
                                <td>{{ $value->department['name'] }}</td>
                                <td>{{ $value->subdepartment['name'] }}</td>
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
                                    <a href="{{ route('admin.item.edit',encrypt($value->id)) }}" class="btn btn-sm btn-secondary" target="_blank">
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
                                    <a href="{{ route('admin.item.detail',encrypt($value->id)) }}" class="btn btn-sm btn-secondary">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </td>
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
                    "bPaginate": false,
                    "searching": true,
                    "ordering": true,
                    "responsive": true,
                    "scrollX": true,
                    "autoWidth":true,
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 11 ]},
                    ],
                    "order": [0,'desc'],
                });
                
                var dt = $('#dataTable').DataTable();
                dt.columns.adjust();

                $("#check-all").click(function () {
                    $('#dataTable tbody input[type="checkbox"]').prop('checked', this.checked);
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
                                url: "{{ url('admin/item/change-status') }}",
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

            // function filterData(){

            //     $.ajax({
            //         url: "{{ url('admin/item/filter') }}",
            //         type: 'POST',
            //             data: {
            //                 "_token": "{{ csrf_token() }}",
            //                 "status": $('#status').val(),
            //             },
            //             success: function (data) {
            //                 $("#dataTable tbody").empty();
            //                 var result = JSON.parse(data);

            //                 alert(result.length);

            //                 if (result.length > 0) {

            //                     $.each(result, function (count, val) {

            //                         $('#dataTable tbody').append(
            //                             '<tr>'
            //                             +'</td><input type="checkbox" name="ids[]" value="'+ val['id'] +'" class="form-check-label"></td>'
            //                             +'</td>'+ val['id'] +'</td>'
            //                             +'</td></td>'
            //                             +'</td></td>'
            //                             +'</td></td>'
            //                             +'</td></td>'
            //                             +'</td></td>'
            //                             +'</td></td>'
            //                             +'</td></td>'
            //                             +'</td></td>'
            //                             +'</td></td>'
            //                             +'</td></td>'
            //                             +'</td></td>'
            //                             +'</tr>'
            //                         );
            //                     });
            //                 } 
            //             }, error: function (data) {
                                    
            //         }
            //     });
            // }

            function selectPageSize(pageSize) {
                    document.getElementById('frm-list').submit();
                }
        </script>
    @endsection
</x-admin>