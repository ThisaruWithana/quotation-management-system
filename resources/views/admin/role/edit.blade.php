<x-admin>
@section('css')
@stop

    @section('title'){{ 'User Roles' }} @endsection

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
                    <form action="{{ route('admin.role.store') }}" method="POST"
                        class="text-center border border-light p-5">
                        @csrf
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <div class="card-body px-lg-2 pt-0">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group text-left">
                                        <label for="name" class="form-label">Role Name</label>
                                        <span class="required"> * </span>
                                        <input type="text" class="form-control" name="name" id="name"
                                            required="" value="{{ $data->name }}">
                                            @error('name')
                                                <span>{{ $message }}</span>
                                            @enderror
                                        <div class="invalid-feedback">Role name field is required.</div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group text-left">
                                        <label for="permission" class="form-label">Permissions</label>
                                        <span class="required"> * </span>
                                        <select name="permission[]" id="permission" required multiple class="selectpicker form-control show-tick" data-live-search="true">
                                            <option value="" selected disabled>Selecte permissions</option>
                                            @foreach ($permissions as $permission)
                                                <option value="{{ $permission->name }}"
                                                {{in_array($permission->id, $selectedPermissions) ? 'selected' : ''}}>{{ $permission->name }}</option>
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

@section('js')


@stop