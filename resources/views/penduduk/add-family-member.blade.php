<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Tambah Anggota Keluarga') }}
            </h2>
            <a href="{{ route('penduduk.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-800 font-bold py-2 px-4 shadow-md rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('penduduk.store-family-member') }}">
                        @csrf

                        <div class="mb-8 bg-gray-100 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Data Keluarga</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="no_kk" class="block text-sm font-medium text-gray-700">Nomor KK</label>
                                    <input type="text" name="no_kk" id="no_kk" class="mt-1 p-2 w-full border rounded-md bg-gray-100" value="{{ $kkNumber }}" readonly>
                                </div>
                                <input type="hidden" name="alamats_id" value="{{ $alamatsId }}">
                            </div>
                        </div>

                        <div class="bg-gray-100 p-6 rounded-lg mb-6">
                            <h3 class="text-lg font-semibold mb-4">Data Pribadi</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                                    <input type="text" name="nik" id="nik" class="mt-1 p-2 w-full border rounded-md @error('nik') border-red-500 @enderror" value="{{ old('nik') }}" required>
                                    @error('nik')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                                    <input type="text" name="nama" id="nama" class="mt-1 p-2 w-full border rounded-md @error('nama') border-red-500 @enderror" value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="jk" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                    <select name="jk" id="jk" class="mt-1 p-2 w-full border rounded-md @error('jk') border-red-500 @enderror" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="laki-laki" {{ old('jk') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="perempuan" {{ old('jk') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jk')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="tmp_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                    <input type="text" name="tmp_lahir" id="tmp_lahir" class="mt-1 p-2 w-full border rounded-md @error('tmp_lahir') border-red-500 @enderror" value="{{ old('tmp_lahir') }}" required>
                                    @error('tmp_lahir')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label for="tgl_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" id="tgl_lahir" class="mt-1 p-2 w-full border rounded-md @error('tgl_lahir') border-red-500 @enderror" value="{{ old('tgl_lahir') }}" required>
                                    @error('tgl_lahir')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="agamas_id" class="block text-sm font-medium text-gray-700">Agama</label>
                                    <select name="agamas_id" id="agamas_id" class="mt-1 p-2 w-full border rounded-md @error('agamas_id') border-red-500 @enderror" required>
                                        <option value="">Pilih Agama</option>
                                        @foreach($agamas as $agama)
                                            <option value="{{ $agama->id }}" {{ old('agamas_id') == $agama->id ? 'selected' : '' }}>{{ $agama->nama_agama }}</option>
                                        @endforeach
                                    </select>
                                    @error('agamas_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="gol_darahs_id" class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                                    <select name="gol_darahs_id" id="gol_darahs_id" class="mt-1 p-2 w-full border rounded-md @error('gol_darahs_id') border-red-500 @enderror">
                                        <option value="">Pilih Golongan Darah</option>
                                        @foreach($golDarahs as $golDarah)
                                            <option value="{{ $golDarah->id }}" {{ old('gol_darahs_id') == $golDarah->id ? 'selected' : '' }}>{{ $golDarah->nama_gol_darah }}</option>
                                        @endforeach
                                    </select>
                                    @error('gol_darahs_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label for="pendidikans_id" class="block text-sm font-medium text-gray-700">Pendidikan</label>
                                    <select name="pendidikans_id" id="pendidikans_id" class="mt-1 p-2 w-full border rounded-md @error('pendidikans_id') border-red-500 @enderror" required>
                                        <option value="">Pilih Pendidikan</option>
                                        @foreach($pendidikans as $pendidikan)
                                            <option value="{{ $pendidikan->id }}" {{ old('pendidikans_id') == $pendidikan->id ? 'selected' : '' }}>{{ $pendidikan->nama_pendidikan }}</option>
                                        @endforeach
                                    </select>
                                    @error('pendidikans_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="pendidikan_sedangs_id" class="block text-sm font-medium text-gray-700">Pendidikan Sedang</label>
                                    <select name="pendidikan_sedangs_id" id="pendidikan_sedangs_id" class="mt-1 p-2 w-full border rounded-md @error('pendidikan_sedangs_id') border-red-500 @enderror">
                                        <option value="">Pilih Pendidikan Sedang</option>
                                        @foreach($pendidikanSedangs as $pendidikanSedang)
                                            <option value="{{ $pendidikanSedang->id }}" {{ old('pendidikan_sedangs_id') == $pendidikanSedang->id ? 'selected' : '' }}>{{ $pendidikanSedang->nama_pendidikan_sedangs }}</option>
                                        @endforeach
                                    </select>
                                    @error('pendidikan_sedangs_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="pekerjaans_id" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                                    <select name="pekerjaans_id" id="pekerjaans_id" class="mt-1 p-2 w-full border rounded-md @error('pekerjaans_id') border-red-500 @enderror" required>
                                        <option value="">Pilih Pekerjaan</option>
                                        @foreach($pekerjaans as $pekerjaan)
                                            <option value="{{ $pekerjaan->id }}" {{ old('pekerjaans_id') == $pekerjaan->id ? 'selected' : '' }}>{{ $pekerjaan->nama_pekerjaan }}</option>
                                        @endforeach
                                    </select>
                                    @error('pekerjaans_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label for="stat_kawins_id" class="block text-sm font-medium text-gray-700">Status Perkawinan</label>
                                    <select name="stat_kawins_id" id="stat_kawins_id" class="mt-1 p-2 w-full border rounded-md @error('stat_kawins_id') border-red-500 @enderror" required>
                                        <option value="">Pilih Status Perkawinan</option>
                                        @foreach($statKawins as $statKawin)
                                            <option value="{{ $statKawin->id }}" {{ old('stat_kawins_id') == $statKawin->id ? 'selected' : '' }}>{{ $statKawin->nama_stat_kawins }}</option>
                                        @endforeach
                                    </select>
                                    @error('stat_kawins_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="stat_hub_keluargas_id" class="block text-sm font-medium text-gray-700">Hubungan Keluarga</label>
                                    <select name="stat_hub_keluargas_id" id="stat_hub_keluargas_id" class="mt-1 p-2 w-full border rounded-md @error('stat_hub_keluargas_id') border-red-500 @enderror" required>
                                        <option value="">Pilih Hubungan Keluarga</option>
                                        @foreach($statHubKeluargas as $statHubKeluarga)
                                            <option value="{{ $statHubKeluarga->id }}" {{ old('stat_hub_keluargas_id') == $statHubKeluarga->id ? 'selected' : '' }}>{{ $statHubKeluarga->nama_hub_keluarga }}</option>
                                        @endforeach
                                    </select>
                                    @error('stat_hub_keluargas_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="kewarganegaraan" class="block text-sm font-medium text-gray-700">Kewarganegaraan</label>
                                    <select name="kewarganegaraan" id="kewarganegaraan" class="mt-1 p-2 w-full border rounded-md @error('kewarganegaraan') border-red-500 @enderror" required>
                                        <option value="wni" {{ old('kewarganegaraan') == 'wni' ? 'selected' : '' }}>WNI</option>
                                        <option value="wna" {{ old('kewarganegaraan') == 'wna' ? 'selected' : '' }}>WNA</option>
                                        <option value="dua kewarganegaraan" {{ old('kewarganegaraan') == 'dua kewarganegaraan' ? 'selected' : '' }}>Dua Kewarganegaraan</option>
                                    </select>
                                    @error('kewarganegaraan')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-100 p-6 rounded-lg mb-6">
                            <h3 class="text-lg font-semibold mb-4">Data Orang Tua</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="ayah_nik" class="block text-sm font-medium text-gray-700">NIK Ayah</label>
                                    <input type="text" name="ayah_nik" id="ayah_nik" class="mt-1 p-2 w-full border rounded-md @error('ayah_nik') border-red-500 @enderror" value="{{ old('ayah_nik') }}">
                                    @error('ayah_nik')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="ayah_nama" class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                                    <input type="text" name="ayah_nama" id="ayah_nama" class="mt-1 p-2 w-full border rounded-md @error('ayah_nama') border-red-500 @enderror" value="{{ old('ayah_nama') }}">
                                    @error('ayah_nama')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="ibu_nik" class="block text-sm font-medium text-gray-700">NIK Ibu</label>
                                    <input type="text" name="ibu_nik" id="ibu_nik" class="mt-1 p-2 w-full border rounded-md @error('ibu_nik') border-red-500 @enderror" value="{{ old('ibu_nik') }}">
                                    @error('ibu_nik')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="ibu_nama" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                                    <input type="text" name="ibu_nama" id="ibu_nama" class="mt-1 p-2 w-full border rounded-md @error('ibu_nama') border-red-500 @enderror" value="{{ old('ibu_nama') }}">
                                    @error('ibu_nama')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-100 p-6 rounded-lg mb-6">
                            <h3 class="text-lg font-semibold mb-4">Data Lainnya</h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label for="cacats_id" class="block text-sm font-medium text-gray-700">Cacat</label>
                                    <select name="cacats_id" id="cacats_id" class="mt-1 p-2 w-full border rounded-md @error('cacats_id') border-red-500 @enderror">
                                        <option value="">Pilih Cacat</option>
                                        @foreach($cacats as $cacat)
                                            <option value="{{ $cacat->id }}" {{ old('cacats_id') == $cacat->id ? 'selected' : '' }}>{{ $cacat->nama_cacat }}</option>
                                        @endforeach
                                    </select>
                                    @error('cacats_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="cara_kbs_id" class="block text-sm font-medium text-gray-700">Cara KB</label>
                                    <select name="cara_kbs_id" id="cara_kbs_id" class="mt-1 p-2 w-full border rounded-md @error('cara_kbs_id') border-red-500 @enderror">
                                        <option value="">Pilih Cara KB</option>
                                        @foreach($caraKbs as $caraKb)
                                            <option value="{{ $caraKb->id }}" {{ old('cara_kbs_id') == $caraKb->id ? 'selected' : '' }}>{{ $caraKb->nama_cara_kb }}</option>
                                        @endforeach
                                    </select>
                                    @error('cara_kbs_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="asuransis_id" class="block text-sm font-medium text-gray-700">Asuransi</label>
                                    <select name="asuransis_id" id="asuransis_id" class="mt-1 p-2 w-full border rounded-md @error('asuransis_id') border-red-500 @enderror">
                                        <option value="">Pilih Asuransi</option>
                                        @foreach($asuransis as $asuransi)
                                            <option value="{{ $asuransi->id }}" {{ old('asuransis_id') == $asuransi->id ? 'selected' : '' }}>{{ $asuransi->nama_asuransi }}</option>
                                        @endforeach
                                    </select>
                                    @error('asuransis_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label for="stat_rekams_id" class="block text-sm font-medium text-gray-700">Status Rekam KTP</label>
                                    <select name="stat_rekams_id" id="stat_rekams_id" class="mt-1 p-2 w-full border rounded-md @error('stat_rekams_id') border-red-500 @enderror">
                                        <option value="">Pilih Status Rekam KTP</option>
                                        @foreach($statRekams as $statRekam)
                                            <option value="{{ $statRekam->id }}" {{ old('stat_rekams_id') == $statRekam->id ? 'selected' : '' }}>{{ $statRekam->nama_stat_rekam }}</option>
                                        @endforeach
                                    </select>
                                    @error('stat_rekams_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="stat_dasars_id" class="block text-sm font-medium text-gray-700">Status Dasar</label>
                                    <select name="stat_dasars_id" id="stat_dasars_id" class="mt-1 p-2 w-full border rounded-md @error('stat_dasars_id') border-red-500 @enderror" required>
                                        @foreach($statDasars as $statDasar)
                                            <option value="{{ $statDasar->id }}" {{ $statDasar->nama_stat_dasars == 'HIDUP' ? 'selected' : '' }}>{{ $statDasar->nama_stat_dasars }}</option>
                                        @endforeach
                                    </select>
                                    @error('stat_dasars_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="suku" class="block text-sm font-medium text-gray-700">Suku</label>
                                    <input type="text" name="suku" id="suku" class="mt-1 p-2 w-full border rounded-md @error('suku') border-red-500 @enderror" value="{{ old('suku') }}">
                                    @error('suku')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex space-x-6 mt-4">
                                <div class="flex items-center">
                                    <input type="checkbox" name="ktp_el" id="ktp_el" class="mr-2" {{ old('ktp_el') ? 'checked' : '' }}>
                                    <label for="ktp_el" class="text-sm font-medium text-gray-700">KTP Elektronik</label>
                                </div>

                                <div class="flex items-center" id="hamilContainer" style="display: none;">
                                    <input type="checkbox" name="hamil" id="hamil" class="mr-2" {{ old('hamil') ? 'checked' : '' }}>
                                    <label for="hamil" class="text-sm font-medium text-gray-700">Hamil</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show/hide hamil checkbox based on gender
            const genderSelect = document.getElementById('jk');
            const hamilContainer = document.getElementById('hamilContainer');

            genderSelect.addEventListener('change', function() {
                hamilContainer.style.display = this.value === 'perempuan' ? 'block' : 'none';
            });

            // Initialize based on current value
            if (genderSelect.value === 'perempuan') {
                hamilContainer.style.display = 'block';
            }
        });
    </script>
</x-app-layout>
