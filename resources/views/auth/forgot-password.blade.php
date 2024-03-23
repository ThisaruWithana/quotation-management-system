<x-guest-layout>
    @section('title')
        {{ 'Recover your password' }}
    @endsection
    <div class="login-box">
        <div class="card card-outline">
            <!-- <div class="card-header text-center">
                <a href="/" class="h1"><b>{{ config('app.name') }}</a>
            </div> -->
            <div class="card-body">

            <form class="text-center border border-light p-2" action="{{ route('login') }}" method="POST">
                @csrf
                <p class="h4 mb-4">Forgot Password</p>

                <!-- Email -->
                <input id="email" class="form-control" type="email" name="email" :value="old('email')"
                            required autofocus class="form-control mb-4" placeholder="E-mail">

                <x-input-error :messages="$errors->get('email')" class="text-danger" />
            
                <button class="btn btn-primary btn-block my-4" type="submit">Email Password Reset Link</button>

                </form>


               
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
</x-guest-layout>
