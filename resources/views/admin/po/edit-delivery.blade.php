<x-admin>
@section('title')  {{ 'Purchase Deliveries' }} @endsection
    <section class="content">
        <!-- Default box -->
        <div class="d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card card-primary">
                <h5 class="card-header  white-text text-left py-3">
                    {{ $title }}

                    <div class="card-tools">
                        <a href="{{ route('admin.deliveries') }}" class="btn btn-sm btn-primary">
                            <button type="button" class="btn btn-tool">
                                    <i class="fas fa-times"></i>
                            </button>
                        </a>
                    </div>
                </h5>
                    <!-- /.card-header -->
                            <!-- form start -->
                    <form action="{{ URL('admin/deliveries/update') }}" method="POST" class="text-center border border-light p-5" id="formCreate">
                         @csrf
                        <div class="card-body px-lg-2 pt-0">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="row card card-dark">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="form-group text-left">
                                                        <label for="type" class="form-label">Type</label>
                                                        <span class="required"> * </span>
                                                        <select id="type" name="type" class="selectpicker col-lg-12" disabled>
                                                            <option value=""></option>
                                                            <option value="Manual" {{ $data->type === 'Manual' ? 'selected' : '' }}>Manual</option>
                                                            <option value="Import" {{ $data->type === 'Import' ? 'selected' : '' }}>Import</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="form-group text-left">
                                                        <label for="status" class="form-label">Delivery Status</label>
                                                        <span class="required"> * </span>
                                                        <select id="status" name="status" class="selectpicker col-lg-12">
                                                            <option value=""></option>
                                                            <option value="0" {{ $data->status === 0 ? 'selected' : '' }}>Suspended</option>
                                                            <option value="1" {{ $data->status === 1 ? 'selected' : '' }}>Awaiting Delivery</option>
                                                            <option value="4" {{ $data->status === 4 ? 'selected' : '' }}>Full Delivery</option>
                                                            <option value="3" {{ $data->status === 3 ? 'selected' : '' }}>Part Delivery</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group text-left">
                                                        <label for="supplier" class="form-label">Supplier</label>
                                                        <span class="required"> * </span>
                                                        <select id="supplier" name="supplier" class="selectpicker show-tick col-lg-12" data-live-search="true" required>
                                                            <option value="">Select Client</option>
                                                            @foreach ($suppliers as $value)
                                                            <option value="{{ $value->id }}" 
                                                                {{ $data->supplier_id === $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            @if($data->type === 'Manual')
                                                <div id="manual_form"> 
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group text-left">
                                                                <label for="remark" class="form-label">Remark</label>
                                                                <textarea class="form-control" name="remark" id="remark">{{ $data->reference }}</textarea>
                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row"> 
                                                    <div class="col-lg-6">
                                                        <div class="form-group text-left">
                                                            <label for="delivery_date" class="form-label">Delivery Date</label>
                                                            
                                                            @if(isset($data->delivery_date)) 
                                                                <input type="date" class="form-control datepicker" id="delivery_date" name="delivery_date" value="{{ date('Y-m-d', strtotime($data->delivery_date)) }}">
                                                            @else
                                                                <input type="date" class="form-control datepicker" id="delivery_date" name="delivery_date" value="">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            @endif
                                        
                                            @if($data->type === 'Import')
                                                <div id="import_form" style="display:none;"> 
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group text-left">
                                                                <label for="file" class="form-label">Upload File</label>
                                                                <input type="file" class="form-control" id="file" name="file" value=""> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pricing-details">
                                        <div class="text-left" style="margin-left:100px;margin-top: 25px;">
                                            <table class="table table-bordered">
                                                <tr class="bundle-item-cost">
                                                    <td style="width:100px;"><p class="text-sm mb-0 text-bold"><b class="d-block info-lb">Total Cost :</b></p></td>
                                                    <td style="width:100px;"><p class="text-sm mb-0 text-bold"><b class="d-block info-lb"><span id="total-cost-lbl">{{ number_format($data->total_cost, 2) }}</span></b></p></td>
                                                </tr>
                                                <tr class="bundle-item-cost">
                                                    <td style="width:100px;"><p class="text-sm mb-0 text-bold"><b class="d-block info-lb">Total Retail :</b></p></td>
                                                    <td style="width:100px;"><p class="text-sm mb-0 text-bold"><b class="d-block info-lb"><span id="total-retail-lbl">{{ number_format($data->total_retail, 2) }}</span></b></p></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div><br>
                                
                                <input type="hidden" class="form-control" name="delivery_id" id="delivery_id" value="{{ $data->id }}">
                        </div>

                            <div class="row add-items" style="display:block;">
                                <div class="col-lg-12">
                                    <div class="col-md-3 col-lg-3 mb-1" style="float:right;">
                                        <button class="btn btn-primary btn-block" type="button" id="itemSearchBtn" data-toggle="modal" data-target="#exampleModal">
                                            <i class="fa fa-search-plus"></i>
                                            Find Items
                                        </button>
                                    </div><br><br>

                                    <div class="table-responsive">
                                        <table class="table item-list table-bordered" id="sortable-table" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="th-sm">Code</th>
                                                    <th class="th-sm">Name</th>
                                                    <th class="th-sm">Supplier</th>
                                                    <th class="th-sm">Department</th>
                                                    <th class="w-150px th-sm">Sub Department</th>
                                                    <th class="w-100px th-sm item-list-item-cost">Item Cost</th>
                                                    <th class="w-120px th-sm item-list-item-retail">Item Retail</th>
                                                    <th class="th-sm item-list-qty">Qty</th>
                                                    <th class="w-100px th-sm">Total Cost</th>
                                                    <th class="w-120px th-sm">Total Retail</th>
                                                    <th class="th-sm"></th>
                                                    <th class="th-sm"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <?php $i = 1; ?>
                                                        @foreach ($itemList as $value)
                                                            <tr id="{{ $value['id'] }}">
                                                                <td>{{ $value['item_id'] }}</td>
                                                                <td>{{ $value['name'] }}</td>
                                                                <td>{{ $value['supplier'] }}</td>
                                                                <td>{{ $value['department'] }}</td>
                                                                <td>{{ $value['sub_department'] }}</td>
                                                                <td class="item-list-item-cost">{{ $value['item_cost'] }}</td>
                                                                <td class="item-list-item-retail">{{ $value['retail'] }}</td>
                                                                <td class="item-list-qty">{{ $value['qty'] }}</td>
                                                                <td class="item-list-total-cost">{{ $value['total_cost'] }}</td>
                                                                <td class="item-list-total-cost">{{ $value['total_retail'] }}</td>
                                                                <td>
                                                                    <a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus({{ $value['id'] }}, {{ $value['delivery_id'] }})">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails({{ $value['id'] }}, {{ $value['item_cost'] }}, {{ $value['qty'] }}, {{ $value['retail'] }})">
                                                                        <i class="fas fa-edit"></i>
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
                                <br>
                                    
                                <div class="row">
                                    @if($data->status != 0)
                                    <div class="col-md-4 col-lg-2 mb-1">
                                            <button class="btn btn-warning btn-block" type="button" id="btnSuspend">Suspend</button>
                                        </div>
                                    @endif
                                    <div class="col-md-4 col-lg-3 mb-1">
                                        <button class="btn btn-primary btn-block" type="submit" id="btnSaveChanges">Save Details</button>
                                    </div>
                                    <div class="col-md-4 col-lg-3 mb-1">
                                        <button class="btn btn-primary btn-block" type="button" id="btnStockUpdate">Update Stock</button>
                                    </div>
                                </div>
                        </div>
                        </form>
                </div> 

            </div>
        </div>
        <!-- /.card -->
        
        <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Items</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('admin.item.search') }}" method="POST"
                        class="text-center border border-light p-1" id="itemSearch" enctype="multipart/form-data" onsubmit="return false;">
                            @csrf

                        <div class="row">
                            <div class="form-group mr-1">
                                <input type="text" class="form-control" name="keyword" id="keyword"
                                    autocomplete="off"  placeholder="ID, Name, Description" onkeyup="searchItem(this.form)">
                            </div>
                            <input type="hidden" value="delivery" id="search_type" name="search_type">
                            <input type="hidden" value="{{ $data->id }}" id="deliveryId" name="deliveryId">

                            <div class="form-group mr-1">
                                <select id="supplier" name="supplier" class="selectpicker show-tick" data-live-search="true" onchange="searchItem(this.form)">
                                    <option value="">Supplier</option>
                                    @foreach ($suppliers as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mr-1">
                                <select id="departments" name="departments" class="selectpicker show-tick" data-live-search="true" onchange="searchItem(this.form)">
                                    <option value="">Departments</option>
                                    @foreach ($departments as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mr-1">
                                <select id="sub_departments" name="sub_departments" class="selectpicker show-tick" data-live-search="true" onchange="searchItem(this.form)">
                                    <option value="">Sub Departments</option>
                                    @foreach ($sub_departments as $value)
                                        <option value="{{ $value->id }}" >{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="form_action" value="search">
                        </div>

                        <div class="row">
                            <div class="col-lg-12 table-responsive">
                                <table class="table table-item-search table-bordered" id="dataTable" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="w-100px th-sm">Item Code</th>
                                            <th class="w-100px th-sm">Item Name</th>
                                            <th class="th-sm">Department</th>
                                            <th class="th-sm">Supplier</th>
                                            <th class="w-100px th-sm item-search-cost">Cost Price</th>
                                            <th class="w-100px th-sm">Retail Price</th>
                                            <th class="th-sm"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>    
        
        <!-- Edit Detail -->
        <div class="modal fade" id="editDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Quotation Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="" onsubmit="return false;" id="formEditBundleItem">
                <div class="modal-body">
                        @csrf
                    <input type="hidden" name="item_id" value="" id="item_id">
                    <input type="hidden" name="delivery_id" value="" id="delivery_id">
          
                    <div class="form-group">
                        <label for="actual_cost" class="col-form-label">Actual Cost</label>
                        <input type="text" class="form-control" id="actual_cost" name="actual_cost"  
                            required="" value="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="actual_retail" class="col-form-label">Retail Price</label>
                        <input type="text" class="form-control" id="actual_retail" name="actual_retail"  
                            required="" value="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="qty" class="col-form-label">Qty</label>
                        <input type="text" class="form-control" id="qty" name="qty"  
                            required="" value="" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnModalSave">Save</button>
                </div>
                </form>

                </div>
            </div>
        </div>
        <!-- Sub Items Model 1-->
        <div class="modal fade bd-example-modal-lg" id="subItemList1" tabindex="-1" role="dialog" aria-labelledby="subItemList1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subItemListTitle">Group Sub Items - 1</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="" method="POST"
                        class="text-center border border-light p-1" id="itemSearch" enctype="multipart/form-data" onsubmit="return false;">
                            @csrf

                        <div class="row">
                            <div class="col-lg-12 table-responsive">
                                <table class="table table-sub-items-1 table-bordered" id="dataTable" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">Item Code</th>
                                            <th class="th-sm">Item Name</th>
                                            <th class="th-sm">Department</th>
                                            <th class="th-sm">Supplier</th>
                                            <th class="th-sm item-search-cost">Cost Price</th>
                                            <th class="th-sm">Retail Price</th>
                                            <th class="th-sm"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Sub Items Model 2-->
        <div class="modal fade bd-example-modal-lg" id="subItemList2" tabindex="-1" role="dialog" aria-labelledby="subItemList2" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subItemListTitle">Group Sub Items - 2</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="" method="POST"
                        class="text-center border border-light p-1" id="itemSearch" enctype="multipart/form-data" onsubmit="return false;">
                            @csrf

                        <div class="row">
                            <div class="col-lg-12 table-responsive">
                                <table class="table table-sub-items-2 table-bordered" id="dataTable" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">Item Code</th>
                                            <th class="th-sm">Item Name</th>
                                            <th class="th-sm">Department</th>
                                            <th class="th-sm">Supplier</th>
                                            <th class="th-sm item-search-cost">Cost Price</th>
                                            <th class="th-sm">Retail Price</th>
                                            <th class="th-sm"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Sub Items Model 3-->
        <div class="modal fade bd-example-modal-lg" id="subItemList3" tabindex="-1" role="dialog" aria-labelledby="subItemList3" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subItemListTitle">Group Sub Items - 3</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="" method="POST"
                        class="text-center border border-light p-1" id="itemSearch" enctype="multipart/form-data" onsubmit="return false;">
                            @csrf

                        <div class="row">
                            <div class="col-lg-12 table-responsive">
                                <table class="table table-sub-items-3 table-bordered" id="dataTable" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">Item Code</th>
                                            <th class="th-sm">Item Name</th>
                                            <th class="th-sm">Department</th>
                                            <th class="th-sm">Supplier</th>
                                            <th class="th-sm item-search-cost">Cost Price</th>
                                            <th class="th-sm">Retail Price</th>
                                            <th class="th-sm"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
    </section>
    
    @section('js')
        <script>
            $(function() {

                $('.table-item-search').DataTable({
                    "bPaginate": false,
                    "searching": false,
                    "ordering": false,
                    "responsive": true,
                    "autoWidth":true,
                    "fixedHeader": true,
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 6 ]},
                    ]
                });
            });
        </script>
        <script>
            $(document).ready(function() {

                $('.item-list-qty').addClass('editable');
                $('.item-list-item-cost').addClass('editable');
                $('.item-list-item-retail').addClass('editable');
                
                $('#type').on('change', function() {

                    if(this.value === 'Manual'){
                        $('#manual_form').show();
                        $('#import_form').hide();

                    }else{
                        $('#manual_form').hide();
                        $('#import_form').show();
                    }
                });
                
                $('#itemSearchBtn').click(function(){
                    $('.table-item-search tbody').empty();
                });

                $('#formEditBundleItem').submit(function(event){
                    event.preventDefault();

                    var formData = new FormData(this);
                    formData.append('delivery_id', $('#delivery_id').val());
                
                    $.ajax({
                        url: "{{ url('admin/deliveries/item-update') }}",
                        type: 'POST',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            dataType:'JSON',
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data) {
                                var result = data;
                                $('.item-list tbody').empty();

                                if (result['code'] == 1) {

                                    if (result['data'].length > 0) {

                                        $.each(result['data'], function (count, val) {

                                            var editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty']+', '+ val['retail']+' )"><i class="fas fa-edit"></i></a>';
                                        
                                            $('.item-list tbody').append(
                                                '<tr>'
                                                +'<td>'+ val['item_id'] +'</td>'
                                                +'<td>'+ val['name'] +'</td>'
                                                +'<td>'+ val['supplier'] +'</td>'
                                                +'<td>'+ val['department'] +'</td>'
                                                +'<td>'+ val['sub_department'] +'</td>'
                                                +'<td class="item-list-item-cost">'+ val['item_cost'] +'</td>'
                                                +'<td class="item-list-item-retail">'+ val['retail'] +'</td>'
                                                +'<td class="item-list-qty">'+ val['qty'] +'</td>'
                                                +'<td>'+ val['total_cost'] +'</td>'
                                                +'<td>'+ val['total_retail'] +'</td>'
                                                +'<td>'
                                                +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['delivery_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                                +'</td>'
                                                +'<td>'
                                                +editBtn
                                                +'</td>'
                                                +'</tr>'
                                            );
                                            
                                            $('.item-list-qty').addClass('editable');
                                            $('.item-list-item-cost').addClass('editable');
                                            $('.item-list-item-retail').addClass('editable');

                                            $("#editDetails").modal('hide');         
                                            calculatePrices(result['total_cost'], result['total_retail']);
                                        });
                                    } 
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
                                        
                        }
                    });
                });

                $('#btnSuspend').click(function(){

                    $.ajax({
                        url: "{{ url('admin/deliveries/suspend') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "delivery_id":$('#delivery_id').val()
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
                                                window.location = '{{ url("admin/deliveries") }}';
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
                                            }
                                        }
                                    );
                                    }
                            }, error: function (data) {                
                        }
                    });
                });

                $('#btnStockUpdate').click(function(){

                    $.ajax({
                        url: "{{ url('admin/deliveries/update-stock') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "delivery_id":$('#delivery_id').val(),
                                "type":'delivery'
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
                                                window.location = '{{ url("admin/deliveries") }}';
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
                                            }
                                        }
                                    );
                                    }
                            }, error: function (data) {                
                        }
                    });
                });

            });

            function searchItem(form){

                $.ajax({
                    url: "{{ url('admin/item/search') }}",
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: $(form).serialize(),
                    success: function (data) {
                        var result = JSON.parse(data);

                        $('.table-item-search tbody').empty();

                            if (result.length > 0) {

                                $.each(result, function (count, val) {
                                    var type = 'main';
                    
                                    $('.table-item-search tbody').append(
                                        '<tr>'
                                        +'<td>' + val['id'] + '</td>'
                                        +'<td>' + val['name'] + '</td>'
                                        +'<td>' + val['department']+ '</td>'
                                        +'<td>' + val['supplier'] + '</td>'
                                        +'<td class="item-search-cost">' + val['cost_price'] + '</td>'
                                        +'<td>' + val['retail_price'] + '</td>'
                                        +'<td><input type="checkbox" id="item" name="item" onclick="selectItem(this, \'' + type + '\')" value="' + val['id'] + '" class="form-check-label"></td>'
                                        +'</tr>'
                                    );
                                });
                            } 
                        }, error: function (data) {
                                    
                    }
                });
            }

            function selectItem(isChecked, Itemtype){
              var ischecked = isChecked.checked;

                $.ajax({
                        url: "{{ url('admin/deliveries/add-items') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": isChecked.value,
                                "ischecked": ischecked,
                                "delivery_id":$('#delivery_id').val(),
                                "type": Itemtype
                            },
                            success: function (data) {
                                var result = JSON.parse(data);

                                $('.item-list tbody').empty();

                                if (result['data'].length > 0) {

                                    $.each(result['data'], function (count, val) {

                                        var editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty']+', '+ val['retail']+' )"><i class="fas fa-edit"></i></a>';
                                        
                                        $('.item-list tbody').append(
                                                '<tr>'
                                                +'<td>'+ val['item_id'] +'</td>'
                                                +'<td>'+ val['name'] +'</td>'
                                                +'<td>'+ val['supplier'] +'</td>'
                                                +'<td>'+ val['department'] +'</td>'
                                                +'<td>'+ val['sub_department'] +'</td>'
                                                +'<td class="item-list-item-cost">'+ val['item_cost'] +'</td>'
                                                +'<td class="item-list-item-retail">'+ val['retail'] +'</td>'
                                                +'<td class="item-list-qty">'+ val['qty'] +'</td>'
                                                +'<td>'+ val['total_cost'] +'</td>'
                                                +'<td>'+ val['total_retail'] +'</td>'
                                                +'<td>'
                                                +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['delivery_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                                +'</td>'
                                                +'<td>'
                                                +editBtn
                                                +'</td>'
                                                +'</tr>'
                                        );
                                            
                                            $('.item-list-qty').addClass('editable');
                                            $('.item-list-item-cost').addClass('editable');
                                            $('.item-list-item-retail').addClass('editable');
                                    });
                                } 

                                calculatePrices(result['total_cost'], result['total_retail']);

                                if(ischecked == true){
                                    displaySubItemList(isChecked.value, Itemtype);
                                }
                            }, error: function (data) {
                                        
                        }
                });
            }

            function calculatePrices(totalCost, totalRetail){
                $("#total-cost-lbl").text(Number(totalCost).toFixed(2));
                $("#total-retail-lbl").text(Number(totalRetail).toFixed(2));
            }

            function changeStatus(id, delivery_id){

                $.ajax({
                        url: "{{ url('admin/deliveries/delete-item') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id,
                                "delivery_id": delivery_id
                            },
                            success: function (data) {
                                var result = JSON.parse(data);
                                $('.item-list tbody').empty();

                                if (result['data'].length > 0) {
                                    
                                    $.each(result['data'], function (count, val) {
                                        
                                        var editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty']+', '+ val['retail']+' )"><i class="fas fa-edit"></i></a>';
                                        
                                        $('.item-list tbody').append(
                                                '<tr>'
                                                +'<td>'+ val['item_id'] +'</td>'
                                                +'<td>'+ val['name'] +'</td>'
                                                +'<td>'+ val['supplier'] +'</td>'
                                                +'<td>'+ val['department'] +'</td>'
                                                +'<td>'+ val['sub_department'] +'</td>'
                                                +'<td class="item-list-item-cost">'+ val['item_cost'] +'</td>'
                                                +'<td class="item-list-item-retail">'+ val['retail'] +'</td>'
                                                +'<td class="item-list-qty">'+ val['qty'] +'</td>'
                                                +'<td>'+ val['total_cost'] +'</td>'
                                                +'<td>'+ val['total_retail'] +'</td>'
                                                +'<td>'
                                                +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['delivery_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                                +'</td>'
                                                +'<td>'
                                                +editBtn
                                                +'</td>'
                                                +'</tr>'
                                        );
                                            
                                            $('.item-list-qty').addClass('editable');
                                            $('.item-list-item-cost').addClass('editable');
                                            $('.item-list-item-retail').addClass('editable');
                                    });
                                } 
                                calculatePrices(result['total_cost'], result['total_retail']);
                            }, error: function (data) {
                                        
                        }
                });
            }

            function editDetails(id, actual_cost, qty, actual_retail){
                $("#actual_cost").val(actual_cost);
                $("#actual_retail").val(actual_retail);
                $("#qty").val(qty);
                $("#item_id").val(id);
                $("#editDetails").modal('show');
            }

            function displaySubItemList(ItemId, Itemtype){
               
               var type;
               var i = 1;

               if(Itemtype === 'main'){
                   type = 'sub-' + i;
               }else{
                   i = i + 1;
                   type = 'sub-' + i;
               }

               $.ajax({
                   url: "{{ url('admin/item/get-sub-items') }}",
                   type: 'POST',
                   data: {
                           "_token": "{{ csrf_token() }}",
                           "id": ItemId
                       },
                   success: function (data) {
                       var result = JSON.parse(data);

                       $('.table-sub-items-'+ i +' tbody').empty();

                       if (result.length > 0) {
                           $("#subItemList" + i).modal('show');
                           var costColHidden;

                           if($('#in_office').val() != 'yes'){
                               costColHidden = 'style="display:none;"';
                           }

                           $.each(result, function (count, val) {
                               var isMandatory = val['is_mandatory'];
                               var selected;

                               if(isMandatory == 1){
                                   selected = 'checked disabled';
                               }else{
                                   selected = '';
                               }

                               $('.table-sub-items-'+ i +' tbody').append(
                                   '<tr>'
                                   +'<td>' + val['id'] + '</td>'
                                   +'<td>' + val['name'] + '</td>'
                                   +'<td>' + val['department']+ '</td>'
                                   +'<td>' + val['supplier'] + '</td>'
                                   +'<td class="item-search-cost" '+ costColHidden +'>' + val['cost_price'] + '</td>'
                                   +'<td>' + val['retail_price'] + '</td>'
                                   +'<td><input type="checkbox" id="item" name="item" onclick="selectItem(this, \'' + type + '\')" value="' + val['id'] + '" class="form-check-label" '+ selected +'></td>'
                                   +'</tr>'
                                   );
                           });
                       }else{
                           $("#subItemList" + i).modal('hide');
                       }
                   }, error: function (data) {

                   }
               });
           }

        </script>
 
    @endsection
</x-admin>
