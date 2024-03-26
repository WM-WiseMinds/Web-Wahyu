<div>
    <form>
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="">
                <div class="mb-4">
                    <label for="exampleFormControlInput4" class="block text-gray-700 text-sm font-bold mb-2">Mobil</label>
                    <select wire:model="mobil_id" class="select select-bordered w-full"
                        wire:change='getHargaSewa($event.target.value)' id="exampleFormControlInput4">
                        <option value="">Pilih Mobil</option>
                        @foreach ($mobils as $mobil)
                            <option value="{{ $mobil->id }}">
                                {{ $mobil->nama }}</option>
                        @endforeach
                    </select>
                    @error('mobil_id')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput3"
                        class="block text-gray-700 text-sm font-bold mb-2">Pelanggan</label>
                    <select wire:model="pelanggan_id" class="select select-bordered w-full"
                        id="exampleFormControlInput3">
                        <option value="">Pilih Pelanggan</option>
                        @foreach ($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id }}">
                                {{ $pelanggan->user->name }}</option>
                        @endforeach
                    </select>
                    @error('pelanggan_id')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Tanggal
                        Penyewaan</label>
                    <input type="date" class="input input-bordered w-full" id="exampleFormControlInput1"
                        placeholder="Enter Tanggal Penyewaan" wire:model="tanggal_penyewaan">
                    @error('tanggal_penyewaan')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Durasi
                        Sewa (Hari)</label>
                    <input type="number" class="input input-bordered w-full" id="exampleFormControlInput1"
                        placeholder="Enter Durasi Sewa" wire:model="durasi_sewa" wire:change='getJumlahPembayaran'>
                    @error('durasi_sewa')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="hargaSewaMobil" class="block text-gray-700 text-sm font-bold mb-2">Harga Sewa
                        Perhari</label>
                    <input type="text" class="input input-bordered w-full" id="hargaSewaMobil"
                        placeholder="Harga Sewa Perhari" wire:model="hargaSewaMobil" readonly>
                </div>

                <div class="mb-4">
                    <label for="jumlahPembayaran" class="block text-gray-700 text-sm font-bold mb-2">Jumlah
                        Pembayaran</label>
                    <input type="text" class="input input-bordered w-full mr-3" id="jumlahPembayaran"
                        placeholder="Jumlah Pembayaran" wire:model="jumlahPembayaran" readonly>
                    @error('jumlahPembayaran')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- @if ($id)
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Kembali</label>
                    <div class="flex items-center">
                        <input type="radio" id="kembali_yes" value="1" wire:model="kembali">
                        <label for="kembali_yes" class="mr-4">Ya</label>

                        <input type="radio" id="kembali_no" value="0" wire:model="kembali" checked>
                        <label for="kembali_no">Tidak</label>
                    </div>
                    @error('kembali')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            @endif --}}
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button wire:click.prevent="store()" type="button" class="btn btn-success text-white">
                    Submit
                </button>
            </span>
            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button wire:click="closeModal()" type="button" class="btn btn-neutral">
                    Close
                </button>
            </span>
        </div>
    </form>
</div>
