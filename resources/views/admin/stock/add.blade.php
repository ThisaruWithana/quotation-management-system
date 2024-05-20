<x-admin>
    @section('title')
        {{ 'Stock Management' }}
    @endsection

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

            .card-dark{
                background: #FDFDFD;
                padding: 15px;
                border: 1px solid #ddd;
                box-shadow: none;
            }

            .form-control:disabled, .form-control[readonly] {
                background-color: #e9ecef;
                opacity: 1;
                border: 1px solid #ced4da !important;
            }
            .bootstrap-select.disabled, .bootstrap-select > .disabled {
                cursor: not-allowed;
                border: 1px solid #ced4da !important;
                border-radius: 10px;
            }

            .bootstrap-select > .dropdown-toggle{
                border: 1px solid #ced4da !important;
            }
            .form-group .bootstrap-select, .form-horizontal .bootstrap-select, .form-inline .bootstrap-select {
                padding: 0;
            }
        </style>
    <section class="content">
        <!-- Default box -->
        <div class="d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <h5 class="card-header  white-text text-left py-3">
                        {{ $title }}
                    </h5>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('admin.stock.adjustment') }}" method="POST"
                          class="text-center border border-light p-5" id="formCreate">
                        @csrf
                        <div class="card-body px-lg-2 pt-0">

                            <div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row card card-dark">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group text-left">
                                                            <label for="type" class="form-label">Type</label>
                                                            <span class="required"> * </span><br>
                                                            <select id="type" name="type"
                                                                    class="selectpicker show-tick col-lg-12" required>
                                                                <option value="Stock Adjustment (-)">Stock Adjustment (-)</option>
                                                                <option value="Stock Adjustment (+)">Stock Adjustment (+)</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group text-left">
                                                            <label for="comment" class="form-label">Comment</label>
                                                            <textarea class="form-control" name="comment" id="comment" rows="4"></textarea><br>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-12 customer-details"
                                                 style="display:block;margin-top: 0px;padding-left: 100px">
                                                <div class="text-left">
                                                    <table class="table table-bordered ">
                                                        <tr>
                                                            <td style="width:50px;"><p class="text-sm mb-0 text-bold">
                                                                    Total Cost :</p></td>
                                                            <td style="width:50px;"><p class="text-sm mb-0 text-bold"><span
                                                                        id="total-cost-lbl"></span></p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:50px;"><p class="text-sm mb-0 text-bold">
                                                                    Total Retail :</p></td>
                                                            <td style="width:50px;"><p class="text-sm mb-0 text-bold"><span
                                                                        id="total-retail-lbl"></span></p></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="stock_adjustment_id" id="stock_adjustment_id" value="">
                            </div>

                            <div class="col-lg-2 p-0">
                                <button class="btn btn-primary btn-block" type="submit" id="btnSave">Create</button>
                            </div>

                            <div class="add-items" style="display:none;">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-lg-2" style="float:right;">
                                            <button class="btn btn-primary btn-block" type="button" id="itemSearchBtn"
                                                    data-toggle="modal" data-target="#exampleModal">
                                                <i class="fa fa-search-plus"></i>
                                                Find Items
                                            </button>
                                        </div>
                                        <br><br>

                                        <div class="table-responsive">
                                            <table class="table item-list table-bordered" id="sortable-table"
                                                   width="100%">
                                                <thead>
                                                <tr>
                                                    <th class="th-sm">Code</th>
                                                    <th class="th-sm">Name</th>
                                                    <th class="th-sm">Supplier</th>
                                                    <th class="th-sm item-list-item-cost">Item Cost</th>
                                                    <th class="th-sm item-list-retail">Item Retail</th>
                                                    <th class="th-sm">Stock Before Adjustment</th>
                                                    <th class="th-sm item-list-qty">Adjustment Qty</th>
                                                    <th class="th-sm">Stock After Adjustment</th>
                                                    <th class="th-sm item-list-total-cost">Adjustment Total Cost</th>
                                                    <th class="th-sm">Adjustment Total Retail</th>
                                                    <th class="th-sm"></th>
                                                    <th class="th-sm"></th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                        
                                <br>
                                <div class="col-lg-2">
                                    <button class="btn btn-primary btn-block" type="button" id="btnStockUpdate">Update Stock</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!-- /.card -->

        <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Items</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form action="{{ url('admin/item/search') }}" method="POST"
                              class="text-center border border-light p-1" id="itemSearch" enctype="multipart/form-data"
                              onsubmit="return false;">
                            @csrf

                            <div class="row">
                                <div class="form-group mr-1">
                                    <input type="text" class="form-control" name="keyword" id="keyword"
                                           autocomplete="off" placeholder="ID, Name, Description"
                                           onkeyup="searchItem(this.form)">
                                </div>
                                <input type="hidden" value="stock" id="search_type" name="search_type">
                                <input type="hidden" value="" id="stock" name="stock">

                                <div class="form-group mr-1">
                                    <select id="supplier" name="supplier" class="selectpicker show-tick"
                                            data-live-search="true" onchange="searchItem(this.form)">
                                        <option value="">Supplier</option>
                                        @foreach ($suppliers as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mr-1">
                                    <select id="departments" name="departments" class="selectpicker show-tick"
                                            data-live-search="true" onchange="searchItem(this.form)">
                                        <option value="">Departments</option>
                                        @foreach ($departments as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mr-1">
                                    <select id="sub_departments" name="sub_departments" class="selectpicker show-tick"
                                            data-live-search="true" onchange="searchItem(this.form)">
                                        <option value="">Sub Departments</option>
                                        @foreach ($sub_departments as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <input type="hidden" name="form_action" value="search">
                            </div>

                            <div class="row">
                                <div class="col-lg-12 table-responsive">
                                    <table class="table table-item-search table-bordered" id="dataTable"
                                           style="width: 100%">
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

        <!-- Edit Detail -->
        <div class="modal fade" id="editDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Quotation Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="" method="" onsubmit="return false;" id="formEditItem">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="item_id" value="" id="item_id">
                            <input type="hidden" name="stock_before" value="" id="stock_before">
                            <input type="hidden" name="actual_cost" value="" id="actual_cost">
                            <input type="hidden" name="retail" value="" id="retail">

                            <div class="form-group">
                                <label for="qty" class="col-form-label">Adjustment Qty</label>
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

                $("#formCreate").submit(function(event) {
                    event.preventDefault();

                    var formData = new FormData(this);

                    $.ajax({
                        url: "{{ url('admin/stock/adjustment') }}",
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

                                    $("#comment").attr('disabled',true);

                                    $("#type").attr('disabled',true);
                                    $('#type').selectpicker('refresh');

                                    $("#stock_adjustment_id").val(result['data']);
                                    $("#stock").val(result['data']);

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

                $('#itemSearchBtn').click(function(){
                    $('.table-item-search tbody').empty();
                });

                $('#btnSaveChanges').click(function(){

                    $.ajax({
                            url: "{{ url('admin/stock/update-price-info') }}",
                            type: 'POST',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "stock_adjustment_id": $('#stock_adjustment_id').val(),
                                    "total_cost": $("#total-cost-lbl").text(),
                                    "total_retail": $("#total-retail-lbl").text()
                                },
                                success: function (data) {
                                    var result = JSON.parse(data);

                                    if (result['code'] == 1) {
                                        window.location = '{{ url("admin/stock") }}';

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

                $('#formEditItem').submit(function(event){
                    event.preventDefault();

                    var formData = new FormData(this);
                    formData.append('stock_adjustment_id', $('#stock_adjustment_id').val());
                
                    $.ajax({
                        url: "{{ url('admin/stock/item-update') }}",
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

                                            var editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +','+ val['item_cost'] +','+ val['retail'] +','+ val['qty']+','+ val['stock_before']+')"><i class="fas fa-edit"></i></a>';

                                            $('.item-list tbody').append(
                                                '<tr class="row_position" id="' + val['id'] + '" data-id="' + i + '">'
                                                +'<td>' + val['item_id'] + '</td>'
                                                +'<td>' + val['name'] + '</td>'
                                                +'<td>' + val['supplier'] + '</td>'
                                                +'<td class="item-list-cost">' + val['item_cost'] + '</td>'
                                                +'<td class="item-list-retail">' + val['retail'] + '</td>'
                                                +'<td class="">' + val['stock_before'] + '</td>'
                                                +'<td class="item-list-qty">' + val['qty'] + '</td>'
                                                +'<td class="">' + val['stock_after'] + '</td>'
                                                +'<td class="item-list-total-cost">' + val['total_cost'] + '</td>'
                                                +'<td>' + val['total_retail'] + '</td>'
                                                +'<td>'
                                                +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['stock_adjustment_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
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
                                            }
                                        }
                                    );
                                }

                                calculatePrices(result['total_retail'], result['total_cost']);
                                $("#editDetails").modal('hide');
                            }, error: function (data) {
                                        
                        }
                    });
                });

                $('#btnStockUpdate').click(function(){

                    $.ajax({
                        url: "{{ url('admin/stock/update-stock') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "stock_adjustment_id":$('#stock_adjustment_id').val(),
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
                                                window.location = '{{ url("admin/stock") }}';
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
                                var costColHidden;

                                if($('#in_office').val() != 'yes'){
                                    costColHidden = 'style="display:none;"';
                                }

                                $.each(result, function (count, val) {

                                    var type = 'main';
                                    $('.table-item-search tbody').append(
                                        '<tr>'
                                        +'<td>' + val['id'] + '</td>'
                                        +'<td>' + val['name'] + '</td>'
                                        +'<td>' + val['department']+ '</td>'
                                        +'<td>' + val['supplier'] + '</td>'
                                        +'<td class="item-search-cost" '+ costColHidden +'>' + val['cost_price'] + '</td>'
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
                        url: "{{ url('admin/stock/add-items') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": isChecked.value,
                                "ischecked": ischecked,
                                "stock_adjustment_id":$('#stock_adjustment_id').val(),
                                "type": Itemtype
                            },
                            success: function (data) {
                                var result = JSON.parse(data);

                                $('.item-list tbody').empty();

                                if (result['data'].length > 0) {
                                   
                                    $.each(result['data'], function (count, val) {

                                        var editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +','+ val['item_cost'] +','+ val['retail'] +','+ val['qty']+','+ val['stock_before']+')"><i class="fas fa-edit"></i></a>';

                                        $('.item-list tbody').append(
                                            '<tr class="row_position" id="' + val['id'] + '" data-id="' + i + '">'
                                            +'<td>' + val['item_id'] + '</td>'
                                            +'<td>' + val['name'] + '</td>'
                                            +'<td>' + val['supplier'] + '</td>'
                                            +'<td class="item-list-cost">' + val['item_cost'] + '</td>'
                                            +'<td class="item-list-retail">' + val['retail'] + '</td>'
                                            +'<td class="">' + val['stock_before'] + '</td>'
                                            +'<td class="item-list-qty">' + val['qty'] + '</td>'
                                            +'<td class="">' + val['stock_after'] + '</td>'
                                            +'<td class="item-list-total-cost">' + val['total_cost'] + '</td>'
                                            +'<td>' + val['total_retail'] + '</td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['stock_adjustment_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            +editBtn
                                            +'</td>'
                                            +'</tr>'
                                        );
                                        $('.item-list-qty').addClass('editable');
                                    });
                                }

                                calculatePrices(result['total_retail'], result['total_cost']);
                            }, error: function (data) {

                        }
                });
            }

            function calculatePrices(totalRetail, totalCost){
                $("#total-cost-lbl").text(Number(totalCost).toFixed(2));
                $("#total-retail-lbl").text(Number(totalRetail).toFixed(2));
            }

            function changeStatus(id, stock_adjustment_id){

                $.ajax({
                        url: "{{ url('admin/stock/delete-item') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id,
                                "stock_adjustment_id": stock_adjustment_id
                            },
                            success: function (data) {
                                var result = JSON.parse(data);
                                $('.item-list tbody').empty();

                                if (result['data'].length > 0) {
                                    
                                    $.each(result['data'], function (count, val) {

                                        var editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +','+ val['item_cost'] +','+ val['retail'] +','+ val['qty']+','+ val['stock_before']+')"><i class="fas fa-edit"></i></a>';

                                        $('.item-list tbody').append(
                                            '<tr class="row_position" id="' + val['id'] + '" data-id="' + i + '">'
                                            +'<td>' + val['item_id'] + '</td>'
                                            +'<td>' + val['name'] + '</td>'
                                            +'<td>' + val['supplier'] + '</td>'
                                            +'<td class="item-list-cost">' + val['item_cost'] + '</td>'
                                            +'<td class="item-list-retail">' + val['retail'] + '</td>'
                                            +'<td class="">' + val['stock_before'] + '</td>'
                                            +'<td class="item-list-qty">' + val['qty'] + '</td>'
                                            +'<td class="">' + val['stock_after'] + '</td>'
                                            +'<td class="item-list-total-cost">' + val['total_cost'] + '</td>'
                                            +'<td>' + val['total_retail'] + '</td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['stock_adjustment_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            +editBtn
                                            +'</td>'
                                            +'</tr>'
                                        );

                                        $('.item-list-qty').addClass('editable');
                                    });
                                }
                                
                                calculatePrices(result['total_retail'], result['total_cost']);
                            }, error: function (data) {

                        }
                });
            }

            function editDetails(id, cost, retail, qty,stock_before){
                $("#actual_cost").val(cost);
                $("#qty").val(qty);
                $("#stock_before").val(stock_before);
                $("#item_id").val(id);
                $("#retail").val(retail);

                $("#editDetails").modal('show');
            }

        </script>

    @endsection
</x-admin>
