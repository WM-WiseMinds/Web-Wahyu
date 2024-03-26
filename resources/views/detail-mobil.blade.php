<x-guest-layout>
    @php
        session(['showNavigation' => false]);
    @endphp
    <div class="flex flex-col min-h-screen" x-data>
        @livewire('navbar')
        <div class="flex-grow">

            <div class="text-xl">
                <h1 class="text-center text-4xl font-bold mt-10">Detail Mobil</h1>
            </div>

            <div class="flex justify-center my-5 flex-wrap">
                {{-- {{ dump($barang) }} --}}
                <div class="hero h-[50vh] bg-white">
                    <div class="hero-content flex-col lg:flex-row">
                        <img src="{{ asset('storage/' . $barang->gambar) }}"
                            class="max-w-sm rounded-lg shadow-2xl h-96" />
                        <div>
                            <h1 class="text-5xl font-bold">{{ $barang->nama_barang }}</h1>
                            <p class="py-6">{{ $barang->keterangan }}</p>
                            <button class="btn btn-primary"
                                onclick="Livewire.dispatch('openModal', { component: 'keranjang-form', arguments: { barang_id: {{ $barang->id }} } })"">Beli
                                Sekarang</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="text-xl">
                <h1 class="text-center text-4xl font-bold mt-10">Ukuran Produk</h1>
            </div>
            <div class="flex justify-center my-5 flex-wrap">

                <div class="overflow-x-auto w-full mx-10 my-5">
                    <table class="table table-zebra border-2">
                        <!-- head -->
                        <thead class="border-2 text-base">
                            <tr>
                                <th>No </th>
                                <th>Ukuran</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang->ukuran as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->ukuran }}</td>
                                    <td class="border px-4 py-2">{{ $item->panjang }} cm x
                                        {{ $item->lebar }} cm x
                                        {{ $item->tinggi }} cm</td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @livewire('footer')
    </div>
</x-guest-layout>
