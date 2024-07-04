<x-admin>
@section('title')  {{ 'Departments' }} @endsection
    <section class="content">
        <!-- Default box -->
        <div class="d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="card card-primary">
               <h5 class="card-header  white-text text-left py-3">
                  {{ $title }}

                    <div class="card-tools">
                        <a href="{{ route('admin.department.index') }}" class="btn btn-sm btn-primary">
                            <button type="button" class="btn btn-tool">
                                <i class="fas fa-times"></i>
                            </button>
                        </a>
                    </div>

               </h5>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('admin.department.store') }}" method="POST"
                    class="text-center border border-light p-5">
                        @csrf
               <div class="card-body px-lg-2 pt-0">
                            <div class="row">
                                @if($page === 'edit')
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                    <div class="col-lg-12">
                                        <div class="form-group text-left">
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
                                        <div class="form-group text-left">
                                            <label for="sales_vat" class="form-label">Sales VAT</label>
                                            <span class="required"> * </span>
                                            <select name="sales_vat" id="sales_vat" class="selectpicker form-control show-tick" data-live-search="true" required>
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
                                        <div class="form-group text-left">
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
                                        <div class="form-group text-left">
                                            <label for="sales_vat" class="form-label">Sales VAT</label>
                                            <span class="required"> * </span>
                                            <select name="sales_vat" id="sales_vat" class="selectpicker form-control show-tick" data-live-search="true" required>
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
