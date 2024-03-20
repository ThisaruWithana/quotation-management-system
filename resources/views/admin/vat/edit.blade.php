<x-admin>
    @section('title'){{ $title }} @endsection
    <section class="content">
        <!-- Default box -->
        <div class="d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $title }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.vat.index') }}"
                                class="btn btn-sm btn-dark">Back</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('admin.vat.update',$data) }}" method="POST"
                        class="needs-validation" novalidate="">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="name" class="form-label">VAT Name</label>
                                            <span class="required"> * </span>
                                            <input type="text" class="form-control" name="name" id="name"
                                                required="" value="{{ $data->name }}" autocomplete="off" disabled>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <div class="invalid-feedback">VAT Name is required.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="rate" class="form-label">VAT Rate (%)</label>
                                            <span class="required"> * </span>
                                            <input type="number" class="form-control" name="rate" id="rate"
                                                required="" value="{{ $data->value }}" autocomplete="off">
                                                @error('rate')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <div class="invalid-feedback">VAT Rate is required.</div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer float-end float-right">
                            <button type="submit" id="submit"
                                class="btn btn-primary float-end float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.card -->

    </section>
</x-admin>
