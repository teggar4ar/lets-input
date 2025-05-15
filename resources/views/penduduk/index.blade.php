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
                <a href="{{ route('penduduk.export', request()->query()) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
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
                        </div>                    @endif

                    <!-- Search and filter section -->
                    <div class="mb-6">
                        <form action="{{ route('penduduk.index') }}" method="GET" class="flex flex-col md:flex-row gap-4" id="filterForm">
                            <div class="flex-1">
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                                <input type="text" name="search" id="search" placeholder="Cari berdasarkan NIK, No KK, atau nama..."
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                       value="{{ request('search') }}" autofocus
                                       @keydown.enter="$event.target.form.submit()">
                            </div>

                            <div class="w-full md:w-1/4">
                                <label for="filter_dusun" class="block text-sm font-medium text-gray-700 mb-1">Dusun</label>
                                <select name="filter_dusun" id="filter_dusun" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="">Semua Dusun</option>
                                    @foreach(['001', '002', '003', '004', '005', '006', '007'] as $dusun)
                                        <option value="{{ $dusun }}" {{ request('filter_dusun') == $dusun ? 'selected' : '' }}>{{ $dusun }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-end space-x-2">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Filter
                                </button>
                                @if(request('search') || request('filter_dusun'))
                                    <a href="{{ route('penduduk.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Results count summary -->
                    @if($penduduks->total() > 0)
                        <div class="mb-4 text-sm">
                            <span class="font-medium">{{ $penduduks->total() }}</span> data ditemukan
                            @if(request('search') || request('filter_dusun'))
                                dengan filter
                                @if(request('search'))
                                    <span class="font-medium">pencarian: "{{ request('search') }}"</span>
                                @endif
                                @if(request('filter_dusun'))
                                    <span class="font-medium">dusun: {{ request('filter_dusun') }}</span>
                                @endif
                            @endif
                        </div>
                    @endif

                    <div class="overflow-x-auto relative" id="tableContainer">
                        <!-- Loading overlay -->
                        <div id="loadingOverlay" class="hidden absolute inset-0 bg-white bg-opacity-70 flex items-center justify-center z-10">
                            <div class="flex flex-col items-center">
                                <svg class="animate-spin h-10 w-10 text-blue-500 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-gray-700 font-medium">Memuat data...</span>
                            </div>
                        </div>

                        <table class="min-w-full bg-white border border-gray-300">
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
                                        <td class="px-4 py-2 border-b border-gray-300 text-sm">
                                            {{ $penduduk->no_kk }}
                                            <a href="{{ route('penduduk.add-family-member', $penduduk->no_kk) }}" class="text-blue-500 hover:underline ml-2" title="Tambah anggota keluarga">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </a>
                                        </td>
                                        <td class="px-4 py-2 border-b border-gray-300 text-sm">{{ $penduduk->nik }}</td>
                                        <td class="px-4 py-2 border-b border-gray-300 text-sm">{{ $penduduk->nama }}</td>
                                        <td class="px-4 py-2 border-b border-gray-300 text-sm">{{ ucfirst($penduduk->jk) }}</td>
                                        <td class="px-4 py-2 border-b border-gray-300 text-sm">{{ $penduduk->tmp_lahir }}, {{ \Carbon\Carbon::parse($penduduk->tgl_lahir)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2 border-b border-gray-300 text-sm">{{ $penduduk->alamat->nama_alamat ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 border-b border-gray-300 text-sm flex space-x-2">
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
                                        <td colspan="7" class="px-4 py-2 text-center border-b border-gray-300 text-sm">Tidak ada data penduduk</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <div class="flex flex-col md:flex-row justify-between items-center">
                            <!-- Pagination information -->
                            <div class="mb-2 text-sm text-gray-600">
                                Menampilkan {{ $penduduks->firstItem() ?? 0 }} - {{ $penduduks->lastItem() ?? 0 }} dari {{ $penduduks->total() }} data
                            </div>

                            <!-- Items per page selector -->
                            <div class="flex items-center mb-2 md:mb-0">
                                <span class="text-sm text-gray-600 mr-2">Tampilkan:</span>
                                <form action="{{ route('penduduk.index') }}" method="GET" class="inline-flex" id="perPageForm">
                                    @if(request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif

                                    @if(request('filter_dusun'))
                                        <input type="hidden" name="filter_dusun" value="{{ request('filter_dusun') }}">
                                    @endif

                                    <select name="per_page" id="per_page" onchange="showLoading(); this.form.submit()"
                                            class="bg-white border border-gray-300 text-gray-700 py-1 px-2 rounded leading-tight text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                                        @foreach([10, 25, 50, 100] as $perPage)
                                            <option value="{{ $perPage }}" {{ request('per_page', 10) == $perPage ? 'selected' : '' }}>
                                                {{ $perPage }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>

                        <div class="pagination-links">
                            {{ $penduduks->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add the JavaScript for loading overlay and link handling -->
    <script>
        // Loading overlay
        function showLoading() {
            document.getElementById('loadingOverlay').classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Handle form submission
            document.getElementById('filterForm').addEventListener('submit', function() {
                showLoading();
            });

            // Handle pagination links
            document.querySelectorAll('.pagination-links a').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    showLoading();
                    window.location.href = this.getAttribute('href');
                });
            });
        });
    </script>
</x-app-layout>
