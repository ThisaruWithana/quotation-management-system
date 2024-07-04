<x-admin>
    @section('title'){{ 'Role Permission' }} @endsection
    <section class="content">
        <!-- Default box -->
        <div class="d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="card card-primary">
                    
                    <h5 class="card-header  white-text text-left py-3">
                        {{ $title }}

                        <div class="card-tools">
                            <a href="{{ route('admin.permission.index') }}" class="btn btn-sm btn-primary">
                                <button type="button" class="btn btn-tool">
                                        <i class="fas fa-times"></i>
                                </button>
                            </a>
                        </div>
                    </h5>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('admin.permission.store') }}" method="POST"
                        class="text-center border border-light p-5">
                        @csrf
                        <div class="card-body px-lg-2 pt-0">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group text-left">
                                        <label for="name" class="form-label">Permission Name</label>
                                        <span class="required"> * </span>
                                        <input type="text" class="form-control" name="name" id="name"
                                            required="" value="{{ old('name') }}">
                                            @error('name')
                                                <span>{{ $message }}</span>
                                            @enderror
                                        <div class="invalid-feedback">Permission name field is required.</div>
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
