<x-admin>
   @section('title')  {{ 'Order Processing Form' }} @endsection
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
                    <form action="#" method="PUT" class="text-center border border-light p-5" id="formCreate">
                         @csrf
                        <div class="card-body px-lg-2 pt-0">
                            <div class="row text-left">
                                
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group text-left">
                                                <label for="opf_date" class="form-label">OPF Date</label>
                                                <input type="date" class="form-control datepicker" id="opf_date" name="opf_date" value="{{ $opfDetails->created_at->format('Y-m-d') }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group text-left">
                                                <label for="installation_date" class="form-label">Installation Date</label>
                                                @if($opfDetails->installation_date != '')
                                                    <input type="date" class="form-control datepicker" id="installation_date" name="installation_date" value="{{ date('Y-m-d',strtotime($opfDetails->installation_date)) }}">
                                                @else
                                                    <input type="date" class="form-control datepicker" id="installation_date" name="installation_date" value="">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group text-left">
                                                <label for="symbol_group" class="form-label">Symbol Group</label>
                                                <input type="text" class="form-control" id="symbol_group" name="symbol_group" value="{{ $opfDetails->symbol_group }}">
                                            </div>
                                        </div>
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
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group text-left">
                                                <label for="is_installed" class="form-label">Mark As Installed</label> &nbsp;&nbsp; &nbsp;&nbsp;
                                                <input type="checkbox" id="is_installed" name="is_installed" value="" class="form-check-label"
                                                @if($opfDetails['status'] == 2) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td style="width:150px;"><p class="text-sm mb-0 text-bold">Customer Name :</p></td>
                                            <td style="width:auto;"><p class="text-sm  mb-0"><span id="cus-name-lbl">{{ $data['customer']['name'] }}</span></p></td>
                                        </tr>
                                        <tr>
                                            <td style="width:120px;"><p class="text-sm mb-0 text-bold">Quot. Date :</p></td>
                                            <td style="width:auto;"><p class="text-sm  mb-0"><span id="cus-address-lbl">{{ date('d-m-Y', strtotime($data['created_at'])) }}</span></p></td>
                                        </tr>
                                        <tr>
                                            <td style="width:100px;"><p class="text-sm mb-0 text-bold">Quot. Ref :</p></td>
                                            <td style="width:auto;"><p class="text-sm  mb-0"><span id="cus-tel-lbl">{{ $data['ref'] }}</span></p></td>
                                        </tr>
                                        <tr>
                                            <td style="width:100px;"><p class="text-sm mb-0 text-bold">Description :</p></td>
                                            <td style="width:auto;"><p class="text-sm  mb-0"><span id="cus-email-lbl">{{ $data['description'] }}</span></p></td>
                                        </tr>
                                    </table>

                                    <input type="hidden" name="opf_id" id="opf_id" value="{{ $opfDetails['id'] }}">
                                    <input type="hidden" name="vat_rate" id="vat_rate" value="{{ $vat_rate[0] }}">
                                    <input type="hidden" name="row_order" id="row_order" value="">
                                </div>

                            </div>
                            <hr>

                            <div class="add-items">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-lg-2" style="float:right;">
                                            <button class="btn btn-primary btn-block" type="button" id="itemSearchBtn" data-toggle="modal" data-target="#exampleModal">
                                                <i class="fa fa-search-plus"></i> 
                                                Find Items
                                            </button>
                                        </div>
                                    </div>
                                </div><br>
                                    
                                <div class="table-responsiv">
                                    <table class="table item-list table-bordered" id="sortable-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="th-sm">Code</th>
                                                <th class="th-sm">Name</th>
                                                <th class="th-sm">Supplier</th>
                                                <th class="th-sm item-list-item-cost">Item Cost</th>
                                                <th class="th-sm item-list-qty">Qty</th>
                                                <th class="th-sm item-list-total-cost">Total Cost</th>
                                                <th class="th-sm">Stock</th>
                                                <th class="th-sm item-list-on-order">On Order</th>
                                                <th class="th-sm item-list-order-qty">Order Qty</th>
                                                <th class="th-sm"></th>
                                                <th class="th-sm"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($quotationItems as $value)
                                                <tr id="{{ $value['id'] }}">
                                                    <td>{{ $value['item_id'] }}</td>
                                                    <td>
                                                        @if($value['type'] === 'bundle')
                                                            <a class="" title="Edit Bundle" onclick="editBundle({{ $value['opf_id'] }},{{ $value['item_id'] }})">
                                                                {{ $value['name'] }}
                                                            </a>
                                                        @else
                                                            {{ $value['name'] }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $value['supplier'] }}</td>
                                                    <td class="item-list-item-cost">{{ $value['item_cost'] }}</td>
                                                    <td class="item-list-qty">{{ $value['qty'] }}</td>
                                                    <td class="item-list-total-cost">{{ $value['total_cost'] }}</td>
                                                    <td>{{ $value['in_stock'] }}</td>
                                                    <td class="item-list-on-order">{{ $value['on_order'] }}</td>
                                                    <td class="item-list-order-qty">{{ $value['order_qty'] }}
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus({{ $value['id'] }}, {{ $value['opf_id'] }})">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if($value['type'] != 'bundle')
                                                            <a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails({{ $value['id'] }}, {{ $value['item_cost'] }}, {{ $value['qty'] }}, '{{ $value['on_order'] }}', {{ $value['order_qty'] }})">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <br><hr>

                            <div class="row">
                    
                                <div class="col-lg-4 text-left">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td style="width: 150px;;"><p class="text-sm mb-0"><b class="d-block info-lb">Quot. Price :</b></p></td>
                                            <td style="width:100px;"><p class="text-sm mb-0"><b class="d-block info-lb"><span id="quot-price-lbl">{{ number_format($price_after_discount, 2) }}</span></b></p></td>
                                        </tr>
                                        <tr id="lbl-cost-details">
                                            <td style="width:150px;"><p class="text-sm mb-0"><b class="d-block info-lb">Quot. Cost :</b></p></td>
                                            <td style="width:100px;"><p class="text-sm mb-0"><b class="d-block info-lb"><span id="total-cost-lbl">{{ number_format($total_cost, 2) }}</span></b></p></td>
                                        </tr>
                                        <tr>
                                            <td style="width:150px;"><p class="text-sm mb-0"><b class="d-block info-lb">OPF Cost :</b></p></td>
                                            <td style="width:100px;"><p class="text-sm mb-0"><b class="d-block info-lb"><span id="opf-cost-lbl">{{ number_format($total_opf_cost, 2) }}</span></b></p></td>
                                        </tr>
                                        <tr>
                                            <td style="width:150px;"><p class="text-sm mb-0"><b class="d-block info-lb">Gross Profit :</b></p></td>
                                            <td style="width:100px;"><p class="text-sm mb-0"><b class="d-block info-lb"><span id="profit-lbl">{{ number_format($price_after_discount - $total_opf_cost, 2) }}</span></b></p></td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-lg-4 text-left">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td style="width:150px;"><p class="text-sm mb-0"><b class="d-block info-lb">Quot. Margin (%) :</b></p></td>
                                            <td style="width:100px;"><p class="text-sm mb-0"><b class="d-block info-lb"><span id="quot-margin-lbl"> {{ $data->margin }}</span></b></p></td>
                                        </tr>
                                        <tr>
                                            <td style="width:150px;"><p class="text-sm mb-0"><b class="d-block info-lb">OPF Margin (%) :</b></p></td>
                                            <td style="width: 100px;"><p class="text-sm mb-0"><b class="d-block info-lb"><span id="opf-margin-lbl"> {{ $opfDetails->margin }}</span></b></p></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <br>
                                    
                                <div class="row">
                                    <div class="col-lg-1">
                                        <a href="{{ url('admin/opf/print',encrypt($data->id)) }}">
                                            <button class="btn btn-primary btn-block" type="button" id="printBtn">Print</button>
                                        </a>
                                    </div>
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
                            <input type="hidden" value="opf" id="search_type" name="search_type">
                            <input type="hidden" value="{{ $opfDetails['id'] }}" id="opf" name="opf">

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
                    <input type="hidden" name="item_id" value="" id="item_id">
                    <input type="hidden" name="bundleId" value="" id="bundleId">
          
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
                    <div class="form-group">
                        <label for="on_order" class="col-form-label">On Order</label>
                        <input type="text" class="form-control" id="on_order" name="on_order"  
                            value="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="order_qty" class="col-form-label">Order Qty</label>
                        <input type="text" class="form-control" id="order_qty" name="order_qty"  
                             value="" autocomplete="off">
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

                $('#sortable-table').DataTable({
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
                    "bInfo" : false,
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
                $('.item-list-qty').addClass('editable');
                $('.item-list-on-order').addClass('editable');
                $('.item-list-order-qty').addClass('editable');

                $('#bundle').on('change', function() {

                    $.ajax({
                        url: "{{ url('admin/opf/add-bundle') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "bundle": this.value,
                                "opf_id":$('#opf_id').val(),
                            },
                            success: function (data) {
                                var result = JSON.parse(data);

                                $("#bundle_cost").val(result['bundle_cost']);
                                $('.item-list tbody').empty();

                                if (result['data'].length > 0) {

                                    $.each(result['data'], function (count, val) {

                                        var type = val['type'];
                                        var name;
                                        var editBtn = '';

                                        if(type === 'bundle'){
                                            name = '<a class="" title="Edit Bundle" onclick="editBundle('+ val['opf_id'] +','+ val['item_id'] +')">' + val['name'] + '</a>';
                                        }else{
                                            name = val['name'];
                                            editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', \'' + val['on_order'] + '\', '+ val['order_qty'] +' )"><i class="fas fa-edit"></i></a>';
                                        }

                                        $('.item-list tbody').append(
                                                '<tr>'
                                                +'<td>'+ val['item_id'] +'</td>'
                                                +'<td>'+ name +'</td>'
                                                +'<td>'+ val['supplier'] +'</td>'
                                                +'<td class="item-list-item-cost">'+ val['item_cost'] +'</td>'
                                                +'<td class="item-list-qty">'+ val['qty'] +'</td>'
                                                +'<td class="item-list-total-cost">'+ val['total_cost'] +'</td>'
                                                +'<td></td>'
                                                +'<td class="item-list-on-order">'+ val['on_order'] +'</td>'
                                                +'<td class="item-list-order-qty">'+ val['order_qty'] +'</td>'
                                                +'<td>'
                                                +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['opf_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                                +'</td>'
                                                +'<td>'
                                                +editBtn
                                                +'</td>'
                                                +'</tr>'
                                            );
                                        
                                            $('.item-list-item-cost').addClass('editable');
                                            $('.item-list-qty').addClass('editable');
                                            $('.item-list-on-order').addClass('editable');
                                            $('.item-list-order-qty').addClass('editable');
                                    });
                                } 
                                calculatePrices(result['price_after_discount'], result['total_cost']);
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
                    formData.append('opf_id', $('#opf_id').val());
                
                    $.ajax({
                        url: "{{ url('admin/opf/item-update') }}",
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

                                            var type = val['type'];
                                            var name;
                                            var editBtn = ' ';

                                            if(type === 'bundle'){
                                                name = '<a class="" title="Edit Bundle" onclick="editBundle('+ val['opf_id'] +','+ val['item_id'] +')">' + val['name'] + '</a>';
                                            }else{
                                                name = val['name'];
                                                editBtn = '<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', \'' + val['on_order'] + '\', '+ val['order_qty'] +' )"><i class="fas fa-edit"></i></a>';
                                            }

                                            $('.item-list tbody').append(
                                                '<tr>'
                                                +'<td>'+ val['item_id'] +'</td>'
                                                +'<td>'+ name +'</td>'
                                                +'<td>'+ val['supplier'] +'</td>'
                                                +'<td class="item-list-item-cost">'+ val['item_cost'] +'</td>'
                                                +'<td class="item-list-qty">'+ val['qty'] +'</td>'
                                                +'<td class="item-list-total-cost">'+ val['total_cost'] +'</td>'
                                                +'<td></td>'
                                                +'<td class="item-list-on-order">'+ val['on_order'] +'</td>'
                                                +'<td class="item-list-order-qty">'+ val['order_qty'] +'</td>'
                                                +'<td>'
                                                +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['opf_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                                +'</td>'
                                                +'<td>'
                                                +editBtn
                                                +'</td>'
                                                +'</tr>'
                                            );
                                        
                                            $('.item-list-item-cost').addClass('editable');
                                            $('.item-list-qty').addClass('editable');
                                            $('.item-list-on-order').addClass('editable');
                                            $('.item-list-order-qty').addClass('editable');
                                                                        
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
                                calculatePrices(result['price_after_discount'], result['total_cost']);
                                $("#editDetails").modal('hide');
                            }, error: function (data) {
                                        
                        }
                    });
                });

                $('#btnSaveChanges').click(function(){
                    var is_installed = 0;

                    if ($($('#is_installed')).is(':checked')) {
                        is_installed = 1;
                    }

                    $.ajax({
                            url: "{{ url('admin/opf/update') }}",
                            type: 'POST',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "opf_id": $('#opf_id').val(),
                                    "installation_date": $('#installation_date').val(),
                                    "symbol_group": $('#symbol_group').val(),
                                    "is_installed": is_installed,
                                    "vat": $("#vat-lbl").text(),
                                    "row_order": $('#row_order').val(),  
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
                                        window.location.reload();
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
                        url: "{{ url('admin/opf/add-items') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": isChecked.value,
                                "ischecked": ischecked,
                                "opf_id":$('#opf_id').val(),
                                "type": Itemtype
                            },
                            success: function (data) {
                                var result = JSON.parse(data);

                                $('.item-list tbody').empty();

                                if (result['data'].length > 0) {

                                    $.each(result['data'], function (count, val) {

                                        var type = val['type'];
                                            var name;
                                            var editBtn = '';

                                            if(type === 'bundle'){
                                                name = '<a class="" title="Edit Bundle" onclick="editBundle('+ val['opf_id'] +','+ val['item_id'] +')">' + val['name'] + '</a>';
                                            }else{
                                                name = val['name'];
                                                editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', \'' + val['on_order'] + '\', '+ val['order_qty'] +' )"><i class="fas fa-edit"></i></a>';
                                            }

                                            $('.item-list tbody').append(
                                            '<tr>'
                                            +'<td>'+ val['item_id'] +'</td>'
                                            +'<td>'+ name +'</td>'
                                            +'<td>'+ val['supplier'] +'</td>'
                                            +'<td class="item-list-item-cost">'+ val['item_cost'] +'</td>'
                                            +'<td class="item-list-qty">'+ val['qty'] +'</td>'
                                            +'<td class="item-list-total-cost">'+ val['total_cost'] +'</td>'
                                            +'<td></td>'
                                            +'<td class="item-list-on-order">'+ val['on_order'] +'</td>'
                                            +'<td class="item-list-order-qty">'+ val['order_qty'] +'</td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['opf_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            +editBtn
                                            +'</td>'
                                            +'</tr>'
                                        );
                                        
                                        $('.item-list-item-cost').addClass('editable');
                                        $('.item-list-qty').addClass('editable');
                                        $('.item-list-on-order').addClass('editable');
                                        $('.item-list-order-qty').addClass('editable');
                                    });
                                } 

                                calculatePrices(result['price_after_discount'], result['total_cost']);

                                if(Itemtype == 'main'){
                                    displaySubItemList(isChecked.value);
                                }
                            }, error: function (data) {
                                        
                        }
                });
            }

            function calculatePrices(priceAfterDiscount, totalCost){

                var margin = priceAfterDiscount - totalCost;
                var marginRate = Number((margin / priceAfterDiscount) * 100).toFixed(2);

                $("#opf-cost-lbl").text(Number(totalCost).toFixed(2));
                $("#profit-lbl").text(Number(priceAfterDiscount - totalCost).toFixed(2));
                
                $("#opf-margin-lbl").text(marginRate);
            }

            function changeStatus(id, opfId){

                $.ajax({
                        url: "{{ url('admin/opf/delete-item') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id,
                                "opf_id": opfId
                            },
                            success: function (data) {
                                var result = JSON.parse(data);
                                $('.item-list tbody').empty();

                                if (result['data'].length > 0) {
                                    
                                    $.each(result['data'], function (count, val) {

                                        var type = val['type'];
                                        var name;
                                        var editBtn = '';

                                        if(type === 'bundle'){
                                            name = '<a class="" title="Edit Bundle" onclick="editBundle('+ val['opf_id'] +','+ val['item_id'] +')">' + val['name'] + '</a>';
                                        }else{
                                            name = val['name'];
                                            editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', \'' + val['on_order'] + '\', '+ val['order_qty'] +' )"><i class="fas fa-edit"></i></a>';
                                        }
                                    
                                        $('.item-list tbody').append(
                                            '<tr>'
                                            +'<td>'+ val['item_id'] +'</td>'
                                            +'<td>'+ name +'</td>'
                                            +'<td>'+ val['supplier'] +'</td>'
                                            +'<td class="item-list-item-cost">'+ val['item_cost'] +'</td>'
                                            +'<td class="item-list-qty">'+ val['qty'] +'</td>'
                                            +'<td class="item-list-total-cost">'+ val['total_cost'] +'</td>'
                                            +'<td></td>'
                                            +'<td class="item-list-on-order">'+ val['on_order'] +'</td>'
                                            +'<td class="item-list-order-qty">'+ val['order_qty'] +'</td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['opf_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            +editBtn
                                            +'</td>'
                                            +'</tr>'
                                        );
                                        
                                        $('.item-list-item-cost').addClass('editable');
                                        $('.item-list-qty').addClass('editable');
                                        $('.item-list-on-order').addClass('editable');
                                        $('.item-list-order-qty').addClass('editable');
                                    });
                                } 
                                calculatePrices(result['price_after_discount'], result['total_cost']);
                            }, error: function (data) {
                                        
                        }
                });
            }

            function editDetails(id, actual_cost, qty, on_order, order_qty){
                $("#actual_cost").val(actual_cost);
                $("#qty").val(qty);
                $("#item_id").val(id);
                $("#on_order").val(on_order);
                $("#order_qty").val(order_qty);
                $("#editDetails").modal('show');
            }

            function editBundle(opfId, ItemId) {

                cuteAlert({
                    type: "question",
                    title: "Are you sure",
                    message: "You want to edit this bundle ?",
                    confirmText: "Yes",
                    cancelText: "Cancel"
                    }).then((e)=>{
                    if ( e == ("confirm")){
                            $.ajax({
                                url: "{{ url('admin/opf/edit-bundle') }}",
                                type: 'POST',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "opf_id": opfId,
                                    "bundle_id": ItemId,
                                },
                                success: function (data) {
                                    var result = JSON.parse(data);

                                    $('.item-list tbody').empty();

                                    if (result['data'].length > 0) {
                                        
                                        $.each(result['data'], function (count, val) {

                                            var type = val['type'];
                                            var name;
                                            var editBtn = ' ';

                                            if(type === 'bundle'){
                                                name = '<a class="" title="Edit Bundle" onclick="editBundle('+ val['opf_id'] +','+ val['item_id'] +')">' + val['name'] + '</a>';
                                            }else{
                                                name = val['name'];
                                                editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', \'' + val['on_order'] + '\', '+ val['order_qty'] +' )"><i class="fas fa-edit"></i></a>';
                                            }

                                             $('.item-list tbody').append(
                                                '<tr>'
                                                +'<td>'+ val['item_id'] +'</td>'
                                                +'<td>'+ name +'</td>'
                                                +'<td>'+ val['supplier'] +'</td>'
                                                +'<td class="item-list-item-cost">'+ val['item_cost'] +'</td>'
                                                +'<td class="item-list-qty">'+ val['qty'] +'</td>'
                                                +'<td class="item-list-total-cost">'+ val['total_cost'] +'</td>'
                                                +'<td></td>'
                                                +'<td class="item-list-on-order">'+ val['on_order'] +'</td>'
                                                +'<td class="item-list-order-qty">'+ val['order_qty'] +'</td>'
                                                +'<td>'
                                                +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['opf_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                                +'</td>'
                                                +'<td>'
                                                +editBtn
                                                +'</td>'
                                                +'</tr>'
                                            );
                                        
                                            $('.item-list-item-cost').addClass('editable');
                                            $('.item-list-qty').addClass('editable');
                                            $('.item-list-on-order').addClass('editable');
                                            $('.item-list-order-qty').addClass('editable');
                                        });
                                    } 

                                    calculatePrices(result['price_after_discount'], result['total_cost']);

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
                                    +'<td class="item-search-cost">' + val['cost_price'] + '</td>'
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
