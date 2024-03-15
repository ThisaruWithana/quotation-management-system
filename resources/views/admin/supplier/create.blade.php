<x-admin>
    @section('title'){{ $title }} @endsection
    <section class="content">
        <!-- Default box -->
        <div class="d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $title }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.supplier.index') }}"
                                class="btn btn-sm btn-dark">Back</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('admin.supplier.store') }}" method="POST"
                        class="needs-validation" novalidate="">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                @if($page === 'edit')
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Supplier Name</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                required="" value="{{ $data->name }}" autocomplete="off">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <div class="invalid-feedback">Supplier Name is required.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="contact_person" class="form-label">Contact Person</label>
                                            <span class="required"> * </span>
                                            <input type="text" class="form-control" name="contact_person" id="contact_person"
                                                required="" value="{{ $data->contact_person }}"  autocomplete="off">
                                                @error('contact_person')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <div class="invalid-feedback">Contact Person is required.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="address" class="form-label">Address</label>
                                            <span class="required"> * </span>
                                            <textarea class="form-control" name="address" id="address"
                                                required="">{{ $data->address }}</textarea>
                                                @error('address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <div class="invalid-feedback">Address is required.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="postal_code" class="form-label">Postal Code</label>
                                            <input type="text" class="form-control" name="postal_code" id="postal_code"
                                              value="{{ $data->postal_code }}"  autocomplete="off">
                                                @error('postal_code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div><div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="tel" class="form-label">Telephone Number</label>
                                            <span class="required"> * </span>
                                            <input type="text" class="form-control" name="tel" id="tel"
                                                required=""  value="{{ $data->tel }}" autocomplete="off">
                                                @error('tel')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <div class="invalid-feedback">Telephone Number is required.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="mobile" class="form-label">Mobile Number</label>
                                            <input type="text" class="form-control" name="mobile" id="mobile"
                                                value="{{ $data->mobile }}" autocomplete="off">
                                                @error('mobile')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <span class="required"> * </span>
                                            <input type="text" class="form-control" name="email" id="email"
                                                required=""  value="{{ $data->email }}" autocomplete="off">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <div class="invalid-feedback">Email is required.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="website" class="form-label">Web Address</label>
                                            <input type="text" class="form-control" name="website" id="website"
                                                value="{{ $data->website }}" autocomplete="off">
                                                @error('website')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                @else
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Supplier Name</label>
                                            <span class="required"> * </span>
                                            <input type="text" class="form-control" name="name" id="name"
                                                required="" value="{{ old('name') }}" autocomplete="off">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <div class="invalid-feedback">Supplier Name is required.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="contact_person" class="form-label">Contact Person</label>
                                            <span class="required"> * </span>
                                            <input type="text" class="form-control" name="contact_person" id="contact_person"
                                                required="" value="{{ old('contact_person') }}"  autocomplete="off">
                                                @error('contact_person')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <div class="invalid-feedback">Contact Person is required.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="address" class="form-label">Address</label>
                                            <span class="required"> * </span>
                                            <textarea class="form-control" name="address" id="address"
                                                required=""></textarea>
                                                @error('address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <div class="invalid-feedback">Address is required.</div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="postal_code" class="form-label">Postal Code</label>
                                            <input type="text" class="form-control" name="postal_code" id="postal_code"
                                              value="{{ old('postal_code') }}" autocomplete="off">
                                                @error('postal_code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="tel" class="form-label">Telephone Number</label>
                                            <span class="required"> * </span>
                                            <input type="text" class="form-control" name="tel" id="tel"
                                                required=""  value="{{ old('tel') }}" autocomplete="off">
                                                @error('tel')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <div class="invalid-feedback">Telephone Number is required.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="mobile" class="form-label">Mobile Number</label>
                                            <input type="text" class="form-control" name="mobile" id="mobile"
                                                value="{{ old('mobile') }}" autocomplete="off">
                                                @error('mobile')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <span class="required"> * </span>
                                            <input type="text" class="form-control" name="email" id="email"
                                                required=""  value="{{ old('email') }}" autocomplete="off">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            <div class="invalid-feedback">Email is required.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="website" class="form-label">Web Address</label>
                                            <input type="text" class="form-control" name="website" id="website"
                                                value="{{ old('website') }}" autocomplete="off">
                                                @error('website')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                @endif
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
