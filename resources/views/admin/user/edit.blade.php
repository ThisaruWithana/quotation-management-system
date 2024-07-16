<x-admin> @section('title', 'Users') 
    <div class="d-flex justify-content-center">
    <div class="col-lg-10">
      <div class="card card-primary">
        <h5 class="card-header  white-text text-left py-3">
          {{ $title }}

          <div class="card-tools">
              <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-primary">
                  <button type="button" class="btn btn-tool">
                          <i class="fas fa-times"></i>
                  </button>
              </a>
          </div>
        </h5>
        <div class="card-body px-lg-2 pt-0">
          <form action="{{ route('admin.user.update',$user) }}" method="POST" class="text-center border border-light p-5"> @method('PUT') @csrf <input type="hidden" name="id" value="{{ $user->id }}">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group text-left">
                  <label for="name" class="form-label">Name</label>
                  <span class="required"> * </span>
                  <input type="text" class="form-control" name="name" required value="{{ $user->name }}"> @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group text-left">
                  <label for="Email" class="form-label">Email</label>
                  <span class="required"> * </span>
                  <input type="email" class="form-control" name="email" required value="{{ $user->email }}"> @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group text-left">
                  <label for="role" class="form-label">Role</label>
                  <span class="required"> * </span>
                  <select name="role" id="role" class="selectpicker form-control show-tick" data-live-search="true" required>
                    <option value="" selected disabled>Selecte the role</option> @foreach ($roles as $role) <option value="{{ $role->name }}" {{ $user->roles[0]['name'] === $role->name ? 'selected' : '' }}>{{ $role->name }}</option> @endforeach
                  </select> @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3">
                <button class="btn btn-primary btn-block" type="submit">Save</button>
              </div>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  </div>
</x-admin>