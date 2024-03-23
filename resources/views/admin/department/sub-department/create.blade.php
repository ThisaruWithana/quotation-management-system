<x-admin>
@section('title')  {{ 'Sub Departments' }} @endsection
    <section class="content">
        <!-- Default box -->
        <div class="d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="card card-primary">
               <h5 class="card-header  white-text text-left py-3">
                  {{ $title }}
               </h5>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('admin.department.sub.store') }}" method="POST"
                    class="text-center border border-light p-5">
                        @csrf
               <div class="card-body px-lg-2 pt-0">
                            <div class="row">
                                @if($page === 'edit')
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                    <div class="col-lg-12">
                                        <div class="form-group text-left">
                                            <label for="name" class="form-label">Sub Department Name</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                required="" value="{{ $data->name }}" autocomplete="off">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <div class="invalid-feedback">Sub Department Name is required.</div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-12">
                                        <div class="form-group text-left">
                                            <label for="code" class="form-label">Code</label>
                                            <input type="text" class="form-control" name="code" id="code"
                                                value="{{ $data->code }}"  autocomplete="off">
                                                @error('code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div> -->

                                    <div class="col-lg-12">
                                        <div class="form-group text-left">
                                            <label for="department" class="form-label">Department</label>
                                            <span class="required"> * </span>
                                            <select name="department" id="department" class="form-control"  required data-mdb-filter="true">
                                                <option value="" selected disabled>Selecte department</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}"
                                                         {{ $data->departments['name'] === $department->name ? 'selected' : '' }}>{{ $department->name }}</option>
                                                @endforeach
                                            </select>

                                            @error('permission')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @else
                                    <div class="col-lg-12">
                                        <div class="form-group text-left">
                                            <label for="name" class="form-label">Sub Department Name</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                required="" value="{{ old('name') }}" autocomplete="off">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <div class="invalid-feedback">Sub Department Name is required.</div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-12">
                                        <div class="form-group text-left">
                                            <label for="code" class="form-label">Code</label>
                                            <input type="text" class="form-control" name="code" id="code"
                                                value="{{ old('code') }}"  autocomplete="off">
                                                @error('code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div> -->
                                
                                    <div class="col-lg-6">
                                        <div class="form-group text-left">
                                            <label for="department" class="form-label">Department</label>
                                            <span class="required"> * </span>
                                            <select name="department" id="department"  class="browser-default custom-select mb-4 selectpicker"  required data-mdb-filter="true">
                                                <option value="" selected disabled>Selecte department</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}"
                                                    {{ $department->id == old('department') ? 'selected' : '' }}>{{ $department->name }}</option>
                                                @endforeach
                                            </select>

                                            @error('department')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- /.card-body -->
                     <div class="col-lg-4">
                        <button class="btn btn-primary btn-block" type="submit">Save</button>
                     </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.card -->

    </section>
</x-admin>
