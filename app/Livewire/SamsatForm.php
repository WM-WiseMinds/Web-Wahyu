<?php

namespace App\Livewire;

use App\Models\Mobil;
use App\Models\Samsat;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toastable;

class SamsatForm extends ModalComponent
{
    use Toastable;
    use WithFileUploads;

    public Samsat $samsat;
    public $id, $mobil_id, $keterangan, $biaya, $bukti_pembayaran, $bukti_pembayaran_url, $mobils;

    public function mount($rowId = null)
    {
        $this->samsat = Samsat::findOrNew($rowId);
        $this->id = $this->samsat->id;
        $this->mobil_id = $this->samsat->mobil_id;
        $this->keterangan = $this->samsat->keterangan;
        $this->biaya = $this->samsat->biaya;
        $this->mobils = Mobil::all();

        if ($this->samsat->bukti_pembayaran) {
            $this->bukti_pembayaran_url = Storage::disk('public')->url('foto-samsat/' . $this->samsat->bukti_pembayaran);
        }
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
            'bukti_pembayaran' => $this->bukti_pembayaran instanceof UploadedFile ? 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' : ''
        ];
    }

    public function resetForm()
    {
        $this->reset(['mobil_id', 'keterangan', 'biaya', 'bukti_pembayaran']);
    }

    public function store()
    {
        $validatedData = $this->validate();

        if ($this->bukti_pembayaran instanceof UploadedFile) {
            $originalName = pathinfo($this->bukti_pembayaran->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $this->bukti_pembayaran->getClientOriginalExtension();
            $fileName = time() . '-' . $originalName  .  '.' . $extension;

            if ($this->samsat->bukti_pembayaran) {
                Storage::disk('public')->delete('foto-samsat/' . $this->samsat->bukti_pembayaran);
            }

            $this->bukti_pembayaran->storeAs('public/foto-samsat', $fileName);
            $validatedData['bukti_pembayaran'] = $fileName;
        } else {
            $validatedData['bukti_pembayaran'] = $this->samsat->bukti_pembayaran;
        }

        $this->samsat = Samsat::updateOrCreate(['id' => $this->id], $validatedData);

        $this->closeModalWithEvents([
            SamsatTable::class => 'samsatUpdated',
        ]);

        $this->success($this->samsat->wasRecentlyCreated ? 'Data samsat berhasil disimpan' : 'Data samsat berhasil diubah');

        $this->resetForm();
    }
}
