<?php

namespace App\Livewire;

use App\Models\Mobil;
use App\Models\Pemeliharaan;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toastable;

class PemeliharaanForm extends ModalComponent
{
    use Toastable;
    use WithFileUploads;

    public Pemeliharaan $pemeliharaan;
    public $id, $mobils, $mobil_id, $keterangan, $biaya, $bukti_pembayaran, $bukti_pembayaran_url;

    public function mount($rowId = null)
    {
        $this->pemeliharaan = Pemeliharaan::findOrNew($rowId);
        $this->id = $this->pemeliharaan->id;
        $this->mobil_id = $this->pemeliharaan->mobil_id;
        $this->keterangan = $this->pemeliharaan->keterangan;
        $this->biaya = $this->pemeliharaan->biaya;
        $this->mobils = Mobil::all();

        if ($this->pemeliharaan->bukti_pembayaran) {
            $this->bukti_pembayaran_url = Storage::disk('public')->url('foto-pemeliharaan/' . $this->pemeliharaan->bukti_pembayaran);
        }
    }

    public function render()
    {
        return view('livewire.pemeliharaan-form');
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
            $fileName = time() . '-' . $originalName . '.' . $extension;

            if ($this->pemeliharaan->bukti_pembayaran) {
                Storage::disk('public')->delete('foto-pemeliharaan/' . $this->pemeliharaan->bukti_pembayaran);
            }

            $this->bukti_pembayaran->storeAs('public/foto-pemeliharaan', $fileName);
            $validatedData['bukti_pembayaran'] = $fileName;
        } else {
            $validatedData['bukti_pembayaran'] = $this->pemeliharaan->bukti_pembayaran;
        }

        $this->pemeliharaan = Pemeliharaan::updateOrCreate(['id' => $this->id], $validatedData);

        $this->closeModalWithEvents([
            PemeliharaanTable::class => 'pemeliharaanUpdated',
        ]);

        $this->success($this->pemeliharaan->wasRecentlyCreated ? 'Pemeliharaan berhasil ditambahkan' : 'Pemeliharaan berhasil diubah');

        $this->resetForm();
    }
}
