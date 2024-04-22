<x-admin>
   @section('title')  {{ 'Quotation Management' }} @endsection
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
                    <form action="{{ url('admin/quotation/store') }}" method="PUT" class="text-center border border-light p-5" id="formCreate">
                         @csrf
                        <div class="card-body px-lg-2 pt-0">

                                <div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                
                                                <div class="col-lg-6">
                                                    <div class="form-group text-left">
                                                        <label for="ref" class="form-label">Quot. Ref</label>
                                                        <input type="text" class="form-control" id="ref" name="ref" value="" readonly>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-12">
                                                    <div class="form-group text-left">
                                                        <label for="customer" class="form-label">Client</label>
                                                        <span class="required"> * </span><br>
                                                        <select id="customer" name="customer" class="selectpicker show-tick col-lg-12" data-live-search="true" required>
                                                            <option value="">Select Client</option>
                                                            @foreach ($customers as $value)
                                                            <option value="{{ $value->id }}">{{ $value->code }} - {{  $value->postal_code }} - {{ $value->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-12">
                                                    <div class="form-group text-left">
                                                        <label for="description" class="form-label">Description</label>
                                                        <span class="required"> * </span><br>
                               
                                                        <textarea class="form-control" name="description" id="description" rows="4"
                                                            required></textarea><br>
                                                            
                                                        <button class="btn btn-default add-description" type="button" style="float:right; margin-top:-20px;"><i class="fa fa-plus"> Add</i></button><br>
                                                    
                                                        <div style="display:none;" class="add-description-history">
                                                            <select id="description_dropdown" name="description_dropdown" class="selectpicker show-tick col-lg-12" data-live-search="true">
                                                                <option value="">Select Description</option>
                                                                @foreach ($descriptions as $value)
                                                                <option value="{{ $value->description }}">{{ $value->description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                            
                                                    </div>
                                                </div>
                                            </div>
                                            
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group text-left">
                                                <label for="price" class="form-label">Quotation Price</label>
                                                <span class="required"> * </span><br>
                                                <input type="text" class="form-control" id="price" name="price" value="" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group text-left">
                                                <label for="discount" class="form-label">Discount</label>
                                                <input type="text" class="form-control" id="discount" name="discount" value="0" autocomplete="off">
                                            </div>
                                        </div>   
                                        <div class="col-lg-4">
                                            <div class="form-group text-left">
                                                <label for="margin" class="form-label">Quotation Margin</label>
                                                <input type="text" class="form-control" id="margin" name="margin" value="" readonly>
                                            </div>
                                        </div>                               
                                    </div>

                                        </div>
                                        
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-12 customer-details" style="display:block;margin-top: 25px;margin-left:100px;">
                                                    <div class="text-left">
                                                        <table>
                                                            <tr>
                                                                <td style="width:120px;"><p class="text-sm">Name</p></td>
                                                                <td style="width:100px;"><p class="text-sm">:</p></td>
                                                                <td style="width:50px;"><p class="text-sm"><span id="cus-name-lbl"></span></p></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:120px;"><p class="text-sm">Address</p></td>
                                                                <td style="width:100px;"><p class="text-sm">:</p></td>
                                                                <td style="width:50px;"><p class="text-sm"><span id="cus-address-lbl"></span></p></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:120px;"><p class="text-sm">Contact Number</p></td>
                                                                <td style="width:100px;"><p class="text-sm">:</p></td>
                                                                <td style="width:50px;"><p class="text-sm"><span id="cus-tel-lbl"></span></p></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:120px;"><p class="text-sm">Email</p></td>
                                                                <td style="width:100px;"><p class="text-sm">:</p></td>
                                                                <td style="width:50px;"><p class="text-sm"><span id="cus-email-lbl"></span></p></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:120px;"><p class="text-sm">Code</p></td>
                                                                <td style="width:100px;"><p class="text-sm">:</p></td>
                                                                <td style="width:50px;"><p class="text-sm"><span id="cus-code-lbl"></span></p></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="quotation_id" id="quotation_id" value="">
                                    <input type="hidden" name="in_office" id="in_office" value="">
                                    <input type="hidden" name="vat_rate" id="vat_rate" value="{{ $vat_rate[0] }}">
                                </div>
                                
                                <div class="col-lg-2">
                                    <button class="btn btn-primary btn-block" type="submit" id="btnSave">Save</button>
                                </div> 
                            <hr>
              
                            <div class="add-items" style="display:block;">

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group text-left">
                                                <label for="bundle" class="form-label">Bundle</label>
                                                <select id="bundle" name="bundle" class="selectpicker show-tick col-lg-12" data-live-search="true">
                                                    <option value="">Select Bundle</option>
                                                    @foreach ($bundles as $value)
                                                    <option value="{{ $value->id }}">{{ number_format($value->bundle_cost, 2) }} - {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group text-left">
                                                <label for="bundle_cost" class="form-label">Bundle Cost</label>
                                                <input type="text" class="form-control" id="bundle_cost" name="bundle_cost" readonly>
                                            </div>
                                        </div>                               
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-lg-2">
                                                <button class="btn btn-primary btn-block" type="button" id="itemSearchBtn" data-toggle="modal" data-target="#exampleModal">
                                                    <i class="fa fa-search-plus"></i> 
                                                    Find Items
                                                </button>
                                            </div><br>

                                            <div class="">
                                                <table class="table item-list table-bordered" id="dataTable" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="th-sm">Code</th>
                                                            <th class="th-sm">Name</th>
                                                            <th class="th-sm">Supplier</th>
                                                            <th class="th-sm item-list-cost">Cost</th>
                                                            <th class="th-sm item-list-item-cost">Actual Cost</th>
                                                            <th class="th-sm item-list-retail">Retail</th>
                                                            <th class="th-sm item-list-qty">Qty</th>
                                                            <th class="th-sm item-list-total-cost">Total Cost</th>
                                                            <th class="th-sm">Total Retail</th>
                                                            <th class="th-sm item-list-display-report">Display In Report</th>
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
                                    <br><hr>
                                    <div class="row text-left">

                                        <div class="col-lg-4">
                                            <table>
                                                <tr id="lbl-cost-details" style="display:none;">
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Total Cost </b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="total-cost-lbl"></span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Total Retail </b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="retail-lbl"></span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Discount (%)</b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="discount-lbl"></span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:150px;"><p class="text-sm"><b class="d-block info-lb">Quot. Price </b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="quot-price-lbl"></span></b></p></td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="col-lg-4">
                                            <table>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Quot. Margin </b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:200px;"><p class="text-sm"><b class="d-block info-lb"><span id="quot-margin-lbl"></span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">VAT</b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="vat-lbl"></span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:200px;"><p class="text-sm"><b class="d-block info-lb">Quot. + VAT</b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="quot-vat-lbl"></span></b></p></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                <br>
                                <div class="col-lg-2">
                                    <button class="btn btn-primary btn-block" type="button" id="btnSaveChanges">Save Changes</button>
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

                    <form action="{{ url('admin/item/search') }}" method="POST"
                        class="text-center border border-light p-1" id="itemSearch" enctype="multipart/form-data" onsubmit="return false;">
                            @csrf

                        <div class="row">
                            <div class="form-group mr-1">
                                <input type="text" class="form-control" name="keyword" id="keyword"
                                    autocomplete="off"  placeholder="ID, Name, Description" onkeyup="searchItem(this.form)">
                            </div>
                            <input type="hidden" value="quotation_search" id="search_type" name="search_type">
                            <input type="hidden" value="" id="quotation" name="quotation">

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
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Quotation Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="" onsubmit="return false;" id="formEditBundleItem">
                <div class="modal-body">
                        @csrf
                    <input type="hidden" name="quotation_item_id" value="" id="quotation_item_id">
                    <input type="hidden" name="bundleId" value="" id="quotation_item_id">
          
                    <div class="form-group" id="actual_cost_edit">
                        <label for="actual_cost" class="col-form-label">Actual Cost</label>
                        <input type="text" class="form-control" id="actual_cost" name="actual_cost"  
                            required="" value="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="retail" class="col-form-label">Item Retail</label>
                        <input type="text" class="form-control" id="retail" name="retail"  
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
                    "paging": false,
                    "scrollCollapse": true,
                    "scrollY": '50vh',
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
                        $("#lbl-cost-details").show();
                        $('.item-list-item-cost').show();
                        $('.item-list-total-cost').show();
                        $('.item-list-cost').show();
                        $('.item-search-cost').show();
                        $('.item-list-display-report').show();
                        
                    } else {
                        $('#in_office').val('no');
                    }
                });

                $('.add-description').click(function(){
                    $('.add-description-history').show();
                });

                $('#description_dropdown').on('change', function() {
                    var txt = $.trim(this.value);
                    $('#description').append(txt);
                    $('.add-description-history').hide();
                });

                $("#discount").on("keyup", function() {

                    var discount = this.value;
                    var totalCost = parseFloat($("#total-cost-lbl").text());
                    var totalRetail = parseFloat($("#retail-lbl").text());
                    var quotationCost = parseFloat($('#price').val());

                    calculatePrices(quotationCost, totalRetail, totalCost, discount);

                });

                $("#price").on("keyup", function() {

                    var quotationCost = this.value;
                    var totalCost = parseFloat($("#total-cost-lbl").text());
                    var totalRetail = parseFloat($("#retail-lbl").text());
                    var discount = parseFloat($('#discount').val());

                    if (isNaN(totalCost)) {
                        totalCost = 0;
                    }

                    if (isNaN(totalRetail)) {
                        totalRetail = 0;
                    }

                    calculatePrices(quotationCost, totalRetail, totalCost, discount);

                });

                $("#formCreate").submit(function(event) {
                    event.preventDefault();

                    var formData = new FormData(this);

                    $.ajax({
                        url: "{{ url('admin/quotation/store') }}",
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
                                    
                                    $("#customer").attr('disabled',true);
                                    $('#customer').selectpicker('refresh');

                                    $("#description").attr('disabled',true);
                                    $('#description').selectpicker('refresh');

                                    $("#quotation_id").val(result['data']);
                                    $("#quotation").val(result['data']);
                                    $("#ref").val(result['ref']);
                                    
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

                $('#customer').on('change', function() {
                    $.ajax({
                        url: "{{ url('admin/customer/get-details') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": this.value
                            },
                            success: function (data) {
                                var result = JSON.parse(data);
                                if(result['postal_code'] != null){
                                    var address = result['address'] + ' '+ result['postal_code'].trim();
                                }else{
                                    var address = result['address'];
                                }

                                $("#cus-name-lbl").text(result['name']);
                                $("#cus-address-lbl").text(address);
                                $("#cus-email-lbl").text(result['email']);
                                $("#cus-code-lbl").text(result['code']);
                                $("#cus-tel-lbl").text(result['tel']);

                            }, error: function (data) {
        
                        }
                    });
                });

                $('#bundle').on('change', function() {

                    $.ajax({
                        url: "{{ url('admin/quotation/add-bundle') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "bundle": this.value,
                                "quotation_id":$('#quotation_id').val(),
                            },
                            success: function (data) {
                                var result = JSON.parse(data);

                                $("#bundle_cost").val(result['bundle_cost']);
                                $('.item-list tbody').empty();

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

                                        var type = val['type'];
                                        var name;
                                        var editBtn = '';

                                        if(type === 'bundle'){
                                            name = '<a class="" title="Edit Bundle" onclick="editBundle('+ val['quotation_id'] +','+ val['item_id'] +')">' + val['name'] + '</a>';
                                        }else{
                                            name = val['name'];
                                            editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>';
                                        }

                                        $('.item-list tbody').append(
                                            '<tr>'
                                            +'<td>' + val['item_id'] + '</td>'
                                            +'<td>' + name + '</td>'
                                            +'<td>' + val['supplier'] + '</td>'
                                            +'<td class="item-list-cost" '+ costColHidden +'>' + val['actual_cost'] + '</td>'
                                            +'<td class="item-list-item-cost" '+ costColHidden +'>' + val['item_cost'] + '</td>'
                                            +'<td class="item-list-retail">' + val['retail'] + '</td>'
                                            +'<td class="item-list-qty">' + val['qty'] + '</td>'
                                            +'<td '+ costColHidden +'>' + val['total_cost'] + '</td>'
                                            +'<td>' + val['total_retail'] + '</td>'
                                            +'<td class="item-list-display-report" '+ costColHidden +'><input type="checkbox" id="item" name="item" onclick="updateDisplayStatus(this)" value="' + val['id'] + '" class="form-check-label" '+ checkboxStatus +'></td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['quotation_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'+ editBtn +'</td>'
                                            +'</tr>'
                                        );
                                        
                                        $('.item-list-item-cost').addClass('editable');
                                        $('.item-list-retail').addClass('editable');
                                        $('.item-list-qty').addClass('editable');
                                    });
                                } 

                                calculatePrices(result['quotation_cost'], result['total_retail'], result['total_cost'], result['discount']);

                            }, error: function (data) {
        
                        }
                    });
                });
                
                $('#itemSearchBtn').click(function(){
                    $('.table-item-search tbody').empty();
                });

                $('#formEditBundleItem').submit(function(event){
                    event.preventDefault();

                    var formData = new FormData(this);
                    formData.append('quotation_id', $('#quotation_id').val());
                
                    $.ajax({
                        url: "{{ url('admin/quotation/item-update') }}",
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


                                            var type = val['type'];
                                            var name;
                                            var editBtn;

                                            if(type === 'bundle'){
                                                name = '<a class="" title="Edit Bundle" onclick="editBundle('+ val['quotation_id'] +','+ val['item_id'] +')">' + val['name'] + '</a>';
                                            }else{
                                                name = val['name'];
                                                editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>';
                                            }

                                            $('.item-list tbody').append(
                                                '<tr>'
                                                +'<td>' + val['item_id'] + '</td>'
                                                +'<td>' + name + '</td>'
                                                +'<td>' + val['supplier'] + '</td>'
                                                +'<td class="item-list-cost" '+ costColHidden +'>' + val['actual_cost'] + '</td>'
                                                +'<td class="item-list-item-cost" '+ costColHidden +'>' + val['item_cost'] + '</td>'
                                                +'<td class="item-list-retail">' + val['retail'] + '</td>'
                                                +'<td class="item-list-qty">' + val['qty'] + '</td>'
                                                +'<td '+ costColHidden +'>' + val['total_cost'] + '</td>'
                                                +'<td>' + val['total_retail'] + '</td>'
                                                +'<td class="item-list-display-report" '+ costColHidden +'><input type="checkbox" id="item" name="item" onclick="updateDisplayStatus(this)" value="' + val['id'] + '" class="form-check-label" '+ checkboxStatus +'></td>'
                                                +'<td>'
                                                +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['quotation_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                                +'</td>'
                                                +'<td>' + editBtn +'</td>'
                                                +'</tr>'
                                            );
                                        
                                            $('.item-list-item-cost').addClass('editable');
                                            $('.item-list-retail').addClass('editable');
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
                                calculatePrices($('#price').val(), result['total_retail'], result['total_cost'], result['discount']);
                                
                                $("#editDetails").modal('hide');
                            }, error: function (data) {
                                        
                        }
                    });
                });

                $('#btnSaveChanges').click(function(){
                   
                    $.ajax({
                            url: "{{ url('admin/quotation/update-price-info') }}",
                            type: 'POST',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "quotation_id": $('#quotation_id').val(),
                                    "price": $('#price').val(),
                                    "discount": $('#discount').val(),
                                    "vat": $("#vat-lbl").text(),
                                    "total_vat": $("#quot-vat-lbl").text(),
                                    "total_cost": $("#total-cost-lbl").text(),
                                    "total_retail": $("#retail-lbl").text(),
                                    "quotation_vat": $("#quot-vat-lbl").text(),
                                    "price_after_discount":  $("#quot-price-lbl").text(),
                                    "quotation_margin": $("#quot-margin-lbl").text()
                                },
                                success: function (data) {
                                    var result = JSON.parse(data);

                                    if (result['code'] == 1) {
                                        window.location = '{{ url("admin/quotation") }}';
                                    
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
                        url: "{{ url('admin/quotation/add-items') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": isChecked.value,
                                "ischecked": ischecked,
                                "quotation_id":$('#quotation_id').val(),
                                "type": Itemtype
                            },
                            success: function (data) {
                                var result = JSON.parse(data);

                                $('.item-list tbody').empty();

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

                                        var type = val['type'];
                                            var name;
                                            var editBtn = '';

                                            if(type === 'bundle'){
                                                name = '<a class="" title="Edit Bundle" onclick="editBundle('+ val['quotation_id'] +','+ val['item_id'] +')">' + val['name'] + '</a>';
                                            }else{
                                                name = val['name'];
                                                editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>';
                                            }
                               
                                        $('.item-list tbody').append(
                                            '<tr>'
                                            +'<td>' + val['item_id'] + '</td>'
                                            +'<td>' + name + '</td>'
                                            +'<td>' + val['supplier'] + '</td>'
                                            +'<td class="item-list-cost" '+ costColHidden +'>' + val['actual_cost'] + '</td>'
                                            +'<td class="item-list-item-cost" '+ costColHidden +'>' + val['item_cost'] + '</td>'
                                            +'<td class="item-list-retail">' + val['retail'] + '</td>'
                                            +'<td class="item-list-qty">' + val['qty'] + '</td>'
                                            +'<td '+ costColHidden +'>' + val['total_cost'] + '</td>'
                                            +'<td>' + val['total_retail'] + '</td>'
                                            +'<td class="item-list-display-report" '+ costColHidden +'><input type="checkbox" id="item" name="item" onclick="updateDisplayStatus(this)" value="' + val['id'] + '" class="form-check-label" '+ checkboxStatus +'></td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['quotation_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            +editBtn
                                            +'</td>'
                                            +'</tr>'
                                        );
                                        
                                        $('.item-list-item-cost').addClass('editable');
                                        $('.item-list-retail').addClass('editable');
                                        $('.item-list-qty').addClass('editable');
                                    });
                                } 

                                calculatePrices(result['quotation_cost'], result['total_retail'], result['total_cost'], result['discount']);

                                if(Itemtype == 'main'){
                                    displaySubItemList(isChecked.value);
                                }
                            }, error: function (data) {
                                        
                        }
                });
            }

            function calculatePrices(quotationCost, totalRetail, totalCost, discount){

                if(typeof discount == "undefined"){
                    discount = 0;
                }else{
                    discount = parseFloat(discount);
                }

                var quotationPriceAfterDiscount = quotationCost - ((quotationCost * discount)/100);

                var quotationMargin = quotationPriceAfterDiscount - totalCost;
                var quotationMarginRate = Number((quotationMargin / quotationPriceAfterDiscount) * 100).toFixed(2);
                var quotationMarginVal = Number(quotationMargin).toFixed(2) + ' (' + quotationMarginRate + '%)';

                var vat_rate = $("#vat_rate").val();

                $("#margin").val(quotationMarginRate);

                var vatValue = (quotationPriceAfterDiscount * vat_rate) / 100;

                $("#quot-price-lbl").text(Number(quotationPriceAfterDiscount).toFixed(2));
                $("#total-cost-lbl").text(Number(totalCost).toFixed(2));
                $("#retail-lbl").text(Number(totalRetail).toFixed(2));

                $("#quot-margin-lbl").text(quotationMarginVal);
                $("#discount-lbl").text(discount);
                $("#vat-lbl").text(Number(vatValue).toFixed(2));
                $("#quot-vat-lbl").text(Number(vatValue + quotationPriceAfterDiscount).toFixed(2));
            }

            function updateDisplayStatus(isChecked){
              var ischecked = isChecked.checked;

                $.ajax({
                        url: "{{ url('admin/quotation/update-display-status') }}",
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

            function changeStatus(id, quotationId){

                $.ajax({
                        url: "{{ url('admin/quotation/delete-item') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id,
                                "quotation_id": quotationId
                            },
                            success: function (data) {
                                var result = JSON.parse(data);
                                $('.item-list tbody').empty();

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

                                        var type = val['type'];
                                        var name;
                                        var editBtn = '';

                                        if(type === 'bundle'){
                                            name = '<a class="" title="Edit Bundle" onclick="editBundle('+ val['quotation_id'] +','+ val['item_id'] +')">' + val['name'] + '</a>';
                                        }else{
                                            name = val['name'];
                                            editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>';
                                        }

                                        $('.item-list tbody').append(
                                            '<tr>'
                                            +'<td>' + val['item_id'] + '</td>'
                                            +'<td>' + name + '</td>'
                                            +'<td>' + val['supplier'] + '</td>'
                                            +'<td class="item-list-cost" '+ costColHidden +'>' + val['actual_cost'] + '</td>'
                                            +'<td class="item-list-item-cost" '+ costColHidden +'>' + val['item_cost'] + '</td>'
                                            +'<td class="item-list-retail">' + val['retail'] + '</td>'
                                            +'<td class="item-list-qty">' + val['qty'] + '</td>'
                                            +'<td '+ costColHidden +'>' + val['total_cost'] + '</td>'
                                            +'<td>' + val['total_retail'] + '</td>'
                                            +'<td class="item-list-display-report" '+ costColHidden +'><input type="checkbox" id="item" name="item" onclick="updateDisplayStatus(this)" value="' + val['id'] + '" class="form-check-label" '+ checkboxStatus +'></td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['quotation_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'+ editBtn +'</td>'
                                            +'</tr>'
                                        );
                                        
                                        $('.item-list-item-cost').addClass('editable');
                                        $('.item-list-retail').addClass('editable');
                                        $('.item-list-qty').addClass('editable');
                                    });
                                } 
                                calculatePrices($('#price').val(), result['total_retail'], result['total_cost'], result['discount']);
                            }, error: function (data) {
                                        
                        }
                });
            }

            function editDetails(id, actual_cost, qty, retail){
                $("#actual_cost").val(actual_cost);
                $("#qty").val(qty);
                $("#quotation_item_id").val(id);
                $("#retail").val(retail);
                $("#editDetails").modal('show');

                if($('#in_office').val() != 'yes'){
                    $("#actual_cost_edit").hide();
                }
            }

            function editBundle(quotationId, ItemId) {

                cuteAlert({
                    type: "question",
                    title: "Are you sure",
                    message: "You want to edit this bundle ?",
                    confirmText: "Yes",
                    cancelText: "Cancel"
                    }).then((e)=>{
                    if ( e == ("confirm")){
                            $.ajax({
                                url: "{{ url('admin/quotation/edit-bundle') }}",
                                type: 'POST',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "quotation_id": quotationId,
                                    "bundle_id": ItemId,
                                },
                                success: function (data) {
                                    var result = JSON.parse(data);

                                    $('.item-list tbody').empty();

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

                                            var type = val['type'];
                                            var name;
                                            var editBtn;

                                            if(type === 'bundle'){
                                                name = '<a class="" title="Edit Bundle" onclick="editBundle('+ val['quotation_id'] +','+ val['item_id'] +')">' + val['name'] + '</a>';
                                            }else{
                                                name = val['name'];
                                                editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>';
                                            }

                                            $('.item-list tbody').append(
                                                '<tr>'
                                                +'<td>' + val['item_id'] + '</td>'
                                                +'<td>' + name + '</td>'
                                                +'<td>' + val['supplier'] + '</td>'
                                                +'<td class="item-list-cost" '+ costColHidden +'>' + val['actual_cost'] + '</td>'
                                                +'<td class="item-list-item-cost" '+ costColHidden +'>' + val['item_cost'] + '</td>'
                                                +'<td class="item-list-retail">' + val['retail'] + '</td>'
                                                +'<td class="item-list-qty">' + val['qty'] + '</td>'
                                                +'<td '+ costColHidden +'>' + val['total_cost'] + '</td>'
                                                +'<td>' + val['total_retail'] + '</td>'
                                                +'<td class="item-list-display-report" '+ costColHidden +'><input type="checkbox" id="item" name="item" onclick="updateDisplayStatus(this)" value="' + val['id'] + '" class="form-check-label" '+ checkboxStatus +'></td>'
                                                +'<td>'
                                                +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['quotation_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                                +'</td>'
                                                +'<td>'+ editBtn +'</td>'
                                                +'</tr>'
                                            );
                                        
                                            $('.item-list-item-cost').addClass('editable');
                                            $('.item-list-retail').addClass('editable');
                                            $('.item-list-qty').addClass('editable');
                                        });
                                    } 

                                    calculatePrices(result['quotation_cost'], result['total_retail'], result['total_cost'], result['discount']);

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
                                    +'<td '+ costColHidden +'>' + val['cost_price'] + '</td>'
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
