<div>
    <form>
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="">
                <div class="mb-4">
                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Nama</label>
                    <input type="text" class="input input-bordered w-full" id="exampleFormControlInput1"
                        placeholder="Enter Nama" wire:model="nama">
                    @error('nama')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput2"
                        class="block text-gray-700 text-sm font-bold mb-2">Merk</label>
                    <input type="text" class="input input-bordered w-full" id="exampleFormControlInput2"
                        placeholder="Enter Merk" wire:model="merk">
                    @error('merk')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput3"
                        class="block text-gray-700 text-sm font-bold mb-2">Warna</label>
                    <input type="text" class="input input-bordered w-full" id="exampleFormControlInput3"
                        placeholder="Enter Warna" wire:model="warna">
                    @error('warna')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput4"
                        class="block text-gray-700 text-sm font-bold mb-2">Tahun</label>
                    <input type="text" class="input input-bordered w-full" id="exampleFormControlInput4"
                        placeholder="Enter Tahun" wire:model="tahun">
                    @error('tahun')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput5" class="block text-gray-700 text-sm font-bold mb-2">Plat
                        Nomor</label>
                    <input type="text" class="input input-bordered w-full" id="exampleFormControlInput5"
                        placeholder="Enter Plat Nomor" wire:model="plat_nomor">
                    @error('plat_nomor')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput6"
                        class="block text-gray-700 text-sm font-bold mb-2">Keterangan</label>
                    <textarea class="textarea textarea-bordered w-full" id="exampleFormControlInput6" placeholder="Enter Keterangan"
                        wire:model="keterangan"></textarea>
                    @error('keterangan')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput7"
                        class="block text-gray-700 text-sm font-bold mb-2">Harga</label>
                    <input type="number" class="input input-bordered w-full" id="exampleFormControlInput7"
                        placeholder="Enter Harga" wire:model="harga">
                    @error('harga')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                {{-- Kapasitas Penumpang --}}
                <div class="mb-4">
                    <label for="exampleFormControlInput8" class="block text-gray-700 text-sm font-bold mb-2">Kapasitas
                        Penumpang</label>
                    <input type="number" class="input input-bordered w-full" id="exampleFormControlInput8"
                        placeholder="Enter Kapasitas Penumpang" wire:model="kapasitas_penumpang">
                    @error('kapasitas_penumpang')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput8"
                        class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select class="input input-bordered w-full" id="exampleFormControlInput8" wire:model="status">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Disewa">Disewa</option>
                        <option value="Rusak">Rusak</option>
                    </select>
                    @error('status')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput3"
                        class="block text-gray-700 text-sm font-bold mb-2">Foto</label>

                    <input type="file" id="foto" wire:model.live="foto" x-ref="foto"
                        class="file-input file-input-bordered file-input-sm w-full"
                        x-on:change="
                            photoName = $refs.foto.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                photoPreview = e.target.result;
                            };
                            reader.readAsDataURL($refs.foto.files[0]);
                        " />
                    @error('foto')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                    @if ($mobil->exists && $mobil->foto)
                        <x-button emerald class="mt-2">
                            <a href="{{ $foto_url }}" download>Download</a>
                        </x-button>
                    @endif
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
