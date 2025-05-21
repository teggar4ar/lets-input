<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center">
                <div class="mr-3 bg-white rounded-full p-1.5 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m6 0H6m6 6v-6" />
                    </svg>
                </div>
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('Tambah Data Keluarga') }}
                </h2>
            </div>
            <a href="{{ route('penduduk.index') }}" class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-gray-800 font-medium py-2 px-4 rounded-lg shadow-md transition duration-300 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                <div class="p-6 text-gray-900">
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('penduduk.store') }}" id="familyForm">
                        @csrf

                        <div class="mb-8 bg-gradient-to-br from-green-50 to-white p-6 rounded-xl border border-green-100 shadow-sm">
                            <div class="flex items-center mb-6">
                                <div class="inline-flex p-2 bg-green-100 text-green-600 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-green-800">Data Alamat</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                <div>
                                    <label for="no_kk" class="block text-sm font-medium text-gray-700 mb-1">Nomor KK</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                            </svg>
                                        </div>
                                        <input type="text" name="no_kk" id="no_kk" class="mt-1 pl-10 p-2.5 w-full bg-white border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('no_kk') border-red-500 @enderror" value="{{ old('no_kk') }}" required>
                                    </div>
                                    @error('no_kk')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                <div class="relative">
                                    <div class="absolute top-3 left-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <textarea name="alamat" id="alamat" rows="2" class="mt-1 pl-10 p-2.5 w-full bg-white border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('alamat') border-red-500 @enderror" required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="dusun" class="block text-sm font-medium text-gray-700 mb-1">Dusun</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <select name="dusun" id="dusun" class="mt-1 pl-10 p-2.5 w-full bg-white border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('dusun') border-red-500 @enderror" style="-webkit-appearance: none; -moz-appearance: none; appearance: none;" required>
                                            <option value="">Pilih Dusun</option>
                                            @foreach(['001', '002', '003', '004', '005', '006', '007'] as $dusun)
                                                <option value="{{ $dusun }}" {{ old('dusun') == $dusun ? 'selected' : '' }}>{{ $dusun }}</option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('dusun')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="no_rt" class="block text-sm font-medium text-gray-700 mb-1">RT</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                            </svg>
                                        </div>
                                        <input type="number" name="no_rt" id="no_rt" class="mt-1 pl-10 p-2.5 w-full bg-white border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('no_rt') border-red-500 @enderror" value="{{ old('no_rt') }}" required>
                                    </div>
                                    @error('no_rt')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="no_rw" class="block text-sm font-medium text-gray-700 mb-1">RW</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                            </svg>
                                        </div>
                                        <input type="number" name="no_rw" id="no_rw" class="mt-1 pl-10 p-2.5 w-full bg-white border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('no_rw') border-red-500 @enderror" value="{{ old('no_rw') }}" required>
                                    @error('no_rw')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div id="familyMembersContainer" class="mb-8 mt-6">
                            <div class="flex items-center mb-6">
                                <div class="inline-flex p-2 bg-blue-100 text-blue-600 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-blue-800">Data Anggota Keluarga</h3>
                            </div>
                            <div class="family-member bg-gradient-to-br from-blue-50 to-white p-6 rounded-xl border border-blue-100 shadow-sm mb-6" data-index="0">
                                <div class="flex justify-between items-center mb-4">
                                    <div class="inline-flex items-center">
                                        <div class="bg-blue-600 rounded-full w-8 h-8 flex items-center justify-center text-white font-medium mr-2">1</div>
                                        <h4 class="font-semibold text-blue-800">Anggota Keluarga</h4>
                                    </div>
                                    <button type="button" class="remove-member inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors" onclick="removeMember(this)" style="display: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                    <div>
                                        <label for="family_members[0][nik]" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                                </svg>
                                            </div>
                                            <input type="text" name="family_members[0][nik]" class="mt-1 pl-10 p-2.5 w-full bg-white border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Nomor NIK" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="family_members[0][nama]" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <input type="text" name="family_members[0][nama]" class="mt-1 pl-10 p-2.5 w-full bg-white border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Nama Lengkap" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="family_members[0][jk]" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                        <div class="relative">
                                            <!-- Ikon di kiri -->
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>

                                            <!-- Dropdown -->
                                            <select name="family_members[0][jk]"
                                                class="mt-1 pl-10 pr-10 p-2.5 w-full bg-white border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none"
                                                required>
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="laki-laki">Laki-laki</option>
                                                <option value="perempuan">Perempuan</option>
                                            </select>

                                            <!-- Ikon panah custom di kanan -->
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label for="family_members[0][tmp_lahir]" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                        <input type="text" name="family_members[0][tmp_lahir]" class="mt-1 p-2 w-full border rounded-md" required>
                                    </div>
                                    <div>
                                        <label for="family_members[0][tgl_lahir]" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                        <input type="date" name="family_members[0][tgl_lahir]" class="mt-1 p-2 w-full border rounded-md" required>
                                    </div>
                                    <div>
                                        <label for="family_members[0][agamas_id]" class="block text-sm font-medium text-gray-700">Agama</label>
                                        <select name="family_members[0][agamas_id]" class="mt-1 p-2 w-full border rounded-md" required>
                                            <option value="">Pilih Agama</option>
                                            @foreach($agamas as $agama)
                                                <option value="{{ $agama->id }}">{{ $agama->nama_agama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label for="family_members[0][pendidikans_id]" class="block text-sm font-medium text-gray-700">Pendidikan</label>
                                        <select name="family_members[0][pendidikans_id]" class="mt-1 p-2 w-full border rounded-md" required>
                                            <option value="">Pilih Pendidikan</option>
                                            @foreach($pendidikans as $pendidikan)
                                                <option value="{{ $pendidikan->id }}">{{ $pendidikan->nama_pendidikan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="family_members[0][pendidikan_sedangs_id]" class="block text-sm font-medium text-gray-700">Pendidikan Sedang</label>
                                        <select name="family_members[0][pendidikan_sedangs_id]" class="mt-1 p-2 w-full border rounded-md">
                                            <option value="">Pilih Pendidikan Sedang</option>
                                            @foreach($pendidikanSedangs as $pendidikanSedang)
                                                <option value="{{ $pendidikanSedang->id }}">{{ $pendidikanSedang->nama_pendidikan_sedangs }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="family_members[0][pekerjaans_id]" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                                        <select name="family_members[0][pekerjaans_id]" class="mt-1 p-2 w-full border rounded-md" required>
                                            <option value="">Pilih Pekerjaan</option>
                                            @foreach($pekerjaans as $pekerjaan)
                                                <option value="{{ $pekerjaan->id }}">{{ $pekerjaan->nama_pekerjaan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label for="family_members[0][stat_kawins_id]" class="block text-sm font-medium text-gray-700">Status Perkawinan</label>
                                        <select name="family_members[0][stat_kawins_id]" class="mt-1 p-2 w-full border rounded-md" required>
                                            <option value="">Pilih Status Perkawinan</option>
                                            @foreach($statKawins as $statKawin)
                                                <option value="{{ $statKawin->id }}">{{ $statKawin->nama_stat_kawins }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="family_members[0][stat_hub_keluargas_id]" class="block text-sm font-medium text-gray-700">Hubungan Keluarga</label>
                                        <select name="family_members[0][stat_hub_keluargas_id]" class="mt-1 p-2 w-full border rounded-md" required>
                                            <option value="">Pilih Hubungan Keluarga</option>
                                            @foreach($statHubKeluargas as $statHubKeluarga)
                                                <option value="{{ $statHubKeluarga->id }}">{{ $statHubKeluarga->nama_hub_keluarga }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="family_members[0][kewarganegaraan]" class="block text-sm font-medium text-gray-700">Kewarganegaraan</label>
                                        <select name="family_members[0][kewarganegaraan]" class="mt-1 p-2 w-full border rounded-md" required>
                                            <option value="wni">WNI</option>
                                            <option value="wna">WNA</option>
                                            <option value="dua kewarganegaraan">Dua Kewarganegaraan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label for="family_members[0][ayah_nama]" class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                                        <input type="text" name="family_members[0][ayah_nama]" class="mt-1 p-2 w-full border rounded-md">
                                    </div>
                                    <div>
                                        <label for="family_members[0][ibu_nama]" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                                        <input type="text" name="family_members[0][ibu_nama]" class="mt-1 p-2 w-full border rounded-md">
                                    </div>
                                    <div>
                                        <label for="family_members[0][gol_darahs_id]" class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                                        <select name="family_members[0][gol_darahs_id]" class="mt-1 p-2 w-full border rounded-md">
                                            <option value="">Pilih Golongan Darah</option>
                                            @foreach($golDarahs as $golDarah)
                                                <option value="{{ $golDarah->id }}">{{ $golDarah->nama_gol_darah }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label for="family_members[0][stat_dasars_id]" class="block text-sm font-medium text-gray-700">Status Dasar</label>
                                        <select name="family_members[0][stat_dasars_id]" class="mt-1 p-2 w-full border rounded-md" required>
                                            @foreach($statDasars as $statDasar)
                                                <option value="{{ $statDasar->id }}" {{ $statDasar->nama_stat_dasars == 'HIDUP' ? 'selected' : '' }}>{{ $statDasar->nama_stat_dasars }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="family_members[0][asuransis_id]" class="block text-sm font-medium text-gray-700">Asuransi</label>
                                        <select name="family_members[0][asuransis_id]" id="family_members[0][asuransis_id]" class="mt-1 p-2 w-full border rounded-md">
                                            <option value="">Pilih Asuransi</option>
                                            @foreach($asuransis as $asuransi)
                                                <option value="{{ $asuransi->id }}">{{ $asuransi->nama_asuransi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="flex items-center mr-4 mt-6">
                                            <input type="checkbox" name="family_members[0][ktp_el]" id="family_members[0][ktp_el]" class="mr-2">
                                            <label for="family_members[0][ktp_el]" class="text-sm font-medium text-gray-700">KTP Elektronik</label>
                                        </div>
                                        <div class="flex items-center mr-4 mt-6" id="hamilContainer0" style="display: none;">
                                            <input type="checkbox" name="family_members[0][hamil]" id="family_members[0][hamil]" class="mr-2">
                                            <label for="family_members[0][hamil]" class="text-sm font-medium text-gray-700">Hamil</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-4 mt-8">
                            <button type="button" id="addMemberBtn" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium py-2.5 px-5 rounded-lg shadow-md transition duration-300 flex items-center justify-center gap-2 transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Tambah Anggota Keluarga
                            </button>
                        </div>

                        <div class="mt-10 border-t border-gray-200 pt-6">
                            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                                <p class="text-sm text-gray-500">Pastikan semua data telah diisi dengan benar sebelum menyimpan</p>
                                <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium py-3 px-6 rounded-lg shadow-md transition duration-300 flex items-center justify-center gap-2 min-w-[200px] transform hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                    Simpan Data Keluarga
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let memberIndex = 0;

        document.addEventListener('DOMContentLoaded', function() {
            // Show/hide hamil checkbox based on gender
            const genderSelects = document.querySelectorAll('select[name^="family_members"][name$="[jk]"]');
            genderSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const index = this.name.match(/\[(\d+)\]/)[1];
                    const hamilContainer = document.getElementById(`hamilContainer${index}`);
                    hamilContainer.style.display = this.value === 'perempuan' ? 'block' : 'none';
                });
            });

            // Add member button
            document.getElementById('addMemberBtn').addEventListener('click', function() {
                addMember();
            });
        });

        function addMember() {
            memberIndex++;
            const template = document.querySelector('.family-member').cloneNode(true);
            template.dataset.index = memberIndex;

            // Update all input names and IDs with new index
            template.querySelectorAll('input, select').forEach(input => {
                if (input.name) {
                    input.name = input.name.replace(/\[0\]/, `[${memberIndex}]`);
                    input.id = input.name;
                    input.value = '';
                    if (input.type === 'checkbox') {
                        input.checked = false;
                    }
                }
            });

            // Update label for's
            template.querySelectorAll('label').forEach(label => {
                if (label.getAttribute('for')) {
                    label.setAttribute('for', label.getAttribute('for').replace(/\[0\]/, `[${memberIndex}]`));
                }
            });

            // Update family member number in header
            const memberNumber = template.querySelector('.bg-blue-600.rounded-full');
            if (memberNumber) {
                memberNumber.textContent = memberIndex + 1; // Adding 1 because index starts at 0
            }

            // Update hamil container ID
            const hamilContainer = template.querySelector('[id^="hamilContainer"]');
            if (hamilContainer) {
                hamilContainer.id = `hamilContainer${memberIndex}`;
                hamilContainer.style.display = 'none';
            }

            // Show remove button for this new member
            template.querySelector('.remove-member').style.display = 'inline-block';

            document.getElementById('familyMembersContainer').appendChild(template);

            // Re-attach change event for gender select
            const newGenderSelect = template.querySelector(`select[name="family_members[${memberIndex}][jk]"]`);
            newGenderSelect.addEventListener('change', function() {
                const hamilContainer = document.getElementById(`hamilContainer${memberIndex}`);
                hamilContainer.style.display = this.value === 'perempuan' ? 'block' : 'none';
            });
        }

        function removeMember(button) {
            const memberDiv = button.closest('.family-member');
            memberDiv.remove();
        }
    </script>
</x-app-layout>
