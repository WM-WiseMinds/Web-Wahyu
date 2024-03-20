<?php

namespace App\Livewire;

use App\Models\Mobil;
use App\Models\Pelanggan;
use App\Models\Penyewaan;
use App\Models\Transaksi;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toastable;

class PenyewaanForm extends ModalComponent
{
    use Toastable;

    public Penyewaan $penyewaan;
    public $id, $pelanggan_id, $mobil_id, $user_id, $username, $tanggal_penyewaan, $durasi_sewa, $mobils, $pelanggans;
    public $hargaSewaMobil = 0;
    public $jumlahPembayaran = 0;

    public function mount($rowId = null)
    {
        $this->mobils = $rowId ? Mobil::all() : Mobil::query()->where('status', 'Tersedia')->get();
        $this->pelanggans = Pelanggan::all();
        $this->penyewaan = Penyewaan::findOrNew($rowId);
        $this->id = $this->penyewaan->id;
        $this->pelanggan_id = $this->penyewaan->pelanggan_id;
        $this->mobil_id = $this->penyewaan->mobil_id;
        $this->user_id = $rowId ? $this->penyewaan->user_id : auth()->id();
        $this->username = $rowId ? $this->penyewaan->user->name : auth()->user()->name;
        $this->tanggal_penyewaan = $this->penyewaan->tanggal_penyewaan;
        $this->durasi_sewa = $this->penyewaan->durasi_sewa;

        if ($this->mobil_id) {
            $this->getHargaSewa($this->mobil_id);
        }
    }

    public function render()
    {
        return view('livewire.penyewaan-form');
    }

    public function rules()
    {
        return [
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'mobil_id' => 'required|exists:mobil,id',
            'user_id' => 'required|exists:users,id',
            'tanggal_penyewaan' => 'required',
            'durasi_sewa' => 'required',
        ];
    }

    public function resetForm()
    {
        $this->reset(['pelanggan_id', 'mobil_id', 'user_id', 'tanggal_penyewaan', 'durasi_sewa']);
    }

    public function store()
    {
        $validatedData = $this->validate();

        $oldPenyewaan = $this->penyewaan->exists ? $this->penyewaan : null;
        $oldDurasiSewa = $oldPenyewaan ? $oldPenyewaan->durasi_sewa : 0;
        $newDurasiSewa = $validatedData['durasi_sewa'];

        $this->penyewaan = Penyewaan::updateOrCreate(['id' => $this->id], $validatedData);

        if ($this->penyewaan->wasRecentlyCreated) {
            $this->penyewaan->mobil->update(['status' => 'Disewa']);

            $jumlahPembayaran = $this->penyewaan->durasi_sewa * $this->penyewaan->mobil->harga;

            Transaksi::create([
                'penyewaan_id' => $this->penyewaan->id,
                'keterangan' => 'Penyewaan (' . $this->penyewaan->tanggal_penyewaan . ')',
                'jumlah_pembayaran' => $jumlahPembayaran,
                'status' => 'Belum Dibayar'
            ]);
        } else {
            $hargaSewaMobil = $this->penyewaan->mobil->harga;

            if ($newDurasiSewa > $oldDurasiSewa) {
                $durasiSelisih = $newDurasiSewa - $oldDurasiSewa;
                $jumlahPembayaran = $durasiSelisih * $hargaSewaMobil;

                Transaksi::create([
                    'penyewaan_id' => $this->penyewaan->id,
                    'keterangan' => 'Penambahan Durasi (' . $durasiSelisih . ' hari)',
                    'jumlah_pembayaran' => $jumlahPembayaran,
                    'status' => 'Belum Dibayar',
                ]);
            } elseif ($newDurasiSewa < $oldDurasiSewa) {
                $durasiSelisih = $oldDurasiSewa - $newDurasiSewa;
                $jumlahPenguranganPembayaran = $durasiSelisih * $hargaSewaMobil;

                $transaksiTerakhir = Transaksi::where('penyewaan_id', $this->penyewaan->id)->latest()->first();
                if ($transaksiTerakhir) {
                    $transaksiTerakhir->update([
                        'jumlah_pembayaran' => $transaksiTerakhir->jumlah_pembayaran - $jumlahPenguranganPembayaran,
                    ]);
                }
            }
        }

        $this->closeModalWithEvents([
            PenyewaanTable::class => 'penyewaanUpdated',
        ]);

        $this->success($this->penyewaan->wasRecentlyCreated ? 'Penyewaan berhasil disimpan' : 'Penyewaan berhasil diubah');

        $this->resetForm();
    }

    public function getHargaSewa($mobilId)
    {
        $mobil = Mobil::find($mobilId);
        $this->hargaSewaMobil = $mobil ? $mobil->harga : null;
        $this->updateJumlahPembayaran();
    }

    public function getJumlahPembayaran()
    {
        $this->updateJumlahPembayaran();
    }

    private function updateJumlahPembayaran()
    {
        $this->jumlahPembayaran = $this->hargaSewaMobil * $this->durasi_sewa;
    }
}
