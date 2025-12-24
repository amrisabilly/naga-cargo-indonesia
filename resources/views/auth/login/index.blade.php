@extends('auth.layout.main', [
    'title' => 'Login',
    'active' => 'Login',
])

@section('content')
    <div class="h-screen flex flex-col bg-gradient-to-br from-gray-50 via-blue-50 to-gray-50 relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-20">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <circle cx="20" cy="20" r="1.5" fill="#4A90E2" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        {{-- Main Content --}}
        <div class="relative z-10 flex-1 flex items-center justify-center px-6 pb-12">
            <div class="w-full max-w-md">
                {{-- Welcome Text --}}
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
                    <p class="text-gray-600 text-sm">Masuk untuk mengakses dashboard monitoring</p>
                </div>

                {{-- Login Card --}}
                <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
                    {{-- Card Body --}}
                    <div class="p-8">
                        <form id="loginForm" action="{{ route('auth.authenticate') }}" method="POST" class="space-y-5">
                            @csrf

                            {{-- Username Field --}}
                            <div>
                                <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Username
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="bx bx-user text-lg text-gray-400"></i>
                                    </div>
                                    <input type="text" id="username" name="username" required
                                        value="{{ old('username') }}"
                                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4A90E2] focus:border-transparent transition-all text-sm text-gray-900 placeholder-gray-400"
                                        placeholder="Masukkan username Anda">
                                </div>
                                @error('username')
                                    <div
                                        class="flex items-center gap-2 mt-2 text-xs text-red-600 bg-red-50 px-3 py-2 rounded-lg border border-red-100">
                                        <i class="bx bx-error-circle text-sm"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            {{-- Password Field --}}
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Password
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="bx bx-lock-alt text-lg text-gray-400"></i>
                                    </div>
                                    <input type="password" id="password" name="password" required
                                        class="w-full pl-11 pr-11 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#4A90E2] focus:border-transparent transition-all text-sm text-gray-900 placeholder-gray-400"
                                        placeholder="Masukkan password Anda">
                                    <button type="button" id="togglePassword"
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                        <i class="bx bx-hide text-lg text-gray-400 hover:text-[#4A90E2] transition-colors"
                                            id="eyeIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div
                                        class="flex items-center gap-2 mt-2 text-xs text-red-600 bg-red-50 px-3 py-2 rounded-lg border border-red-100">
                                        <i class="bx bx-error-circle text-sm"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            {{-- Remember Me --}}
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input type="checkbox" id="remember" name="remember"
                                        class="w-4 h-4 text-[#4A90E2] rounded focus:ring-2 focus:ring-[#4A90E2] border-gray-300 cursor-pointer">
                                    <label for="remember" class="ml-2 text-sm text-gray-700 cursor-pointer select-none">
                                        Ingat saya
                                    </label>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <button type="submit" id="submitBtn"
                                class="w-full bg-gradient-to-r from-[#4A90E2] to-[#357ABD] hover:from-[#357ABD] hover:to-[#2868A8] active:scale-[0.98] text-white font-semibold py-3.5 rounded-lg transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                <span id="submitText">Masuk ke Dashboard</span>
                                <i class="bx bx-right-arrow-alt text-xl transition-transform group-hover:translate-x-1"
                                    id="submitIcon"></i>
                            </button>
                        </form>
                    </div>

                    {{-- Card Footer --}}
                    <div class="px-8 pb-6 pt-4 bg-gray-50 border-t border-gray-100">
                        <div class="flex items-center justify-center gap-2 text-xs text-gray-500">
                            <span>Sistem Monitoring Pengiriman</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="relative z-10 pb-6 text-center">
            <p class="text-xs text-gray-500">
                © 2025 <span class="font-semibold text-gray-700">Dropshiper</span>. All rights reserved.
            </p>
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        // Toggle Password
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.classList.remove('bx-hide');
                eyeIcon.classList.add('bx-show');
            } else {
                password.type = 'password';
                eyeIcon.classList.remove('bx-show');
                eyeIcon.classList.add('bx-hide');
            }
        });
    </script>
@endsection
