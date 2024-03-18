<div>
    <form>
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="">
                <div class="mb-4">
                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input type="text" class="input input-bordered w-full" id="exampleFormControlInput1"
                        placeholder="Enter Name" wire:model="name">
                    @error('name')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput2"
                        class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" class="input input-bordered w-full" id="exampleFormControlInput2"
                        placeholder="Enter Email" wire:model="email">
                    @error('email')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput3"
                        class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" class="input input-bordered w-full" id="exampleFormControlInput3"
                        placeholder="Enter Password" wire:model="password">
                    @error('password')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput4" class="block text-gray-700 text-sm font-bold mb-2">Confirm
                        Password</label>
                    <input type="password" class="input input-bordered w-full" id="exampleFormControlInput4"
                        placeholder="Enter Confirm Password" wire:model="password_confirmation">
                    @error('password_confirmation')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput4"
                        class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                    <select wire:model="role" class="select select-bordered w-full" id="exampleFormControlInput4">
                        <option value="">Pilih Role</option>
                        @foreach ($roles as $r)
                            <option value="{{ $r->name }}">
                                {{ $r->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
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
