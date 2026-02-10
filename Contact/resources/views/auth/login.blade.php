@extends('layouts.guest')
@section('title', 'Sign In - ConnectHub')

@section('content')
<div class="min-h-screen w-full flex items-center justify-center bg-slate-50">
    <div class="w-full max-w-sm px-4">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="p-6 sm:p-8">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-600 rounded-xl shadow-lg shadow-blue-500/20 mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900">Sign in</h1>
                    <p class="text-slate-500 mt-1 text-sm">Enter your credentials to continue</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="block w-full px-4 py-4 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/5 focus:border-blue-600 transition-all outline-none text-slate-900 placeholder-slate-400 @error('email') border-red-500 bg-red-50 @enderror"
                            placeholder="name@company.com">
                        @error('email')
                            <p class="text-red-600 text-[11px] font-bold mt-2 ml-1 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2 ml-1">
                            <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Password</label>
                            <a href="#" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">Forgot?</a>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="block w-full px-4 py-4 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/5 focus:border-blue-600 transition-all outline-none text-slate-900 placeholder-slate-400 @error('password') border-red-500 bg-red-50 @enderror"
                            placeholder="••••••••">
                        @error('password')
                            <p class="text-red-600 text-[11px] font-bold mt-2 ml-1 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center ml-1 py-1">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500/20 transition-all cursor-pointer">
                        <label for="remember" class="ml-2.5 text-sm font-medium text-slate-600 cursor-pointer select-none">Remember me</label>
                    </div>

                    <button type="submit"
                        class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all active:scale-[0.98] outline-none text-base">
                        Sign In
                    </button>

                    <div class="text-center pt-4">
                        <p class="text-sm font-medium text-slate-500">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-bold">Create one</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="mt-8 text-center">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">&copy; 2026 ConnectHub Systems</p>
        </div>
    </div>
</div>
@endsection
