<?php

namespace App\Livewire;

use App\Models\Pelanggan;
use Livewire\Component;

class UpdateDetailPelanggan extends Component
{
    public Pelanggan $pelanggan;
    public $no_hp, $alamat, $user_id;

    public function mount()
    {
        $this->pelanggan = auth()->user()->pelanggan;
        $this->no_hp = $this->pelanggan->no_hp;
        $this->alamat = $this->pelanggan->alamat;
    }

    public function update()
    {
        $this->validate([
            'no_hp' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        $this->pelanggan->update([
            'no_hp' => $this->no_hp,
            'alamat' => $this->alamat,
        ]);

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.update-detail-pelanggan');
    }
}
