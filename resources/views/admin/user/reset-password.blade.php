<x-admin> @section('title', 'Users') 
    <div class="d-flex justify-content-center">
    <div class="col-lg-8">
      <div class="card card-primary">
        <h5 class="card-header  white-text text-left py-3">
          {{ $title }} - {{ $user->name }}

          <div class="card-tools">
              <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-primary">
                  <button type="button" class="btn btn-tool">
                          <i class="fas fa-times"></i>
                  </button>
              </a>
          </div>
        </h5>
        <div class="card-body px-lg-2 pt-0">
          <form action="{{ url('admin/user/change-password') }}" method="POST" class="text-center border border-light p-5">
             @csrf <input type="hidden" name="id" value="{{ $user->id }}">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group text-left">
                  <label for="password" class="form-label">New Password</label>
                  <span class="required"> * </span>
                  <input type="password" class="form-control" id="password" name="password" required autocomplete="off" required title="Minimum 5 characters">
                   @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>
              
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group text-left">
                  <label for="confirm_password" class="form-label">Confirm Password</label>
                  <span class="required"> * </span>
                  <input type="password" class="form-control" name="confirm_password" id="confirm_password" required autocomplete="off" onkeyup = "checkPasswordConfirmation()">
                   @error('confirm_password') <span class="text-danger">{{ $message }}</span> @enderror
                   <div class="text-danger" id="divCheckPasswordMatch"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3">
                <button class="btn btn-primary btn-block" type="submit" id= "btnSave">Save</button>
              </div>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  </div>
  @section('js')
        <script>
            $("#btnSave").prop('disabled', true);

            function checkPasswordConfirmation() {
                var newPassword = $("#password").val();
                var confirmPassword = $("#confirm_password").val();

                if (newPassword != confirmPassword){
                    $("#divCheckPasswordMatch").show();
                    $("#divCheckPasswordMatch").html("Passwords do not match!");
                    $("#btnSave").prop('disabled', true);

                }else{
                    if(newPassword.length >= 5){
                        $("#divCheckPasswordMatch").hide();
                        $("#divCheckPasswordMatch").html("Passwords match.");
                        $("#btnSave").prop('disabled', false);

                    }else{
                        $("#divCheckPasswordMatch").show();
                        $("#divCheckPasswordMatch").html("Password Length should be minimum 5 characters.");
                        $("#btnSave").prop('disabled', true);
                    }
                }

            }
        </script>
    @endsection
</x-admin>