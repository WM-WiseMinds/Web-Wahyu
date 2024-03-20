<div>
    <form>
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="">
                <div class="mb-4">
                    <label for="exampleFormControlInput4" class="block text-gray-700 text-sm font-bold mb-2">Mobil</label>
                    <select wire:model="mobil_id" class="select select-bordered w-full" id="exampleFormControlInput4">
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
                    <label for="exampleFormControlInput1"
                        class="block text-gray-700 text-sm font-bold mb-2">Keterangan</label>
                    <input type="text" class="input input-bordered w-full" id="exampleFormControlInput1"
                        placeholder="Enter Keterangan" wire:model="keterangan">
                    @error('keterangan')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput2"
                        class="block text-gray-700 text-sm font-bold mb-2">Biaya</label>
                    <input type="number" class="input input-bordered w-full" id="exampleFormControlInput2"
                        placeholder="Enter Biaya" wire:model="biaya">
                    @error('biaya')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput3" class="block text-gray-700 text-sm font-bold mb-2">Bukti
                        Pembayaran</label>

                    <input type="file" id="bukti_pembayaran" wire:model.live="bukti_pembayaran"
                        x-ref="bukti_pembayaran" class="file-input file-input-bordered file-input-sm w-full"
                        x-on:change="
                            photoName = $refs.bukti_pembayaran.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                photoPreview = e.target.result;
                            };
                            reader.readAsDataURL($refs.bukti_pembayaran.files[0]);
                        " />
                    @error('bukti_pembayaran')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
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
