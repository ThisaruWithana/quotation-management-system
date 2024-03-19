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
                            <a href="{{ route('admin.department.index') }}"
                                class="btn btn-sm btn-dark">Back</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('admin.department.store') }}" method="POST"
                        class="needs-validation" novalidate="">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                @if($page === 'edit')
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Department Name</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                required="" value="{{ $data->name }}" autocomplete="off">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <div class="invalid-feedback">Department Name is required.</div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="code" class="form-label">Code</label>
                                            <input type="text" class="form-control" name="code" id="code"
                                                value="{{ $data->code }}"  autocomplete="off">
                                                @error('code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div> -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="sales_vat" class="form-label">Sales VAT Name</label>
                                            <input type="text" class="form-control" name="sales_vat" id="sales_vat"
                                                value="{{ $vat['name'] }}" disabled>
                                                <input type="hidden" name="vat_id" id="vat_id" value="{{ $vat['id'] }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="sales_vat" class="form-label">Sales VAT Rate (%)</label>
                                            <input type="text" class="form-control" name="sales_vat" id="sales_vat"
                                                value="{{ $vat['value'] }}" disabled>
                                                <input type="hidden" name="vat_id" id="vat_id" value="{{ $vat['id'] }}">
                                        </div>
                                    </div>
                                    
                                @else
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Department Name</label>
                                            <span class="required"> * </span>
                                            <input type="text" class="form-control" name="name" id="name"
                                                required="" value="{{ old('name') }}" autocomplete="off">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <div class="invalid-feedback">Department Name is required.</div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="code" class="form-label">Code</label>
                                            <input type="text" class="form-control" name="code" id="code"
                                                value="{{ old('code') }}"  autocomplete="off">
                                                @error('code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div> -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="sales_vat" class="form-label">Sales VAT Name</label>
                                            <input type="text" class="form-control" name="sales_vat" id="sales_vat"
                                                value="{{ $vat['name'] }}" disabled>
                                                <input type="hidden" name="vat_id" id="vat_id" value="{{ $vat['id'] }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="sales_vat" class="form-label">Sales VAT Rate (%)</label>
                                            <input type="text" class="form-control" name="sales_vat" id="sales_vat"
                                                value="{{ $vat['value'] }}" disabled>
                                                <input type="hidden" name="vat_id" id="vat_id" value="{{ $vat['id'] }}">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer float-end">
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
