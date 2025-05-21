<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center">
                <div class="mr-3 bg-white rounded-full p-1.5 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('Detail Penduduk') }}
                </h2>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('penduduk.edit', $penduduk->id) }}" class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition duration-300 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('penduduk.index') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition duration-300 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                <!-- Data Header with Info -->
                <div class="bg-gradient-to-r from-green-50 to-white border-b border-gray-100 p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <div class="bg-gradient-to-br from-green-600 to-green-800 rounded-xl p-3 text-white shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-green-800">{{ $penduduk->nama }}</h2>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6 mt-1">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                                        NIK
                                    </span>
                                    {{ $penduduk->nik }}
                                </div>
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-2">
                                        No. KK
                                    </span>
                                    {{ $penduduk->no_kk }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 text-gray-900">
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="inline-flex p-1 bg-blue-100 text-blue-600 rounded-lg mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-blue-700">Data Pribadi</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-blue-50 bg-opacity-30 p-6 rounded-xl border border-blue-100">
                            <!-- Hidden for mobile but visible versions already above -->
                            <div class="hidden">
                                <p class="text-sm text-gray-600">No. KK</p>
                                <p class="font-medium">{{ $penduduk->no_kk }}</p>
                            </div>
                            <div class="hidden">
                                <p class="text-sm text-gray-600">NIK</p>
                                <p class="font-medium">{{ $penduduk->nik }}</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-blue-50 flex flex-col gap-1">
                                <p class="text-xs text-blue-600 font-medium">Nama</p>
                                <p class="font-semibold text-gray-800">{{ $penduduk->nama }}</p>
                            </div>

                            <div class="bg-white p-4 rounded-lg shadow-sm border border-blue-50 flex flex-col gap-1">
                                <p class="text-xs text-blue-600 font-medium">Jenis Kelamin</p>
                                <p class="font-semibold text-gray-800">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $penduduk->jk === 'laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                        {{ ucfirst($penduduk->jk) }}
                                    </span>
                                </p>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-blue-50 flex flex-col gap-1">
                                <p class="text-xs text-blue-600 font-medium">Tempat Lahir</p>
                                <p class="font-semibold text-gray-800">{{ $penduduk->tmp_lahir }}</p>
                            </div>

                            <div class="bg-white p-4 rounded-lg shadow-sm border border-blue-50 flex flex-col gap-1">
                                <p class="text-xs text-blue-600 font-medium">Tanggal Lahir</p>
                                <p class="font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($penduduk->tgl_lahir)->format('d F Y') }}
                                    <span class="text-xs text-gray-500 ml-1">
                                        ({{ \Carbon\Carbon::parse($penduduk->tgl_lahir)->age }} tahun)
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Agama</p>
                                <p class="font-medium">{{ $penduduk->agama->nama_agama }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Pendidikan</p>
                                <p class="font-medium">{{ $penduduk->pendidikan->nama_pendidikan }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Pendidikan Sedang</p>
                                <p class="font-medium">{{ $penduduk->pendidikanSedang->nama_pendidikan_sedangs ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Pekerjaan</p>
                                <p class="font-medium">{{ $penduduk->pekerjaan->nama_pekerjaan }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status Perkawinan</p>
                                <p class="font-medium">{{ $penduduk->statKawin->nama_stat_kawins }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status Hubungan Keluarga</p>
                                <p class="font-medium">{{ $penduduk->statHubKeluarga->nama_hub_keluarga }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Kewarganegaraan</p>
                                <p class="font-medium">{{ strtoupper($penduduk->kewarganegaraan) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Golongan Darah</p>
                                <p class="font-medium">{{ $penduduk->golDarah->nama_gol_darah ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status Rekam KTP</p>
                                <p class="font-medium">{{ $penduduk->statRekam->nama_stat_rekam ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status Dasar</p>
                                <p class="font-medium">{{ $penduduk->statDasar->nama_stat_dasars }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="inline-flex p-1 bg-green-100 text-green-600 rounded-lg mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-green-700">Data Alamat</h3>
                        </div>
                        <div class="bg-green-50 bg-opacity-30 p-6 rounded-xl border border-green-100">
                            <div class="mb-5 bg-white p-4 rounded-lg shadow-sm border border-green-50">
                                <p class="text-xs text-green-600 font-medium">Alamat Lengkap</p>
                                <p class="font-semibold text-gray-800">{{ $penduduk->alamat->nama_alamat }}</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-white p-4 rounded-lg shadow-sm border border-green-50 flex flex-col gap-1">
                                    <p class="text-xs text-green-600 font-medium">Dusun</p>
                                    <p class="font-semibold text-gray-800">{{ $penduduk->alamat->dusun }}</p>
                                </div>
                                <div class="bg-white p-4 rounded-lg shadow-sm border border-green-50 flex flex-col gap-1">
                                    <p class="text-xs text-green-600 font-medium">RT</p>
                                    <p class="font-semibold text-gray-800">{{ $penduduk->alamat->no_rt }}</p>
                                </div>
                                <div class="bg-white p-4 rounded-lg shadow-sm border border-green-50 flex flex-col gap-1">
                                    <p class="text-xs text-green-600 font-medium">RW</p>
                                    <p class="font-semibold text-gray-800">{{ $penduduk->alamat->no_rw }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="inline-flex p-1 bg-yellow-100 text-yellow-600 rounded-lg mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-yellow-700">Data Orang Tua</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-yellow-50 bg-opacity-30 p-6 rounded-xl border border-yellow-100">
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-yellow-50 flex flex-col gap-1">
                                <p class="text-xs text-yellow-600 font-medium">Nama Ayah</p>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <p class="font-semibold text-gray-800">{{ $penduduk->nama_ayah ?: '-' }}</p>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-yellow-50 flex flex-col gap-1">
                                <p class="text-xs text-yellow-600 font-medium">NIK Ayah</p>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                    <p class="font-semibold text-gray-800">{{ $penduduk->nik_ayah ?: '-' }}</p>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-yellow-50 flex flex-col gap-1">
                                <p class="text-xs text-yellow-600 font-medium">Nama Ibu</p>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <p class="font-semibold text-gray-800">{{ $penduduk->nama_ibu ?: '-' }}</p>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-yellow-50 flex flex-col gap-1">
                                <p class="text-xs text-yellow-600 font-medium">NIK Ibu</p>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                    <p class="font-semibold text-gray-800">{{ $penduduk->nik_ibu ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center mb-4">
                            <div class="inline-flex p-1 bg-purple-100 text-purple-600 rounded-lg mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-purple-700">Data Lainnya</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 bg-purple-50 bg-opacity-30 p-6 rounded-xl border border-purple-100">
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-purple-50 flex flex-col gap-1">
                                <p class="text-xs text-purple-600 font-medium">Cacat</p>
                                <p class="font-semibold text-gray-800">{{ $penduduk->cacat->nama_cacat ?? '-' }}</p>
                            </div>

                            <div class="bg-white p-4 rounded-lg shadow-sm border border-purple-50 flex flex-col gap-1">
                                <p class="text-xs text-purple-600 font-medium">Cara KB</p>
                                <p class="font-semibold text-gray-800">{{ $penduduk->caraKb->nama_cara_kb ?? '-' }}</p>
                            </div>

                            <div class="bg-white p-4 rounded-lg shadow-sm border border-purple-50 flex flex-col gap-1">
                                <p class="text-xs text-purple-600 font-medium">Asuransi</p>
                                <p class="font-semibold text-gray-800">{{ $penduduk->asuransi->nama_asuransi ?? '-' }}</p>
                            </div>

                            <div class="bg-white p-4 rounded-lg shadow-sm border border-purple-50 flex flex-col gap-1">
                                <p class="text-xs text-purple-600 font-medium">Hamil</p>
                                <p class="font-semibold text-gray-800">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $penduduk->hamil ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $penduduk->hamil ? 'Ya' : 'Tidak' }}
                                    </span>
                                </p>
                            </div>

                            <div class="bg-white p-4 rounded-lg shadow-sm border border-purple-50 flex flex-col gap-1">
                                <p class="text-xs text-purple-600 font-medium">KTP Elektronik</p>
                                <p class="font-semibold text-gray-800">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $penduduk->ktp_el ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $penduduk->ktp_el ? 'Ya' : 'Tidak' }}
                                    </span>
                                </p>
                            </div>

                            <div class="bg-white p-4 rounded-lg shadow-sm border border-purple-50 flex flex-col gap-1">
                                <p class="text-xs text-purple-600 font-medium">Suku</p>
                                <p class="font-semibold text-gray-800">{{ $penduduk->suku ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
