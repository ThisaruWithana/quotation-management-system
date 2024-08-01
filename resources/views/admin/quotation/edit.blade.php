<x-admin>
   @section('title')  {{ 'Quotation Management' }} @endsection

    <section class="content">
        <!-- Default box -->
        <div class="d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card card-primary">
                <h5 class="card-header  white-text text-left py-3">
                    {{ $title }}

                    <div class="card-tools">
                        <a href="{{ route('admin.quotation') }}" class="btn btn-sm btn-primary">
                            <button type="button" class="btn btn-tool">
                                    <i class="fas fa-times"></i>
                            </button>
                        </a>
                    </div>
                </h5>
                    <!-- /.card-header -->

                            <!-- form start -->
                    <form action="{{ url('admin/quotation/store') }}" method="PUT"
                        class="text-center border border-light p-5" id="formCreate">
                            @csrf

                        <div class="card-body px-lg-2 pt-0">

                                <div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="row card card-dark">
                                                <div class="row">


                                                <div class="col-lg-3">
                                                    <div class="form-group text-left">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select id="status" name="status" class="selectpicker">
                                                        <option value="0" @if($data->status == 0) selected @endif>Deactivated</option>
                                                        <option value="1" @if($data->status == 1) selected @endif>New</option>
                                                        <option value="2" @if($data->status == 2) selected @endif>Accepted</option>
                                                        <option value="3" @if($data->status == 3) selected @endif>Installed</option>
                                                        <option value="4" @if($data->status == 4) selected @endif>Old</option>
                                                    </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6" style="margin-left:100px;">
                                                    <div class="form-group text-left">
                                                        <label for="ref" class="form-label">Quot. Ref</label>
                                                        <input type="text" class="form-control" id="ref" name="ref" value="{{ $data->ref }}" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group text-left">
                                                        <label for="customer" class="form-label">Client</label>
                                                        <span class="required"> * </span><br>
                                                        <select id="customer" name="customer" class="selectpicker show-tick col-lg-12" data-live-search="true" @if($data->status != 1) disabled @endif>
                                                            <option value="">Select Client</option>
                                                            @foreach ($customers as $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ $value->id === $data->customer_id ? 'selected' : '' }}>
                                                                        {{  $value->postal_code }}
                                                                        - {{ $value->name }}
                                                                        - {{ $value->contact_person }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group text-left">
                                                        <label for="description" class="form-label">Description</label>
                                                        <span class="required"> * </span><br>

                                                        <textarea class="form-control" name="description" id="description" rows="4"
                                                            required @if($data->status != 1) disabled @endif>{{ $data->description }}</textarea><br>

                                                        <button class="btn btn-default add-description" type="button" style="float:right; margin-top:-20px;" @if($data->status != 1) disabled @endif><i class="fa fa-plus"> Add</i></button><br>

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
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-12 customer-details" style="display:block;margin-top: 0px;padding-left:100px;">
                                                    <div class="text-left">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td style="width:120px;"><p class="text-sm mb-0 text-bold">Name :</p></td>
                                                                <td style="width:50px;"><p class="text-sm  mb-0"><span id="cus-name-lbl"></span></p></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:120px;"><p class="text-sm  mb-0 text-bold">Address :</p></td>
                                                                <td style="width:50px;"><p class="text-sm  mb-0"><span id="cus-address-lbl"></span></p></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:120px;"><p class="text-sm  mb-0 text-bold">Contact Number :</p></td>
                                                                <td style="width:50px;"><p class="text-sm  mb-0"><span id="cus-tel-lbl"></span></p></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:120px;"><p class="text-sm  mb-0 text-bold">Email :</p></td>
                                                                <td style="width:50px;"><p class="text-sm  mb-0"><span id="cus-email-lbl"></span></p></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:120px;"><p class="text-sm  mb-0 text-bold">Code :</p></td>
                                                                <td style="width:50px;"><p class="text-sm  mb-0"><span id="cus-code-lbl"></span></p></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="quotation_id" id="quotation_id" value="{{ $data['id'] }}">
                                    <input type="hidden" name="in_office" id="in_office" value="">
                                    <input type="hidden" name="vat_rate" id="vat_rate" value="{{ $data['vat_rate'] }}">
                                    <input type="hidden" name="row_order" id="row_order" value="">
                                </div>

                            <hr>
                            <div class="add-items" style="display:block;">

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group text-left">
                                                <label for="bundle" class="form-label">Bundle</label>
                                                <select id="bundle" name="bundle" class="selectpicker show-tick col-lg-12" data-live-search="true" @if($data->status != 1) disabled @endif>
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
                                        <div class="col-lg-3">
                                            <div class="form-group text-left">
                                                <label for="price" class="form-label">Quotation Price</label>
                                                <span class="required"> * </span><br>
                                                <input type="text" class="form-control" id="price" name="price" value="{{ $data['price'] }}" autocomplete="off" @if($data->status != 1) readonly @endif>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group text-left">
                                                <label for="discount" class="form-label">Discount</label>
                                                <input type="text" class="form-control" id="discount" name="discount" value="{{ $data['discount'] ?: 0 }}" autocomplete="off" @if($data->status != 1) readonly @endif>
                                            </div>
                                        </div>
                                        <div class="col-lg-3" id="margin-details">
                                            <div class="form-group text-left">
                                                <label for="margin" class="form-label">Quotation Margin</label>
                                                <input type="text" class="form-control" id="margin" name="margin" value="{{ $data['margin'] }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5" id="retail-print-option" style="display:none;">
                                            <div class="form-group text-left">
                                                <label for="retail_print_option" class="form-label">Print retails prices in print </label>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="checkbox" id="retail_print_option" name="retail_print_option" value="1" 
                                                    class="form-check-label" @if($data['retail_print_option'] == 1)  checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-lg-2 mt-3 mb-3 p-0" style="float:right;">
                                                <button class="btn btn-primary btn-block" type="button" id="itemSearchBtn" data-toggle="modal" data-target="#exampleModal" @if($data->status != 1) disabled @endif>
                                                    <i class="fa fa-search-plus"></i>
                                                    Find Items
                                                </button>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table item-list table-bordered" id="sortable-table" width="100%">
                                                    <thead>

                                                        <tr>
                                                            <th class="th-sm">Code</th>
                                                            <th class="th-sm">Name</th>
                                                            <th class="th-sm">Supplier</th>
                                                            <th class="w-120px th-sm item-list-cost">Actual Cost</th>
                                                            <th class="th-sm item-list-item-cost">Cost</th>
                                                            <th class="th-sm item-list-retail">Retail</th>
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
                                                        <?php $i = 1; ?>
                                                        @foreach ($quotationItems as $value)
                                                        <tr class="row_position" data-id="{{ $i }}" id="{{ $value['id'] }}">
                                                                <td>{{ $value['item_id'] }}</td>
                                                                <td>
                                                                    @if($value['type'] === 'bundle')
                                                                    <a class="" title="Edit Bundle" onclick="editBundle({{ $value['quotation_id'] }},{{ $value['item_id'] }})">
                                                                        {{ $value['name'] }}
                                                                    </a>
                                                                    @else
                                                                        {{ $value['name'] }}
                                                                    @endif
                                                                </td>
                                                                <td>{{ $value['supplier'] }}</td>
                                                                <td class="item-list-cost">
                                                                    @if($value['type'] === 'bundle')
                                                                        
                                                                    @else
                                                                        {{ $value['actual_cost'] }}
                                                                    @endif
                                                                </td>
                                                                <td class="item-list-item-cost">
                                                                    @if($value['type'] === 'bundle')
                                                                        
                                                                    @else
                                                                        {{ $value['item_cost'] }}
                                                                    @endif
                                                                </td>
                                                                <td class="item-list-retail">
                                                                    @if($value['type'] === 'bundle')
                                                                        
                                                                    @else
                                                                        {{ $value['retail'] }}
                                                                    @endif
                                                                </td>
                                                                <td class="item-list-qty">{{ $value['qty'] }}</td>
                                                                <td class="item-list-item-margin">{{ $value['margin'] }}</td>
                                                                <td class="item-list-total-cost">{{ $value['total_cost'] }}</td>
                                                                <td>
                                                                    @if($value['type'] === 'bundle')
                                                                        {{ $value['total_cost'] }}
                                                                    @else
                                                                        {{ $value['total_retail'] }}
                                                                    @endif
                                                                </td>
                                                                <td class="item-list-display-report">
                                                                        <input type="checkbox" id="item" name="item"
                                                                        onclick="updateDisplayStatus(this)" value="{{ $value['id'] }}" class="form-check-label"
                                                                        @if($value['display_report'] == 1) checked @endif
                                                                            @if($data->status != 1) disabled @endif>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-sm btn-secondary @if($data->status != 1) disabled @endif" title="Delete" onclick="changeStatus({{ $value['id'] }}, {{ $value['quotation_id'] }})"
                                                                        >
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    @if($value['type'] != 'bundle')
                                                                    <a class="btn btn-sm btn-secondary @if($data->status != 1) disabled @endif" title="Edit" onclick="editDetails({{ $value['id'] }}, {{ $value['item_cost'] }}, {{ $value['qty'] }}, {{ $value['retail'] }})"
                                                                        >
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <?php $i++; ?>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row text-left">

                                        <div class="col-lg-4">
                                            <table class="table table-bordered">
                                                <tr id="lbl-cost-details" style="display:none;">
                                                    <td style="width:100px;"><p class="text-sm mb-0"><b class="d-block info-lb">Total Cost :</b></p></td>
                                                    <td style="width:50px;">
                                                        <p class="text-sm mb-0"><b class="d-block info-lb"><span id="total-cost-lbl">{{ number_format($total_cost, 2) }}</span></b></p>
                                                        <input type="hidden" value="{{ $total_cost }}" id="total-cost">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm mb-0"><b class="d-block info-lb">Total Retail :</b></p></td>
                                                    <td style="width:50px;">
                                                        <p class="text-sm mb-0"><b class="d-block info-lb"><span id="retail-lbl">{{ number_format($total_retail, 2) }}</span></b></p>
                                                        <input type="hidden" value="{{ $total_retail }}" id="total-retail">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;"><p class="text-sm mb-0"><b class="d-block info-lb">Discount (%) :</b></p></td>
                                                    <td style="width:50px;"><p class="text-sm mb-0"><b class="d-block info-lb"><span id="discount-lbl">{{ $data->discount }}</span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:150px;"><p class="text-sm mb-0"><b class="d-block info-lb">Quot. Price After Discount :</b></p></td>
                                                    <td style="width:50px;"><p class="text-sm mb-0"><b class="d-block info-lb"><span id="quot-price-lbl">{{ number_format($quotationPriceAfterDiscount, 2) }}</span></b></p></td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="col-lg-4">
                                            <table class="table table-bordered">
                                                <tr id="quot-margin-before-discount">
                                                    <td style="width:auto"><p class="text-sm mb-0"><b class="d-block info-lb">Quot. Margin :</b></p></td>
                                                    <td style="width:auto;"><p class="text-sm mb-0"><b class="d-block info-lb"><span id="quot-margin">{{ number_format($quotationMarginRate, 2) }}%</span></b></p></td>
                                                </tr>
                                                <tr id="quot-margin-after-discount">
                                                    <td style="width:auto"><p class="text-sm mb-0"><b class="d-block info-lb">Quot. Margin After Discount:</b></p></td>
                                                    <td style="width:auto;"><p class="text-sm mb-0"><b class="d-block info-lb"><span id="quot-margin-lbl">{{ number_format($quotationMarginRate, 2) }}%</span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:auto"><p class="text-sm mb-0"><b class="d-block info-lb">VAT :</b></p></td>
                                                    <td style="width:auto;"><p class="text-sm mb-0"><b class="d-block info-lb"><span id="vat-lbl">{{ number_format($data['vat_amt'], 2) }}</span></b></p></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:auto;"><p class="text-sm mb-0"><b class="d-block info-lb">Quot. + VAT :</b></p></td>
                                                    <td style="width:auto"><p class="text-sm mb-0"><b class="d-block info-lb"><span id="quot-vat-lbl">{{ number_format($data['vat_amt'] + $quotationPriceAfterDiscount, 2) }}</span></b></p></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <br>

                                <div class="row">
                                    @if($data->status == 2)
                                    <div class="col-lg-1">
                                        <a href="{{ url('admin/opf',encrypt($data['id'])) }}" class="btn btn-primary btn-block" id="opfBtn" target="_blank">
                                            OPF
                                        </a>
                                    </div>
                                    @endif
                                    <div class="col-lg-1">
                                        <a href="{{ url('admin/quotation/print',encrypt($data->id)) }}">
                                            <button class="btn btn-primary btn-block" type="button" id="printBtn">Print</button>
                                        </a>
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
                            <input type="hidden" value="{{ $data['id'] }}" id="quotation" name="quotation">

                            <div class="form-group mr-1">
                                <select id="supplier" name="supplier" class="selectpicker show-tick" data-live-search="true" onchange="searchItem(this.form)">
                                    <option value="">Supplier</option>
                                    @foreach ($suppliers as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mr-1">
                                <select id="departments" name="departments" class="selectpicker show-tick dropdown-item" data-live-search="true" onchange="searchItem(this.form)">
                                    <option value="">Departments</option>
                                    @foreach ($departments as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mr-1">
                                <select id="sub_departments" name="sub_departments" class="selectpicker show-tick dropdown-item" data-live-search="true" onchange="searchItem(this.form)">
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
                                            <th class="w-100px th-sm">Item Code</th>
                                            <th class="w-100px th-sm">Item Name</th>
                                            <th class="th-sm">Department</th>
                                            <th class="th-sm">Supplier</th>
                                            <th class="w-100px th-sm item-search-cost">Cost Price</th>
                                            <th class="w-100px th-sm">Retail Price</th>
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

                <form action="" method="" onsubmit="return false;" id="formEditQuotationItem">
                <div class="modal-body">
                        @csrf
                    <input type="hidden" name="quotation_item_id" value="" id="quotation_item_id">
                    <input type="hidden" name="discount_amt" value="" id="discount_amt">

                    <div class="form-group" id="actual_cost_edit">
                        <label for="actual_cost" class="col-form-label">Cost</label>
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

                getCustomerInfo("{{ $data['customer_id'] }}");

                $('.item-list-item-cost').addClass('editable');
                $('.item-list-retail').addClass('editable');
                $('.item-list-qty').addClass('editable');

                $('.item-list-item-cost').hide();
                $('.item-list-total-cost').hide();
                $('.item-list-cost').hide();
                $('.item-search-cost').hide();
                $('.item-list-display-report').hide();
                $('.item-list-item-margin').hide();
                $('#quot-margin-before-discount').hide();
                $('#quot-margin-after-discount').hide();
                $('#margin-details').hide();
                $('#retail-print-option').hide();

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
                        $('.item-list-item-margin').show();
                        $('#quot-margin-before-discount').show();
                        $('#quot-margin-after-discount').show();
                        $('#margin-details').show();

                        $('#retail-print-option').show();
                        
                    } else {
                        $('#in_office').val('no');
                    }
                });

                var totalCost = parseFloat($("#total-cost").val());
                var totalRetail = parseFloat($("#total-retail").val());
                var quotationCost = parseFloat($('#price').val());
                var discount = $('#discount').val();

                calculateMarginBeforeDiscount(quotationCost, $("#total-cost").val());
                
                $("#discount").on("keyup", function() {

                    var discount = this.value;
                    var totalCost = parseFloat($("#total-cost").val());
                    var totalRetail = parseFloat($("#total-retail").val());
                    var quotationCost = parseFloat($('#price').val());

                    calculatePrices(quotationCost, totalRetail, totalCost, discount);

                });

                $("#price").on("keyup", function() {

                    var quotationCost = this.value;
                    var totalCost = parseFloat($("#total-cost").val());
                    var totalRetail = parseFloat($("#total-retail").val());
                    var discount = parseFloat($('#discount').val());

                    calculatePrices(quotationCost, totalRetail, totalCost, discount);

                });

                $("#formCreate").submit(function(event) {
                    event.preventDefault();

                    var retail_print_option = 0;

                    if($('#retail_print_option').prop('checked') == true ){
                        retail_print_option = $('#retail_print_option').val();
                    }

                    var formData = new FormData(this);

                    $.ajax({
                            url: "{{ url('admin/quotation/store') }}",
                            type: 'POST',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "description": $('#description').val(),
                                    "customer": $('#customer').val(),
                                    "quotation_id": $('#quotation_id').val(),
                                    "price": $('#price').val(),
                                    "price_after_discount":  $("#quot-price-lbl").text(),
                                    "discount": $('#discount').val(),
                                    "row_order": $('#row_order').val(),
                                    "status": $('#status').val(),
                                    "vat": $("#vat-lbl").text(),
                                    "total_vat": $("#quot-vat-lbl").text(),
                                    "total_cost": $("#total-cost").val(),
                                    "total_retail": $("#total-retail").val(),
                                    "quotation_vat": $("#quot-vat-lbl").text(),
                                    "quotation_margin": $("#quot-margin-lbl").text(),
                                    "retail_print_option": retail_print_option
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

                $('#customer').on('change', function() {
                    getCustomerInfo(this.value);
                });

                $('#bundle').on('change', function() {

                    $.ajax({
                        url: "{{ url('admin/quotation/add-bundle') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "bundle": this.value,
                                "quotation_id":$('#quotation_id').val(),
                                "discount":$('#discount').val(),
                                "price":$('#price').val()
                            },
                            success: function (data) {
                                var result = JSON.parse(data);

                                $("#bundle_cost").val(result['bundle_cost']);
                                $('.item-list tbody').empty();

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

                                        var type = val['type'];
                                        var name;
                                        var editBtn = '';
                                        var retail, totalRetail, actualCost, itemCost, margin;

                                        if(type === 'bundle'){
                                            name = '<a class="" title="Edit Bundle" onclick="editBundle('+ val['quotation_id'] +','+ val['item_id'] +')">' + val['name'] + '</a>';
                                            retail = '';
                                            totalRetail = val['total_cost'];
                                            actualCost = '';
                                            itemCost = '';
                                            margin = '';
                                        }else{
                                            name = val['name'];
                                            editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>';
                                            retail = val['retail'];
                                            totalRetail = val['total_retail'];
                                            actualCost = val['actual_cost'];
                                            itemCost = val['item_cost'];
                                            margin = val['margin'];
                                        }

                                        $('.item-list tbody').append(
                                            '<tr class="row_position" id="' + val['id'] + '" data-id="' + i + '">'
                                            +'<td>' + val['item_id'] + '</td>'
                                            +'<td>' + name + '</td>'
                                            +'<td>' + val['supplier'] + '</td>'
                                            +'<td class="item-list-cost" '+ costColHidden +'>' + actualCost + '</td>'
                                            +'<td class="item-list-item-cost" '+ costColHidden +'>' + itemCost + '</td>'
                                            +'<td class="item-list-retail">' + retail + '</td>'
                                            +'<td class="item-list-qty">' + val['qty'] + '</td>'
                                            +'<td  class="item-list-total-cost" '+ costColHidden +'>' + val['total_cost'] + '</td>'
                                            +'<td>' + totalRetail + '</td>'
                                            +'<td class="item-list-display-report" '+ costColHidden +'><input type="checkbox" id="item" name="item" onclick="updateDisplayStatus(this)" value="' + val['id'] + '" class="form-check-label" '+ checkboxStatus +'></td>'
                                            +'<td>'
                                            +'<a class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus(' + val['id'] + ', ' + val['quotation_id'] + ')"><i class="fas fa-trash-alt"></i></a>'
                                            +'</td>'
                                            +'<td>'
                                            + editBtn
                                            +'</td>'
                                            +'</tr>'
                                        );

                                        $('.item-list-item-cost').addClass('editable');
                                        $('.item-list-retail').addClass('editable');
                                        $('.item-list-qty').addClass('editable');
                                        i++;
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

                $('.add-description').click(function(){
                    $('.add-description-history').show();
                });

                $('#description_dropdown').on('change', function() {
                    var txt = $.trim(this.value);
                    $('#description').append(txt);
                    $('.add-description-history').hide();
                });

                $('#formEditQuotationItem').submit(function(event){
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

                                        var i = 1;
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
                                            var retail, totalRetail, actualCost, itemCost, margin;

                                            if(type === 'bundle'){
                                                name = '<a class="" title="Edit Bundle" onclick="editBundle('+ val['quotation_id'] +','+ val['item_id'] +')">' + val['name'] + '</a>';
                                                retail = '';
                                                totalRetail = val['total_cost'];
                                                actualCost = '';
                                                itemCost = '';
                                                margin = '';
                                            }else{
                                                name = val['name'];
                                                editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>';
                                                retail = val['retail'];
                                                totalRetail = val['total_retail'];
                                                actualCost = val['actual_cost'];
                                                itemCost = val['item_cost'];
                                                margin = val['margin'];
                                            }

                                            $('.item-list tbody').append(
                                                '<tr class="row_position" id="' + val['id'] + '" data-id="' + i + '">'
                                                +'<td>' + val['item_id'] + '</td>'
                                                +'<td>' + name + '</td>'
                                                +'<td>' + val['supplier'] + '</td>'
                                                +'<td class="item-list-cost" '+ costColHidden +'>' + actualCost + '</td>'
                                                +'<td class="item-list-item-cost" '+ costColHidden +'>' + itemCost + '</td>'
                                                +'<td class="item-list-retail">' + retail + '</td>'
                                                +'<td class="item-list-qty">' + val['qty'] + '</td>'
                                                +'<td class="item-list-item-margin" '+ costColHidden +'>' + margin + '</td>'
                                                +'<td class="item-list-total-cost" '+ costColHidden +'>' + val['total_cost'] + '</td>'
                                                +'<td>' + totalRetail + '</td>'
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
                                            i++;
                                        });
                                    }

                                    $("#editDetails").modal('hide');
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
                                calculatePrices(result['quotation_cost'], result['total_retail'], result['total_cost'], result['discount']);


                                $("#editDetails").modal('hide');
                            }, error: function (data) {

                        }
                    });
                });

            });

            function getCustomerInfo(customerId){

                $.ajax({
                        url: "{{ url('admin/customer/get-details') }}",
                        type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": customerId
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
                                        +'<td '+ costColHidden +'>' + val['cost_price'] + '</td>'
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

                                        var type = val['type'];
                                        var name;
                                        var editBtn = '';
                                        var retail, totalRetail, actualCost, itemCost, margin;

                                        if(type === 'bundle'){
                                            name = '<a class="" title="Edit Bundle" onclick="editBundle('+ val['quotation_id'] +','+ val['item_id'] +')">' + val['name'] + '</a>';
                                            retail = '';
                                            totalRetail = val['total_cost'];
                                            actualCost = '';
                                            itemCost = '';
                                            margin = '';
                                        }else{
                                            name = val['name'];
                                            editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>';
                                            retail = val['retail'];
                                            totalRetail = val['total_retail'];
                                            actualCost = val['actual_cost'];
                                            itemCost = val['item_cost'];
                                            margin = val['margin'];
                                        }

                                        $('.item-list tbody').append(
                                            '<tr class="row_position" id="' + val['id'] + '" data-id="' + i + '">'
                                            +'<td>' + val['item_id'] + '</td>'
                                            +'<td>' + name + '</td>'
                                            +'<td>' + val['supplier'] + '</td>'
                                            +'<td class="item-list-cost" '+ costColHidden +'>' + actualCost + '</td>'
                                            +'<td class="item-list-item-cost" '+ costColHidden +'>' + itemCost + '</td>'
                                            +'<td class="item-list-retail">' + retail + '</td>'
                                            +'<td class="item-list-qty">' + val['qty'] + '</td>'
                                                +'<td class="item-list-item-margin" '+ costColHidden +'>' + margin + '</td>'
                                            +'<td class="item-list-total-cost" '+ costColHidden +'>' + val['total_cost'] + '</td>'
                                            +'<td>' + totalRetail + '</td>'
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
                                        i++;
                                    });
                                }

                                calculatePrices(result['quotation_cost'], result['total_retail'], result['total_cost'], result['discount']);

                                displaySubItemList(isChecked.value);
                            }, error: function (data) {

                        }
                });
            }

            function calculatePrices(quotationCost, totalRetail, totalCost, discount){

                calculateMarginBeforeDiscount($("#price").val(), totalCost);
   
                if(typeof discount == "undefined"){
                    discount = 0;
                }else{
                    discount = parseFloat(discount);
                }

                if(quotationCost > 0){
          
                    var vat_rate = $("#vat_rate").val();
                    quotationCost = quotationCost - ((quotationCost * discount)/100);
                    var quotationPriceAfterDiscount = quotationCost;
                 
                    var quotationMargin = quotationPriceAfterDiscount - totalCost;
                    var quotationMarginRate = Number((quotationMargin / quotationPriceAfterDiscount) * 100).toFixed(2);
                    var quotationMarginVal = quotationMarginRate + '%';

                    var vatValue = (quotationPriceAfterDiscount * vat_rate) / 100;
                    
                    $("#margin").val(quotationMarginRate);
                    $("#quot-price-lbl").text(Number(quotationPriceAfterDiscount).toFixed(2));
                    $("#quot-margin-lbl").text(quotationMarginVal);
                    $("#quot-vat-lbl").text(Number(vatValue + quotationPriceAfterDiscount).toFixed(2));
                    $("#vat-lbl").text(Number(vatValue).toFixed(2));
                }

                $("#total-cost-lbl").text(Number(totalCost).toFixed(2));
                $("#retail-lbl").text(Number(totalRetail).toFixed(2));
                $("#total-cost").val(Number(totalCost).toFixed(2));
                $("#total-retail").val(Number(totalRetail).toFixed(2));

                $("#discount-lbl").text(discount);
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
                                "quotation_id": quotationId,
                                "discount":$('#discount').val(),
                                "price":$('#price').val()
                            },
                            success: function (data) {
                                var result = JSON.parse(data);
                                $('.item-list tbody').empty();

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

                                        var type = val['type'];
                                        var name;
                                        var editBtn = '';
                                        var retail, totalRetail, actualCost, itemCost, margin;

                                        if(type === 'bundle'){
                                            name = '<a class="" title="Edit Bundle" onclick="editBundle('+ val['quotation_id'] +','+ val['item_id'] +')">' + val['name'] + '</a>';
                                            retail = '';
                                            totalRetail = val['total_cost'];
                                            actualCost = '';
                                            itemCost = '';
                                            margin = '';
                                        }else{
                                            name = val['name'];
                                            editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>';
                                            retail = val['retail'];
                                            totalRetail = val['total_retail'];
                                            actualCost = val['actual_cost'];
                                            itemCost = val['item_cost'];
                                            margin = val['margin'];
                                        }

                                        $('.item-list tbody').append(
                                            '<tr class="row_position" id="' + val['id'] + '" data-id="' + i + '">'
                                            +'<td>' + val['item_id'] + '</td>'
                                            +'<td>' + name + '</td>'
                                            +'<td>' + val['supplier'] + '</td>'
                                            +'<td class="item-list-cost" '+ costColHidden +'>' + actualCost + '</td>'
                                            +'<td class="item-list-item-cost" '+ costColHidden +'>' + itemCost + '</td>'
                                            +'<td class="item-list-retail">' + retail + '</td>'
                                            +'<td class="item-list-qty">' + val['qty'] + '</td>'
                                            +'<td class="item-list-item-margin" '+ costColHidden +'>' + margin + '</td>'
                                            +'<td class="item-list-total-cost" '+ costColHidden +'>' + val['total_cost'] + '</td>'
                                            +'<td>' + totalRetail + '</td>'
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
                                        i++;
                                    });
                                }
                                calculatePrices(result['quotation_cost'], result['total_retail'], result['total_cost'], result['discount']);

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
                                    "discount":$('#discount').val(),
                                    "price":$('#price').val()
                                },
                                success: function (data) {
                                    var result = JSON.parse(data);

                                    $('.item-list tbody').empty();

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

                                            var type = val['type'];
                                            var name;
                                            var editBtn = '';
                                            var retail, totalRetail, actualCost, itemCost, margin;

                                            if(type === 'bundle'){
                                                name = '<a class="" title="Edit Bundle" onclick="editBundle('+ val['quotation_id'] +','+ val['item_id'] +')">' + val['name'] + '</a>';
                                                retail = '';
                                                totalRetail = val['total_cost'];
                                                actualCost = '';
                                                itemCost = '';
                                                margin = '';
                                            }else{
                                                name = val['name'];
                                                editBtn ='<a class="btn btn-sm btn-secondary" title="Edit" onclick="editDetails(' + val['id'] +', '+ val['item_cost'] +', '+ val['qty'] +', '+ val['retail'] +' )"><i class="fas fa-edit"></i></a>';
                                                retail = val['retail'];
                                                totalRetail = val['total_retail'];
                                                actualCost = val['actual_cost'];
                                                itemCost = val['item_cost'];
                                                margin = val['margin'];
                                            }

                                            $('.item-list tbody').append(
                                                '<tr class="row_position" id="' + val['id'] + '" data-id="' + i + '">'
                                                +'<td>' + val['item_id'] + '</td>'
                                                +'<td>' + name + '</td>'
                                                +'<td>' + val['supplier'] + '</td>'
                                                +'<td class="item-list-cost" '+ costColHidden +'>' + actualCost + '</td>'
                                                +'<td class="item-list-item-cost" '+ costColHidden +'>' + itemCost + '</td>'
                                                +'<td class="item-list-retail">' + retail + '</td>'
                                                +'<td class="item-list-qty">' + val['qty'] + '</td>'
                                                +'<td class="item-list-item-margin" '+ costColHidden +'>' + margin + '</td>'
                                                +'<td class="item-list-total-cost" '+ costColHidden +'>' + val['total_cost'] + '</td>'
                                                +'<td>' + totalRetail + '</td>'
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
                                            i++;

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
                                                    // window.location.reload();
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
                                    +'<td class="item-search-cost" '+ costColHidden +'>' + val['cost_price'] + '</td>'
                                    +'<td>' + val['retail_price'] + '</td>'
                                    +'<td><input type="checkbox" id="item" name="item" onclick="selectItem(this, \'' + type + '\')" value="' + val['id'] + '" class="form-check-label" '+ selected +'></td>'
                                    +'</tr>'
                                    );
                            });
                        }else{
                            $("#subItemList").modal('hide');
                        }
                    }, error: function (data) {

                    }
                });
            }

            function calculateMarginBeforeDiscount(quotationCost, totalCost){

                var quotationMarginVal;

                if(quotationCost > 0){
                    var quotationMargin = quotationCost - totalCost;
                    var quotationMarginRate = Number((quotationMargin / quotationCost) * 100).toFixed(2);
                    quotationMarginVal = quotationMarginRate + '%';
                }else{
                    quotationMarginVal = 0;
                }

                $("#quot-margin").text(quotationMarginVal);
            }
        </script>
        <!--Rearrange table rows-->
        <script>
            $(function() {
                // gettableRowOrder();

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

            function gettableRowOrder(){

                var selectedData = new Array();
                $('#sortable-table tbody tr').each(function() {
                    selectedData.push($(this).attr("id"));
                });

                $('#row_order').removeAttr('value');
                $('#row_order').val(selectedData);

            }

        </script>
    @endsection
</x-admin>
