<x-admin>
   @section('title')  {{ 'Product Locations' }} @endsection
   <div class="card">
      <div class="card-header">
         <!-- <h3 class="card-title">Product Locations</h3> -->
         <div class="card-tools">
            <a href="{{ route('admin.location.create') }}" class="btn btn-sm btn-primary">Add New</a>
         </div>
      </div>
      <div class="card-body">
         <table id="dataTable" class="table" width="100%">
            <thead>
               <tr>
                  <th class="th-sm">Name</th>
                  <th class="th-sm">Created By</th>
                  <th class="th-sm">Created At</th>
                  <th class="th-sm">Status</th>
                  <th class="th-sm"></th>
               </tr>
            </thead>
            <tbody>
               @foreach ($data as $value)
               <tr>
                  <td>{{ $value->name }}</td>
                  <td>{{ $value->created_user->name }}</td>
                  <td>{{ $value->created_at }}</td>
                  <td>
                     @if($value->status == 1)
                     <span class="badge badge-success">Active</span>
                     @else 
                     <span class="badge badge-warning">Deactive</span>
                     @endif
                  </td>
                  <td>
                     <a href="{{ route('admin.location.edit',encrypt($value->id)) }}" class="btn btn-sm btn-secondary">
                     <i class="far fa-edit"></i>
                     </a>
                     @if($value->status === 1)
                     <a href="#" class="btn btn-sm btn-secondary" title="Delete" onclick="changeStatus({{ $value->id }}, {{ $value->status }})">
                     <i class="fas fa-trash-alt"></i>
                     </a>
                     @else
                     <a href="#" class="btn btn-sm btn-secondary" title="Activate" onclick="changeStatus({{ $value->id }}, {{ $value->status }})">
                     <i class="fas fa-check-circle"></i>
                     </a>
                     @endif
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
   @section('js')
   <script>
      $(function() {
          $('#dataTable').DataTable({
              "paging": true,
              "searching": true,
              "ordering": true,
              "responsive": true,
              "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 4] }, 
            ]
          });
      });
      
      function changeStatus(id, status) {
      
      cuteAlert({
          type: "question",
          title: "Are you sure",
          message: "You want to change the status of this item ?",
          confirmText: "Yes",
          cancelText: "Cancel"
          }).then((e)=>{
          if ( e == ("confirm")){
                  $.ajax({
                      url: "{{ url('admin/location/change-status') }}",
                      type: 'POST',
                      data: {
                          "_token": "{{ csrf_token() }}",
                          "id": id,
                          "status": status
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
                                          window.location.reload();
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
      }
   </script>
   @endsection
</x-admin>
