<x-admin>
    @section('title'){{ $title }} @endsection
    <section class="content">
        <!-- Default box -->
        <div class="d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="card card-primary">
               
                    <h5 class="card-header  white-text text-left py-3">
                        <!-- <strong>{{ $title }}</strong> -->
                        {{ $title }}
                    </h5>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('admin.vat.update',$data) }}" method="POST"
                    class="text-center border border-light p-5">
                        @method('PUT')
                        @csrf
                        <div class="card-body px-lg-2 pt-0">
                            <div class="row">
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                    <div class="col-lg-12">
                                        <div class="form-group text-left">
                                            <label for="name" class="form-label">VAT Name</label>
                                            <span class="required"> * </span>
                                            <input type="text" class="form-control" name="name" id="name"
                                                required="" value="{{ $data->name }}" autocomplete="off" readonly>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <div class="invalid-feedback">VAT Name is required.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-left">
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
