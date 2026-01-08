@extends('layouts.guest')

@section('title', 'Register - ConnectHub')

@section('content')
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto flex items-center justify-center min-h-[60vh]">
  <div class="sm:max-w-md w-full bg-white border border-gray-200 rounded-xl shadow-sm">
    <div class="p-4 sm:p-7">
      <div class="text-center">
        <h1 class="block text-2xl font-bold text-gray-800">Sign up</h1>
        <p class="mt-2 text-sm text-gray-600">
          Already have an account?
          <a class="text-blue-600 decoration-2 hover:underline font-medium" href="{{ route('login') }}">
            Sign in here
          </a>
        </p>
      </div>

      <div class="mt-5">
        <!-- Form -->
        <form action="{{ route('register') }}" method="POST">
          @csrf
          <div class="grid gap-y-4">
            <!-- Form Group -->
            <div>
              <label for="name" class="block text-sm mb-2">Full Name</label>
              <input type="text" id="name" name="name" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" value="{{ old('name') }}" required>
              @error('name') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>
            <!-- End Form Group -->

            <!-- Form Group -->
            <div>
              <label for="email" class="block text-sm mb-2">Email address</label>
              <input type="email" id="email" name="email" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" value="{{ old('email') }}" required>
              @error('email') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>
            <!-- End Form Group -->

            <!-- Form Group -->
            <div>
              <label for="password" class="block text-sm mb-2">Password</label>
              <input type="password" id="password" name="password" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" required>
              @error('password') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>
            <!-- End Form Group -->

            <!-- Form Group -->
            <div>
              <label for="password_confirmation" class="block text-sm mb-2">Confirm Password</label>
              <input type="password" id="password_confirmation" name="password_confirmation" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" required>
            </div>
            <!-- End Form Group -->

            <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">Sign up</button>
          </div>
        </form>
        <!-- End Form -->
      </div>
    </div>
  </div>
</div>
@endsection
