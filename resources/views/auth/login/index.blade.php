@extends('auth.layout.main', [
    'title' => 'Login',
    'active' => 'Login',
])

@section('content')
    <div class="min-h-screen flex justify-center items-center">
        <div class="bg-white rounded-xl shadow-lg px-20 py-8">
            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-[#879FFF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bx bx-package text-2xl text-white"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Selamat Datang</h2>
                <p class="text-gray-600 mt-2">Silakan masuk ke akun Anda</p>
            </div>

            {{-- Login Form --}}
            <form id="loginForm" action="" method="POST" class="space-y-6">
                @csrf

                {{-- Username Field --}}
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        Username
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bx bx-user text-gray-400"></i>
                        </div>
                        <input type="text" id="username" name="username" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:border-transparent transition-colors"
                            placeholder="Masukkan username">
                    </div>
                    @error('username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Field --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bx bx-lock-alt text-gray-400"></i>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#879FFF] focus:border-transparent transition-colors"
                            placeholder="Masukkan password">
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="bx bx-hide text-gray-400 hover:text-gray-600 transition-colors" id="eyeIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember"
                        class="h-4 w-4 text-[#879FFF] focus:ring-[#879FFF] border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Ingat saya
                    </label>
                </div>

                {{-- Submit Button --}}
                <button type="submit" id="submitBtn"
                    class="w-full bg-[#879FFF] hover:bg-[#6B7EF7] text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <span id="submitText">Masuk</span>
                    <i class="bx bx-right-arrow-alt text-lg" id="submitIcon"></i>
                </button>
            </form>

            {{-- Footer --}}
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    © 2024 Dropshiper. Semua hak dilindungi.
                </p>
            </div>
        </div>
    </div>

    {{-- Loading Overlay --}}
    <div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-[#879FFF]"></div>
            <span class="text-gray-700">Memproses login...</span>
        </div>
    </div>
@endsection

