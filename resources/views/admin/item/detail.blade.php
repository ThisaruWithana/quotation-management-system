<x-admin>
    @section('title')  {{ 'Item Maintainance' }} @endsection
      <section class="content">
        <div class="card ">
          <div class="card-header">
            <div class="card-tools">
                <a href="{{ route('admin.item.edit',encrypt($data->id)) }}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i>  Edit Item</a>
                <a href="{{ route('admin.item') }}" class="btn btn-sm btn-primary"><i class="fas fa-times"></i></a>
        
            </div>
          </div>
        <div class="card-body">

            <div class="row">
                <div class="col-10">
                    <div class="row">
                        <div class="post table-responsive">
                            <h4>Suppliers</h4><br>
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="th-sm">ID</th>
                                        <th class="th-sm">Name</th>
                                        <th class="th-sm">Contact Person</th>
                                        <th class="th-sm w-100px">Address</th>
                                        <th class="th-sm">Contact No</th>
                                        <th class="th-sm">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->suppliers as $value)
                                        <tr>
                                            <td>{{ $value->suppliername->id }}</td>
                                            <td>{{ $value->suppliername->name }}</td>
                                            <td>{{ $value->suppliername->contact_person }}</td>
                                            <td>{{ $value->suppliername->address }} {{ $value->suppliername->postal_code }}</td>
                                            <td>{{ $value->suppliername->tel }}</td>
                                            <td>{{ $value->suppliername->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div><br><br>
                    <div class="row">
                        <div class="post table-responsive">
                            <h4>Optional Item List</h4><br>
                            <table class="table table-head-fixed text-nowrap">
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
                                            <td>
                                                @if($value->is_mandatory == 1)
                                                    Yes
                                                @else
                                                    No
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                   
                
                </div>
                
                <div class="col-2">
                    <h4> {{ 'Item Details' }} </h4><br>
              
                    @if(isset($data->image))
                    <div class="post">
                        <img class="item-img" src="{{ URL::to('/') }}/images/{{ $data->image }}" alt="{{ $data->name }}">
                    </div>
                    @endif
          
                    <div class="text-muted">
                        <p class="text-sm"><b class="d-block info-lb">Name: </b> {{ $data->name }}</p>
                        <p class="text-sm"><b class="d-block info-lb">Description: </b> {{ $data->description }}</p>
                        <p class="text-sm"><b class="d-block info-lb">Department: </b> {{ $data->department->name }}</p>
                        <p class="text-sm"><b class="d-block info-lb">Sub Department: </b> {{ $data->subdepartment->name }}</p>
                        <p class="text-sm"><b class="d-block info-lb">Item Size: </b> {{ $data->item_size }}</p>
                        <p class="text-sm"><b class="d-block info-lb">Margin Type: </b> {{ $data->margin_type }}</p>
                        <p class="text-sm"><b class="d-block info-lb">Sales VAT (%): </b> {{ $data->department->vat->value }}</p>
                            <p class="text-sm"><b class="d-block info-lb">Status:</b>&nbsp&nbsp
                                @if($data->status == 1)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Deactive</span>
                                @endif
                            </p>
                    </div>
                    <h5 class="mt-5 text-muted">Pricing Details</h5>
  
                    <div class="text-muted col-md-5">
                        <p class="text-sm"><b class="d-block info-lb">Case Size: </b> {{ $data->case_size }}</p>
                        <p class="text-sm"><b class="d-block info-lb">Cost Price: </b> {{ $data->cost_price }}</p>
                        <p class="text-sm"><b class="d-block info-lb">Retail Price: </b> {{ $data->retail_price }}</p>
                        <p class="text-sm"><b class="d-block info-lb">Margin (%): </b> {{ $data->margin }}</p>
                    </div>
      
                    <h5 class="mt-5 text-muted">Stock Details</h5>
                    <div class="text-muted col-md-5">
                        <p class="text-sm"><b class="d-block info-lb">Min Stock: </b> {{ $data->min_stock }}</p>
                        <p class="text-sm"><b class="d-block info-lb">In Stock: </b> </p>
                        <p class="text-sm"><b class="d-block info-lb">Location: </b> {{ $data->location->name }}</p>
                        <p class="text-sm"><b class="d-block info-lb">Auto Order:</b>&nbsp&nbsp
                            @if($data->auto_order == 1)  Yes @else No @endif
                        </p>
                        <p class="text-sm"><b class="d-block info-lb">Exclude from Stock: </b>
                            @if($data->exclude_from_stock == 1) Yes @else No @endif
                        </p>
                    </div>
        
                </div>
            </div>
            
        </div>







          </div>
        </div>
      </section>

    @section('js')
        <script>
            $(document).ready(function(){
                $('.table-responsive').doubleScroll();
            });
        </script>
    @endsection
</x-admin>