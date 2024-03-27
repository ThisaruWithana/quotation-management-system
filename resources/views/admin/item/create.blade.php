<x-admin>
    @section('title')  {{ 'Item Maintainance' }} @endsection
    <div class="card col-md-12">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
            <div class="card-tools">
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

                    <form class="text-center border border-light p-5" action="" id="itemCreate" onsubmit="return false;">
                        
                      <div class="row">
                        <div class="col-lg-10">
                            <div class="form-group text-left">
                                <label for="product_code" class="form-label">Product Code</label>
                                <span class="required"> * </span>
                                <input type="text" class="form-control" name="product_code" id="product_code" required=""
                                value="" autocomplete="off"  placeholder="">
                            </div>
                        </div>
                      </div>
                        <div class="row">
                        <div class="col-lg-10">
                            <div class="form-group text-left">
                                <label for="supplier" class="form-label">Supplier</label>
                                <span class="required"> * </span>
                            <select id="supplier" name="supplier" class="browser-default custom-select selectpicker" required>
                                <option value="">Select Supplier</option>
                                @foreach ($suppliers as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group text-left">
                                <label for="department" class="form-label">Department</label>
                                <span class="required"> * </span>
                            <select id="department" name="department" class="browser-default custom-select selectpicker" required>
                                <option value="">Select Department</option>
                                @foreach ($departments as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                      <div class="col-lg-5">
                          <div class="form-group text-left">
                              <label for="sub_department" class="form-label">Sub Department</label>
                              <span class="required"> * </span>
                          <select id="sub_department" name="sub_department" class="browser-default custom-select selectpicker" required>
                              <option value="">Select Sub Department</option>
                              @foreach ($sub_departments as $value)
                              <option value="{{ $value->id }}">{{ $value->name }}</option>
                              @endforeach
                          </select>
                          </div>
                      </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group text-left">
                                <label for="vat" class="form-label">Sales VAT (%)</label>
                                <input type="text" class="form-control" name="vat" id="vat"
                                value="" autocomplete="off"  readonly>
                            </div>
                        </div>
                      </div>
                          
                          <div class="text-left">
                            <button class="btn btn-primary" type="submit">Next</button>
                          </div>
             
                    </form>
              </div>
              <div id="test-l-2" class="content">

                <form class="text-center border border-light p-5" action="" id="itemdetails" onsubmit="return false;">
                        
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
                                                required=""></textarea>
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
                                    <label for="margin_type" class="form-label">Margin Type</label>
                                    <span class="required"> * </span>
                                    <select id="margin_type" name="margin_type" class="browser-default custom-select selectpicker" required>
                                        <option value="Floating">Floating</option>
                                        <option value="Fixed">Fixed</option>
                                    </select>
                                </div>
                            </div>
                          </div>
                          
                          <div class="text-left">
                            <button class="btn btn-primary item-info" type="submit">Next</button>
                            <button class="btn btn-primary" onclick="stepper1.previous()">Previous</button>
                          </div>
                </form>
              </div>
              <div id="test-l-3" class="content">
                
                <form class="text-center border border-light p-5" action="" id="itemStockSettings" enctype="multipart/form-data" onsubmit="return false;">
                        
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
                                    <span class="required"> * </span>
                                    <select id="location" name="location" class="browser-default custom-select selectpicker" required>
                                        <option value="">Select Location</option>
                                        @foreach ($locations as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
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
                            <button class="btn btn-primary stock-setting" type="submit">Next</button>
                            <button class="btn btn-primary" onclick="stepper1.previous()">Previous</button>
                          </div>
                </form>
              </div>
              <div id="test-l-4" class="content">
                <p class="text-center">test 4</p>
                <button class="btn btn-primary" onclick="stepper1.next()">Next</button>
                <button class="btn btn-primary" onclick="stepper1.previous()">Previous</button>
              </div>
              <div id="test-l-5" class="content">
                <form class="text-center border border-light p-5" action="" id="itemPricingInfo" onsubmit="return false;">
                        
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
                            <button class="btn btn-primary" type="submit">Save</button>
                            <button class="btn btn-primary" onclick="stepper1.previous()">Previous</button>
                          </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        </div>
    </div>
    @section('js')
    <!-- <script src="dist/js/bs-stepper.js"></script> -->
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

      // var stepper2 = new Stepper(document.querySelector('#stepper2'), {
      //   linear: false,
      //   animation: true
      // });
      // var stepper3 = new Stepper(document.querySelector('#stepper3'), {
      //   animation: true
      // });
      // var stepper4 = new Stepper(document.querySelector('#stepper4'));


      // Select picker
        const sorting = document.querySelector('.selectpicker');
        const commentSorting = document.querySelector('.selectpicker');
        const sortingchoices = new Choices(sorting, {
            placeholder: false,
            itemSelectText: ''
        });

        let sortingClass = sorting.getAttribute('class');
        window.onload= function () {
            sorting.parentElement.setAttribute('class', sortingClass);
        }
    </script>

    <script>

        $(document).ready(function() {

            $('#department').on('change', function() {
                $("#sub_department").empty();

                $.ajax({
                    url: "{{ url('admin/department/get-subdepartments-by-departments') }}",
                    type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "department": this.value,
                        },
                        success: function (data) {

                            var result = JSON.parse(data);

                            if (result.length > 0) {

                                $.each(result, function (count, val) {

                                  $('#sub_department').append(
                                    '<option value="' + val['id'] + '">' + val['name'] + '</option>'
                                    );
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

            $("#itemCreate").submit(function(event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ url('admin/item/store') }}",
                    type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "supplier": $('#supplier').val(),
                            "product_code": $('#product_code').val(),
                            "department": $('#department').val(),
                            "sub_department": $('#sub_department').val()
                        },
                        success: function (data) {

                            var result = JSON.parse(data);

                              if (result['code'] == 1) {
                                $('#item_id').val(result['data']);
                                stepper1.next();
                              } else {
                                toastr.error(
                                  'Error',
                                  result['msg'],
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

            $("#itemdetails").submit(function(event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ url('admin/item/store-details') }}",
                    type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": $('#item_id').val(),
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

            $("#itemStockSettings").submit(function(event) {
                event.preventDefault();

                var formData = new FormData(this);

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
                                                    window.location.reload();
                                                }
                                            }
                                        );
                                    }
                        }, error: function (data) {
                                    
                    }
                });
            });

            $("#itemPricingInfo").submit(function(event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ url('admin/item/store-item-pricing') }}",
                    type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": $('#item_id').val(),
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
    </script>
    @endsection
</x-admin>