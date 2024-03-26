<x-guest-layout>
    <div class="flex flex-col min-h-screen">
        @livewire('navbar')
        <div class="flex-grow">

            <div class="text-xl">
                <h1 class="text-center text-4xl font-bold mt-10">Mobil</h1>
            </div>

            <div class="flex justify-center my-5 flex-wrap">
                @foreach ($mobil as $item)
                    {{-- {{ dump($item) }} --}}
                    <div class="card w-96 mx-2 bg-base-100 shadow-xl my-3">
                        <figure><img src="{{ asset('storage/foto-mobil/' . $item->foto) }}"
                                alt="{{ $item->nama_mobil }}" />
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">{{ $item->nama_mobil }}</h2>
                            <p>{{ $item->keterangan }}</p>
                            <div class="card-actions justify-end">
                                <a class="btn btn-primary"
                                    href="{{ route('detail-mobil', ['id' => $item->id]) }}">Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
        @livewire('footer')
    </div>
</x-guest-layout>
