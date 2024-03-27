<x-admin>
    @section('title') {{ 'Item Maintainance' }} @endsection
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="#" class="btn btn-sm btn-primary" >Bulck Edit</a>
                <a href="{{ route('admin.item.create') }}" class="btn btn-sm btn-primary" >Add New</a>
            </div>
        </div>
        <div class="card-body">
            

            <!-- <div class="row">
                <div class="form-group text-left col-lg-2">
                    <select id="status" name="status" class="browser-default custom-select selectpicker" required>
                        <option value="">Status</option>        
                        <option value="1">Active</option>     
                        <option value="0">Deactive</option> 
                    </select>
                </div>
                <div class="form-group text-left col-lg-2">
                    <button class="btn btn-primary" type="submit" onclick="filterData()">Filter</button>
                </div>
            </div><br> -->

            <div>
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th class="th-sm">
                                <input type="checkbox" class="form-check-label" id="check-all">
                            </th>
                            <th class="th-sm">ID</th>
                            <th class="th-sm">Name</th>
                            <th class="th-sm">Barcode</th>
                            <th class="th-sm" style="width: 100px;">Description</th>
                            <th class="th-sm" style="width: 100px;">Margin Type</th>
                            <th class="th-sm" style="width: 100px;">Supplier</th>
                            <th class="th-sm" style="width: 100px;">Department</th>
                            <th class="th-sm" style="width: 120px;">Sub Department</th>
                            <th class="th-sm" style="width: 80px;">Created By</th>
                            <th class="th-sm" style="width: 80px;">Created At</th>
                            <th class="th-sm">Status</th>
                            <th class="th-sm" style="width: 120px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach ($data as $value)
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $value->id }}" class="form-check-label">
                                </td>
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
                    "scrollX": true,
                    "autoWidth":true,
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 12 ]},
                        { "bSortable": true, "aTargets": [ 0 ]}
                    ]
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

            function filterData(){

                $.ajax({
                    url: "{{ url('admin/item/filter') }}",
                    type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "status": $('#status').val(),
                        },
                        success: function (data) {
                            $("#dataTable tbody").empty();
                            var result = JSON.parse(data);

                            alert(result.length);

                            if (result.length > 0) {

                                $.each(result, function (count, val) {

                                    $('#dataTable tbody').append(
                                        '<tr>'
                                        +'</td><input type="checkbox" name="ids[]" value="'+ val['id'] +'" class="form-check-label"></td>'
                                        +'</td>'+ val['id'] +'</td>'
                                        +'</td></td>'
                                        +'</td></td>'
                                        +'</td></td>'
                                        +'</td></td>'
                                        +'</td></td>'
                                        +'</td></td>'
                                        +'</td></td>'
                                        +'</td></td>'
                                        +'</td></td>'
                                        +'</td></td>'
                                        +'</td></td>'
                                        +'</tr>'
                                    );
                                });
                            } 
                        }, error: function (data) {
                                    
                    }
                });
            }
        </script>
    @endsection
</x-admin>