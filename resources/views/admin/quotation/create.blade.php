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
                                                
                                                <div class="col-lg-12">
                                                    <div class="form-group text-left">
                                                        <label for="customer" class="form-label">Client</label>
                                                        <span class="required"> * </span><br>
                                                        <select id="customer" name="customer" class="selectpicker show-tick col-lg-12" data-live-search="true" required>
                                                            <option value="">Select Client</option>
                                                            @foreach ($customers as $value)
                                                            <option value="{{ $value->id }}">{{ $value->code }} - {{ $value->name }}</option>
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
                                </div>
                                
                                <div class="col-lg-2">
                                    <button class="btn btn-primary btn-block" type="submit" id="btnSave">Save</button>
                                </div> 
                            <hr>
              
                            <div class=" add-items" style="display:none;">

                                    <div class="row">
                                        <div class="col-lg-6">
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
                                        <div class="col-lg-3">
                                            <div class="form-group text-left">
                                                <label for="bundle_cost" class="form-label">Bundle Cost</label>
                                                <input type="text" class="form-control" id="bundle_cost" name="bundle_cost" readonly>
                                            </div>
                                        </div>  
                                        <div class="col-lg-3">
                                            <div class="form-group text-left">
                                                <label for="discount" class="form-label">Discount</label>
                                                <input type="text" class="form-control" id="discount" name="discount" value="" autocomplete="off">
                                            </div>
                                        </div>                                
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group text-left">
                                                <label for="price" class="form-label">Quotation Price</label>
                                                <span class="required"> * </span><br>
                                                <input type="text" class="form-control" id="price" name="price" value="" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group text-left">
                                                <label for="margin" class="form-label">Quotation Margin</label>
                                                <input type="text" class="form-control" id="margin" name="margin" value="" readonly>
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

                                            <div class="col-lg-12 table-responsive">
                                                <table class="table item-list table-bordered" id="dataTable" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="th-sm">Code</th>
                                                            <th class="th-sm">Name</th>
                                                            <th class="th-sm">Supplier</th>
                                                            <th class="th-sm">Cost</th>
                                                            <th class="th-sm">Actual Cost</th>
                                                            <th class="th-sm">Retail</th>
                                                            <th class="th-sm">Qty</th>
                                                            <th class="th-sm">Total Cost</th>
                                                            <th class="th-sm">Total Retail</th>
                                                            <th class="th-sm">Display In Report</th>
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
                                                <tr>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb">Item Cost </b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="item-cost-lbl"></span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Extra Item Cost </b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="extra-item-lbl"></span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Total Cost </b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="total-cost-lbl"></span></b></p></td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="col-lg-4">
                                            <table>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Item Retail </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="item-retail-lbl"></span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:150px;"><p class="text-sm"><b class="d-block info-lb">Extra Item Retail </b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="extra-item-lbl"></span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Total Retail </b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="retail-lbl"></span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Item Retail Margin</b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="item-retail-margin-lbl"></span></b></p></td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="col-lg-4">
                                            <table>
                                                <tr>
                                                    <td style="width:150px;"><p class="text-sm"><b class="d-block info-lb">Quot. Price </b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="quot-price-lbl"></span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Quot. Margin </b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="quot-margin-lbl"></span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">VAT</b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="vat-lbl"></span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Quot. + VAT</b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="quot-vat-lbl"></span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Extra Item Margin</b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="extra-item-margin-lbl"></span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Margin</b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="margin-lbl"></span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Discount</b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="discount-lbl"></span></b></p></td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="col-lg-2">
                                            <button class="btn btn-primary btn-block" type="button" id="btnSaveChanges">Save Changes</button>
                                        </div>
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
                                            <th class="th-sm">Cost</th>
                                            <th class="th-sm">Actual Cost</th>
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
          
                    <div class="form-group">
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

                $('.add-description').click(function(){
                    $('.add-description-history').show();
                });

                $('#description_dropdown').on('change', function() {
                    var txt = $.trim(this.value);
                    $('#description').append(txt);
                    $('.add-description-history').hide();
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
                        url: "{{ url('admin/bundle/get-details') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": this.value
                            },
                            success: function (data) {
                                var result = JSON.parse(data);

                                $("#bundle_cost").val(result['bundle_cost']);

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
                                        $.each(result['data'], function (count, val) {

                                            var displayReport = val['display_report'];
                                            var checkboxStatus = '';

                                            if(displayReport === 1){
                                                checkboxStatus = 'checked';
                                            }

                                            $('.item-list tbody').append(
                                                '<tr>'
                                                +'<td>' + val['item_id'] + '</td>'
                                                +'<td>' + val['name'] + '</td>'
                                                +'<td>' + val['supplier'] + '</td>'
                                                +'<td>' + val['actual_cost'] + '</td>'
                                                +'<td>' + val['item_cost'] + '</td>'
                                                +'<td>' + val['retail'] + '</td>'
                                                +'<td>' + val['qty'] + '</td>'
                                                +'<td>' + val['total_cost'] + '</td>'
                                                +'<td>' + val['total_retail'] + '</td>'
                                                +'<td><input type="checkbox" id="item" name="item" onclick="updateDisplayStatus(this)" value="' + val['id'] + '" class="form-check-label" '+ checkboxStatus +'></td>'
                                                +'<td>'
                                                +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['quotation_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                                +'</td>'
                                                +'<td>'
                                                +'<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>'
                                                +'</td>'
                                                +'</tr>'
                                            );
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
                                calculatePrices($('#price').val(), result['total_retail'], result['total_cost'], result['total_item_cost'], result['total_item_retail']);
                                
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
                                    "margin": $('#margin').val(),
                                    "item_cost": $("#item-cost-lbl").text(),
                                    "item_retail": $("#item-retail-lbl").text(),
                                    "vat": $("#vat-lbl").text(),
                                    "total_vat": $("#quot-vat-lbl").text(),
                                    "item_retail_margin": $("#item-retail-margin-lbl").text(),
                                    "total_cost": $("#total-cost-lbl").text(),
                                    "total_retail": $("#retail-lbl").text(),
                                    "quotation_vat": $("#quot-vat-lbl").text(),
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
                                $.each(result, function (count, val) {
                    
                                    $('.table-item-search tbody').append(
                                        '<tr>'
                                        +'<td>' + val['id'] + '</td>'
                                        +'<td>' + val['name'] + '</td>'
                                        +'<td>' + val['department']+ '</td>'
                                        +'<td>' + val['supplier'] + '</td>'
                                        +'<td>' + val['cost_price'] + '</td>'
                                        +'<td>' + val['cost_price'] + '</td>'
                                        +'<td><input type="checkbox" id="item" name="item" onclick="selectItem(this)" value="' + val['id'] + '" class="form-check-label"></td>'
                                        +'</tr>'
                                    );
                                });
                            } 
                        }, error: function (data) {
                                    
                    }
                });
            }

            function selectItem(isChecked){
              var ischecked = isChecked.checked;

                $.ajax({
                        url: "{{ url('admin/quotation/add-items') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": isChecked.value,
                                "ischecked": ischecked,
                                "quotation_id":$('#quotation_id').val(),
                            },
                            success: function (data) {
                                var result = JSON.parse(data);

                                $('.item-list tbody').empty();

                                if (result['data'].length > 0) {
                                    $.each(result['data'], function (count, val) {

                                        var displayReport = val['display_report'];
                                        var checkboxStatus = '';

                                        if(displayReport === 1){
                                            checkboxStatus = 'checked';
                                        }

                                        $('.item-list tbody').append(
                                            '<tr>'
                                            +'<td>' + val['item_id'] + '</td>'
                                            +'<td>' + val['name'] + '</td>'
                                            +'<td>' + val['supplier'] + '</td>'
                                            +'<td>' + val['actual_cost'] + '</td>'
                                            +'<td>' + val['item_cost'] + '</td>'
                                            +'<td>' + val['retail'] + '</td>'
                                            +'<td>' + val['qty'] + '</td>'
                                            +'<td>' + val['total_cost'] + '</td>'
                                            +'<td>' + val['total_retail'] + '</td>'
                                            +'<td><input type="checkbox" id="item" name="item" onclick="updateDisplayStatus(this)" value="' + val['id'] + '" class="form-check-label" '+ checkboxStatus +'></td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['quotation_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>'
                                            +'</td>'
                                            +'</tr>'
                                        );
                                    });
                                } 

                                calculatePrices($('#price').val(), result['total_retail'], result['total_cost'], result['total_item_cost'], result['total_item_retail']);
                            }, error: function (data) {
                                        
                        }
                });
            }

            function calculatePrices(quotationCost, totalRetail, totalCost, itemCost, itemRetail){
                $("#quot-price-lbl").text(Number(quotationCost).toFixed(2));

                $("#total-cost-lbl").text(Number(totalCost).toFixed(2));
                $("#item-cost-lbl").text(Number(itemCost).toFixed(2));

                $("#item-retail-lbl").text(Number(itemRetail).toFixed(2));
                $("#retail-lbl").text(Number(totalRetail).toFixed(2));
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
                                    $.each(result['data'], function (count, val) {

                                        var displayReport = val['display_report'];
                                        var checkboxStatus = '';

                                        if(displayReport === 1){
                                            checkboxStatus = 'checked';
                                        }

                                        $('.item-list tbody').append(
                                            '<tr>'
                                            +'<td>' + val['item_id'] + '</td>'
                                            +'<td>' + val['name'] + '</td>'
                                            +'<td>' + val['supplier'] + '</td>'
                                            +'<td>' + val['actual_cost'] + '</td>'
                                            +'<td>' + val['item_cost'] + '</td>'
                                            +'<td>' + val['retail'] + '</td>'
                                            +'<td>' + val['qty'] + '</td>'
                                            +'<td>' + val['total_cost'] + '</td>'
                                            +'<td>' + val['total_retail'] + '</td>'
                                            +'<td><input type="checkbox" id="item" name="item" onclick="updateDisplayStatus(this)" value="' + val['id'] + '" class="form-check-label" '+ checkboxStatus +'></td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['quotation_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>'
                                            +'</td>'
                                            +'</tr>'
                                        );
                                    });
                                } 
                                calculatePrices($('#price').val(), result['total_retail'], result['total_cost'], result['total_item_cost'], result['total_item_retail']);
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
            }

        </script>
    @endsection
</x-admin>
