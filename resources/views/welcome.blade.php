<x-guest-layout>
    <div class="flex flex-col min-h-screen">
        @livewire('navbar')
        <div class="flex-grow">

            <div class="hero h-[75vh]"
                style="background-image: url(https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?q=80&w=2370&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D);">
                <div class="hero-overlay bg-opacity-60"></div>
                <div class="hero-content text-center text-neutral-content">
                    <div class="max-w-md">
                        <h1 class="mb-5 text-5xl font-bold">PT. Karya Marga Jaya - Penyewaan Mobil Terpercaya di Bali
                        </h1>
                        <p class="mb-5">PT. Karya Marga Jaya – Solusi terpercaya untuk kebutuhan sewa mobil Anda di
                            Bali sejak 2022.</p>
                        <a class="btn btn-primary" href="{{ route('register') }}">Sewa Sekarang</a>
                    </div>
                </div>
            </div>
            <div class="hero min-h-fit bg-gray-300 py-10">
                <div class="hero-content flex-col lg:flex-row-reverse">
                    <div>
                        <h1 class="text-5xl font-bold text-center">PT. Karya Marga Jaya</h1>
                        <p class="py-6 text-center">
                            PT. Karya Marga Jaya adalah perusahaan penyewaan mobil yang berlokasi di Denpasar, Bali.
                            Diresmikan pada 17 September 2022, perusahaan ini awalnya memulai operasionalnya dengan
                            delapan unit mobil dan telah berkembang menjadi dua puluh unit.
                            Meskipun merupakan cabang dari perusahaan induk PT Karya Marga Jaya, entitas ini dijalankan
                            dengan manajemen yang berbeda, menunjukkan keinginan untuk beroperasi secara lebih
                            profesional dalam industri transportasi.
                        </p>
                    </div>
                </div>
            </div>
            <div class="hero min-h-fit py-10 bg-base-200">
                <div class="hero-content flex-col lg:flex-row-reverse">
                    <img src="https://images.unsplash.com/photo-1494976388531-d1058494cdd8?q=80&w=2574&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        class="max-w-sm rounded-lg shadow-2xl" />
                    <div>
                        <h1 class="text-5xl font-bold">Keunggulan PT. Karya Marga Jaya</h1>
                        <ul class="list-none p-0 mt-4 text-gray-700">
                            <li class="border-b border-gray-200 py-2">
                                <span class="text-xl font-bold">Armada Baru dan Bersih</span>
                                <p>Kami menyediakan berbagai jenis mobil yang seluruhnya baru dan dalam kondisi bersih.
                                </p>
                            </li>
                            <li class="border-b border-gray-200 py-2">
                                <span class="text-xl font-bold">Layanan Antar-Jemput</span>
                                <p>Nikmati kemudahan dengan layanan antar-jemput unit dari kami.</p>
                            </li>
                            <li class="border-b border-gray-200 py-2">
                                <span class="text-xl font-bold">Opsi Sewa Fleksibel</span>
                                <p>Pilih opsi sewa yang sesuai dengan kebutuhan Anda, mulai dari sewa harian, mingguan,
                                    hingga bulanan.</p>
                            </li>
                            <li class="border-b border-gray-200 py-2">
                                <span class="text-xl font-bold">Pembayaran Mudah</span>
                                <p>Prosedur pembayaran kami dirancang untuk memudahkan dan memberikan kenyamanan kepada
                                    pelanggan.</p>
                            </li>
                            <li class="py-2">
                                <span class="text-xl font-bold">Tim Profesional</span>
                                <p>Kami memiliki struktur organisasi yang lengkap dan profesional untuk memberikan
                                    pelayanan terbaik.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @livewire('footer')
    </div>
</x-guest-layout>
