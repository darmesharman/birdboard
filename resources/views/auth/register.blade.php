@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card max-w-2xl mx-auto">
                <div class="font-normal text-center text-2xl py-8">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="px-12 mb-3">
                            <label for="name" class="text-xs">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="border w-full border h-8 rounded focus:outline-none px-4 shadow-sm  @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="px-12 mb-3">
                            <label for="email" class="text-xs">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="border w-full border h-8 rounded focus:outline-none px-4 shadow-sm  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="px-12 mb-3">
                            <label for="password" class="text-xs">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="border w-full border h-8 rounded focus:outline-none px-4 shadow-sm  @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="px-12 mb-6">
                            <label for="password-confirm" class="text-xs">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="border w-full border h-8 rounded focus:outline-none px-4 shadow-sm " name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="px-12 mb-3">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="button">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
