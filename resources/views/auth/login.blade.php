@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card max-w-2xl mx-auto">
                <div class="font-normal text-center text-2xl py-8">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="px-12 mb-3">
                            <label for="email" class="text-xs">{{ __('Email Address') }}</label>

                            <div class="mt-1">
                                <input id="email" type="email" class="border w-full border h-8 rounded focus:outline-none px-4 shadow-sm @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="px-12 mb-6">
                            <label for="password" class="text-xs">{{ __('Password') }}</label>

                            <div class="mt-1">
                                <input id="password" type="password" class="border w-full border h-8 rounded focus:outline-none px-4 shadow-sm @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="px-12 mb-6">
                            <div class="">
                                <div class="flex items-center">
                                    <input class="form-checkbox text-sky-500" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="ml-1 text-xs" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="px-12 mb-3">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="button">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="underline text-gray-400 ml-2 text-sm" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
