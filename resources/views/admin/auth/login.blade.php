@extends('admin.auth.register')
@section('register')

    <div class="wrapper-page">

        <div class="card">
            <div class="card-body">

                <div class="auth-logo">
                    <h3 class="text-center">

                        <h3 class="text-center text-danger">admin</h3>


                    </h3>
                </div>

                <div class="p-3">
                    <h4 class="text-muted font-size-18 text-center">Welcome Back !</h4>
                    <p class="text-muted text-center">Sign in to continue to Agroxa.</p>
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600">
                                {{ __('Whoops! Something went wrong.') }}
                            </div>

                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="form-horizontal" action="{{route('login')}}" method="post">
@csrf
                        <div class="mb-3">
                            <label class="form-label" for="useremail">Email</label>
                            <input type="email" name="email" :value="old('email')" required  class="form-control" id="useremail" placeholder="Enter email">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="userpassword">Password</label>
                            <input type="password"  name="password"  required class="form-control" id="userpassword" placeholder="Enter password">
                        </div>

                        <div class="mb-3 row text-center">
{{--                            <div class="col-6">--}}
{{--                                <div class="form-check">--}}
{{--                                    <input name="remember" value="1" type="checkbox" class="form-check-input" id="customControlInline">--}}
{{--                                    <label  class="form-check-label" for="customControlInline">Remember--}}
{{--                                        me</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-6 text-end">
                                <button class="btn btn-primary w-md waves-effect waves-light text-center" type="submit">Log In</button>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-12">
                                <a ass="col-12">
                                    <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your
                                    password?</a>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>

        <div class="text-center">
{{--            <p class="text-white-50">Don't have an account ? <a href="{{route('register')}}" class="text-white"> Signup Now--}}
                </a> </p>
            <p class="text-muted">
                ©
                <script>document.write(new Date().getFullYear())</script> Agroxa. Crafted with <i
                    class="mdi mdi-heart text-primary"></i> by
                Salhi
            </p>
        </div>

    </div>
@endsection
