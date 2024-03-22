<x-admin>
   @section('title', 'Product Location')
   <section class="content">
      <!-- Default box -->
      <div class="d-flex justify-content-center">
         <div class="col-lg-6">
            <div class="card card-primary">
               <h5 class="card-header  white-text text-left py-3">
                  <!-- <strong>{{ $title }}</strong> -->
                  {{ $title }}
               </h5>
               <div class="card-body px-lg-2 pt-0">
                  <form class="text-center border border-light p-5" action="{{ route('admin.location.store') }}" method="POST">
                    @csrf

                    @if($page === 'edit')
                        <div class="col-lg-12">
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="form-group text-left">
                            <label for="name" class="form-label">Location Name</label>
                            <span class="required"> * </span>
                            <input type="text" class="form-control" name="name" id="name" required="" 
                                value="{{ $data->name }}" autocomplete="off"  placeholder="">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="invalid-feedback">Location name field is required.</div>
                            </div>
                        </div>
                    @else
                     <div class="col-lg-12">
                        <div class="form-group text-left">
                           <label for="name" class="form-label">Location Name</label>
                           <span class="required"> * </span>
                           <input type="text" class="form-control" name="name" id="name" required="" 
                              value="{{ old('name') }}" autocomplete="off"  placeholder="">
                           @error('name')
                           <span class="text-danger">{{ $message }}</span>
                           @enderror
                           <div class="invalid-feedback">Location name field is required.</div>
                        </div>
                     </div>
                    @endif
                     <div class="col-lg-4">
                        <button class="btn btn-primary btn-block" type="submit">Save</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <!-- /.card -->
   </section>
</x-admin>
