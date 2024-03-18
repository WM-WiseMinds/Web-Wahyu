<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toastable;
use Spatie\Permission\Models\Role;

class UserForm extends ModalComponent
{
    use Toastable;

    public User $user;
    public $id, $name, $email, $password, $alamat, $no_hp, $roles, $role;

    public function mount($rowId = null)
    {
        $this->user = User::findOrNew($rowId);
        $this->id = $this->user->id;
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->alamat = $this->user->alamat;
        $this->no_hp = $this->user->no_hp;
        $this->roles = Role::all();

        if ($rowId) {
            $this->role = $this->user->roles->pluck('name')->first();

            // dump($this->selectedRole);
        }
    }

    public function render()
    {
        return view('livewire.user-form');
    }

    public function resetForm()
    {
        $this->id = '';
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->id)],
            'password' => 'required|string|min:8',
            'role' => 'required',
        ];
    }

    public function store()
    {
        $validatedData = $this->validate();
        $validatedData['password'] = Hash::make($validatedData['password']);

        $this->user = User::updateOrCreate(['id' => $this->id], $validatedData);

        $this->user->syncRoles($this->role);

        $this->closeModalWithEvents([
            UserTable::class => 'userUpdated',
        ]);

        $this->success($this->user->wasRecentlyCreated ? 'User berhasil dibuat' : 'User berhasil diupdate');

        $this->resetForm();
    }
}
