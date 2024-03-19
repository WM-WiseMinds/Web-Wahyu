<?php

namespace App\Livewire;

use App\Models\Mobil;
use App\Models\Samsat;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toastable;

class SamsatForm extends ModalComponent
{
    use Toastable;

    public Samsat $samsat;
    public $id, $mobil_id, $keterangan, $biaya, $mobils;

    public function mount($rowId = null)
    {
        $this->samsat = Samsat::findOrNew($rowId);
        $this->id = $this->samsat->id;
        $this->mobil_id = $this->samsat->mobil_id;
        $this->keterangan = $this->samsat->keterangan;
        $this->biaya = $this->samsat->biaya;
        $this->mobils = Mobil::all();
    }

    public function render()
    {
        return view('livewire.samsat-form');
    }

    public function rules()
    {
        return [
            'mobil_id' => 'required|exists:mobil,id',
            'keterangan' => 'required',
            'biaya' => 'required',
        ];
    }

    public function resetForm()
    {
        $this->reset(['mobil_id', 'keterangan', 'biaya']);
    }

    public function store()
    {
        $validatedData = $this->validate();

        $this->samsat = Samsat::updateOrCreate(['id' => $this->id], $validatedData);

        $this->closeModalWithEvents([
            SamsatTable::class => 'samsatUpdated',
        ]);

        $this->success($this->samsat->wasRecentlyCreated ? 'Data samsat berhasil disimpan' : 'Data samsat berhasil diubah');

        $this->resetForm();
    }
}
