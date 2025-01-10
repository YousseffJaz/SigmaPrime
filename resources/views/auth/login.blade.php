@extends('layouts.myapp')
@section('content')
    <div class="grid place-items-center h-screen">
        <div class="border p-5 md:w-1/2 w-4/5 bg-sec-100 -mt-48">
            <form method="POST" action="{{ route('login', ['car_id' => $car_id ?? '']) }}">
                @csrf
                <div class="mb-6">
                    <label for="identity_card_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your CIN</label>
                    <input type="text" id="identity_card_number" name="identity_card_number" value="{{ old('identity_card_number') }}"
                        class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5"
                        placeholder="Enter your CIN">
                    @error('identity_card_number')
                        <span>
                            <strong class="text-red-500">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="flex items-start mb-6">
                    <div class="flex items-center h-5">
                        <input id="remember" type="checkbox" value=""
                            class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-pr-300"
                            name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    </div>
                    <label for="remember" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember
                        me</label>
                </div>

                <button type="submit"
                    class="text-white bg-pr-400 hover:bg-pr-600 focus:ring-4 focus:outline-none focus:ring-pr-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-pr-600 dark:hover:bg-pr-700 dark:focus:ring-pr-800">
                    Login
                </button>

                @if (Route::has('password.request'))
                    <a class="m-2 text-gray-600 hover:text-blue-600 hover:cursor-pointer" href="{{ route('password.request') }}">
                        {{ __('Forgot Your CIN?') }}
                    </a>
                @endif

                
            </form>
        </div>
    </div>
@endsection
