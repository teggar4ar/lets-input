<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Data Keluarga') }}
            </h2>
            <a href="{{ route('penduduk.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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

                    <form method="POST" action="{{ route('penduduk.store') }}" id="familyForm">
                        @csrf
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <strong class="font-bold">Validation Error!</strong>
                                <span class="block sm:inline">Mohon perbaiki kesalahan berikut:</span>
                                <ul class="mt-2 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-8 bg-gray-100 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Data Alamat</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="no_kk" class="block text-sm font-medium text-gray-700">Nomor KK <span class="text-red-500">*</span></label>
                                    <input type="text" name="no_kk" id="no_kk" class="mt-1 p-2 w-full border rounded-md @error('no_kk') border-red-500 @enderror" value="{{ old('no_kk') }}" required>
                                    @error('no_kk')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat<span class="text-red-500">*</span></label>
                                <textarea name="alamat" id="alamat" rows="2" class="mt-1 p-2 w-full border rounded-md @error('alamat') border-red-500 @enderror" required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="dusun" class="block text-sm font-medium text-gray-700">Dusun<span class="text-red-500">*</span></label>
                                    <select name="dusun" id="dusun" class="mt-1 p-2 w-full border rounded-md @error('dusun') border-red-500 @enderror" required>
                                        @foreach(['001', '002', '003', '004', '005', '006', '007'] as $dusun)
                                            <option value="{{ $dusun }}" {{ old('dusun') == $dusun ? 'selected' : '' }}>{{ $dusun }}</option>
                                        @endforeach
                                    </select>
                                    @error('dusun')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="no_rt" class="block text-sm font-medium text-gray-700">RT<span class="text-red-500">*</span></label>
                                    <input type="number" name="no_rt" id="no_rt" class="mt-1 p-2 w-full border rounded-md @error('no_rt') border-red-500 @enderror" value="{{ old('no_rt') }}" required>
                                    @error('no_rt')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="no_rw" class="block text-sm font-medium text-gray-700">RW<span class="text-red-500">*</span></label>
                                    <input type="number" name="no_rw" id="no_rw" class="mt-1 p-2 w-full border rounded-md @error('no_rw') border-red-500 @enderror" value="{{ old('no_rw') }}" required>
                                    @error('no_rw')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div id="familyMembersContainer">
                            <h3 class="text-lg font-semibold mb-4">Data Anggota Keluarga</h3>
                            <div class="family-member bg-gray-100 p-6 rounded-lg mb-4" data-index="0">
                                <div class="text-right mb-2">
                                    <button type="button" class="remove-member text-red-500 hover:text-red-700" onclick="removeMember(this)" style="display: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label for="family_members[0][nik]" class="block text-sm font-medium text-gray-700">NIK<span class="text-red-500">*</span></label>
                                        <input type="text" name="family_members[0][nik]" class="mt-1 p-2 w-full border rounded-md @error('family_members.0.nik') border-red-500 @enderror" value="{{ old('family_members.0.nik') }}" required>
                                        @error('family_members.0.nik')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="family_members[0][nama]" class="block text-sm font-medium text-gray-700">Nama<span class="text-red-500">*</span></label>
                                        <input type="text" name="family_members[0][nama]" class="mt-1 p-2 w-full border rounded-md @error('family_members.0.nama') border-red-500 @enderror" value="{{ old('family_members.0.nama') }}" required>
                                        @error('family_members.0.nama')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="family_members[0][jk]" class="block text-sm font-medium text-gray-700">Jenis Kelamin<span class="text-red-500">*</span></label>
                                        <select name="family_members[0][jk]" class="mt-1 p-2 w-full border rounded-md @error('family_members.0.jk') border-red-500 @enderror" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="laki-laki" {{ old('family_members.0.jk') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="perempuan" {{ old('family_members.0.jk') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('family_members.0.jk')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label for="family_members[0][tmp_lahir]" class="block text-sm font-medium text-gray-700">Tempat Lahir<span class="text-red-500">*</span></label>
                                        <input type="text" name="family_members[0][tmp_lahir]" class="mt-1 p-2 w-full border rounded-md @error('family_members.0.tmp_lahir') border-red-500 @enderror" value="{{ old('family_members.0.tmp_lahir') }}" required>
                                        @error('family_members.0.tmp_lahir')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="family_members[0][tgl_lahir]" class="block text-sm font-medium text-gray-700">Tanggal Lahir<span class="text-red-500">*</span></label>
                                        <input type="date" name="family_members[0][tgl_lahir]" class="mt-1 p-2 w-full border rounded-md @error('family_members.0.tgl_lahir') border-red-500 @enderror" value="{{ old('family_members.0.tgl_lahir') }}" required>
                                        @error('family_members.0.tgl_lahir')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="family_members[0][agamas_id]" class="block text-sm font-medium text-gray-700">Agama<span class="text-red-500">*</span></label>
                                        <select name="family_members[0][agamas_id]" class="mt-1 p-2 w-full border rounded-md @error('family_members.0.agamas_id') border-red-500 @enderror" required>
                                            <option value="">Pilih Agama</option>
                                            @foreach($agamas as $agama)
                                                <option value="{{ $agama->id }}" {{ old('family_members.0.agamas_id') == $agama->id ? 'selected' : '' }}>{{ $agama->nama_agama }}</option>
                                            @endforeach
                                        </select>
                                        @error('family_members.0.agamas_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label for="family_members[0][pendidikans_id]" class="block text-sm font-medium text-gray-700">Pendidikan<span class="text-red-500">*</span></label>
                                        <select name="family_members[0][pendidikans_id]" class="mt-1 p-2 w-full border rounded-md @error('family_members.0.pendidikans_id') border-red-500 @enderror" required>
                                            <option value="">Pilih Pendidikan</option>
                                            @foreach($pendidikans as $pendidikan)
                                                <option value="{{ $pendidikan->id }}" {{ old('family_members.0.pendidikans_id') == $pendidikan->id ? 'selected' : '' }}>{{ $pendidikan->nama_pendidikan }}</option>
                                            @endforeach
                                        </select>
                                        @error('family_members.0.pendidikans_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="family_members[0][pendidikan_sedangs_id]" class="block text-sm font-medium text-gray-700">Pendidikan Sedang</label>
                                        <select name="family_members[0][pendidikan_sedangs_id]" class="mt-1 p-2 w-full border rounded-md @error('family_members.0.pendidikan_sedangs_id') border-red-500 @enderror">
                                            <option value="">Pilih Pendidikan Sedang</option>
                                            @foreach($pendidikanSedangs as $pendidikanSedang)
                                                <option value="{{ $pendidikanSedang->id }}" {{ old('family_members.0.pendidikan_sedangs_id') == $pendidikanSedang->id ? 'selected' : '' }}>{{ $pendidikanSedang->nama_pendidikan_sedangs }}</option>
                                            @endforeach
                                        </select>
                                        @error('family_members.0.pendidikan_sedangs_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="family_members[0][pekerjaans_id]" class="block text-sm font-medium text-gray-700">Pekerjaan<span class="text-red-500">*</span></label>
                                        <select name="family_members[0][pekerjaans_id]" class="mt-1 p-2 w-full border rounded-md @error('family_members.0.pekerjaans_id') border-red-500 @enderror" required>
                                            <option value="">Pilih Pekerjaan</option>
                                            @foreach($pekerjaans as $pekerjaan)
                                                <option value="{{ $pekerjaan->id }}" {{ old('family_members.0.pekerjaans_id') == $pekerjaan->id ? 'selected' : '' }}>{{ $pekerjaan->nama_pekerjaan }}</option>
                                            @endforeach
                                        </select>
                                        @error('family_members.0.pekerjaans_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label for="family_members[0][stat_kawins_id]" class="block text-sm font-medium text-gray-700">Status Perkawinan<span class="text-red-500">*</span></label>
                                        <select name="family_members[0][stat_kawins_id]" class="mt-1 p-2 w-full border rounded-md @error('family_members.0.stat_kawins_id') border-red-500 @enderror" required>
                                            <option value="">Pilih Status Perkawinan</option>
                                            @foreach($statKawins as $statKawin)
                                                <option value="{{ $statKawin->id }}" {{ old('family_members.0.stat_kawins_id') == $statKawin->id ? 'selected' : '' }}>{{ $statKawin->nama_stat_kawins }}</option>
                                            @endforeach
                                        </select>
                                        @error('family_members.0.stat_kawins_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="family_members[0][stat_hub_keluargas_id]" class="block text-sm font-medium text-gray-700">Hubungan Keluarga<span class="text-red-500">*</span></label>
                                        <select name="family_members[0][stat_hub_keluargas_id]" class="mt-1 p-2 w-full border rounded-md @error('family_members.0.stat_hub_keluargas_id') border-red-500 @enderror" required>
                                            <option value="">Pilih Hubungan Keluarga</option>
                                            @foreach($statHubKeluargas as $statHubKeluarga)
                                                <option value="{{ $statHubKeluarga->id }}" {{ old('family_members.0.stat_hub_keluargas_id') == $statHubKeluarga->id ? 'selected' : '' }}>{{ $statHubKeluarga->nama_hub_keluarga }}</option>
                                            @endforeach
                                        </select>
                                        @error('family_members.0.stat_hub_keluargas_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="family_members[0][kewarganegaraan]" class="block text-sm font-medium text-gray-700">Kewarganegaraan<span class="text-red-500">*</span></label>
                                        <select name="family_members[0][kewarganegaraan]" class="mt-1 p-2 w-full border rounded-md @error('family_members.0.kewarganegaraan') border-red-500 @enderror" required>
                                            <option value="wni" {{ old('family_members.0.kewarganegaraan', 'wni') == 'wni' ? 'selected' : '' }}>WNI</option>
                                            <option value="wna" {{ old('family_members.0.kewarganegaraan') == 'wna' ? 'selected' : '' }}>WNA</option>
                                            <option value="dua kewarganegaraan" {{ old('family_members.0.kewarganegaraan') == 'dua kewarganegaraan' ? 'selected' : '' }}>Dua Kewarganegaraan</option>
                                        </select>
                                        @error('family_members.0.kewarganegaraan')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label for="family_members[0][ayah_nama]" class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                                        <input type="text" name="family_members[0][ayah_nama]" class="mt-1 p-2 w-full border rounded-md @error('family_members.0.ayah_nama') border-red-500 @enderror" value="{{ old('family_members.0.ayah_nama') }}">
                                        @error('family_members.0.ayah_nama')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="family_members[0][ibu_nama]" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                                        <input type="text" name="family_members[0][ibu_nama]" class="mt-1 p-2 w-full border rounded-md @error('family_members.0.ibu_nama') border-red-500 @enderror" value="{{ old('family_members.0.ibu_nama') }}">
                                        @error('family_members.0.ibu_nama')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="family_members[0][gol_darahs_id]" class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                                        <select name="family_members[0][gol_darahs_id]" class="mt-1 p-2 w-full border rounded-md @error('family_members.0.gol_darahs_id') border-red-500 @enderror">
                                            <option value="">Pilih Golongan Darah</option>
                                            @foreach($golDarahs as $golDarah)
                                                <option value="{{ $golDarah->id }}" {{ old('family_members.0.gol_darahs_id') == $golDarah->id ? 'selected' : '' }}>{{ $golDarah->nama_gol_darah }}</option>
                                            @endforeach
                                        </select>
                                        @error('family_members.0.gol_darahs_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label for="family_members[0][stat_dasars_id]" class="block text-sm font-medium text-gray-700">Status Dasar<span class="text-red-500">*</span></label>
                                        <select name="family_members[0][stat_dasars_id]" class="mt-1 p-2 w-full border rounded-md @error('family_members.0.stat_dasars_id') border-red-500 @enderror" required>
                                            @foreach($statDasars as $statDasar)
                                                <option value="{{ $statDasar->id }}" {{ old('family_members.0.stat_dasars_id', ($statDasar->nama_stat_dasars == 'HIDUP' ? $statDasar->id : '')) == $statDasar->id ? 'selected' : '' }}>{{ $statDasar->nama_stat_dasars }}</option>
                                            @endforeach
                                        </select>
                                        @error('family_members.0.stat_dasars_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="family_members[0][asuransis_id]" class="block text-sm font-medium text-gray-700">Asuransi</label>
                                        <select name="family_members[0][asuransis_id]" class="mt-1 p-2 w-full border rounded-md @error('family_members.0.asuransis_id') border-red-500 @enderror">
                                            <option value="">Pilih Asuransi</option>
                                            @foreach($asuransis as $asuransi)
                                                <option value="{{ $asuransi->id }}" {{ old('family_members.0.asuransis_id') == $asuransi->id ? 'selected' : '' }}>{{ $asuransi->nama_asuransi }}</option>
                                            @endforeach
                                        </select>
                                        @error('family_members.0.asuransis_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex items-center">
                                        <div class="flex items-center mr-4 mt-6">
                                            <input type="checkbox" name="family_members[0][ktp_el]" id="family_members[0][ktp_el]" class="mr-2" {{ old('family_members.0.ktp_el') ? 'checked' : '' }}>
                                            <label for="family_members[0][ktp_el]" class="text-sm font-medium text-gray-700">KTP Elektronik</label>
                                        </div>
                                        <div class="flex items-center mr-4 mt-6" id="hamilContainer0" style="display: none;">
                                            <input type="checkbox" name="family_members[0][hamil]" id="family_members[0][hamil]" class="mr-2" {{ old('family_members.0.hamil') ? 'checked' : '' }}>
                                            <label for="family_members[0][hamil]" class="text-sm font-medium text-gray-700">Hamil</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="button" id="addMemberBtn" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Tambah Anggota Keluarga
                            </button>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Data Keluarga
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/simple-native-form.js') }}"></script>
    <script>
        let memberIndex = 0;

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize dynamic member indices based on old input
            @if(old('family_members') && count(old('family_members')) > 1)
                // Find the highest index in old family_members
                @foreach(old('family_members') as $index => $member)
                    @if($index > 0) // Skip the first member since it's already in the template
                        addMember({{ $index }}, @json($member));
                    @endif
                @endforeach
                memberIndex = {{ max(array_keys(old('family_members'))) }};
            @endif

            // Show/hide hamil checkbox based on gender
            const genderSelects = document.querySelectorAll('select[name^="family_members"][name$="[jk]"]');
            genderSelects.forEach(select => {
                // Apply initial state based on selected value
                const index = select.name.match(/\[(\d+)\]/)[1];
                const hamilContainer = document.getElementById(`hamilContainer${index}`);
                if (hamilContainer) {
                    hamilContainer.style.display = select.value === 'perempuan' ? 'block' : 'none';
                }

                // Add change event listener
                select.addEventListener('change', function() {
                    const index = this.name.match(/\[(\d+)\]/)[1];
                    const hamilContainer = document.getElementById(`hamilContainer${index}`);
                    hamilContainer.style.display = this.value === 'perempuan' ? 'block' : 'none';
                });
            });

            // Add member button
            document.getElementById('addMemberBtn').addEventListener('click', function() {
                addMember(memberIndex + 1);
            });
        });

        function addMember(index = null, oldData = null) {
            // Use provided index or increment
            if (index === null) {
                memberIndex++;
                index = memberIndex;
            } else {
                memberIndex = Math.max(memberIndex, index);
            }

            const template = document.querySelector('.family-member').cloneNode(true);
            template.dataset.index = index;

            // Update all input names and IDs with new index
            template.querySelectorAll('input, select').forEach(input => {
                if (input.name) {
                    const oldName = input.name;
                    const newName = oldName.replace(/\[0\]/, `[${index}]`);
                    input.name = newName;
                    input.id = newName;

                    // Set value from oldData if available
                    if (oldData) {
                        const fieldName = oldName.match(/\[([a-z_]+)\]$/);
                        if (fieldName && fieldName[1]) {
                            const field = fieldName[1];
                            if (field in oldData) {
                                if (input.type === 'checkbox') {
                                    input.checked = oldData[field] ? true : false;
                                } else {
                                    input.value = oldData[field] || '';
                                }
                            }
                        }
                    } else {
                        // Reset value if no old data
                        if (input.type === 'checkbox') {
                            input.checked = false;
                        } else if (input.type !== 'hidden') {
                            input.value = '';
                        }
                    }
                }
            });

            // Update label for attributes
            template.querySelectorAll('label').forEach(label => {
                if (label.getAttribute('for')) {
                    label.setAttribute('for', label.getAttribute('for').replace(/\[0\]/, `[${index}]`));
                }
            });

            // Update hamil container ID
            const hamilContainer = template.querySelector('[id^="hamilContainer"]');
            if (hamilContainer) {
                hamilContainer.id = `hamilContainer${index}`;

                // Set visibility based on gender
                const genderSelect = template.querySelector(`select[name="family_members[${index}][jk]"]`);
                if (genderSelect) {
                    hamilContainer.style.display = genderSelect.value === 'perempuan' ? 'block' : 'none';
                } else {
                    hamilContainer.style.display = 'none';
                }
            }

            // Show remove button for this new member
            template.querySelector('.remove-member').style.display = 'inline-block';

            document.getElementById('familyMembersContainer').appendChild(template);

            // Re-attach change event for gender select
            const newGenderSelect = template.querySelector(`select[name="family_members[${index}][jk]"]`);
            newGenderSelect.addEventListener('change', function() {
                const hamilContainer = document.getElementById(`hamilContainer${index}`);
                hamilContainer.style.display = this.value === 'perempuan' ? 'block' : 'none';
            });
        }

        function removeMember(button) {
            const memberDiv = button.closest('.family-member');
            memberDiv.remove();
        }
    </script>
</x-app-layout>
