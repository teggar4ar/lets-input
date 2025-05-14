<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Penduduk') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('penduduk.edit', $penduduk->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('penduduk.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Data Pribadi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border p-4 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-600">No. KK</p>
                                <p class="font-medium">{{ $penduduk->no_kk }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">NIK</p>
                                <p class="font-medium">{{ $penduduk->nik }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Nama</p>
                                <p class="font-medium">{{ $penduduk->nama }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Jenis Kelamin</p>
                                <p class="font-medium">{{ ucfirst($penduduk->jk) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tempat Lahir</p>
                                <p class="font-medium">{{ $penduduk->tmp_lahir }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tanggal Lahir</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($penduduk->tgl_lahir)->format('d F Y') }}</p>
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
                        <h3 class="text-lg font-semibold mb-4">Data Alamat</h3>
                        <div class="border p-4 rounded-lg">
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Alamat</p>
                                <p class="font-medium">{{ $penduduk->alamat->nama_alamat }}</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Dusun</p>
                                    <p class="font-medium">{{ $penduduk->alamat->dusun }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">RT</p>
                                    <p class="font-medium">{{ $penduduk->alamat->no_rt }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">RW</p>
                                    <p class="font-medium">{{ $penduduk->alamat->no_rw }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Data Orang Tua</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border p-4 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-600">Nama Ayah</p>
                                <p class="font-medium">{{ $penduduk->ayah_nama ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">NIK Ayah</p>
                                <p class="font-medium">{{ $penduduk->ayah_nik ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Nama Ibu</p>
                                <p class="font-medium">{{ $penduduk->ibu_nama ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">NIK Ibu</p>
                                <p class="font-medium">{{ $penduduk->ibu_nik ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">Data Lainnya</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border p-4 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-600">Cacat</p>
                                <p class="font-medium">{{ $penduduk->cacat->nama_cacat ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Cara KB</p>
                                <p class="font-medium">{{ $penduduk->caraKb->nama_cara_kb ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Asuransi</p>
                                <p class="font-medium">{{ $penduduk->asuransi->nama_asuransi ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Hamil</p>
                                <p class="font-medium">{{ $penduduk->hamil ? 'Ya' : 'Tidak' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">KTP Elektronik</p>
                                <p class="font-medium">{{ $penduduk->ktp_el ? 'Ya' : 'Tidak' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Suku</p>
                                <p class="font-medium">{{ $penduduk->suku ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
