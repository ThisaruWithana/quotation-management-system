<x-admin>
   @section('title')  {{ 'Reports' }} @endsection
    <div class="card">
        <div class="card-body table-responsive">
        <br>
            <form method="GET" action="{{ url('admin/report/order-history') }}" id="frm-list">

                <div class="row">
                    <div class="form-group" style="margin-left:10px;">

                        <select name="pagesize" id="pagesize" class="custom-select tbl-sort-select"
                            onchange="selectPageSize(this.value)">
                                <option value="10" {{ $pageSize == '10' ? 'selected="selected"' : '' }}>10
                                </option>
                                <option value="25" {{ $pageSize == '25' ? 'selected="selected"' : '' }}>25
                                </option>
                                <option value="50" {{ $pageSize == '50' ? 'selected="selected"' : '' }}>50
                                </option>
                                <option value="100" {{ $pageSize == '100' ? 'selected="selected"' : '' }}>100
                                </option>
                        </select>
                    </div>
                        
                    <div class="form-group" style="margin-left:10px;">
                        <select id="items" name="items" class="selectpicker show-tick" data-live-search="true" >
                                <option value="">Select Items</option>        
                                @foreach ($items as $value)
                                    <option value="{{ $value->id }}" @if(Request()->items == $value->id) selected @endif>{{ $value->name }}</option>
                                @endforeach 
                        </select>
                    </div>

                    <div class="form-group" style="margin-left:10px;">
                        @if(Request()->from_date != '') 
                            <input type="date" class="form-control datepicker" id="from_date" name="from_date" value="{{ date('d/m/Y', strtotime(Request()->from_date)) }}">
                        @else
                            <input type="date" class="form-control datepicker" id="from_date" name="from_date" value="">
                        @endif
                    </div>
                        
                    <div class="form-group" style="margin-left:10px;">
                        @if(isset(Request()->to_date)) 
                            <input type="date" class="form-control datepicker" id="to_date" name="to_date" value="{{ date('d/m/Y', strtotime(Request()->to_date)) }}">
                        @else
                            <input type="date" class="form-control datepicker" id="to_date" name="to_date" value="">
                        @endif
                    </div>
                        
                    <input type="hidden" name="form_action" value="search">
                        
                    <div class="form-group text-right" style="margin-left:10px;">
                        <button class="btn btn-primary" type="submit">Get Report</button>
                    </div>
                </div>
            </form>
            <br>
            <div>
                <table class="table" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">Item ID</th>
                            <th class="th-sm">Name</th>
                            <th class="th-sm">PO No</th>
                            <th class="th-sm">Item Cost</th>
                            <th class="th-sm">Qty</th>
                            <th class="th-sm">Total Cost</th>
                            <th class="th-sm">PO Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listData as $value)
                            <tr>
                                <td>{{ $value->item->id }}</td>
                                <td>{{ $value->item->name }}</td>
                                <td>{{ $value->po->id }}</td>
                                <td>{{ number_format($value->item_cost, 2) }}</td>
                                <td>{{ $value->qty }}</td>
                                <td>{{ number_format($value->total_cost, 2) }}</td>
                                <td>{{ date('Y-m-d H:i:s', strtotime($value->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="list_pagination" style="float: right;">{{ $listData->appends(Request::all())->links() }}</div>
        </div>
    </div>
    @section('js')
        <script>
            $(function() {

                $('#dataTable').DataTable({
                    "bPaginate": false,
                    "searching": true,
                    "ordering": true,
                    "responsive": true,
                    // "scrollX": false,
                    "autoWidth":true,
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 6 ]},
                    ],
                    "order": [0,'desc'],
                });
            });
            
        </script>
    @endsection
</x-admin>