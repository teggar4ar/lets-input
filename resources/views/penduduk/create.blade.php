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
                                    <label for="no_kk" class="block text-sm font-medium text-gray-700">Nomor KK</label>
                                    <input type="text" name="no_kk" id="no_kk" class="mt-1 p-2 w-full border rounded-md @error('no_kk') border-red-500 @enderror" value="{{ old('no_kk') }}" required>
                                    @error('no_kk')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="2" class="mt-1 p-2 w-full border rounded-md @error('alamat') border-red-500 @enderror" required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="dusun" class="block text-sm font-medium text-gray-700">Dusun</label>
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
                                    <label for="no_rt" class="block text-sm font-medium text-gray-700">RT</label>
                                    <input type="number" name="no_rt" id="no_rt" class="mt-1 p-2 w-full border rounded-md @error('no_rt') border-red-500 @enderror" value="{{ old('no_rt') }}" required>
                                    @error('no_rt')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="no_rw" class="block text-sm font-medium text-gray-700">RW</label>
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
                                        <label for="family_members[0][nik]" class="block text-sm font-medium text-gray-700">NIK</label>
                                        <input type="text" name="family_members[0][nik]" class="mt-1 p-2 w-full border rounded-md" required>
                                    </div>
                                    <div>
                                        <label for="family_members[0][nama]" class="block text-sm font-medium text-gray-700">Nama</label>
                                        <input type="text" name="family_members[0][nama]" class="mt-1 p-2 w-full border rounded-md" required>
                                    </div>
                                    <div>
                                        <label for="family_members[0][jk]" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                        <select name="family_members[0][jk]" class="mt-1 p-2 w-full border rounded-md" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="laki-laki">Laki-laki</option>
                                            <option value="perempuan">Perempuan</option>
                                        </select>
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
