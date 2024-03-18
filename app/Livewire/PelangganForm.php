<?php

namespace App\Livewire;

use App\Models\Pelanggan;
use App\Models\User;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toastable;

class PelangganForm extends ModalComponent
{
    use Toastable;

    public Pelanggan $pelanggan;
    public $id, $user_id, $alamat, $no_hp, $users;

    public function mount($rowId = null)
    {
        $this->pelanggan = Pelanggan::findOrNew($rowId);
        $this->users = User::query()->whereHas('roles', function ($query) {
            $query->where('name', 'Pelanggan');
        })->get();
        $this->id = $this->pelanggan->id;
        $this->user_id = $this->pelanggan->user_id;
        $this->alamat = $this->pelanggan->alamat;
        $this->no_hp = $this->pelanggan->no_hp;
    }

    public function render()
    {
        return view('livewire.pelanggan-form');
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'alamat' => 'required',
            'no_hp' => 'required',
        ];
    }

    public function resetForm()
    {
        $this->reset(['id', 'user_id', 'alamat', 'no_hp']);
    }

    public function store()
    {
        $validatedData = $this->validate();

        $this->pelanggan = Pelanggan::updateOrCreate(['id' => $this->id], $validatedData);

        $this->closeModalWithEvents([
            PelangganTable::class => 'pelangganUpdated',
        ]);

        $this->success($this->pelanggan->wasRecentlyCreated ? 'Pelanggan berhasil ditambahkan' : 'Pelanggan berhasil diubah');

        $this->resetForm();
    }
}
