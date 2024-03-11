<x-admin>
    @section('title'){{ 'Create Role' }} @endsection
    <section class="content">
        <!-- Default box -->
        <div class="d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create New Role</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.role.index') }}"
                                class="btn btn-sm btn-dark">Back</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('admin.role.store') }}" method="POST"
                        class="needs-validation" novalidate="">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Role Name</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            required="" value="{{ old('name') }}">
                                            @error('name')
                                                <span>{{ $message }}</span>
                                            @enderror
                                        <div class="invalid-feedback">Role name field is required.</div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="permission" class="form-label">Permissions:*</label>
                                        <select name="permission[]" id="permission" class="form-control"  required multiple data-mdb-filter="true">
                                            <option value="" selected disabled>Selecte permissions</option>
                                            @foreach ($permissions as $permission)
                                                <option value="{{ $permission->name }}"
                                                {{ $permission->name == old('permission') ? 'selected' : '' }}>{{ $permission->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('permission')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
       
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer float-end float-right">
                            <button type="submit" id="submit"
                                class="btn btn-primary float-end float-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.card -->

    </section>
</x-admin>
