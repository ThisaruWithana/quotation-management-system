<x-admin>
    @section('title')  {{ 'Item Maintainance' }} @endsection
    <div class="card col-md-12">
        
        <form class="text-center border border-light p-2" action="" id="itemCreate" onsubmit="return false;">
        
            <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>
                <div class="card-tools">
                    <a>
                        <button class="btn btn-sm btn-primary" type="submit" id="btnSaveDetails">
                        <i class="fa fa-save"></i> &nbsp;Save
                        </button>
                    </a>

                    <a class="btn btn-sm btn-primary" onclick=softeDelete()><i class="fas fa-times"></i></a>
                </div>
            </div>

            <div class="card-body px-lg-2 pt-0">

                <div class="col-md-12">
                <div id="stepper1" class="bs-stepper">

                    <div class="bs-stepper-header">
                    <div class="step" data-target="#test-l-1">
                        <button type="button" class="btn step-trigger">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label">Create Item</span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#test-l-2">
                        <button type="button" class="btn step-trigger">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">Item Details</span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#test-l-3">
                        <button type="button" class="btn step-trigger">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">Stock Settings</span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#test-l-4">
                        <button type="button" class="btn step-trigger">
                        <span class="bs-stepper-circle">4</span>
                        <span class="bs-stepper-label">Optional Items</span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#test-l-5">
                        <button type="button" class="btn step-trigger">
                        <span class="bs-stepper-circle">5</span>
                        <span class="bs-stepper-label">Pricing Details</span>
                        </button>
                    </div>
                    </div>
                    <div class="bs-stepper-content">
                    <div id="test-l-1" class="content">
                                
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group text-left">
                                        <label for="product_code" class="form-label">Product Code</label>
                                        <span class="required"> * </span>
                                        <input type="text" class="form-control" name="product_code" id="product_code" required=""
                                        value="" autocomplete="off"  placeholder="">
                                        <span id="product-code-err" class="required"> </span>
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group text-left">
                                        <label for="supplier" class="form-label">Supplier</label>
                                        <span class="required"> * </span><br>
                                    <select id="supplier" name="supplier" class="selectpicker  show-tick col-lg-6" data-live-search="true" multiple required>
                                        <option value="">Select Supplier</option>
                                        @foreach ($suppliers as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group text-left">
                                        <label for="department" class="form-label">Department</label>
                                        <span class="required"> * </span><br>
                                        <select id="department" name="department" class="selectpicker form-control show-tick col-lg-6" data-live-search="true" required>
                                            <option value="">Select Department</option>
                                            @foreach ($departments as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            <div class="col-lg-6">
                                <div class="form-group text-left">
                                    <label for="sub_department" class="form-label">Sub Department</label>
                                    <span class="required"> * </span><br>
                                <select id="sub_department" name="sub_department" class="selectpicker form-control show-tick col-lg-6" data-live-search="true" required>
                                    <option value="">Select Sub Department</option>
                                    @foreach ($sub_departments as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group text-left">
                                        <label for="vat" class="form-label">Sales VAT (%)</label>
                                        <input type="text" class="form-control" name="vat" id="vat"
                                        value="" autocomplete="off"  readonly>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="text-left">
                                <button class="btn btn-primary" type="button" id="btnSubmit">Next</button>
                            </div>
            
                    </div>
                    <div id="test-l-2" class="content">

                        <!-- <form class="text-center border border-light" action="" id="itemdetails" onsubmit="return false;"> -->
                                
                                <div class="row">
                                <div class="col-lg-10">
                                    <div class="form-group text-left">
                                        <label for="name" class="form-label">Item Name</label>
                                        <span class="required"> * </span>
                                        <input type="text" class="form-control" name="name" id="name"
                                        value="" autocomplete="off"  placeholder="" required>
                                    </div>
                                </div>
                                </div>
                                
                                <div class="row">
                                <div class="col-lg-10">
                                    <div class="form-group text-left">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" name="description" id="description"
                                                    ></textarea>
                                    </div>
                                </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group text-left">
                                            <label for="item_size" class="form-label">Item Size</label>
                                            <span class="required"> * </span>
                                            <input type="text" class="form-control" name="item_size" id="item_size"
                                            value="" autocomplete="off"  placeholder="" required>
                                        </div>
                                    </div>
        
                                    <div class="col-lg-5">
                                        <div class="form-group text-left">
                                            <label for="margin_type">Margin Type</label>
                                            <span class="required"> * </span><br>
                                            <select id="margin_type" name="margin_type" class="selectpicker show-tick col-lg-5" required>
                                                <option value="Floating">Floating</option>
                                                <option value="Fixed">Fixed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-left">
                                    <button class="btn btn-primary item-info" type="submit" id="itemdetails">Next</button>
                                    <button class="btn btn-primary" onclick="stepper1.previous()">Previous</button>
                                </div>
                        <!-- </form> -->
                    </div>
                    <div id="test-l-3" class="content">
                        
                        <form class="text-center border border-light p-5" method="post" action="{{ url('admin/item/store-stock-settings') }}" id="stockDetails" enctype="multipart/form-data">
                                
                                <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group text-left">
                                        <label for="min_stock" class="form-label">Min Stock</label>
                                        <span class="required"> * </span>
                                        <input type="text" class="form-control" name="min_stock" id="min_stock"
                                        value="" autocomplete="off"  placeholder="" required>
                                    </div>
                                </div>
                                    <div class="col-lg-5">
                                        <div class="form-group text-left">
                                            <label for="location" class="form-label">Location</label>
                                            <span class="required"> * </span><br>
                                            <select id="location" name="location" class="selectpicker show-tick col-lg-5" data-live-search="true" required>
                                                <option value="">Select Location</option>
                                                @foreach ($locations as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" class="form-control" name="location_id" id="location_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group text-left">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" class="form-control" name="image" id="image"
                                        value="" autocomplete="off"  placeholder="">
                                    </div>

                                    <div class="img-upload" style="display:none;">
                                        <img class="item-img" src="" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group text-left">
                                        <label for="in_stock" class="form-label">In Stock</label>
                                        <input type="text" class="form-control" name="in_stock" id="in_stock"
                                        value="" autocomplete="off"  placeholder="" disabled>
                                    </div>
                                </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group text-left form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="auto_order" id="auto_order" checked/>
                                    <label class="form-check-label" for="auto_order">Auto Order</label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                <div class="form-group text-left form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="status" id="status"/>
                                    <label class="form-check-label" for="status">Active</label>
                                </div>
                                </div>
                                <div class="col-lg-3">
                                <div class="form-group text-left form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="exclude_from_stock" name="exclude_from_stock"/>
                                    <label class="form-check-label" for="exclude_from_stock">Exclude from stock</label>
                                </div>
                                </div>
                                
                                <input type="hidden" class="form-control" name="item_id" id="item_id">
                                
                                <div class="text-left">
                                    <button class="btn btn-primary stock-setting" id="stock-setting" type="submit">Next</button>
                                    <button class="btn btn-primary" onclick="stepper1.previous()">Previous</button>
                                </div>
                        </form>
                    </div>
                    <div id="test-l-4" class="content">
                            <form class="text-center border border-light" action="" id="itemOptionalItems" onsubmit="return false;">
                                    
                                    <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-md-3 col-lg-3 mb-1"style="float:right;">
                                        <button class="btn btn-primary btn-block" type="button" id="itemSearchBtn" data-toggle="modal" data-target="#exampleModal">
                                            <i class="fa fa-search-plus"></i>
                                            Find Items
                                        </button>
                                        </div>
                                    </div>
                                    </div><br><br>
                                    <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-head-fixed text-nowrap text-left" id="optionalItemTable">
                                            <thead>
                                                <tr>
                                                    <th class="th-sm">ID</th>
                                                    <th class="th-sm">Name</th>
                                                    <th class="th-sm">Barcode</th>
                                                    <th class="th-sm">Department</th>
                                                    <th class="th-sm">Cost Price</th>
                                                    <th class="th-sm">Retail Price</th>
                                                    <th class="th-sm">Is Mandatory</th>
                                                    <th class="th-sm"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>

                                    <div class="text-left">
                                    <button class="btn btn-primary" type="submit" onclick="stepper1.next()">Next</button>
                                        <button class="btn btn-primary" onclick="stepper1.previous()">Previous</button>
                                    </div>
                            </form>
                    </div>
                    <div id="test-l-5" class="content">
                        <form class="text-center border border-light" action="" id="itemPricingInfo" onsubmit="return false;">
                                
                                <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group text-left">
                                        <label for="case_size" class="form-label">Case Size</label>
                                        <span class="required"> * </span>
                                        <input type="text" class="form-control" name="case_size" id="case_size"
                                        value="" autocomplete="off"  placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group text-left">
                                        <label for="cost_price" class="form-label">Cost Price</label>
                                        <span class="required"> * </span>
                                        <input type="text" class="form-control" name="cost_price" id="cost_price"
                                        value="" autocomplete="off"  placeholder="" required>
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group text-left">
                                        <label for="retail_price" class="form-label">Retail Price</label>
                                        <span class="required"> * </span>
                                        <input type="text" class="form-control" name="retail_price" id="retail_price"
                                        value="" autocomplete="off"  placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group text-left">
                                        <label for="margin" class="form-label">Margin (%)</label>
                                        <input type="text" class="form-control" name="margin" id="margin"
                                        value="" autocomplete="off"  placeholder="" readonly>
                                    </div>
                                </div>
                                </div>
                                
                                <div class="text-left">
                                    <!-- <button class="btn btn-primary" type="submit">Save</button> -->
                                    <button class="btn btn-primary" onclick="stepper1.previous()">Previous</button>
                                </div>
                        </form>
                    </div>
                    </div>
                </div>
                </div>
            
            </div>
            
        </form>
        
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
                            <input type="hidden" value="sub_items" id="search_type" name="search_type">
                            <input type="hidden" name="id" id="id" value="">

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
    @section('js')
    <script>

      // Form stepper
      var stepper1Node = document.querySelector('#stepper1');
      var stepper1 = new Stepper(document.querySelector('#stepper1'));

      stepper1Node.addEventListener('show.bs-stepper', function (event) {
        console.warn('show.bs-stepper', event)
      });
      stepper1Node.addEventListener('shown.bs-stepper', function (event) {
        console.warn('shown.bs-stepper', event)
      });

    </script>

    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to hide all content divs
            function hideAllContentDivs() {
                document.querySelectorAll('.bs-stepper-content .content').forEach(function(contentDiv) {
                    contentDiv.style.display = 'none';
                });
            }

            // Function to show the relevant content div based on the data-target attribute
            function showRelevantContentDiv(targetId) {
                const targetDiv = document.querySelector(targetId);
                if (targetDiv) {
                    targetDiv.style.display = 'block';
                }
            }

            // Add event listeners to all step-trigger buttons
            document.querySelectorAll('.step .step-trigger').forEach(function(triggerBtn) {
                triggerBtn.addEventListener('click', function() {
                    const targetId = this.parentElement.getAttribute('data-target'); // Get data-target from parent .step div
                    hideAllContentDivs(); // Hide all content divs
                    showRelevantContentDiv(targetId); // Show the relevant content div
                });
            });


            const firstStepTrigger = document.querySelector('.step .step-trigger');
            if (firstStepTrigger) {
                firstStepTrigger.click();
            }
        });
    </script> -->

    <script>

        $(document).ready(function() {

            $("#image").change(function(){
              $(".img-upload").show();
                readURL(this);
            });

            $('#location').on('change', function() {
                $("#location_id").val(this.value);
            });

            $('#department').on('change', function() {

              var select = document.querySelector("[name=sub_department]");
  
                $.ajax({
                    url: "{{ url('admin/department/get-subdepartments-by-departments') }}",
                    type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "department": this.value,
                        },
                        success: function (data) {
                          select.innerHTML = "";

                            var result = JSON.parse(data);

                            if (result.length > 0) {
                                $.each(result, function (count, val) {
               
                                  $('#sub_department').append(
                                    '<option value="' + val['id'] + '">' + val['name'] + '</option>'
                                    );
                                  $(select).selectpicker('refresh');
                              });
                            } 

                        }, error: function (data) {
                                    
                    }
                });

                $.ajax({
                    url: "{{ url('admin/department/get-vat-value') }}",
                    type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "department": this.value,
                        },
                        success: function (data) {
                            var result = JSON.parse(data);
                            $('#vat').val(result['vat']);

                        }, error: function (data) {
                                    
                    }
                });
            });

            $("#product_code").keyup(function (event){
              event.preventDefault();

                $.ajax({
                    url: "{{ url('admin/item/validate-productcode') }}",
                    type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "code": this.value
                        },
                        success: function (data) {
                            console.log(data);
                            var result = JSON.parse(data);

                            if(result['code'] == 0){
                              $("#btnSubmit").prop('disabled', true);
                              $("#product-code-err").text(result['msg']);
                            }else{
                              $("#btnSubmit").prop('disabled', false);
                              $("#product-code-err").text('');
                            }
                        }, error: function (data) {      
                    }
                });

            });

            $("#retail_price").keyup(function (){

                $.ajax({
                    url: "{{ url('admin/item/calculate-margin') }}",
                    type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": $('#item_id').val(),
                            "retail_price": this.value,
                            "cost_price": $('#cost_price').val(),
                            "vat": $('#vat').val(),
                            "case_size": $('#case_size').val()
                        },
                        success: function (data) {
                            var result = JSON.parse(data);
                            $('#margin').val(result);
                        }, error: function (data) {
                                    
                    }
                });

            });

            $('#btnSubmit').click(function(event){
                event.preventDefault();
                
                $.ajax({
                    url: "{{ url('admin/item/store') }}",
                    type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "supplier": $('#supplier').val(),
                            "product_code": $('#product_code').val(),
                            "department": $('#department').val(),
                            "item_id": $('#item_id').val(),
                            "sub_department": $('#sub_department').val()
                        },
                        success: function (data) {

                            var result = JSON.parse(data);

                              if (result['code'] == 1) {
                                $('#item_id').val(result['data']);
                                $('#id').val(result['data']);
                                stepper1.next();
                              } else {
                                toastr.error(
                                  'Error',
                                  result['msg'],
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

            $('#itemdetails').click(function(event){
                event.preventDefault();

                $.ajax({
                    url: "{{ url('admin/item/store-details') }}",
                    type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "item_id": $('#item_id').val(),
                            "name": $('#name').val(),
                            "description": $('#description').val(),
                            "item_size": $('#item_size').val(),
                            "margin_type": $('#margin_type').val()
                        },
                            success: function (data) {
                            var result = JSON.parse(data);
                                    if (result['code'] == 1) {
                                      stepper1.next();
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

            $('#stock-setting').on('click', function (e) {
              
                var formData = new FormData();
            
                formData.append('image', $('input[name=image]')[0].files[0]);
                formData.append('item_id', $('input[name=item_id]').val());
                formData.append('min_stock', $('input[name=min_stock]').val());
                formData.append('location', $('input[name=location_id]').val());
                formData.append('exclude_from_stock', $('input[name=exclude_from_stock]').val());
                formData.append('auto_order', $('input[name=auto_order]').val());
                formData.append('status', $('input[name=status]').val());

                $.ajax({
                    url: "{{ url('admin/item/store-stock-settings') }}",
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
                                      stepper1.next();
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

            $("#stockDetails").submit(form2ajax);
            
            function form2ajax(evt) {
                evt.preventDefault();
                console.log(evt);
                var formData = new FormData(this);
                console.log(formData);

                $.ajax({
                    url:  "{{ url('admin/item/store-stock-settings') }}",
                    method: 'POST',
                    dataType:'JSON',
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(data) {
                        var result = data;

                        if (result['code'] == 1) {
                        stepper1.next();
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
                    }
                });
            
            }

            $('#btnSaveDetails').click(function(event){
                event.preventDefault();

                $.ajax({
                    url: "{{ url('admin/item/store-item-pricing') }}",
                    type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "item_id": $('#item_id').val(),
                            "cost_price": $('#cost_price').val(),
                            "retail_price": $('#retail_price').val(),
                            "margin": $('#margin').val(),
                            "case_size": $('#case_size').val()
                        },
                            success: function (data) {
                            var result = JSON.parse(data);
                                    if (result['code'] == 1) {
                                      window.location = '{{ url("admin/item/") }}';

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

        function updateMandatoryStatus(isChecked){
              var ischecked = isChecked.checked;

                $.ajax({
                    url: "{{ url('admin/item/update-mandatory-status') }}",
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
                                  +'<td class="item-search-cost">' + val['cost_price'] + '</td>'
                                  +'<td>' + val['retail_price'] + '</td>'
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
                url: "{{ url('admin/item/store-sub-items') }}",
                type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": isChecked.value,
                        "ischecked": ischecked,
                        "parent_id":  $('#item_id').val()
                    },
                    success: function (data) {
                        var result = JSON.parse(data);
                        $('#optionalItemTable tbody').empty();

                        if (result['data'].length > 0) {
                            $.each(result['data'], function (count, val) {

                              var isMandatory = val['is_mandatory'];
                              var checkboxStatus = '';

                                if(isMandatory === 1){
                                  checkboxStatus = 'checked';
                                }

                                $('#optionalItemTable tbody').append(
                                    '<tr>'
                                    +'<td>' + val['subitem']['id'] + '</td>'
                                    +'<td>' + val['subitem']['name'] + '</td>'
                                    +'<td>' + val['subitem']['barcode']['barcode'] + '</td>'
                                    +'<td>' + val['subitem']['department']['name'] + '</td>'
                                    +'<td>' + val['subitem']['cost_price'] + '</td>'
                                    +'<td>' + val['subitem']['retail_price'] + '</td>'
                                    +'<td><input type="checkbox" id="is_mandatory" name="is_mandatory" value="' + val['id'] + '" class="form-check-label" '+ checkboxStatus +'></td>'
                                    +'<td>'
                                    +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['parent_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                    +'</td>'
                                    +'</tr>'
                                );
                          });
                        }
                    }, error: function (data) {
                }
            });
      }

      function changeStatus(id, itemId){

        $.ajax({
                url: "{{ url('admin/item/delete-item') }}",
                type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                        "item_id": itemId
                    },
                    success: function (data) {
                        var result = JSON.parse(data);
                        $('#optionalItemTable tbody').empty();

                        if (result['data'].length > 0) {
                          
                            $.each(result['data'], function (count, val) {

                                var isMandatory = val['is_mandatory'];
                                var checkboxStatus = '';

                                if(isMandatory === 1){
                                checkboxStatus = 'checked';
                                }
                                console.log(result['data'].length);
                                $('#optionalItemTable tbody').append(
                                    '<tr>'
                                        +'<td>' + val['subitem']['id'] + '</td>'
                                        +'<td>' + val['subitem']['name'] + '</td>'
                                        +'<td>' + val['subitem']['barcode']['barcode'] + '</td>'
                                        +'<td>' + val['subitem']['department']['name'] + '</td>'
                                        +'<td>' + val['subitem']['cost_price'] + '</td>'
                                        +'<td>' + val['subitem']['retail_price'] + '</td>'
                                        +'<td><input type="checkbox" id="is_mandatory" name="is_mandatory" value="' + val['id'] + '" class="form-check-label" '+ checkboxStatus +'></td>'
                                        +'<td>'
                                        +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['parent_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                        +'</td>'
                                    +'</tr>'
                                );
                            });
                        }
                    }, error: function (data) {

                }
        });
      }

      function softeDelete() {

        if($('#item_id').val() != ''){
            cuteAlert({
                type: "error",
                title: "Are you sure",
                message: "You want to delete of this changes and go back?",
                buttonText: "Yes"
                }).then((e)=>{
                if ( e == ("ok")){
                        $.ajax({
                            url: "{{ url('admin/item/destroy') }}",
                            type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id":$('#item_id').val()
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
                                                window.location = '{{ url("admin/item") }}';
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
            window.location = '{{ url("admin/item") }}';
        }
      }
    </script>
    @endsection
</x-admin>