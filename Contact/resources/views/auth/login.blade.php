@extends('layouts.guest')

@section('title', 'Login - ConnectHub')

@section('content')
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto flex items-center justify-center min-h-[60vh]">
  <div class="sm:max-w-md w-full bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-slate-900 dark:border-gray-700">
    <div class="p-4 sm:p-7">
      <div class="text-center">
        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Sign in</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
          Don't have an account yet?
          <a class="text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('register') }}">
            Sign up here
          </a>
        </p>
      </div>

      <div class="mt-5">
        <!-- Form -->
        <form action="{{ route('login') }}" method="POST">
          @csrf
          <div class="grid gap-y-4">
            <!-- Form Group -->
            <div>
              <label for="email" class="block text-sm mb-2 dark:text-white">Email address</label>
              <div class="relative">
                <input type="email" id="email" name="email" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" value="{{ old('email') }}" required>
              </div>
              @error('email') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>
            <!-- End Form Group -->

            <!-- Form Group -->
            <div>
              <div class="flex justify-between items-center">
                <label for="password" class="block text-sm mb-2 dark:text-white">Password</label>
              </div>
              <div class="relative">
                <input type="password" id="password" name="password" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required>
              </div>
            </div>
            <!-- End Form Group -->

            <!-- Checkbox -->
            <div class="flex items-center">
              <div class="flex">
                <input id="remember" name="remember" type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
              </div>
              <div class="ms-3">
                <label for="remember" class="text-sm dark:text-white">Remember me</label>
              </div>
            </div>
            <!-- End Checkbox -->

            <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">Sign in</button>
          </div>
        </form>
        <!-- End Form -->
      </div>
    </div>
  </div>
</div>
@endsection
