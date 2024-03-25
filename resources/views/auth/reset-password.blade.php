<x-guest-layout>
    <!-- Password -->
    @section('title')
        {{ 'Reset Your Password' }}
    @endsection

    <div class="login-box">
        <div class="card card-outline">
            <!-- <div class="card-header text-center">
                <a href="/" class="h1"><b>{{ config('app.name') }}</a>
            </div> -->
            <div class="card-body">
                
                <p class="h4 mb-4 text-center">Reset Password</p>

                <p class="login-box-msg" style="font-size:15px;">You are only one step a way from your new password, recover your password now.
                </p>
                <form method="POST" action="{{ route('password.store') }}" class="text-center border border-light p-2">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <div class="input-group mb-3">
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" readonly />
                        <x-input-error :messages="$errors->get('email')" class="text-danger" />
                    </div>
                    <div class="input-group mb-3">
                        <input id="password" class="form-control" type="password" name="password" required
                            autocomplete="new-password" placeholder="Enter your new password">
                        <x-input-error :messages="$errors->get('password')" class="text-danger" />
                    </div>
                    <div class="input-group mb-3">
                        <input id="password_confirmation" class="form-control" type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Confirm Password">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger" />
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ route('login') }}">Sign in</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
</x-guest-layout>
