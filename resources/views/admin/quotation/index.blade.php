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
                        <select id="customer" name="customer" class="selectpicker show-tick" data-live-search="true">
                            <option value="">Customer</option>
                            @foreach ($customers as $value)
                                <option value="{{ $value->id }}" @if(Request()->customer == $value->id) selected @endif>{{ $value->name }} - {{ $value->contact_person }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" style="margin-left:10px; width: 210px;">
                        <input type="text" class="form-control" name="keyword" id="keyword" autocomplete="off"
                            placeholder="Ref, Customer, Description" value="{{ Request()->keyword }}">
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
                            <th class="th-sm w-120px">Quot.Ref</th>
                            <th class="th-sm w-150px">Customer Name</th>
                            <th class="th-sm">Description</th>
                            <th class="th-sm w-150px">Quotation Price</th>
                            <th class="th-sm">Discount</th>
                            <th class="th-sm w-100px">Created By</th>
                            <th class="th-sm">Status</th>
                            <th class="th-sm w-150px"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($listData as $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->ref }}</td>
                                <td>{{ $value->customer->name }}</td>
                                <td>{{ strip_tags(html_entity_decode($value->description)) }} </td>
                                <td>{{ number_format($value->price, 2) }}</td>
                                <td>{{ $value->discount }}</td>
                                <td>{{ $value->created_user->name }}</td>
                                <td>
                                    @if($value->status == 1)
                                    <span class="badge badge-success">Active</span>
                                    @elseif($value->status == 2)
                                    <span class="badge badge-success">Accepted</span>
                                    @elseif($value->status == 3)
                                    <span class="badge badge-primary">Installed</span>
                                    @elseif($value->status == 4)
                                    <span class="badge badge-warning">Old</span>
                                    @else
                                    <span class="badge badge-warning">Deactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-secondary" title="Delete" onclick="softeDelete({{ $value->id }}, {{ $value->status }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    @if($value->status == 1 || $value->status == 2 || $value->status == 3 || $value->status == 4)
                                        <a href="{{ url('admin/quotation/edit',encrypt($value->id)) }}" class="btn btn-sm btn-secondary" target="_blank" title="Edit">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    @endif
                                    <a href="#" class="btn btn-sm btn-secondary" title="Copy" onclick="makeCopy({{ $value->id }}, {{ $value->customer->id }})">
                                        <i class="fas fa-copy"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="list_pagination" style="float: right;">{{ $listData->appends(Request::all())->links() }}</div>
        </div>
    </div>

        <!-- Edit Detail -->
        <div class="modal fade" id="quotationCopy" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Create Copy of Quotation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="" method="" onsubmit="return false;" id="formEditBundleItem">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="quotation_id" value="" id="quotation_id">
                            <div class="form-group">
                                <label for="change_customer" class="col-form-label">Current Client :</label> <span id="client_name"></span>
                            </div>
                            
                            <span class="text-danger">You can change customer from here</span><br>

                            <div class="form-group">
                                <label for="change_customer" class="col-form-label">Client</label>
                                <select id="change_customer" name="change_customer" class="form-control selectpicker" data-live-search="true" required>
                                    <option value="">Select Client</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="btnCreateCopy">Save & Continue</button>
                        </div>
                    </form>

                </div>
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
                            url: "{{ url('admin/quotation/change-status') }}",
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

        function softeDelete(id) {

            cuteAlert({
                type: "question",
                title: "Are you sure",
                message: "You want to delete of this quotation ?",
                confirmText: "Yes",
                cancelText: "Cancel"
                }).then((e)=>{
                if ( e == ("confirm")){
                        $.ajax({
                            url: "{{ url('admin/quotation/destroy') }}",
                            type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id,
                                "status": 5
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

        function makeCopy(quotationId, customerId) {

            $("#quotationCopy").modal('show');
            $("#quotation_id").val(quotationId);

            $.ajax({
                url: "{{ url('admin/customer/get-customer-list') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    var result = JSON.parse(data);
                    var status = '';

                    $.each(result, function (index, value) {

                        $('#change_customer').append($('<option/>', { 
                            value: value['id'],
                            text :  value['postal_code']+ ' - '+ value['name'] +' - ' + value['contact_person'],
                            selected: value['id'] == customerId ? true : false
                        }));

                        if(value['id'] == customerId){
                            $("#client_name").html(value['postal_code']+ ' - '+ value['name'] +' - ' + value['contact_person']);
                        }
                    });
          
                    $("#change_customer").selectpicker("refresh");
                }, error: function (data) {
                }
            });
        }

        $('#btnCreateCopy').click(function(){

            $.ajax({
                url: "{{ url('admin/quotation/make-copy') }}",
                type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "quotation_id": $('#quotation_id').val(),
                        "customer": $('#change_customer').val(),
                    },
                        success: function (data) {
                            var result = JSON.parse(data);
console.log(result);
                            if (result['code'] == 1) {
                                var id = result["data"];
                                window.location = "{{ url('admin/quotation/edit') }}/" + id;

                            } else {
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
                        }, error: function (data) {

                    }
                });
        });
    </script>
    @endsection
</x-admin>
