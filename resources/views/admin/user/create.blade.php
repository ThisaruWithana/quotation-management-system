<x-admin> @section('title', 'Users') 
    <div class="d-flex justify-content-center">
    <div class="col-lg-10">
      <div class="card card-primary">
        <h5 class="card-header  white-text text-left py-3">
          {{ $title }}
        </h5>
        <div class="card-body px-lg-2 pt-0">
          <form action="{{ route('admin.user.store') }}" method="POST" class="text-center border border-light p-5"> 
            @csrf 
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group text-left">
                  <label for="name" class="form-label">Name</label>
                  <span class="required"> * </span>
                  <input type="text" class="form-control" name="name" required value="{{ old('name') }}"> 
                    @error('name') 
                    <span class="text-danger">{{ $message }}</span> 
                    @enderror
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group text-left">
                  <label for="Email" class="form-label">Email</label>
                  <span class="required"> * </span>
                  <input type="email" class="form-control" name="email" required value="{{ old('email') }}"> 
                    @error('email') 
                    <span class="text-danger">{{ $message }}</span> 
                    @enderror
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group text-left">
                  <label for="Password" class="form-label">Password</label>
                  <span class="required"> * </span>
                  <input type="password" class="form-control" name="password" required> @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group text-left">
                  <label for="role" class="form-label">Role</label>
                  <span class="required"> * </span>
                  <select name="role" id="role" class="browser-default custom-select mb-4 selectpicker" required>
                    <option value="" selected disabled>selecte the role</option> @foreach ($roles as $role) <option value="{{ $role->name }}" {{ $role->name == old('role') ? 'selected' : '' }}>{{ $role->name }}</option> @endforeach
                  </select> @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>
              <div class="col-lg-3">
                <button class="btn btn-primary btn-block" type="submit">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-admin>