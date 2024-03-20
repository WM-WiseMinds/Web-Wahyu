<div>
    <form>
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="">
                @if ($updateDurasi || !$penyewaan->id)
                    <div class="mb-4">
                        <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Durasi
                            Sewa (Hari)</label>
                        <input type="number" class="input input-bordered w-full" id="exampleFormControlInput1"
                            placeholder="Enter Durasi Sewa" wire:model="durasi_sewa">
                        @error('durasi_sewa')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
                @if (!$updateDurasi || !$penyewaan->id)
                    <div class="mb-4">
                        <label for="exampleFormControlInput4"
                            class="block text-gray-700 text-sm font-bold mb-2">Mobil</label>
                        <select wire:model="mobil_id" class="select select-bordered w-full"
                            id="exampleFormControlInput4">
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
                @endif
            </div>
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
