<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-gradient-to-br from-white to-green-50 overflow-hidden shadow-md rounded-xl mb-8 border border-green-100 relative">
                <div class="absolute top-0 right-0 w-32 h-32 bg-green-50 opacity-30 rounded-full -mr-10 -mt-10"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-green-50 opacity-30 rounded-full -ml-8 -mb-8"></div>
                <div class="p-6 relative z-10">
                    <div class="flex flex-col sm:flex-row items-center">
                        <div class="mb-4 sm:mb-0 sm:mr-6">
                            <div class="bg-gradient-to-br from-green-700 to-green-900 rounded-xl p-3 shadow-lg">
                                <x-tajurhalang-logo class="h-16 w-16 text-white" />
                            </div>
                        </div>
                        <div class="text-center sm:text-left">
                            <h2 class="text-2xl font-bold text-green-900 mb-1">Selamat Datang di Sistem Informasi Kependudukan</h2>
                            <p class="text-green-800 font-medium">Desa Tajurhalang - Kecamatan Tajurhalang - Kabupaten Bogor</p>
                            <p class="text-gray-600 mt-2">Sistem ini digunakan untuk mengelola data penduduk Desa Tajurhalang</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Data Penduduk Card -->
                <div class="bg-gradient-to-br from-white to-green-50 overflow-hidden shadow-md rounded-xl border border-green-100 transform transition duration-300 hover:shadow-lg hover:scale-[1.02] group">
                    <div class="p-6 relative">
                        <!-- Decorative elements -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-green-100 opacity-20 rounded-full -mr-16 -mt-16 transition-all duration-500 group-hover:bg-green-200"></div>

                        <div class="flex flex-col sm:flex-row items-center">
                            <div class="mb-4 sm:mb-0 sm:mr-5 bg-gradient-to-br from-green-600 to-green-800 p-4 rounded-xl shadow-md text-white transform transition duration-500 group-hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xl font-bold text-green-800 mb-1">Data Penduduk</div>
                                <p class="text-gray-600">Kelola data penduduk Desa Tajurhalang</p>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-center sm:justify-start">
                            <a href="{{ route('penduduk.index') }}" class="px-5 py-2.5 bg-gradient-to-r from-green-700 to-green-800 text-white rounded-lg hover:from-green-800 hover:to-green-900 shadow-md transition duration-300 flex items-center gap-2 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat Data
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Export Data Card -->
                <div class="bg-gradient-to-br from-white to-yellow-50 overflow-hidden shadow-md rounded-xl border border-yellow-100 transform transition duration-300 hover:shadow-lg hover:scale-[1.02] group">
                    <div class="p-6 relative">
                        <!-- Decorative elements -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-100 opacity-20 rounded-full -mr-16 -mt-16 transition-all duration-500 group-hover:bg-yellow-200"></div>

                        <div class="flex flex-col sm:flex-row items-center">
                            <div class="mb-4 sm:mb-0 sm:mr-5 bg-gradient-to-br from-yellow-500 to-yellow-600 p-4 rounded-xl shadow-md text-white transform transition duration-500 group-hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xl font-bold text-yellow-700 mb-1">Export Data</div>
                                <p class="text-gray-600">Export data penduduk ke Excel</p>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-center sm:justify-start">
                            <a href="{{ route('penduduk.export') }}" class="px-5 py-2.5 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-lg hover:from-yellow-600 hover:to-yellow-700 shadow-md transition duration-300 flex items-center gap-2 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Export Excel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Info & Features -->
            <div class="bg-white overflow-hidden shadow-md rounded-xl mb-8 border border-gray-100">
                <div class="relative">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 bg-opacity-10 overflow-hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-green-50" preserveAspectRatio="none">
                            <pattern id="pattern-circles" width="50" height="50" patternUnits="userSpaceOnUse" patternTransform="scale(0.5)">
                                <circle cx="25" cy="25" r="7" fill="currentColor" fill-opacity="0.3"></circle>
                            </pattern>
                            <rect width="100%" height="100%" fill="url(#pattern-circles)"></rect>
                        </svg>
                    </div>

                    <div class="p-8 relative">
                        <div class="flex items-center mb-6">
                            <div class="inline-flex p-2 bg-green-100 text-green-600 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-green-800">Sistem Informasi Penduduk Desa</h3>
                        </div>
                        <p class="text-gray-600 mb-8 max-w-3xl leading-relaxed">
                            Selamat datang di Sistem Informasi Penduduk Desa Tajurhalang. Aplikasi ini dirancang untuk memudahkan pengelolaan data penduduk
                            dengan fitur pencatatan lengkap informasi penduduk, pengelolaan data keluarga, dan kemampuan export data.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="bg-gradient-to-br from-blue-50 to-white p-6 rounded-xl border border-blue-100 shadow-sm hover:shadow-md transition duration-300">
                                <div class="inline-flex p-3 bg-blue-100 rounded-lg text-blue-600 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-blue-700 text-lg mb-2">Input Data Keluarga</h4>
                                <p class="text-gray-600">Input data keluarga dengan informasi lengkap anggota keluarga</p>
                            </div>

                            <div class="bg-gradient-to-br from-green-50 to-white p-6 rounded-xl border border-green-100 shadow-sm hover:shadow-md transition duration-300">
                                <div class="inline-flex p-3 bg-green-100 rounded-lg text-green-600 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-green-700 text-lg mb-2">Pengelolaan Anggota</h4>
                                <p class="text-gray-600">Tambah, edit, dan hapus anggota keluarga dengan mudah</p>
                            </div>

                            <div class="bg-gradient-to-br from-purple-50 to-white p-6 rounded-xl border border-purple-100 shadow-sm hover:shadow-md transition duration-300">
                                <div class="inline-flex p-3 bg-purple-100 rounded-lg text-purple-600 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-purple-700 text-lg mb-2">Laporan Data</h4>
                                <p class="text-gray-600">Akses dan export data penduduk untuk pelaporan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
