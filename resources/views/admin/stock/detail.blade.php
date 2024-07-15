<x-admin>
    @section('title')  {{ 'Stock Management' }} @endsection
      <section class="content">
        <div class="card ">
          <div class="card-header">
            <div class="card-tools">
                <a href="{{ route('admin.stock.create-adjustment') }}" class="btn btn-sm btn-primary"> Add Stock Adjustment</a>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                <div class="row">
                    <div class="col-lg-12" style="margin-left:20px;">
                        <h4>Stock Adjustment Details</h4><br>
                        <div class="post">
                    
                            <div class="text-muted">
                                <p class="text-sm"><b class="d-block info-lb">Type: &nbsp;&nbsp;&nbsp;&nbsp;</b> {{ $data['type'] }}</p>
                                <p class="text-sm"><b class="d-block info-lb">Comment: &nbsp;&nbsp;&nbsp;&nbsp;</b> {{ $data['comment'] }}</p>
                                <p class="text-sm"><b class="d-block info-lb">Total Cost: </b>&nbsp;&nbsp;&nbsp;&nbsp;   £{{ number_format($data['total_cost'], 2) }}</p>
                                <p class="text-sm"><b class="d-block info-lb">Total Retail: </b>&nbsp;&nbsp;&nbsp;&nbsp;   £{{ number_format($data['total_retail'], 2) }}</p>
                            </div>
                        </div>

                    </div>
                </div>
                <hr><br>

                    <div class="row table-responsive">
                        <div class="col-lg-12" style="margin-left:20px;">
                            <h4>Stock Adjustment Items</h4><br>
                            <div class="post">
                                <table class="table table-head-fixed" id="">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">ID</th>
                                            <th class="th-sm">Name</th>
                                            <th class="th-sm">Supplier</th>
                                            <th class="w-100px th-sm">Item Cost</th>
                                            <th class="w-120px th-sm">Item Retail</th>
                                            <th class="w-200px th-sm">Stock Before Adjustment</th>
                                            <th class="th-sm">Qty</th>
                                            <th class="w-200px th-sm">Stock After Adjustment</th>
                                            <th class="w-200px th-sm">Adjustment Total Cost</th>
                                            <th class="w-200px th-sm">Adjustment Total Retail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($itemList as $value)
                                            <tr>
                                                <td>{{ $value['item_id'] }}</td>
                                                <td>{{ $value['name'] }}</td>
                                                <td>{{ $value['supplier'] }}</td>
                                                <td>{{ number_format($value['item_cost'], 2) }}</td>
                                                <td>{{ number_format($value['retail'], 2) }}</td>
                                                <td>{{ $value['stock_before'] }}</td>
                                                <td>{{ $value['qty'] }}</td>
                                                <td>{{ $value['stock_after'] }}</td>
                                                <td>{{ number_format($value['total_cost'], 2) }}</td>
                                                <td>{{ number_format($value['total_retail'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
              </div>
  
            </div>
          </div>
        </div>
      </section>

    @section('js')
        <script>
        </script>
    @endsection
</x-admin>