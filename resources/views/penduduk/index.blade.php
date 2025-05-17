<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data Penduduk') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('penduduk.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Tambah Keluarga
                </a>
                <a href="{{ route('penduduk.export') }}?{{ http_build_query(request()->except('page')) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Export Excel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Search and Filter Section -->
                    <div class="mb-6 bg-gray-50 p-5 rounded-lg shadow-sm border border-gray-200">
                        <form action="{{ route('penduduk.index') }}" method="GET" class="space-y-4">
                            <!-- Search Bar -->
                            <div class="relative flex items-center bg-white border rounded-lg overflow-hidden shadow-sm">
                                <!-- Search icon -->
                                <div class="absolute left-0 top-0 ml-3 h-full flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>

                                <!-- Search input -->
                                <input type="text" name="search" placeholder="Cari berdasarkan NIK, No KK, Nama, atau Alamat..." value="{{ request('search') }}"
                                    class="flex-grow pl-10 py-3 pr-3 border-0 focus:outline-none focus:ring-0">

                                <!-- Search button -->
                                <button type="submit" class="h-full px-6 py-3 bg-blue-500 text-white font-medium hover:bg-blue-600 focus:outline-none transition duration-150">
                                    Cari
                                </button>
                            </div>

                            <!-- Action buttons -->
                            <div class="flex items-center justify-end space-x-2 mt-4">
                                <a href="{{ route('penduduk.index') }}" class="flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 border border-gray-300 transition duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Reset
                                </a>
                                <button type="button" id="toggle-filters" class="flex items-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Filter Lanjutan
                                    <span id="filter-indicator" class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none {{ request()->anyFilled(['jk', 'agama_id', 'pekerjaan_id', 'pendidikan_id', 'stat_kawin_id', 'stat_dasar_id', 'umur_dari', 'umur_sampai']) ? 'bg-white text-purple-700' : 'bg-purple-700 text-white' }} rounded-full">
                                        {{ request()->anyFilled(['jk', 'agama_id', 'pekerjaan_id', 'pendidikan_id', 'stat_kawin_id', 'stat_dasar_id', 'umur_dari', 'umur_sampai']) ? count(array_filter(request()->only(['jk', 'agama_id', 'pekerjaan_id', 'pendidikan_id', 'stat_kawin_id', 'stat_dasar_id', 'umur_dari', 'umur_sampai']))) : '0' }}
                                    </span>
                                </button>
                            </div>

                            <!-- Advanced Filters (Hidden by default) -->
                            <div id="advanced-filters" class="hidden mt-6 p-5 bg-white rounded-lg border border-gray-200 shadow-sm">
                                <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Filter Data Penduduk
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label for="jk" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                        <select name="jk" id="jk" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                            <option value="">Semua</option>
                                            <option value="laki-laki" {{ request('jk') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="perempuan" {{ request('jk') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="agama_id" class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                                        <select name="agama_id" id="agama_id" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                            <option value="">Semua</option>
                                            @foreach($agamas as $agama)
                                                <option value="{{ $agama->id }}" {{ request('agama_id') == $agama->id ? 'selected' : '' }}>
                                                    {{ $agama->nama_agama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="pekerjaan_id" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                                        <select name="pekerjaan_id" id="pekerjaan_id" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                            <option value="">Semua</option>
                                            @foreach($pekerjaans as $pekerjaan)
                                                <option value="{{ $pekerjaan->id }}" {{ request('pekerjaan_id') == $pekerjaan->id ? 'selected' : '' }}>
                                                    {{ $pekerjaan->nama_pekerjaan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label for="pendidikan_id" class="block text-sm font-medium text-gray-700 mb-1">Pendidikan</label>
                                        <select name="pendidikan_id" id="pendidikan_id" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                            <option value="">Semua</option>
                                            @foreach($pendidikans as $pendidikan)
                                                <option value="{{ $pendidikan->id }}" {{ request('pendidikan_id') == $pendidikan->id ? 'selected' : '' }}>
                                                    {{ $pendidikan->nama_pendidikan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="stat_kawin_id" class="block text-sm font-medium text-gray-700 mb-1">Status Perkawinan</label>
                                        <select name="stat_kawin_id" id="stat_kawin_id" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                            <option value="">Semua</option>
                                            @foreach($statKawins as $status)
                                                <option value="{{ $status->id }}" {{ request('stat_kawin_id') == $status->id ? 'selected' : '' }}>
                                                    {{ $status->nama_stat_kawins }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="stat_dasar_id" class="block text-sm font-medium text-gray-700 mb-1">Status Dasar</label>
                                        <select name="stat_dasar_id" id="stat_dasar_id" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                            <option value="">Semua</option>
                                            @foreach($statDasars as $status)
                                                <option value="{{ $status->id }}" {{ request('stat_dasar_id') == $status->id ? 'selected' : '' }}>
                                                    {{ $status->nama_stat_dasars }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div class="bg-gray-50 p-3 rounded-md shadow-inner">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Rentang Umur</label>
                                        <div class="flex space-x-4">
                                            <div class="w-1/2 relative">
                                                <input type="number" name="umur_dari" id="umur_dari" min="0" max="120" value="{{ request('umur_dari') }}"
                                                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="0">
                                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                    <span class="text-gray-500">tahun</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="text-gray-600">sampai</span>
                                            </div>
                                            <div class="w-1/2 relative">
                                                <input type="number" name="umur_sampai" id="umur_sampai" min="0" max="120" value="{{ request('umur_sampai') }}"
                                                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="100">
                                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                    <span class="text-gray-500">tahun</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="per_page" class="block text-sm font-medium text-gray-700 mb-1">Tampilkan</label>
                                        <select name="per_page" id="per_page" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 per halaman</option>
                                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per halaman</option>
                                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per halaman</option>
                                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per halaman</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-1">Urutkan Berdasarkan</label>
                                        <div class="flex space-x-2">
                                            <select name="sort_by" id="sort_by" class="w-3/4 border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                                <option value="updated_at" {{ request('sort_by') == 'updated_at' ? 'selected' : '' }}>Terakhir Diubah</option>
                                                <option value="nama" {{ request('sort_by') == 'nama' ? 'selected' : '' }}>Nama</option>
                                                <option value="nik" {{ request('sort_by') == 'nik' ? 'selected' : '' }}>NIK</option>
                                                <option value="no_kk" {{ request('sort_by') == 'no_kk' ? 'selected' : '' }}>No. KK</option>
                                                <option value="tgl_lahir" {{ request('sort_by') == 'tgl_lahir' ? 'selected' : '' }}>Tanggal Lahir</option>
                                            </select>
                                            <select name="sort_direction" id="sort_direction" class="w-1/4 border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                                <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Naik</option>
                                                <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Turun</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Filter action buttons -->
                                <div class="flex justify-end mt-6 pt-4 border-t border-gray-200">
                                    <button type="button" class="flex items-center px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50 mr-2" onclick="resetFilters()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Reset Filter
                                    </button>
                                    <button type="submit" class="flex items-center px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                        </svg>
                                        Terapkan Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Data Table -->
                    <div class="overflow-x-auto mt-6">
                        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-sm">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b-2 border-gray-300 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">No. KK</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-300 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">NIK</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-300 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Nama</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-300 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Jenis Kelamin</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-300 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Tempat, Tgl Lahir</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-300 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Alamat</th>
                                    <th class="px-4 py-2 border-b-2 border-gray-300 text-left text-sm leading-4 font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($penduduks as $penduduk)
                                    <tr>
                                        <td class="px-4 py-2 border-b border-gray-300 text-sm whitespace-nowrap">
                                            {{ $penduduk->no_kk }}
                                        </td>
                                        <td class="px-4 py-2 border-b border-gray-300 text-sm whitespace-nowrap">{{ $penduduk->nik }}</td>
                                        <td class="px-4 py-2 border-b border-gray-300 text-sm whitespace-nowrap">{{ $penduduk->nama }}</td>
                                        <td class="px-4 py-2 border-b border-gray-300 text-sm whitespace-nowrap">{{ ucfirst($penduduk->jk) }}</td>
                                        <td class="px-4 py-2 border-b border-gray-300 text-sm whitespace-nowrap">{{ $penduduk->tmp_lahir }}, {{ \Carbon\Carbon::parse($penduduk->tgl_lahir)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2 border-b border-gray-300 text-sm whitespace-nowrap overflow-hidden text-ellipsis" style="max-width: 200px;">{{ $penduduk->alamat->nama_alamat ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 border-b border-gray-300 text-sm whitespace-nowrap flex space-x-2">
                                            <a href="{{ route('penduduk.show', $penduduk->id) }}" class="text-blue-500 hover:text-blue-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('penduduk.edit', $penduduk->id) }}" class="text-yellow-500 hover:text-yellow-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('penduduk.add-family-member', $penduduk->no_kk) }}" class="text-blue-500 hover:text-blue-600" title="Tambah anggota keluarga">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('penduduk.destroy', $penduduk->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-2 text-center border-b border-gray-300 text-sm whitespace-nowrap">Tidak ada data penduduk</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex justify-between items-center flex-col sm:flex-row">
                        <div class="text-sm text-gray-600 mb-4 sm:mb-0">
                            Menampilkan {{ $penduduks->firstItem() ?? 0 }} - {{ $penduduks->lastItem() ?? 0 }} dari {{ $penduduks->total() }} data
                            @if(request('search'))
                                untuk pencarian "{{ request('search') }}"
                            @endif
                        </div>
                        <div class="pagination-container">
                            {{ $penduduks->links() }}
                        </div>

                        <style>
                            /* Custom pagination styling */
                            .pagination-container nav div:first-child {
                                display: none; /* Hide the "Showing X to Y of Z results" text that comes with Laravel pagination */
                            }

                            .pagination-container nav div:last-child span,
                            .pagination-container nav div:last-child a {
                                background-color: #f3f4f6 !important; /* Light gray background */
                                color: #4b5563 !important; /* Gray text */
                                border-color: #e5e7eb !important;
                            }

                            .pagination-container nav div:last-child span[aria-current="page"] {
                                background-color: #e5e7eb !important; /* Slightly darker gray for current page */
                                color: #374151 !important;
                                border-color: #d1d5db !important;
                            }

                            .pagination-container nav div:last-child a:hover {
                                background-color: #e5e7eb !important;
                                color: #374151 !important;
                            }
                        </style>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleFiltersButton = document.getElementById('toggle-filters');
            const advancedFilters = document.getElementById('advanced-filters');

            // Check if filters are already applied to show the advanced filters section
            const urlParams = new URLSearchParams(window.location.search);
            const hasAdvancedFilters = urlParams.has('jk') ||
                urlParams.has('agama_id') ||
                urlParams.has('pekerjaan_id') ||
                urlParams.has('pendidikan_id') ||
                urlParams.has('stat_kawin_id') ||
                urlParams.has('stat_dasar_id') ||
                urlParams.has('umur_dari') ||
                urlParams.has('umur_sampai') ||
                urlParams.has('sort_by') ||
                urlParams.has('sort_direction');

            if (hasAdvancedFilters) {
                advancedFilters.classList.remove('hidden');
            }

            // Toggle filters when button is clicked
            toggleFiltersButton.addEventListener('click', function() {
                advancedFilters.classList.toggle('hidden');

                // Add smooth animation
                if (!advancedFilters.classList.contains('hidden')) {
                    advancedFilters.style.opacity = '0';
                    advancedFilters.style.maxHeight = '0';
                    setTimeout(() => {
                        advancedFilters.style.transition = 'opacity 0.3s ease, max-height 0.3s ease';
                        advancedFilters.style.opacity = '1';
                        advancedFilters.style.maxHeight = '1000px';
                    }, 10);
                }
            });

            // Auto-submit form when per_page changes
            document.getElementById('per_page').addEventListener('change', function() {
                this.form.submit();
            });

            // Auto-submit form when sort_by or sort_direction changes
            document.getElementById('sort_by').addEventListener('change', function() {
                this.form.submit();
            });

            document.getElementById('sort_direction').addEventListener('change', function() {
                this.form.submit();
            });

            // Initialize select2 for better dropdown experience if available
            if (typeof $ !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
                $('#agama_id, #pekerjaan_id, #pendidikan_id, #stat_kawin_id, #stat_dasar_id').select2({
                    placeholder: 'Semua',
                    allowClear: true
                });
            }
        });

        // Function to reset all filters
        function resetFilters() {
            // Clear all inputs except search
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('select, input:not([name="search"])');

            inputs.forEach(input => {
                if (input.type === 'number' || input.type === 'text') {
                    input.value = '';
                } else if (input.type === 'select-one') {
                    input.selectedIndex = 0;
                }
            });

            // Keep the current search term but remove other parameters
            const searchTerm = document.querySelector('input[name="search"]').value;
            if (searchTerm) {
                window.location.href = '{{ route("penduduk.index") }}?search=' + encodeURIComponent(searchTerm);
            } else {
                window.location.href = '{{ route("penduduk.index") }}';
            }
        }
    </script>
</x-app-layout>
