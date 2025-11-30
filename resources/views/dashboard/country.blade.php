<x-layouts.dashboard>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Country</h1>
            <div class="flex space-x-2">
                <a href="{{ route('countries.export') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded flex items-center space-x-2 transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Export Countries</span>
                </a>
                
                <button onclick="document.getElementById('importCountryModal').showModal()"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded flex items-center space-x-2 transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <span>Import Countries</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <livewire:country.add-country />
        <livewire:country.list-country />
    </div>

    <dialog id="importCountryModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Import Countries</h3>
            <form action="{{ route('countries.import') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Select CSV file</span>
                    </label>
                    <input type="file" name="file" class="file-input file-input-bordered w-full" 
                           accept=".csv,.txt" required>
                    <label class="label">
                        <span class="label-text-alt">Supported formats: CSV, TXT (Max: 10MB)</span>
                    </label>
                    <div class="mt-2 p-2 bg-gray-100 rounded text-sm">
                        <p class="font-semibold">CSV format should include:</p>
                        <p>Name, Top (optional, default: 0)</p>
                    </div>
                </div>
                <div class="modal-action">
                    <button type="submit" class="btn btn-primary">Import</button>
                    <button type="button" onclick="document.getElementById('importCountryModal').close()" 
                            class="btn btn-ghost">Cancel</button>
                </div>
            </form>
        </div>
    </dialog>
</x-layouts.dashboard>