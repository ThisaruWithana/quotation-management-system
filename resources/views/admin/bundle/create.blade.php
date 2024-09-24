<x-admin>
   @section('title')  {{ 'Bundle Management' }} @endsection

    <section class="content">
        <!-- Default box -->
        <div class="d-flex justify-content-center">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card card-primary">
                    <h5 class="card-header white-text text-left py-3">
                        {{ $title }}

                        <div class="card-tools">
                            <a class="btn btn-sm btn-primary" onclick="softeDelete()">
                                <button type="button" class="btn btn-tool">
                                    <i class="fas fa-times"></i>
                                </button>
                            </a>
                        </div>
                    </h5>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('admin.bundle.store') }}" method="PUT" class="text-center border border-light p-5" id="bundleCreate">
                        @csrf
                        <div class="card-body px-lg-2 pt-0">
                            <div class="row">
                                <div class="col-lg-7 col-md-12">
                                    <div class="card card-dark">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group text-left">
                                                <label for="name" class="form-label">Bundle Name</label>
                                                <span class="required"> * </span>
                                                <input type="text" class="form-control" name="name" id="name" required value="{{ old('name') }}" autocomplete="off">
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                <div class="invalid-feedback">Bundle Name is required.</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group text-left">
                                                <label for="bundle_cost" class="form-label">Bundle Cost</label>
                                                <input type="text" class="form-control" name="bundle_cost" id="bundle_cost" value="{{ old('bundle_cost') }}" autocomplete="off">
                                                @error('bundle_cost')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                <div class="invalid-feedback">Bundle Cost is required.</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group text-left">
                                                <label for="remark" class="form-label">Remark</label>
                                                <textarea class="form-control" name="remark" id="remark"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="text-left mt-4">
                                        <table class="table table-bordered">
                                            <tr class="bundle-item-cost">
                                                <td style="width:100px;"><p class="text-sm mb-0"><b class="d-block info-lb">Total Cost :</b></p></td>
                                                <td style="width:50px; text-align: right;">
                                                    <p class="text-sm mb-0"><b class="d-block info-lb"><span id="total-cost-lbl"></span></b></p>
                                                    <input type="hidden" value="" id="total_cost" name="total_cost">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:100px;"><p class="text-sm mb-0"><b class="d-block info-lb">Total Retail :</b></p></td>
                                                <td style="width:50px; text-align: right;">
                                                    <p class="text-sm mb-0"><b class="d-block info-lb"><span id="retail-lbl"></span></b></p>
                                                    <input type="hidden" value="" id="total_retail" name="total_retail">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:100px;"><p class="text-sm mb-0"><b class="d-block info-lb">Difference :</b></p></td>
                                                <td style="width:50px; text-align: right;"><p class="text-sm mb-0"><b class="d-block info-lb"><span id="diff-lbl"></span></b></p></td>
                                            </tr>
                                            <tr>
                                                <td style="width:100px;"><p class="text-sm mb-0"><b class="d-block info-lb">Bundle Cost :</b></p></td>
                                                <td style="width:50px; text-align: right;"><p class="text-sm mb-0"><b class="d-block info-lb"><span id="bundle-cost-lbl"></span></b></p></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" class="form-control" name="bundle_id" id="bundle_id" value="">
                            <input type="hidden" name="in_office" id="in_office" value="">
                            <input type="hidden" name="row_order" id="row_order" value="">
                        </div>
                        <!-- /.card-body -->
                        <div class="col-lg-2 col-md-3 col-sm-6 mx-auto">
                            <button class="btn btn-primary btn-block" type="submit" id="btnSave">Create</button>
                        </div>
                        <br>

                        <div class="row add-items" style="display:none;">
                            <div class="col-lg-12 col-md-12">
                                <div class="col-md-3 col-lg-4 mb-1" style="float:right;">
                                    <button class="btn btn-primary btn-block" type="button" id="itemSearchBtn" data-toggle="modal" data-target="#exampleModal">
                                        <i class="fa fa-search-plus"></i>
                                        Find Items
                                    </button>
                                </div>
                                <br><br>

                                <div class="table-responsive">
                                    <table class="table bundle-item-list table-bordered" id="sortable-table" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th class="th-sm">Code</th>
                                            <th class="th-sm">Name</th>
                                            <th class="th-sm">Supplier</th>
                                            <th class="w-120px th-sm item-list-cost">Actual Cost</th>
                                            <th class="th-sm item-list-item-cost">Cost</th>
                                            <th class="th-sm">Retail</th>
                                            <th class="th-sm item-list-qty">Qty</th>
                                            <th class="th-sm item-list-item-margin">Margin</th>
                                            <th class="w-120px th-sm item-list-total-cost">Total Cost</th>
                                            <th class="w-120px th-sm">Total Retail</th>
                                            <th class="w-150px th-sm item-list-display-report">Display In Report</th>
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

                        <div class="col-lg-2 col-md-3 col-sm-6 mx-auto" style="display:none;">
                            <button class="btn btn-primary btn-block" type="button" id="btnUpdate">Save</button>
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
                                    autocomplete="off"  placeholder="Name, Description" onkeyup="searchItem(this.form)">
                            </div>
                            <input type="hidden" value="bundle_search" id="search_type" name="search_type">
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
                                            <th class="w-120px th-sm">Item Code</th>
                                            <th class="w-120px th-sm">Item Name</th>
                                            <th class="th-sm">Department</th>
                                            <th class="th-sm">Supplier</th>
                                            <th class="w-120px th-sm item-search-cost">Cost Price</th>
                                            <th class="w-120px th-sm">Retail Price</th>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Bundle Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="" onsubmit="return false;" id="formEditBundleItem">
                <div class="modal-body">
                        @csrf
                    <input type="hidden" name="bundle_item_id" value="" id="bundle_item_id">
                    <input type="hidden" name="bundleId" value="" id="bundle_item_id">
                    <input type="hidden" name="retail" value="" id="retail">

                    <div class="form-group" id="actual_cost_edit">
                        <label for="actual_cost" class="col-form-label">Cost</label>
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
                    "paging": false,
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

                $('.item-list-item-cost').addClass('editable');
                $('.item-list-retail').addClass('editable');
                $('.item-list-qty').addClass('editable');

                $('#in_office').val('yes');

                $("#bundleCreate").submit(function(event) {
                    event.preventDefault();

                    var formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('admin.bundle.store') }}",
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
                                    $("#name").prop('disabled', true);

                                    $("#bundle_id").val(result['data']);
                                    $("#bundle").val(result['data']);
                                    $("#btnUpdate").show();

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

            $('#bundle_cost').on('keyup', function(e) {
                calculatePrices(e.target.value, $("#total_retail").val(), $("#total_cost").val());
            });

            $('#itemSearchBtn').click(function(){
                $('.table-item-search tbody').empty();
            });

            $('#btnUpdate').click(function(){

                if($('#bundle_cost').val() != ''){

                    $.ajax({
                        url: "{{ url('admin/bundle/update-bundle-item-order') }}",
                        type: 'POST',
                        data: {
                                "_token": "{{ csrf_token() }}",
                                "bundle_id": $('#bundle_id').val(),
                                "row_order": $('#row_order').val(),
                                "bundle_cost": $('#bundle_cost').val(),
                                "remark": $('#remark').val()
                            },
                        success: function (data) {

                            var result = JSON.parse(data);

                            if (result['code'] == 1) {
                                window.location = '{{ url("admin/bundle") }}';
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

                }else{
                        toastr.error(
                            'Error',
                            'Please Enter Bundle Cost !',
                            {
                                timeOut: 1500,
                                fadeOut: 1500,
                                onHidden: function () {
                                }
                            }
                        );

                }
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
                        url: "{{ url('admin/bundle/add-items') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": isChecked.value,
                                "ischecked": ischecked,
                                "bundle_id":$('#bundle_id').val(),
                                "type": Itemtype
                            },
                            success: function (data) {
                                var result = JSON.parse(data);

                                $('.bundle-item-list tbody').empty();

                                    var costColHidden;

                                    if($('#in_office').val() != 'yes'){
                                        costColHidden = 'style="display:none;"';
                                    }

                                if (result['data'].length > 0) {
                                    var i = 1;
                                    $.each(result['data'], function (count, val) {

                                        var displayReport = val['display_report'];
                                        var checkboxStatus = '';

                                        if(displayReport === 1){
                                            checkboxStatus = 'checked';
                                        }

                                        $('.bundle-item-list tbody').append(
                                            '<tr class="row_position" id="' + val['id'] + '" data-id="' + i + '">'
                                            +'<td>' + val['item_id'] + '</td>'
                                            +'<td>' + val['name'] + '</td>'
                                            +'<td>' + val['supplier'] + '</td>'
                                            +'<td class="item-list-cost" '+ costColHidden +'>' + val['actual_cost'] + '</td>'
                                            +'<td class="item-list-item-cost" '+ costColHidden +'>' + val['item_cost'] + '</td>'
                                            +'<td>' + val['retail'] + '</td>'
                                            +'<td class="item-list-qty">' + val['qty'] + '</td>'
                                            +'<td class="item-list-item-margin">' + val['margin'] + '</td>'
                                            +'<td class="item-list-total-cost" '+ costColHidden +'>' + val['total_cost'] + '</td>'
                                            +'<td>' + val['total_retail'] + '</td>'
                                            +'<td class="item-list-display-report" '+ costColHidden +'><input type="checkbox" id="item" name="item" onclick="updateDisplayStatus(this)" value="' + val['id'] + '" class="form-check-label" '+ checkboxStatus +'></td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['bundle_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['actual_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>'
                                            +'</td>'
                                            +'</tr>'
                                        );

                                        $('.item-list-item-cost').addClass('editable');
                                        $('.item-list-qty').addClass('editable');
                                        i++;
                                    });
                                }

                                calculatePrices(result['bundle_cost'], result['total_retail'], result['total_cost']);

                                if(ischecked == true){
                                    displaySubItemList(isChecked.value, Itemtype);
                                }
                            }, error: function (data) {

                        }
                });
            }

            function calculatePrices(bundleCost, totalRetail, totalCost){
                var difference = bundleCost - totalCost;

                $("#bundle-cost-lbl").text(Number(bundleCost).toFixed(2));
                $("#diff-lbl").text(Number(difference).toFixed(2));
                $("#retail-lbl").text(Number(totalRetail).toFixed(2));
                $("#total-cost-lbl").text(Number(totalCost).toFixed(2));
                $("#total_cost").val(Number(totalCost).toFixed(2));
                $("#total_retail").val(Number(totalRetail).toFixed(2));
            }

            function updateDisplayStatus(isChecked){
              var ischecked = isChecked.checked;

                $.ajax({
                        url: "{{ url('admin/bundle/update-display-status') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": isChecked.value,
                                "ischecked": ischecked
                            },
                            success: function (data) {
                                var result = JSON.parse(data);

                            }, error: function (data) {

                        }
                });
            }

            function changeStatus(id, bundleId){

                $.ajax({
                        url: "{{ url('admin/bundle/delete-item') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id,
                                "bundle_id": bundleId
                            },
                            success: function (data) {
                                var result = JSON.parse(data);
                                $('.bundle-item-list tbody').empty();

                                if (result['data'].length > 0) {

                                    var costColHidden;
                                    var i = 1;

                                    if($('#in_office').val() != 'yes'){
                                        costColHidden = 'style="display:none;"';
                                    }

                                    $.each(result['data'], function (count, val) {

                                        var displayReport = val['display_report'];
                                        var checkboxStatus = '';

                                        if(displayReport === 1){
                                            checkboxStatus = 'checked';
                                        }

                                        $('.bundle-item-list tbody').append(
                                            '<tr class="row_position" id="' + val['id'] + '" data-id="' + i + '">'
                                            +'<td>' + val['item_id'] + '</td>'
                                            +'<td>' + val['name'] + '</td>'
                                            +'<td>' + val['supplier'] + '</td>'
                                            +'<td class="item-list-cost" '+ costColHidden +'>' + val['actual_cost'] + '</td>'
                                            +'<td class="item-list-item-cost" '+ costColHidden +'>' + val['item_cost'] + '</td>'
                                            +'<td>' + val['retail'] + '</td>'
                                            +'<td class="item-list-qty">' + val['qty'] + '</td>'
                                            +'<td class="item-list-item-margin">' + val['margin'] + '</td>'
                                            +'<td class="item-list-total-cost" '+ costColHidden +'>' + val['total_cost'] + '</td>'
                                            +'<td>' + val['total_retail'] + '</td>'
                                            +'<td class="item-list-display-report" '+ costColHidden +'><input type="checkbox" id="item" name="item" onclick="updateDisplayStatus(this)" value="' + val['id'] + '" class="form-check-label" '+ checkboxStatus +'></td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['bundle_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['actual_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>'
                                            +'</td>'
                                            +'</tr>'
                                        );

                                        $('.item-list-item-cost').addClass('editable');
                                        $('.item-list-qty').addClass('editable');
                                        i++;
                                    });
                                }
                                calculatePrices(result['bundle_cost'], result['total_retail'], result['total_cost']);
                            }, error: function (data) {

                        }
                });
            }

            function editDetails(id, actual_cost, qty, retail){
                $("#actual_cost").val(actual_cost);
                $("#qty").val(qty);
                $("#bundle_item_id").val(id);
                $("#retail").val(retail);
                $("#editDetails").modal('show');

                if($('#in_office').val() != 'yes'){
                    $("#actual_cost_edit").hide();
                }
            }

            $('#formEditBundleItem').submit(function(event){
                event.preventDefault();

                var formData = new FormData(this);
                formData.append('bundle_id', $('#bundle_id').val());

                $.ajax({
                    url: "{{ url('admin/bundle/item-update') }}",
                    type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: formData,
                        dataType:'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            var result = data;
                            $('.bundle-item-list tbody').empty();

                            if (result['code'] == 1) {

                                if (result['data'].length > 0) {

                                    var costColHidden;
                                    var i = 1;

                                    if($('#in_office').val() != 'yes'){
                                        costColHidden = 'style="display:none;"';
                                    }

                                    $.each(result['data'], function (count, val) {

                                        var displayReport = val['display_report'];
                                        var checkboxStatus = '';

                                        if(displayReport === 1){
                                            checkboxStatus = 'checked';
                                        }

                                        $('.bundle-item-list tbody').append(
                                            '<tr class="row_position" id="' + val['id'] + '" data-id="' + i + '">'
                                            +'<td>' + val['item_id'] + '</td>'
                                            +'<td>' + val['name'] + '</td>'
                                            +'<td>' + val['supplier'] + '</td>'
                                            +'<td class="item-list-cost" '+ costColHidden +'>' + val['actual_cost'] + '</td>'
                                            +'<td class="item-list-item-cost" '+ costColHidden +'>' + val['item_cost'] + '</td>'
                                            +'<td>' + val['retail'] + '</td>'
                                            +'<td class="item-list-qty">' + val['qty'] + '</td>'
                                            +'<td class="item-list-item-margin">' + val['margin'] + '</td>'
                                            +'<td class="item-list-total-cost" '+ costColHidden +'>' + val['total_cost'] + '</td>'
                                            +'<td>' + val['total_retail'] + '</td>'
                                            +'<td class="item-list-display-report" '+ costColHidden +'><input type="checkbox" id="item" name="item" onclick="updateDisplayStatus(this)" value="' + val['id'] + '" class="form-check-label" '+ checkboxStatus +'></td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['bundle_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['actual_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>'
                                            +'</td>'
                                            +'</tr>'
                                        );

                                        $('.item-list-item-cost').addClass('editable');
                                        $('.item-list-qty').addClass('editable');
                                        i++;
                                    });
                                }
                                calculatePrices(result['bundle_cost'], result['total_retail'], result['total_cost']);
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
                            calculatePrices(result['bundle_cost'], result['total_retail'], result['total_cost']);

                            $("#editDetails").modal('hide');
                        }, error: function (data) {

                    }
                });
            });

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

            function softeDelete() {

                if($('#bundle_id').val() != ''){
                    cuteAlert({
                        type: "error",
                        title: "Are you sure",
                        message: "You want to delete of this bundle and go back?",
                        buttonText: "Yes"
                        }).then((e)=>{
                        if ( e == ("ok")){
                                $.ajax({
                                    url: "{{ url('admin/bundle/destroy') }}",
                                    type: 'POST',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        "id":$('#bundle_id').val(),
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
                                                        window.location = '{{ url("admin/bundle") }}';
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
                }else{
                    window.location = '{{ url("admin/bundle") }}';
                }
            }
        </script>

        <!--Rearrange table rows-->
        <script>
            $(function() {

                $("#sortable-table tbody").sortable({
                    helper: fixHelper,
                    update: function(event, ui) {
                        // Get the sorted rows
                        var sortedRows = $("#sortable-table tbody tr");
                        // Loop through the sorted rows to update their order ID
                        sortedRows.each(function(index) {
                            $(this).attr("data-id", index + 1);
                        });
                    },
                    stop: function() {
                        var selectedData = new Array();
                        $('#sortable-table tbody tr').each(function() {
                            selectedData.push($(this).attr("id"));
                        });
                        $('#row_order').removeAttr('value');
                        $('#row_order').val(selectedData);
                    }
                }).disableSelection();
            });

        function fixHelper(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        }
        </script>
    @endsection
</x-admin>
