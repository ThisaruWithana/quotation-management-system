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
              <form class="text-center border border-light p-5" action="" id="itemdetails" enctype="multipart/form-data" onsubmit="return false;">
                <div id="test-l-1" class="content">

                      <!-- <form class="text-center border border-light p-5" action="" id="itemCreate" onsubmit="return false;"> -->

                        <div class="row">
                          <div class="col-lg-5">
                              <div class="form-group text-left">
                                  <label for="product_code" class="form-label">Product Code</label>
                                  <input type="text" class="form-control" name="product_code" id="product_code"
                                  value="{{ $data->barcode['product_code'] }}" autocomplete="off"  readonly>
                              </div>
                          </div>
                          <div class="col-lg-5">
                              <div class="form-group text-left">
                                  <label for="barcode" class="form-label">Barcode</label>
                                  <input type="text" class="form-control" name="barcode" id="barcode"
                                  value="{{ $data->barcode['barcode'] }}" autocomplete="off"  readonly>
                              </div>
                          </div>
                        </div>
                          <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group text-left">
                                    <label for="supplier" class="form-label">Supplier</label>
                                    <span class="required"> * </span><br>
                                    <select id="supplier" name="supplier[]" class="selectpicker show-tick col-lg-6" data-live-search="true" multiple required>
                                        <option value="">Select Supplier</option>
                                        @foreach ($suppliers as $value)
                                        <option value="{{ $value->id }}"
                                        {{in_array($value->id, $selectedSuppliers) ? 'selected' : ''}}>{{ $value->name }}</option>
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
                                    <select id="department" name="department" class="selectpicker show-tick col-lg-6" data-live-search="true" required>
                                        <option value="">Select Department</option>
                                        @foreach ($departments as $value)
                                        <option value="{{ $value->id }}"
                                            {{ $value->id === $data->department_id ? 'selected' : '' }}>{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                          </div>
                          <div class="col-lg-6">
                              <div class="form-group text-left">
                                  <label for="sub_department" class="form-label">Sub Department</label>
                                  <span class="required"> * </span><br>
                                  <select id="sub_department" name="sub_department" class="selectpicker show-tick col-lg-6" data-live-search="true" required>
                                      <option value="">Select Sub Department</option>
                                      @foreach ($sub_departments as $value)
                                      <option value="{{ $value->id }}"
                                        {{ $value->id === $data->sub_department_id ? 'selected' : '' }}>{{ $value->name }}</option>
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
                                  value="{{ $data->department->vat['value'] }}" autocomplete="off"  readonly>
                              </div>
                          </div>
                        </div>

                            <div class="text-left">
                              <button class="btn btn-primary" type="button" onclick="stepper1.next()">Next</button>
                            </div>

                      <!-- </form> -->
                </div>
                <div id="test-l-2" class="content">

                  <!-- <form class="text-center border border-light p-5" action="" id="itemdetails" onsubmit="return false;"> -->

                          <div class="row">
                            <div class="col-lg-10">
                                <div class="form-group text-left">
                                    <label for="name" class="form-label">Item Name</label>
                                    <span class="required"> * </span>
                                    <input type="text" class="form-control" name="name" id="name"
                                    value="{{ $data['name'] }}" autocomplete="off"  placeholder="" required>
                                </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-10">
                                <div class="form-group text-left">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description">{{ $data['description'] }}</textarea>
                                </div>
                            </div>
                          </div>
                            <div class="row">
                              <div class="col-lg-5">
                                    <div class="form-group text-left">
                                        <label for="item_size" class="form-label">Item Size</label>
                                        <span class="required"> * </span>
                                        <input type="text" class="form-control" name="item_size" id="item_size"
                                        value="{{ $data['item_size'] }}" autocomplete="off"  placeholder="" required>
                                    </div>
                              </div>
                              <div class="col-lg-5">
                                  <div class="form-group text-left">
                                      <label for="margin_type" class="form-label">Margin Type</label>
                                      <span class="required"> * </span><br>
                                      <select id="margin_type" name="margin_type" class="selectpicker show-tick col-lg-6" required>
                                          <option value="Floating" @if ($data->margin_type == 'Floating') selected @endif>Floating</option>
                                          <option value="Fixed" @if ($data->margin_type == 'Fixed') selected @endif>Fixed</option>
                                      </select>
                                  </div>
                              </div>
                            </div>
                            <div class="row">
                            </div>

                            <div class="text-left">
                              <button class="btn btn-primary item-info" type="button"  onclick="stepper1.next()">Next</button>
                              <button class="btn btn-primary" onclick="stepper1.previous()">Previous</button>
                            </div>
                  <!-- </form> -->
                </div>
                <div id="test-l-3" class="content">

                  <!-- <form class="text-center border border-light p-5" action="" id="itemStockSettings" enctype="multipart/form-data" onsubmit="return false;"> -->

                          <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group text-left">
                                    <label for="min_stock" class="form-label">Min Stock</label>
                                    <span class="required"> * </span><br>
                                    <input type="text" class="form-control" name="min_stock" id="min_stock"
                                    value="{{ $data['min_stock'] }}" autocomplete="off"  placeholder="" required>
                                </div>
                            </div>
                              <div class="col-lg-5">
                                  <div class="form-group text-left">
                                      <label for="location" class="form-label">Location</label>
                                      <span class="required"> * </span><br>
                                      <select id="location" name="location" class="selectpicker show-tick col-lg-6" required>
                                          <option value="">Select Location</option>
                                          @foreach ($locations as $value)
                                          <option value="{{ $value->id }}"
                                              {{ $value->id === $data->location_id ? 'selected' : '' }}>{{ $value->name }}</option>
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

                                <div class="img-upload">
                                  @if ($data->image)
                                    <img class="item-img" src="{{ URL::to('/') }}/images/{{ $data->image }}" alt="{{ $data->name }}">
                                  @else
                                    <img class="item-img" src="" alt="" style="display:none;">
                                  @endif
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group text-left">
                                    <label for="in_stock" class="form-label">In Stock</label>
                                    <input type="text" class="form-control" name="in_stock" id="in_stock"
                                    value="" autocomplete="off"  placeholder="" readonly>
                                </div>
                            </div>
                          </div>
                          <div class="col-lg-3">
                              <div class="form-group text-left form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="auto_order" id="auto_order" @if($data->auto_order == 1) checked @endif/>
                                <label class="form-check-label" for="auto_order">Auto Order</label>
                              </div>
                          </div>
                          <div class="col-lg-3">
                            <div class="form-group text-left form-check">
                              <input class="form-check-input" type="checkbox" value="1" name="status" id="status" @if($data->status == 1) checked @endif/>
                              <label class="form-check-label" for="status">Active</label>
                            </div>
                          </div>
                          <div class="col-lg-3">
                            <div class="form-group text-left form-check">
                              <input class="form-check-input" type="checkbox" value="1" id="exclude_from_stock" name="exclude_from_stock" @if($data->exclude_from_stock == 1) checked @endif/>
                              <label class="form-check-label" for="exclude_from_stock">Exclude from stock</label>
                            </div>
                          </div>

                          <input type="hidden" class="form-control" name="item_id" id="item_id" value="{{ $data['id'] }}">

                            <div class="text-left">
                              <button class="btn btn-primary stock-setting" type="button" onclick="stepper1.next()">Next</button>
                              <button class="btn btn-primary" onclick="stepper1.previous()">Previous</button>
                            </div>
                  <!-- </form> -->
                </div>
                <div id="test-l-4" class="content">
                    <!-- <form class="text-center border border-light p-5" action="" id="itemOptionalItems" onsubmit="return false;"> -->

                            <div class="row">
                              <div class="col-lg-8">
                                  <div class="form-group text-left">
                                      <label for="case_size" class="form-label">Optional Items</label>
                                      <span class="required"> * </span>
                                      <select class="selectpicker  show-tick col-lg-8" data-live-search="true" id="optional_items" name="optional_items[]" multiple>
                                          <!-- <option value="">Select Items</option> -->
                                          @foreach ($itemList as $value)
                                            <option value="{{ $value->id }}"
                                          {{in_array($value->id, $selectedOptionalItems) ? 'selected' : ''}}>{{ $value->barcode->barcode }} - (Dep) {{ $value->department->name }} - {{ $value->name }}</option>
                                          @endforeach
                                      </select>
                                      <button class="btn btn-primary" type="button" id="addOptionalItems">Save</button>
                                  </div>
                              </div>
                            </div><br><br>
                            <div class="row">
                              <div class="col-lg-12">
                                <table class="table table-head-fixed text-nowrap text-left table-bordered" id="optionalItemTable" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">ID</th>
                                            <th class="th-sm">Name</th>
                                            <th class="th-sm">Barcode</th>
                                            <th class="th-sm">Department</th>
                                            <th class="th-sm">Cost Price</th>
                                            <th class="th-sm">Retail Price</th>
                                            <th class="th-sm">Is Mandatory</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($optionalItems as $value)
                                            <tr>
                                                <td>{{ $value->subitem->id }}</td>
                                                <td>{{ $value->subitem->name }}</td>
                                                <td>{{ $value->subitem->barcode->barcode }}</td>
                                                <td>{{ $value->subitem->department->name }}</td>
                                                <td>{{ $value->subitem->cost_price }}</td>
                                                <td>{{ $value->subitem->retail_price }}</td>
                                                <td><input type="checkbox" id="is_mandatory" name="is_mandatory" value="{{ $value->id }}" class="form-check-label"
                                                  @if($value->is_mandatory == 1) checked @endif></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                              </div>
                            </div>

                              <div class="text-left">
                              <button class="btn btn-primary" type="button" onclick="stepper1.next()">Next</button>
                                <button class="btn btn-primary" onclick="stepper1.previous()">Previous</button>
                              </div>
                    <!-- </form> -->
                </div>
                <div id="test-l-5" class="content">
                  <!-- <form class="text-center border border-light p-5" action="" id="itemPricingInfo" onsubmit="return false;"> -->

                          <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group text-left">
                                    <label for="case_size" class="form-label">Case Size</label>
                                    <span class="required"> * </span>
                                    <input type="text" class="form-control" name="case_size" id="case_size"
                                    value="{{ $data['case_size'] }}" autocomplete="off"  placeholder="" required>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group text-left">
                                    <label for="cost_price" class="form-label">Cost Price</label>
                                    <span class="required"> * </span>
                                    <input type="text" class="form-control" name="cost_price" id="cost_price"
                                    value="{{ $data['cost_price'] }}" autocomplete="off"  placeholder="" required>
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group text-left">
                                    <label for="retail_price" class="form-label">Retail Price</label>
                                    <span class="required"> * </span>
                                    <input type="text" class="form-control" name="retail_price" id="retail_price"
                                    value="{{ $data['retail_price'] }}" autocomplete="off"  placeholder="" required>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group text-left">
                                    <label for="margin" class="form-label">Margin (%)</label>
                                    <input type="text" class="form-control" name="margin" id="margin"
                                    value="{{ $data['margin'] }}" autocomplete="off"  placeholder="" readonly>
                                </div>
                            </div>
                          </div>

                            <div class="text-left">
                              <button class="btn btn-primary" type="submit">Save</button>
                              <button class="btn btn-primary" onclick="stepper1.previous()">Previous</button>
                            </div>
                  <!-- </form> -->
                </div>
                </form>
              </div>
            </div>
          </div>

        </div>
    </div>


    @section('js')

            <script>
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
</script>


    <script>

        $(document).ready(function() {

            $("#image").change(function(){
              $(".item-img").show();
                readURL(this);
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

            $("#itemdetails").submit(function(event) {
                event.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ url('admin/item/update') }}",
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
                                      window.location = '{{ url("admin/item") }}';
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

            $('#addOptionalItems').click(function(){

              if( $('#optional_items :selected').length > 0){

                  var selectednumbers = [];
                  $('#optional_items :selected').each(function(i, selected) {
                      selectednumbers[i] = $(selected).val();
                  });

                  $.ajax({
                    url: "{{ url('admin/item/store-sub-items') }}",
                    type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "item_list": selectednumbers,
                            "parent_id":  $('#item_id').val()
                        },
                        success: function (data) {
                            var result = JSON.parse(data);
                            $('#optionalItemTable tbody').empty();

                            if (result['data'].length > 0) {
                                $.each(result['data'], function (count, val) {

                                  $('#optionalItemTable tbody').append(
                                    '<tr>'
                                    +'<td>' + val['subitem']['id'] + '</td>'
                                    +'<td>' + val['subitem']['name'] + '</td>'
                                    +'<td>' + val['subitem']['barcode']['barcode'] + '</td>'
                                    +'<td>' + val['subitem']['department']['name'] + '</td>'
                                    +'<td>' + val['subitem']['cost_price'] + '</td>'
                                    +'<td>' + val['subitem']['retail_price'] + '</td>'
                                    +'<td><input type="checkbox" id="is_mandatory" name="is_mandatory" value="' + val['id'] + '" class="form-check-label"></td>'
                                    +'</tr>'
                                    );
                              });
                            }
                        }, error: function (data) {

                    }
                });
              }
            });

            $('#is_mandatory').click(function() {

              var ischecked = $(this).is(":checked");

              $.ajax({
                    url: "{{ url('admin/item/update-mandatory-status') }}",
                    type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": $(this).val(),
                            "ischecked": ischecked
                        },
                        success: function (data) {
                            var result = JSON.parse(data);

                        }, error: function (data) {

                    }
                });
            });

        });
    </script>
    @endsection
</x-admin>
