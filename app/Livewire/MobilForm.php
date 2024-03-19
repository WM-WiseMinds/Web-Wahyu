<?php

namespace App\Livewire;

use App\Models\Mobil;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toastable;

class MobilForm extends ModalComponent
{
    use Toastable;
    use WithFileUploads;

    public Mobil $mobil;
    public $id, $nama, $merk, $warna, $tahun, $plat_nomor, $keterangan, $harga, $status, $kapasitas_penumpang, $foto, $foto_url;

    public function mount($rowId = null)
    {
        $this->mobil = Mobil::findOrNew($rowId);
        $this->id = $this->mobil->id;
        $this->nama = $this->mobil->nama;
        $this->merk = $this->mobil->merk;
        $this->warna = $this->mobil->warna;
        $this->tahun = $this->mobil->tahun;
        $this->plat_nomor = $this->mobil->plat_nomor;
        $this->keterangan = $this->mobil->keterangan;
        $this->harga = $this->mobil->harga;
        $this->status = $rowId ? $this->mobil->status : 'Tersedia';
        $this->kapasitas_penumpang = $this->mobil->kapasitas_penumpang;
        $this->foto = $this->mobil->foto;

        if ($this->mobil->foto) {
            $this->foto_url = Storage::disk('public')->url('foto-mobil/' . $this->mobil->foto);
        }
    }

    public function render()
    {
        return view('livewire.mobil-form');
    }

    public function rules()
    {
        return [
            'nama' => 'required',
            'merk' => 'required',
            'warna' => 'required',
            'tahun' => 'required',
            'plat_nomor' => 'required',
            'keterangan' => 'required',
            'harga' => 'required',
            'status' => 'required',
            'kapasitas_penumpang' => 'required',
            'foto' => $this->foto instanceof UploadedFile ? 'image|mimes:jpg,jpeg,png,svg' : '',
        ];
    }

    public function resetForm()
    {
        $this->reset([
            'nama', 'merk', 'warna', 'tahun', 'plat_nomor', 'keterangan', 'harga', 'status', 'kapasitas_penumpang', 'foto', 'foto_url'
        ]);
    }

    public function store()
    {
        $validatedData = $this->validate();

        if ($this->foto instanceof UploadedFile) {
            $originalName = pathinfo($this->foto->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $this->foto->getClientOriginalExtension();
            $fileName = time() . '_' . $originalName . '.'  . $extension;

            if ($this->mobil->foto) {
                Storage::delete(['public/foto-mobil/' . $this->mobil->foto]);
            }

            $this->foto->storeAs('public/foto-mobil', $fileName);
            $validatedData['foto'] = $fileName;
        } else {
            $validatedData['foto'] = $this->mobil->foto;
        }

        $this->mobil = Mobil::updateOrCreate(['id' => $this->id], $validatedData);

        $this->success($this->mobil->wasRecentlyCreated ? 'Surat berhasil dibuat' : 'Surat berhasil diupdate');
        $this->closeModalWithEvents([
            MobilTable::class => 'mobilUpdated',
        ]);

        $this->resetForm();
    }
}
