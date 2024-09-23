<x-guest-layout>
    @section('title')
        {{ 'Log in' }}
    @endsection

    
    <div class="login-box">
        <div class="card card-outline">
            <div class="card-body">

                <form class="text-center border border-light p-2" action="{{ url('otp/verify') }}" method="POST">
                @csrf
                <p class="h4 mb-4">Two Factor Authentication</p>
                <p class="login-box-msg">Enter the code that has been sent to your email.</p>

                <input id="otp" type="text" name="otp" 
                            required autocomplete="off" class="form-control mb-4" placeholder="Authentication Code">
                           
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <span class="alert-warning-sm">{{ $error }}</span>
                        @endforeach
                     </div>
                @endif

                @if (Session::has('otpmsg'))
                    <span class="text-danger">{{ session('otpmsg') }}</span>
                @endif

                <button class="btn btn-primary btn-block my-4" type="submit">Verify</button>
                
                <div class="form-group" id="resend" name="resend" hidden>
                    <p class="verify-code">Didn't received the code <a href="{{ url('otp/resend') }}">Resend</a>
                    </p>
                </div>

                </form>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</x-guest-layout>
<script>
        window.onload = function() {
            document.getElementsByName("resend")[0].hidden = true;
            setTimeout(function() {
                var element = document.getElementsByName("resend")[0];
                element.hidden = false;
            }, 30000);
        }

    </script>