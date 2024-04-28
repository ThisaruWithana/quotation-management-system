<x-admin>
   @section('title')  {{ 'Bundle Management' }} @endsection
    <section class="content">
        <!-- Default box -->
        <div class="d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card card-primary">
                <h5 class="card-header  white-text text-left py-3">
                    <!-- <strong>{{ $title }}</strong> -->
                    {{ $title }}
                </h5>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('admin.bundle.store') }}" method="PUT"
                    class="text-center border border-light pt-4 pb-4 pl-3 pr-3" id="bundleCreate">
                        @csrf
                        <div class="card-body px-lg-2 pt-0">

                                <div class="row">
                                    <div class="col-lg-8 p-0">
                                        <div class="col-lg-12">
                                            <div class="form-group text-left">
                                                <label for="name" class="form-label">Bundle Name</label>
                                                <span class="required"> * </span>
                                                <input type="text" class="form-control" name="name" id="name"
                                                    required="" value="{{ $data->name }}" autocomplete="off">
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                <div class="invalid-feedback">Bundle Name is required.</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group text-left">
                                                <label for="bundle_cost" class="form-label">Bundle Cost</label>
                                                <span class="required"> * </span>
                                                <input type="text" class="form-control" name="bundle_cost" id="bundle_cost"
                                                    required="" value="{{ $data->bundle_cost }}"  autocomplete="off">
                                                    @error('bundle_cost')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                <div class="invalid-feedback">Bundle Cost is required.</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group text-left">
                                                <label for="remark" class="form-label">Remark</label>
                                                <textarea class="form-control" name="remark" id="remark">{{ $data->remark }}</textarea>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pricing-details">
                                        <div class="text-left" style="margin-left:100px;margin-top: 25px;">
                                            <table>
                                                <tr class="bundle-item-cost">
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Total Cost </b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="total-cost-lbl">{{ number_format($data->total_cost, 2) }}</span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Total Retail </b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="retail-lbl">{{ number_format($data->total_retail, 2) }}</span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Difference</b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="diff-lbl">{{ number_format($data->bundle_cost - $data->total_cost, 2) }}</span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Bundle Cost</b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="bundle-cost-lbl">{{ number_format($data->bundle_cost, 2) }}</span></b></p></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" value="{{ $data->total_cost }}" id="total_cost" name="total_cost">
                                <input type="hidden" value="{{ $data->total_retail }}" id="total_retail" name="total_retail">
                                <input type="hidden" class="form-control" name="bundle_id" id="bundle_id" value="{{ $data->id }}">
                                <input type="hidden" name="in_office" id="in_office" value="">
                        </div>
                        <!-- /.card-body -->

                    <div class="row add-items" style="display:block;">
                        <div class="col-lg-12">
                            <div class="col-lg-2">
                                <button class="btn btn-primary btn-block" type="button" id="itemSearchBtn" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fa fa-search-plus"></i>
                                    Find Items
                                </button>
                            </div><br>

                            <div class="col-lg-12 table-responsive">
                                <table class="table bundle-item-list table-bordered" id="dataTable" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">Code</th>
                                            <th class="th-sm">Name</th>
                                            <th class="th-sm">Supplier</th>
                                            <th class="th-sm item-list-cost">Cost</th>
                                            <th class="th-sm item-list-item-cost">Actual Cost</th>
                                            <th class="th-sm">Retail</th>
                                            <th class="th-sm item-list-qty">Qty</th>
                                            <th class="th-sm item-list-total-cost">Total Cost</th>
                                            <th class="th-sm">Total Retail</th>
                                            <th class="th-sm item-list-display-report">Display In Report</th>
                                            <th class="th-sm"></th>
                                            <th class="th-sm"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bundleItems as $value)
                                            <tr>
                                                <td>{{ $value['item_id'] }}</td>
                                                <td>{{ $value['name'] }}</td>
                                                <td>{{ $value['supplier'] }}</td>
                                                <td class="item-list-cost">{{ $value['actual_cost'] }}</td>
                                                <td class="item-list-item-cost">{{ $value['item_cost'] }}</td>
                                                <td>{{ $value['retail'] }}</td>
                                                <td class="item-list-qty">{{ $value['qty'] }}</td>
                                                <td class="item-list-total-cost">{{ $value['total_cost'] }}</td>
                                                <td>{{ $value['total_retail'] }}</td>
                                                <td class="item-list-display-report">
                                                    <input type="checkbox" id="item" name="item"
                                                    onclick="updateDisplayStatus(this)" value="{{ $value['id'] }}" class="form-check-label"
                                                    @if($value['display_report'] == 1) checked @endif></td>
                                                <td>
                                                    <a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus({{ $value['id'] }}, {{ $value['bundle_id'] }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails({{ $value['id'] }}, {{ $value['actual_cost'] }}, {{ $value['qty'] }}, {{ $value['retail'] }})">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <br>
                    <div class="col-lg-2">
                        <button class="btn btn-primary btn-block" type="submit" id="btnSave">Save</button>
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
                            <input type="hidden" value="bundle_search" id="search_type" name="search_type">
                            <input type="hidden" value="{{ $data->id }}" id="bundle" name="bundle">

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

        <!-- Sub Items Model -->
        <div class="modal fade bd-example-modal-lg" id="subItemList" tabindex="-1" role="dialog" aria-labelledby="subItemList" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subItemListTitle">Group Sub Items</h5>
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
                                <table class="table table-sub-items table-bordered" id="dataTable" style="width: 100%">
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
                $('#dataTable').DataTable({
                    "bPaginate": false,
                    "searching": false,
                    "ordering": false,
                    "responsive": true,
                    "scrollX": true,
                    "autoWidth":true,
                    "fixedHeader": true,
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 8,9 ]},
                    ]
                });

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

                $('.item-list-item-cost').addClass('editable');
                $('.item-list-retail').addClass('editable');
                $('.item-list-qty').addClass('editable');

                $('.bundle-item-cost').hide();
                $('.item-list-item-cost').hide();
                $('.item-list-total-cost').hide();
                $('.item-list-cost').hide();
                $('.item-search-cost').hide();
                $('.item-list-display-report').hide();

                cuteAlert({
                    type: "question",
                    title: "Are you in the office",
                    message: "",
                    confirmText: "Yes",
                    cancelText: "No"
                    }).then((e)=>{
                    if ( e == ("confirm")){
                        $('#in_office').val('yes');
                        $(".bundle-item-cost").show();
                        $('.item-list-item-cost').show();
                        $('.item-list-total-cost').show();
                        $('.item-list-cost').show();
                        $('.item-search-cost').show();
                        $('.item-list-display-report').show();

                    } else {
                        $('#in_office').val('no');
                    }
                });


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
                                    window.location = '{{ url("admin/bundle") }}';
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
                                    $.each(result['data'], function (count, val) {

                                        var displayReport = val['display_report'];
                                        var checkboxStatus = '';

                                        if(displayReport === 1){
                                            checkboxStatus = 'checked';
                                        }

                                        $('.bundle-item-list tbody').append(
                                            '<tr>'
                                            +'<td>' + val['item_id'] + '</td>'
                                            +'<td>' + val['name'] + '</td>'
                                            +'<td>' + val['supplier'] + '</td>'
                                            +'<td class="item-list-cost" '+ costColHidden +'>' + val['actual_cost'] + '</td>'
                                            +'<td class="item-list-item-cost" '+ costColHidden +'>' + val['item_cost'] + '</td>'
                                            +'<td>' + val['retail'] + '</td>'
                                            +'<td class="item-list-qty">' + val['qty'] + '</td>'
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
                                    });
                                }

                                calculatePrices(result['bundle_cost'], result['total_retail'], result['total_cost']);

                                if(Itemtype == 'main'){
                                    displaySubItemList(isChecked.value);
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
                                            '<tr>'
                                            +'<td>' + val['item_id'] + '</td>'
                                            +'<td>' + val['name'] + '</td>'
                                            +'<td>' + val['supplier'] + '</td>'
                                            +'<td class="item-list-cost" '+ costColHidden +'>' + val['actual_cost'] + '</td>'
                                            +'<td class="item-list-item-cost" '+ costColHidden +'>' + val['item_cost'] + '</td>'
                                            +'<td>' + val['retail'] + '</td>'
                                            +'<td class="item-list-qty">' + val['qty'] + '</td>'
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

                            if (result['code'] == 1) {
                                window.location.reload();

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

                    }
                });
            });

            function displaySubItemList(ItemId){

                $.ajax({
                    url: "{{ url('admin/item/get-sub-items') }}",
                    type: 'POST',
                    data: {
                            "_token": "{{ csrf_token() }}",
                            "id": ItemId
                        },
                    success: function (data) {
                        var result = JSON.parse(data);

                        $('.table-sub-items tbody').empty();

                        if (result.length > 0) {
                            $("#subItemList").modal('show');
                            var costColHidden;

                            if($('#in_office').val() != 'yes'){
                                costColHidden = 'style="display:none;"';
                            }

                            $.each(result, function (count, val) {
                                var isMandatory = val['is_mandatory'];
                                var selected;
                                var type = 'sub';

                                if(isMandatory == 1){
                                    selected = 'checked disabled';
                                }else{
                                    selected = '';
                                }

                                $('.table-sub-items tbody').append(
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

                        }
                    }, error: function (data) {

                    }
                });
            }
        </script>
    @endsection
</x-admin>
