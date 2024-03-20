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

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="sales_vat" class="form-label">Sales VAT</label>
                                            <span class="required"> * </span>
                                            <select name="sales_vat" id="sales_vat" class="form-control"  required data-mdb-filter="true">
                                                @foreach ($sales_vat as $value)
                                                    <option value="{{ $value->id }}" 
                                                    {{ $data->vat_id === $value->id ? 'selected' : '' }}>{{ $value->name }} - {{ $value->value }} %</option>
                                                @endforeach
                                            </select>

                                            @error('sales_vat')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
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

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="sales_vat" class="form-label">Sales VAT</label>
                                            <span class="required"> * </span>
                                            <select name="sales_vat" id="sales_vat" class="form-control"  required data-mdb-filter="true">
                                                @foreach ($sales_vat as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }} - {{ $value->value }} %</option>
                                                @endforeach
                                            </select>

                                            @error('sales_vat')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
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
