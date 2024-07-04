<x-admin>
   @section('title')  {{ 'Customers' }} @endsection
    <section class="content">
        <!-- Default box -->
        <div class="d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card card-primary">
                <h5 class="card-header  white-text text-left py-3">
                    <!-- <strong>{{ $title }}</strong> -->
                    {{ $title }}

                    <div class="card-tools">
                        <a href="{{ route('admin.customer.index') }}" class="btn btn-sm btn-primary">
                            <button type="button" class="btn btn-tool">
                                <i class="fas fa-times"></i>
                            </button>
                        </a>
                    </div>
                </h5>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('admin.customer.store') }}" method="POST"
                    class="text-center border border-light p-5" >
                        @csrf
                        <div class="card-body px-lg-2 pt-0">
                            <div class="row">
                                @if($page === 'edit')
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                    <div class="col-lg-12">
                                        <div class="form-group text-left">
                                            <label for="name" class="form-label">Customer Name</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                required="" value="{{ $data->name }}" autocomplete="off">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-left">
                                            <label for="contact_person" class="form-label">Contact Person</label>
                                            <span class="required"> * </span>
                                            <input type="text" class="form-control" name="contact_person" id="contact_person"
                                                required="" value="{{ $data->contact_person }}"  autocomplete="off">
                                                @error('contact_person')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-left">
                                            <label for="address" class="form-label">Address</label>
                                            <span class="required"> * </span>
                                            <textarea class="form-control" name="address" id="address"
                                                required="">{{ $data->address }}</textarea>
                                                @error('address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group text-left">
                                            <label for="postal_code" class="form-label">Postal Code</label>
                                            <input type="text" class="form-control" name="postal_code" id="postal_code"
                                              value="{{ $data->postal_code }}"  autocomplete="off">
                                                @error('postal_code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div><div class="col-lg-6">
                                        <div class="form-group text-left">
                                            <label for="tel" class="form-label">Telephone Number</label>
                                            <span class="required"> * </span>
                                            <input type="text" class="form-control" name="tel" id="tel"
                                                required=""  value="{{ $data->tel }}" autocomplete="off">
                                                @error('tel')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group text-left">
                                            <label for="mobile" class="form-label">Mobile Number</label>
                                            <input type="text" class="form-control" name="mobile" id="mobile"
                                                value="{{ $data->mobile }}" autocomplete="off">
                                                @error('mobile')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group text-left">
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
                                        <div class="form-group text-left">
                                            <label for="symbol_group" class="form-label">Symbol Group</label>
                                            <input type="text" class="form-control" name="symbol_group" id="symbol_group"
                                                value="{{ $data->symbol_group }}" autocomplete="off">
                                                @error('symbol_group')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group text-left">
                                            <label for="ctype" class="form-label">Customer Type</label>
                                            <span class="required"> * </span>
                                            <select name="ctype" id="ctype" class="selectpicker form-control show-tick" required>
                                                <option value="Prospective" @if ($data->type == 'Prospective') selected @endif>Prospective</option>
                                                <option value="Accepted" @if ($data->type == 'Accepted') selected @endif>Accepted</option>
                                                <option value="Installed" @if ($data->type == 'Installed') selected @endif>Installed</option>
                                            </select>
                                            @error('ctype')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @else
                                    <div class="col-lg-12">
                                        <div class="form-group text-left">
                                            <label for="name" class="form-label">Customer Name</label>
                                            <span class="required"> * </span>
                                            <input type="text" class="form-control" name="name" id="name"
                                                required="" value="{{ old('name') }}" autocomplete="off">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-left">
                                            <label for="contact_person" class="form-label">Contact Person</label>
                                            <span class="required"> * </span>
                                            <input type="text" class="form-control" name="contact_person" id="contact_person"
                                                required="" value="{{ old('contact_person') }}"  autocomplete="off">
                                                @error('contact_person')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-left">
                                            <label for="address" class="form-label">Address</label>
                                            <span class="required"> * </span>
                                            <textarea class="form-control" name="address" id="address"
                                                required=""></textarea>
                                                @error('address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group text-left">
                                            <label for="postal_code" class="form-label">Postal Code</label>
                                            <input type="text" class="form-control" name="postal_code" id="postal_code"
                                              value="{{ old('postal_code') }}" autocomplete="off">
                                                @error('postal_code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group text-left">
                                            <label for="tel" class="form-label">Telephone Number</label>
                                            <span class="required"> * </span>
                                            <input type="text" class="form-control" name="tel" id="tel"
                                                required=""  value="{{ old('tel') }}" autocomplete="off">
                                                @error('tel')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group text-left">
                                            <label for="mobile" class="form-label">Mobile Number</label>
                                            <input type="text" class="form-control" name="mobile" id="mobile"
                                                value="{{ old('mobile') }}" autocomplete="off">
                                                @error('mobile')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group text-left">
                                            <label for="email" class="form-label">Email</label>
                                            <span class="required"> * </span>
                                            <input type="email" class="form-control" name="email" id="email"
                                                required=""  value="{{ old('email') }}" autocomplete="off">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group text-left">
                                            <label for="symbol_group" class="form-label">Symbol Group</label>
                          
                                            <input type="text" class="form-control" name="symbol_group" id="symbol_group"
                                                value="{{ old('symbol_group') }}" autocomplete="off">
                                                @error('symbol_group')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group text-left">
                                            <label for="ctype" class="form-label">Customer Type</label>
                                            <span class="required"> * </span>
                                            <select name="ctype" id="ctype" class="selectpicker form-control show-tick" required>
                                                <option value="Prospective">Prospective</option>
                                                <option value="Accepted">Accepted</option>
                                                <option value="Installed">Installed</option>
                                            </select>

                                            @error('ctype')
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
