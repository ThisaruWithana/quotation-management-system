<x-admin>
   @section('title')  {{ 'Bundle Management' }} @endsection
    <section class="content">
        <!-- Default box -->
        <div class="d-flex justify-content-center">
            <div class="col-lg-10">
                <div class="card card-primary">
                <h5 class="card-header  white-text text-left py-3">
                    <!-- <strong>{{ $title }}</strong> -->
                    {{ $title }}
                </h5>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('admin.bundle.store') }}" method="PUT"
                    class="text-center border border-light p-5" id="bundleCreate">
                        @csrf
                        <div class="card-body px-lg-2 pt-0">
                                
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="col-lg-12">
                                            <div class="form-group text-left">
                                                <label for="name" class="form-label">Bundle Name</label>
                                                <span class="required"> * </span>
                                                <input type="text" class="form-control" name="name" id="name"
                                                    required="" value="{{ old('name') }}" autocomplete="off">
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
                                                    required="" value="{{ old('bundle_cost') }}"  autocomplete="off">
                                                    @error('bundle_cost')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                <div class="invalid-feedback">Bundle Cost is required.</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group text-left">
                                                <label for="remark" class="form-label">Remark</label>
                                                <textarea class="form-control" name="remark" id="remark"></textarea>
                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pricing-details">
                                        <div class="text-left" style="margin-left:100px;margin-top: 25px;">
                                            <table>
                                                <tr>
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
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Difference</b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="diff-lbl"></span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">Bundle Cost</b></p></td>
                                                    <td style="width:100px;"><p class="text-sm"><b class="d-block info-lb">: </b></p></td>
                                                    <td style="width:50px;"><p class="text-sm"><b class="d-block info-lb"><span id="bundle-cost-lbl"></span></b></p></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                               
                                <input type="hidden" class="form-control" name="bundle_id" id="bundle_id" value="">
                        </div>
                        <!-- /.card-body -->
                     <div class="col-lg-2">
                        <button class="btn btn-primary btn-block" type="submit" id="btnSave">Save</button>
                     </div><br>
                            
                    <div class="row add-items" style="display:none;">
                        <div class="col-lg-12">
                            <div class="col-lg-2">
                                <button class="btn btn-primary btn-block" type="button" id="itemSearchBtn" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fa fa-search-plus"></i> 
                                    Find Items
                                </button>
                            </div><br>

                            <div class="col-lg-12 table-responsive">
                                <table class="table bundle-item-list" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">Code</th>
                                            <th class="th-sm">Name</th>
                                            <!-- <th class="th-sm">Supplier</th> -->
                                            <th class="th-sm">Cost</th>
                                            <th class="th-sm">Actual Cost</th>
                                            <th class="th-sm">Retail</th>
                                            <th class="th-sm">Qty</th>
                                            <th class="th-sm">Total Cost</th>
                                            <th class="th-sm">Total Retail</th>
                                            <th class="th-sm">Display In Report</th>
                                            <th class="th-sm"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
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
                        class="text-center border border-light p-5" id="itemSearch" enctype="multipart/form-data" onsubmit="return false;">
                            @csrf
                            
                        <div class="row">
                            <div class="form-group">
                                <input type="text" class="form-control" name="keyword" id="keyword" 
                                    autocomplete="off"  placeholder="ID, Name, Description" onkeyup="searchItem(this.form)">
                            </div>
                            <input type="hidden" value="bundle_search" id="search_type" name="search_type">
                            <input type="hidden" value="" id="bundle" name="bundle">
                            
                            <!-- <div class="form-group">
                                <select id="status" name="status" class="selectpicker show-tick" data-live-search="false" onchange="searchItem(this.form)">
                                    <option value="">Status</option>        
                                    <option value="1">Active</option>     
                                    <option value="0">Deactive</option> 
                                </select>
                            </div> -->
                            <div class="form-group">
                                <select id="supplier" name="supplier" class="selectpicker show-tick" data-live-search="true" onchange="searchItem(this.form)">
                                    <option value="">Supplier</option>        
                                    @foreach ($suppliers as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach 
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <select id="departments" name="departments" class="selectpicker show-tick" data-live-search="true" onchange="searchItem(this.form)">
                                    <option value="">Departments</option>        
                                    @foreach ($departments as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach 
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <select id="sub_departments" name="sub_departments" class="selectpicker show-tick" data-live-search="true" onchange="searchItem(this.form)">
                                    <option value="">Sub Departments</option>        
                                    @foreach ($sub_departments as $value)
                                        <option value="{{ $value->id }}" >{{ $value->name }}</option>
                                    @endforeach 
                                </select>
                            </div>

                            <input type="hidden" name="form_action" value="search">

                            <!-- <div class="form-group text-right" style="margin-left:10px;">
                                <button class="btn btn-primary" type="submit">Find</button>
                            </div> -->
                        </div>

                        <div class="row">
                            
                            <div class="col-lg-12 table-responsive">
                                <table class="table table-item-search" id="dataTable">
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
                    <!-- <button type="button" class="btn btn-primary">Add</button> -->
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
                    <div class="form-group">
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

    </section>
    
    @section('js')
        <script>
            $(function() {
                $('#dataTable').DataTable({
                    "bPaginate": false,
                    "searching": false,
                    "ordering": true,
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
                                    $("#bundle_cost").prop('disabled', true);
                                    $("#remark").prop('disabled', true);
                                    
                                    $("#bundle_id").val(result['data']);
                                    $("#bundle").val(result['data']);
                                    
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
            });

            $('#bundle_cost').on('keyup', function(e) {
                calculatePrices(e.target.value, 0, 0);
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
                        url: "{{ url('admin/bundle/add-items') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": isChecked.value,
                                "ischecked": ischecked,
                                "bundle_id":$('#bundle_id').val(),
                            },
                            success: function (data) {
                                var result = JSON.parse(data);

                                $('.bundle-item-list tbody').empty();

                                if (result['data'].length > 0) {
                                    $.each(result['data'], function (count, val) {

                                        var displayReport = val['display_report'];
                                        var checkboxStatus = '';

                                        if(displayReport === 1){
                                            checkboxStatus = 'checked';
                                        }

                                        $('.bundle-item-list tbody').append(
                                            '<tr>'
                                            +'<td>' + val['item']['id'] + '</td>'
                                            +'<td>' + val['item']['name'] + '</td>'
                                            // +'<td>' + val['item']['name'] + '</td>'
                                            +'<td>' + val['actual_cost'] + '</td>'
                                            +'<td>' + val['actual_cost'] + '</td>'
                                            +'<td>' + val['retail'] + '</td>'
                                            +'<td>' + val['qty'] + '</td>'
                                            +'<td>' + val['total_cost'] + '</td>'
                                            +'<td>' + val['total_retail'] + '</td>'
                                            +'<td><input type="checkbox" id="item" name="item" onclick="updateDisplayStatus(this)" value="' + val['id'] + '" class="form-check-label" '+ checkboxStatus +'></td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['bundle_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['actual_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>'
                                            +'</td>'
                                            +'</tr>'
                                        );
                                    });
                                } 

                                calculatePrices(result['bundle_cost'], result['total_retail'], result['total_cost']);
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
                                    $.each(result['data'], function (count, val) {

                                        var displayReport = val['display_report'];
                                        var checkboxStatus = '';

                                        if(displayReport === 1){
                                            checkboxStatus = 'checked';
                                        }

                                        $('.bundle-item-list tbody').append(
                                            '<tr>'
                                            +'<td>' + val['item']['id'] + '</td>'
                                            +'<td>' + val['item']['name'] + '</td>'
                                            // +'<td>' + val['item']['name'] + '</td>'
                                            +'<td>' + val['actual_cost'] + '</td>'
                                            +'<td>' + val['actual_cost'] + '</td>'
                                            +'<td>' + val['retail'] + '</td>'
                                            +'<td>' + val['qty'] + '</td>'
                                            +'<td>' + val['total_cost'] + '</td>'
                                            +'<td>' + val['total_retail'] + '</td>'
                                            +'<td><input type="checkbox" id="item" name="item" onclick="updateDisplayStatus(this)" value="' + val['id'] + '" class="form-check-label" '+ checkboxStatus +'></td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['bundle_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['actual_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>'
                                            +'</td>'
                                            +'</tr>'
                                        );
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
                                    $.each(result['data'], function (count, val) {

                                        var displayReport = val['display_report'];
                                        var checkboxStatus = '';

                                        if(displayReport === 1){
                                            checkboxStatus = 'checked';
                                        }

                                        $('.bundle-item-list tbody').append(
                                            '<tr>'
                                            +'<td>' + val['item']['id'] + '</td>'
                                            +'<td>' + val['item']['name'] + '</td>'
                                            // +'<td>' + val['item']['name'] + '</td>'
                                            +'<td>' + val['actual_cost'] + '</td>'
                                            +'<td>' + val['actual_cost'] + '</td>'
                                            +'<td>' + val['retail'] + '</td>'
                                            +'<td>' + val['qty'] + '</td>'
                                            +'<td>' + val['total_cost'] + '</td>'
                                            +'<td>' + val['total_retail'] + '</td>'
                                            +'<td><input type="checkbox" id="item" name="item" onclick="updateDisplayStatus(this)" value="' + val['id'] + '" class="form-check-label" '+ checkboxStatus +'></td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['bundle_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['actual_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>'
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
                            calculatePrices(result['bundle_cost'], result['total_retail'], result['total_cost']);
                            
                            $("#editDetails").modal('hide');
                        }, error: function (data) {
                                    
                    }
                });
            });
        </script>
    @endsection
</x-admin>
