<div>
    <form>
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="">
                @if ($this->updatingPembayaranOnly)
                    <div class="mb-4">
                        <h2 class="font-bold mb-2">Rekening</h2>
                        <p>Nama Bank: XXXX</p>
                        <p>No. Rekening: XXXX</p>
                        <p>Nama Pemilik Rekening: XXXX</p>
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
                @endif

                @if ($this->updatingStatusOnly)
                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                        <select wire:model.defer="status"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="status">
                            <option value="" readonly>Pilih Status</option>
                            <option value="Dikonfirmasi">Dikonfirmasi</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                        @error('status')
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
