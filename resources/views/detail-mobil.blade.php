<x-guest-layout>
    @php
        session(['showNavigation' => false]);
    @endphp
    <div class="flex flex-col min-h-screen" x-data>
        @livewire('navbar')

        <div class="flex-grow">
            <div class="container mx-auto my-10">
                <h1 class="text-center text-4xl font-bold mb-10">Detail Mobil</h1>

                <div class="flex flex-col md:flex-row items-center justify-center gap-8">
                    <div class="w-full md:w-1/2 flex justify-center">
                        <img src="{{ asset('storage/foto-mobil/' . $mobil->foto) }}" alt="{{ $mobil->nama }}"
                            class="w-96 h-96 object-cover rounded-lg shadow-lg">
                    </div>
                    <div class="w-full md:w-1/2">
                        <h2 class="text-3xl font-bold mb-4">{{ $mobil->nama }}</h2>
                        <p class="text-gray-600 mb-4">{{ $mobil->keterangan }}</p>

                        <div class="mb-4">
                            <span class="font-bold">Merk:</span> {{ $mobil->merk }}
                        </div>
                        <div class="mb-4">
                            <span class="font-bold">Warna:</span> {{ $mobil->warna }}
                        </div>
                        <div class="mb-4">
                            <span class="font-bold">Tahun:</span> {{ $mobil->tahun }}
                        </div>
                        <div class="mb-4">
                            <span class="font-bold">Plat Nomor:</span> {{ $mobil->plat_nomor }}
                        </div>
                        <div class="mb-4">
                            <span class="font-bold">Harga Sewa:</span> {{ $mobil->harga }}
                        </div>
                        <div class="mb-4">
                            <span class="font-bold">Status:</span> {{ $mobil->status }}
                        </div>
                        <div class="mb-4">
                            <span class="font-bold">Kapasitas Penumpang:</span> {{ $mobil->kapasitas_penumpang }}
                        </div>

                        <button class="btn btn-primary"
                            onclick="Livewire.dispatch('openModal', { component: 'penyewaan-form', arguments: { mobil_id: {{ $mobil->id }} } })">
                            Sewa Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @livewire('footer')
    </div>
</x-guest-layout>
