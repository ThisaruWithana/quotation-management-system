<x-admin>
   @section('title')  {{ 'Purchase Order' }} @endsection
    <section class="content">
        <!-- Default box -->
        <div class="d-flex justify-content-center">
            <div class="col-lg-10">
                <div class="card card-primary">
                <h5 class="card-header  white-text text-left py-3">
                    {{ $title }}

                    <div class="card-tools">
                        <a href="{{ route('admin.po') }}" class="btn btn-sm btn-primary">
                            <button type="button" class="btn btn-tool">
                                    <i class="fas fa-times"></i>
                            </button>
                        </a>
                    </div>
                </h5>
                    <!-- /.card-header -->
                            <!-- form start -->
                    <form action="{{ route('admin.po.store') }}" method="PUT" class="text-center border border-light p-5" id="poCreate">
                         @csrf
                        <div class="card-body px-lg-2 pt-0">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group text-left">
                                                    <label for="type" class="form-label">PO Type</label>
                                                    <span class="required"> * </span>
                                                    <select id="type" name="type" class="selectpicker col-lg-12" required>
                                                        <option value=""></option>
                                                        <option value="Manual">Manual</option>
                                                        <option value="Automatic">Automatic</option>
                                                        <option value="Import">Import</option>
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
                                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div id="manual_form" style="display:none;"> 
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group text-left">
                                                        <label for="remark" class="form-label">Remark</label>
                                                        <textarea class="form-control" name="remark" id="remark"></textarea>
                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row"> 
                                            <div class="col-lg-6">
                                                <div class="form-group text-left">
                                                    <label for="order_date" class="form-label">Order Date</label>
                                                    <input type="date" class="form-control datepicker" id="order_date" name="order_date" value=""> 
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group text-left">
                                                    <label for="expected_date" class="form-label">Expected Date</label>
                                                    <input type="date" class="form-control datepicker" id="expected_date" name="expected_date" value="">
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                       
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
                                        
                                    </div>
                                    <div class="col-lg-4 pricing-details">
                                        <div class="text-left" style="margin-top: 25px;padding-left: 50px;">
                                            <table class="table table-bordered ">
                                                <tr class="bundle-item-cost">
                                                    <td style="width:120px;"><p class="text-sm mb-0 text-bold"><b class="d-block info-lb">Total Cost :</b></p></td>
                                                    <td style="width:50px;"><p class="text-sm mb-0"><b class="d-block info-lb"><span id="total-cost-lbl"></span></b></p></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div><br>
                                
                            <input type="hidden" class="form-control" name="po_id" id="po_id" value="">
                            <div class="col-lg-2">
                                <button class="btn btn-primary btn-block" type="submit" id="btnSave">Create</button>
                            </div><br>
                        </div>

                            <div class="add-items" style="display:none;">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-lg-2" style="float:right;">
                                            <button class="btn btn-primary btn-block" type="button" id="itemSearchBtn" data-toggle="modal" data-target="#exampleModal">
                                                <i class="fa fa-search-plus"></i> 
                                                Find Items
                                            </button>
                                        </div>
                                    </div>
                                </div><br>
                                    
                                <div class="table-responsiv">
                                    <table class="table item-list table-bordered" id="sortable-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="th-sm">Code</th>
                                                <th class="th-sm">Name</th>
                                                <th class="th-sm">Supplier</th>
                                                <th class="th-sm">Department</th>
                                                <th class="w-150px th-sm">Sub Department</th>
                                                <th class="w-100px th-sm">Item Cost</th>
                                                <th class="th-sm item-list-qty">Qty</th>
                                                <th class="w-100px th-sm">Total Cost</th>
                                                <th class="th-sm"></th>
                                                <th class="th-sm"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         
                                        
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <br>
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
                            <input type="hidden" value="po" id="search_type" name="search_type">
                            <input type="hidden" value="" id="bundle" name="bundle">

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
                    <input type="hidden" name="poId" value="" id="poId">
          
                    <div class="form-group" id="actual_cost_edit">
                        <label for="actual_cost" class="col-form-label">Actual Cost</label>
                        <input type="text" class="form-control" id="actual_cost" name="actual_cost"  
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
                
                $("#poCreate").submit(function(event) {
                    event.preventDefault();

                    var formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('admin.po.store') }}",
                        type: 'POST',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            dataType:'JSON',
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data) {
                                var result = data;

                                if (result['code'] == 1) {
                                    $(".add-items").show();
                                    $("#btnSave").hide();
                                    $("#supplier").prop('disabled', true);
                                    $("#remark").prop('disabled', true);
                                    $("#order_date").prop('disabled', true);
                                    $("#expected_date").prop('disabled', true);
                                    
                                    $("#po_id").val(result['po_id']);
                                    $("#poId").val(result['po_id']);
                                    $("#btnUpdate").show();

                                    if (result['data'].length > 0) {

                                        $('.item-list tbody').empty();

                                        $.each(result['data'], function (count, val) {

                                            var editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty']+' )"><i class="fas fa-edit"></i></a>';

                                            $('.item-list tbody').append(
                                                '<tr>'
                                                +'<td>'+ val['item_id'] +'</td>'
                                                +'<td>'+ val['name'] +'</td>'
                                                +'<td>'+ val['supplier'] +'</td>'
                                                +'<td>'+ val['department'] +'</td>'
                                                +'<td>'+ val['sub_department'] +'</td>'
                                                +'<td>'+ val['item_cost'] +'</td>'
                                                +'<td class="item-list-qty">'+ val['qty'] +'</td>'
                                                +'<td>'+ val['total_cost'] +'</td>'
                                                +'<td>'
                                                +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['po_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                                +'</td>'
                                                +'<td>'
                                                +editBtn
                                                +'</td>'
                                                +'</tr>'
                                            );

                                            $('.item-list-qty').addClass('editable');           
                                        });
                                            calculatePrices(result['total_cost']);  
                                    } 
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

                $('#type').on('change', function() {

                    if(this.value === 'Manual'){
                        $('#manual_form').show();
                        $('#import_form').hide();

                    }else if(this.value === 'Import'){
                        $('#manual_form').hide();
                        $('#import_form').show();
                        
                    }else{
                        $('#manual_form').hide();
                        $('#import_form').hide();
                    }
                });
                
                $('#itemSearchBtn').click(function(){
                    $('.table-item-search tbody').empty();
                });

                $('#formEditBundleItem').submit(function(event){
                    event.preventDefault();

                    var formData = new FormData(this);
                    formData.append('po_id', $('#po_id').val());
                
                    $.ajax({
                        url: "{{ url('admin/po/item-update') }}",
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

                                            var editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty']+' )"><i class="fas fa-edit"></i></a>';
                                        
                                            $('.item-list tbody').append(
                                                '<tr>'
                                                +'<td>'+ val['item_id'] +'</td>'
                                                +'<td>'+ val['name'] +'</td>'
                                                +'<td>'+ val['supplier'] +'</td>'
                                                +'<td>'+ val['department'] +'</td>'
                                                +'<td>'+ val['sub_department'] +'</td>'
                                                +'<td>'+ val['item_cost'] +'</td>'
                                                +'<td class="item-list-qty">'+ val['qty'] +'</td>'
                                                +'<td>'+ val['total_cost'] +'</td>'
                                                +'<td>'
                                                +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['po_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                                +'</td>'
                                                +'<td>'
                                                +editBtn
                                                +'</td>'
                                                +'</tr>'
                                            );
                                        $('.item-list-qty').addClass('editable');             
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
                                calculatePrices(result['total_cost']);
                                $("#editDetails").modal('hide');
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
                        url: "{{ url('admin/po/add-items') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": isChecked.value,
                                "ischecked": ischecked,
                                "po_id":$('#po_id').val(),
                                "type": Itemtype
                            },
                            success: function (data) {
                                var result = JSON.parse(data);

                                $('.item-list tbody').empty();

                                if (result['data'].length > 0) {

                                    $.each(result['data'], function (count, val) {

                                        var editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty']+' )"><i class="fas fa-edit"></i></a>';
                                        
                                        $('.item-list tbody').append(
                                            '<tr>'
                                            +'<td>'+ val['item_id'] +'</td>'
                                            +'<td>'+ val['name'] +'</td>'
                                            +'<td>'+ val['supplier'] +'</td>'
                                            +'<td>'+ val['department'] +'</td>'
                                            +'<td>'+ val['sub_department'] +'</td>'
                                            +'<td>'+ val['item_cost'] +'</td>'
                                            +'<td class="item-list-qty">'+ val['qty'] +'</td>'
                                            +'<td>'+ val['total_cost'] +'</td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['po_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            +editBtn
                                            +'</td>'
                                            +'</tr>'
                                        );
                                        
                                        $('.item-list-qty').addClass('editable');
                                    });
                                } 

                                calculatePrices(result['total_cost']);

                                if(ischecked == true){
                                    displaySubItemList(isChecked.value, Itemtype);
                                }
                            }, error: function (data) {
                                        
                        }
                });
            }

            function calculatePrices(totalCost){
                $("#total-cost-lbl").text(Number(totalCost).toFixed(2));
            }

            function changeStatus(id, poId){

                $.ajax({
                        url: "{{ url('admin/po/delete-item') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id,
                                "po_id": poId
                            },
                            success: function (data) {
                                var result = JSON.parse(data);
                                $('.item-list tbody').empty();

                                if (result['data'].length > 0) {
                                    
                                    $.each(result['data'], function (count, val) {

                                        var editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty']+' )"><i class="fas fa-edit"></i></a>';
                                        
                                        $('.item-list tbody').append(
                                            '<tr>'
                                            +'<td>'+ val['item_id'] +'</td>'
                                            +'<td>'+ val['name'] +'</td>'
                                            +'<td>'+ val['supplier'] +'</td>'
                                            +'<td>'+ val['department'] +'</td>'
                                            +'<td>'+ val['sub_department'] +'</td>'
                                            +'<td>'+ val['item_cost'] +'</td>'
                                            +'<td class="item-list-qty">'+ val['qty'] +'</td>'
                                            +'<td>'+ val['total_cost'] +'</td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['po_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            +editBtn
                                            +'</td>'
                                            +'</tr>'
                                        );

                                        $('.item-list-qty').addClass('editable');
                                    });
                                } 
                                calculatePrices(result['total_cost']);
                            }, error: function (data) {
                                        
                        }
                });
            }

            function editDetails(id, actual_cost, qty){
                $("#actual_cost").val(actual_cost);
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
