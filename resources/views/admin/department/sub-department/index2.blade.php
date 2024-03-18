<x-admin>
   @section('title')  {{ $title }} @endsection

   <div class="row">
<div class="col-12 col-sm-12">
   <div class="card card-primary card-tabs">
      <div class="card-header p-0 pt-1">
         <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
               <a class="nav-link active" id="custom-tabs-one-department-tab" data-toggle="pill" href="#custom-tabs-one-department" role="tab" aria-controls="custom-tabs-one-department" aria-selected="true">{{ $title }}</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="custom-tabs-one-subdepartment-tab" data-toggle="pill" href="#custom-tabs-one-subdepartment" role="tab" aria-controls="custom-tabs-one-subdepartment" aria-selected="false">Sub Department</a>
            </li>
         </ul>
      </div>
      <div class="card-body">
         <div class="tab-content" id="custom-tabs-one-tabContent">

            <div class="tab-pane fade show active" id="custom-tabs-one-department" role="tabpanel" aria-labelledby="custom-tabs-one-department-tab">
                <div class="">
                    <a href="{{ route('admin.department.create') }}" class="btn btn-sm btn-primary">Add</a>
                </div>
                <div>
                  <table class="table table-striped" id="dataTable">
                     <thead>
                        <tr>
                           <!-- <th>Code</th> -->
                           <th>Name</th>
                           <th>VAT Rate (%)</th>
                           <th>Status</th>
                           <th>Created By</th>
                           <th>Created At</th>
                           <th>Action</th>
                           <th></th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $i = 1; ?>
                        @foreach ($data as $value)
                        <tr>
                           <!-- <td>{{ $value->code }}</td> -->
                           <td>{{ $value->name }}</td>
                           <td>{{ $value->vat->name }} - {{ $value->vat->value }}</td>
                           <td>
                              @if($value->status == 1)
                              <span class="badge badge-success">Active</span>
                              @else 
                              <span class="badge badge-warning">Deactive</span>
                              @endif
                           </td>
                           <td>{{ $value->created_user->name }}</td>
                           <td>{{ date('Y-m-d H:i:s', strtotime($value->created_at)) }}</td>
                           <td>
                              <a href="{{ route('admin.department.edit',encrypt($value->id)) }}" class="btn btn-sm btn-secondary">
                              <i class="far fa-edit"></i>
                              </a>
                           </td>
                           <td>
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
                        <?php $i++; ?>
                        @endforeach
                     </tbody>
                  </table>
                </div>
            </div>

            <div class="tab-pane fade" id="custom-tabs-one-subdepartment" role="tabpanel" aria-labelledby="custom-tabs-one-subdepartment-tab">
                <div class="">
                    <a href="{{ route('admin.department.sub.create') }}" class="btn btn-sm btn-primary">Add</a>
                </div>
                <div>
                  <table class="table table-striped" id="dataTable">
                     <thead>
                        <tr>
                           <!-- <th>Code</th> -->
                           <th>Name</th>
                           <th>VAT Rate (%)</th>
                           <th>Status</th>
                           <th>Created By</th>
                           <th>Created At</th>
                           <th>Action</th>
                           <th></th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $i = 1; ?>
                        @foreach ($subDepartments as $value)
                        <tr>
                           <!-- <td>{{ $value->code }}</td> -->
                           <td>{{ $value->name }}</td>
                           <td>{{ $value->departments->name }}</td>
                           <td>
                              @if($value->status == 1)
                              <span class="badge badge-success">Active</span>
                              @else 
                              <span class="badge badge-warning">Deactive</span>
                              @endif
                           </td>
                           <td>{{ $value->created_user->name }}</td>
                           <td>{{ date('Y-m-d H:i:s', strtotime($value->created_at)) }}</td>
                           <td>
                              <a href="{{ route('admin.department.sub.edit',encrypt($value->id)) }}" class="btn btn-sm btn-secondary">
                              <i class="far fa-edit"></i>
                              </a>
                           </td>
                           <td>
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
                        <?php $i++; ?>
                        @endforeach
                     </tbody>
                  </table>
                </div>
            </div>
         </div>
      </div>
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
          });
          
          $('.sub-departments').DataTable({
              "paging": true,
              "searching": true,
              "ordering": true,
              "responsive": true,
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
                      url: "{{ url('admin/department/change-status') }}",
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
