<x-admin>
    @section('title')
        {{ 'Stock Management' }}
    @endsection

      
    <section class="content">
        <!-- Default box -->
        <div class="d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <h5 class="card-header  white-text text-left py-3">
                        {{ $title }}

                        <div class="card-tools">
                            <a href="{{ route('admin.stock.take') }}" class="btn btn-sm btn-primary">
                                <button type="button" class="btn btn-tool">
                                        <i class="fas fa-times"></i>
                                </button>
                            </a>
                        </div>
                    </h5>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('admin.stock.store-take') }}" method="POST"
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
                                                            <label for="comment" class="form-label">Comment</label>
                                                            <span class="required"> * </span><br>
                                                            <textarea class="form-control" name="comment" id="comment" rows="4" required>{{ $data->comment }}</textarea><br>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group text-left">
                                                            <label for="date" class="form-label">Date</label>
                                                            
                                                            @if(isset($data->created_at)) 
                                                            <input type="date" class="form-control datepicker" id="date" name="date" value="{{ date('Y-m-d', strtotime($data->created_at)) }}" readonly>
                                                            @else
                                                                <input type="date" class="form-control datepicker" id="date" name="date" value="" readonly>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-10 customer-details">
                                                <div class="text-left" style="margin-left:100px;margin-top: 25px;">
                                                    <table class="table table-bordered ">
                                                        <tr>
                                                            <td style="width:100px;"><p class="text-sm mb-0 text-bold">Total Cost :</p></td>
                                                            <td style="width:100px;"><p class="text-sm mb-0 text-bold"><span id="total-cost-lbl">{{ number_format($data->total_cost, 2) }}</span></p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:100px;"><p class="text-sm mb-0 text-bold">Total Retail :</p></td>
                                                            <td style="width:100px;"><p class="text-sm mb-0 text-bold"><span id="total-retail-lbl">{{ number_format($data->total_retail, 2) }}</span></p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:100px;"><p class="text-sm mb-0 text-bold">Total Cost Difference :</p></td>
                                                            <td style="width:100px;"><p class="text-sm mb-0 text-bold"><span id="total-cost-diff-lbl">{{ number_format($data->total_cost_diff, 2) }}</span></p></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:100px;"><p class="text-sm mb-0 text-bold">Total Retail Difference :</p></td>
                                                            <td style="width:100px;"><p class="text-sm mb-0 text-bold"><span id="total-retail-diff-lbl">{{ number_format($data->total_retail_diff, 2) }}</span></p></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="stock_take_id" id="stock_take_id" value="{{ $data->id }}">
                            </div>


                            <div class="add-items" style="display:block;">
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
                                                    <th class="th-sm">Item Cost</th>
                                                    <th class="th-sm">Item Retail</th>
                                                    <th class="th-sm">Book Stock</th>
                                                    <th class="th-sm item-list-qty">Physical Stock</th>
                                                    <th class="th-sm">Difference</th>
                                                    <th class="th-sm">Cost Difference</th>
                                                    <th class="th-sm">Retail Difference</th>
                                                    <th class="th-sm"></th>
                                                    <th class="th-sm"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                        @foreach ($itemList as $value)
                                                            <tr id="{{ $value['id'] }}">
                                                                <td>{{ $value['item_id'] }}</td>
                                                                <td>{{ $value['name'] }}</td>
                                                                <td>{{ $value['supplier'] }}</td>
                                                                <td class="item-list-item-cost">{{ $value['item_cost'] }}</td>
                                                                <td class="item-list-item-cost">{{ $value['retail'] }}</td>
                                                                <td class="item-list-qty">{{ $value['book_stock'] }}</td>
                                                                <td class="item-list-qty">{{ $value['physical_stock'] }}</td>
                                                                <td class="item-list-qty">{{ $value['diff'] }}</td>
                                                                <td class="item-list-total-cost">{{ $value['total_cost_diff'] }}</td>
                                                                <td class="item-list-total-cost">{{ $value['total_retail_diff'] }}</td>
                                                                <td>
                                                                    <a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus({{ $value['id'] }}, {{ $value['stock_take_id'] }})">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails({{ $value['id'] }}, {{ $value['item_cost'] }}, {{ $value['retail'] }}, {{ $value['physical_stock'] }}, {{ $value['book_stock'] }})">
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
                                <div class="row">
                                    <div class="col-lg-2">
                                        <button class="btn btn-primary btn-block" type="button" id="btnStockUpdate">Update Stock</button>
                                    </div>
                                    <div class="col-lg-2">
                                        <button class="btn btn-primary btn-block" type="submit" id="btnSaveChanges">Save Changes</button>
                                    </div>
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
                                <input type="hidden" value="stock_take" id="search_type" name="search_type">
                                <input type="hidden" value="{{ $data->id }}" id="stock" name="stock">

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
                            <input type="hidden" name="book_stock" value="" id="book_stock">
                            <input type="hidden" name="actual_cost" value="" id="actual_cost">
                            <input type="hidden" name="retail" value="" id="retail">

                            <div class="form-group">
                                <label for="qty" class="col-form-label">Physical Stock</label>
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
                        url: "{{ url('admin/stock/store-take') }}",
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
                                        window.location = '{{ url("admin/stock/take") }}';
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

                $('#formEditItem').submit(function(event){
                    event.preventDefault();

                    var formData = new FormData(this);
                    formData.append('stock_take_id', $('#stock_take_id').val());
                
                    $.ajax({
                        url: "{{ url('admin/stock/take-item-update') }}",
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

                                            var editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +','+ val['item_cost'] +','+ val['retail'] +','+ val['physical_stock']+','+ val['book_stock']+')"><i class="fas fa-edit"></i></a>';

                                            $('.item-list tbody').append(
                                                '<tr class="row_position" id="' + val['id'] + '" data-id="' + i + '">'
                                                +'<td>' + val['item_id'] + '</td>'
                                                +'<td>' + val['name'] + '</td>'
                                                +'<td>' + val['supplier'] + '</td>'
                                                +'<td class="item-list-cost">' + val['item_cost'] + '</td>'
                                                +'<td class="item-list-retail">' + val['retail'] + '</td>'
                                                +'<td class="">' + val['book_stock'] + '</td>'
                                                +'<td class="item-list-qty">' + val['physical_stock'] + '</td>'
                                                +'<td class="">' + val['diff'] + '</td>'
                                                +'<td class="item-list-total-cost">' + val['total_cost_diff'] + '</td>'
                                                +'<td>' + val['total_retail_diff'] + '</td>'
                                                +'<td>'
                                                +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['stock_take_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
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

                                calculatePrices(result['total_retail'], result['total_cost'], result['total_cost_diff'], result['total_retail_diff']);
                                $("#editDetails").modal('hide');
                            }, error: function (data) {
                                        
                        }
                    });
                });

                $('#btnStockUpdate').click(function(){

                    $.ajax({
                        url: "{{ url('admin/stock/stock-take-update-stock') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "stock_take_id":$('#stock_take_id').val(),
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
                                                window.location = '{{ url("admin/stock/take") }}';
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
                        url: "{{ url('admin/stock/add-stock-take-items') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": isChecked.value,
                                "ischecked": ischecked,
                                "stock_take_id":$('#stock_take_id').val(),
                                "type": Itemtype
                            },
                            success: function (data) {
                                var result = JSON.parse(data);

                                $('.item-list tbody').empty();

                                if (result['data'].length > 0) {
                                   
                                    $.each(result['data'], function (count, val) {

                                        var editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +','+ val['item_cost'] +','+ val['retail'] +','+ val['physical_stock']+','+ val['book_stock']+')"><i class="fas fa-edit"></i></a>';

                                        $('.item-list tbody').append(
                                            '<tr class="row_position" id="' + val['id'] + '" data-id="' + i + '">'
                                            +'<td>' + val['item_id'] + '</td>'
                                            +'<td>' + val['name'] + '</td>'
                                            +'<td>' + val['supplier'] + '</td>'
                                            +'<td class="item-list-cost">' + val['item_cost'] + '</td>'
                                            +'<td class="item-list-retail">' + val['retail'] + '</td>'
                                            +'<td class="">' + val['book_stock'] + '</td>'
                                            +'<td class="item-list-qty">' + val['physical_stock'] + '</td>'
                                            +'<td class="">' + val['diff'] + '</td>'
                                            +'<td class="item-list-total-cost">' + val['total_cost_diff'] + '</td>'
                                            +'<td>' + val['total_retail_diff'] + '</td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['stock_take_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            +editBtn
                                            +'</td>'
                                            +'</tr>'
                                        );
                                        $('.item-list-qty').addClass('editable');
                                    });
                                }

                                calculatePrices(result['total_retail'], result['total_cost'], result['total_cost_diff'], result['total_retail_diff']);
                                
                            }, error: function (data) {

                        }
                });
            }

            function calculatePrices(totalRetail, totalCost, totalCostDiff, totalRetailDiff){
                $("#total-cost-lbl").text(Number(totalCost).toFixed(2));
                $("#total-retail-lbl").text(Number(totalRetail).toFixed(2));
                $("#total-cost-diff-lbl").text(Number(totalCostDiff).toFixed(2));
                $("#total-retail-diff-lbl").text(Number(totalRetailDiff).toFixed(2));
            }

            function changeStatus(id, stock_take_id){

                $.ajax({
                        url: "{{ url('admin/stock/delete-stock-take-item') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id,
                                "stock_take_id": stock_take_id
                            },
                            success: function (data) {
                                var result = JSON.parse(data);
                                $('.item-list tbody').empty();

                                if (result['data'].length > 0) {
                                    
                                    $.each(result['data'], function (count, val) {
                                        var editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +','+ val['item_cost'] +','+ val['retail'] +','+ val['physical_stock']+','+ val['book_stock']+')"><i class="fas fa-edit"></i></a>';

                                        $('.item-list tbody').append(
                                            '<tr class="row_position" id="' + val['id'] + '" data-id="' + i + '">'
                                            +'<td>' + val['item_id'] + '</td>'
                                            +'<td>' + val['name'] + '</td>'
                                            +'<td>' + val['supplier'] + '</td>'
                                            +'<td class="item-list-cost">' + val['item_cost'] + '</td>'
                                            +'<td class="item-list-retail">' + val['retail'] + '</td>'
                                            +'<td class="">' + val['book_stock'] + '</td>'
                                            +'<td class="item-list-qty">' + val['physical_stock'] + '</td>'
                                            +'<td class="">' + val['diff'] + '</td>'
                                            +'<td class="item-list-total-cost">' + val['total_cost_diff'] + '</td>'
                                            +'<td>' + val['total_retail_diff'] + '</td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['stock_take_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            +editBtn
                                            +'</td>'
                                            +'</tr>'
                                        );

                                        $('.item-list-qty').addClass('editable');
                                    });
                                }
                                
                                calculatePrices(result['total_retail'], result['total_cost'], result['total_cost_diff'], result['total_retail_diff']);
                                
                            }, error: function (data) {

                        }
                });
            }

            function editDetails(id, cost, retail, qty,book_stock){
                $("#actual_cost").val(cost);
                $("#qty").val(qty);
                $("#book_stock").val(book_stock);
                $("#item_id").val(id);
                $("#retail").val(retail);

                $("#editDetails").modal('show');
            }

        </script>

    @endsection
</x-admin>
