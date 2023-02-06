@if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <input type="email" name="email" :value="old('email')" required  class="form-control" id="useremail" placeholder="Enter email">

            </div>

            <!-- Password -->
            <div class="mt-4">
                <input type="password"  name="password"  required class="form-control" id="userpassword" placeholder="Enter password">

            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <input type="password"  name="password_confirmation" required  class="form-control" id="userpassword" placeholder="Enter password">

            </div>

            <div class="flex items-center justify-end mt-4">
                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>

            </div>
        </form>

