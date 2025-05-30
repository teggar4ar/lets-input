<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Data Penduduk Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-500 text-white mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xl font-semibold text-gray-700">Data Penduduk</div>
                                <p class="text-gray-500">Kelola data penduduk desa</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('penduduk.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                                Lihat Data
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Export Data Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 text-white mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xl font-semibold text-gray-700">Export Data</div>
                                <p class="text-gray-500">Export data penduduk ke Excel</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('penduduk.export') }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">
                                Export Excel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Sistem Informasi Penduduk Desa</h3>
                    <p class="text-gray-600 mb-4">
                        Selamat datang di Sistem Informasi Penduduk Desa. Aplikasi ini dirancang untuk memudahkan pengelolaan data penduduk
                        dengan fitur pencatatan lengkap informasi penduduk, pengelolaan data keluarga, dan kemampuan export data.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-medium text-blue-700">Input Data Keluarga</h4>
                            <p class="text-sm text-gray-600">Input data keluarga dengan informasi lengkap anggota keluarga</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="font-medium text-green-700">Pengelolaan Anggota</h4>
                            <p class="text-sm text-gray-600">Tambah, edit, dan hapus anggota keluarga dengan mudah</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h4 class="font-medium text-purple-700">Laporan Data</h4>
                            <p class="text-sm text-gray-600">Akses dan export data penduduk untuk pelaporan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
