<?php

namespace App\Livewire;

use App\Models\Mobil;
use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\Penyewaan;
use App\Models\Transaksi;
use App\Livewire\PenyewaanTable;
use App\Models\HistoryTransaksi;
use Masmerise\Toaster\Toastable;
use LivewireUI\Modal\ModalComponent;

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

            $transaksi = Transaksi::create([
                'penyewaan_id' => $this->penyewaan->id,
                'keterangan' => 'Penyewaan (' . $this->penyewaan->tanggal_penyewaan . ')',
                'jumlah_pembayaran' => $jumlahPembayaran,
                'status' => 'Belum Dibayar'
            ]);

            HistoryTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'tanggal_mulai' => $this->penyewaan->tanggal_penyewaan,
                'tanggal_selesai' => date('Y-m-d', strtotime($this->penyewaan->tanggal_penyewaan . ' +' . $this->penyewaan->durasi_sewa . ' days')),
                'durasi_sebelumnya' => 0,
                'durasi_baru' => $this->penyewaan->durasi_sewa,
                'perbedaan_harga' => $jumlahPembayaran,
            ]);
        } else {
            $hargaSewaMobil = $this->penyewaan->mobil->harga;
            $durasiSelisih = $newDurasiSewa - $oldDurasiSewa;
            $jumlahPembayaran = $durasiSelisih * $hargaSewaMobil;

            $transaksiPenyewaan = Transaksi::where('penyewaan_id', $this->penyewaan->id)
                ->where('keterangan', 'like', 'Penyewaan%')
                ->orderBy('created_at', 'desc')
                ->first();

            $transaksiPenyewaan->update([
                'jumlah_pembayaran' => $transaksiPenyewaan->jumlah_pembayaran + $jumlahPembayaran,
                'keterangan' => 'Penyewaan (' . $this->penyewaan->tanggal_penyewaan . ') - Durasi: ' . $newDurasiSewa . ' hari',
            ]);

            HistoryTransaksi::create([
                'transaksi_id' => $transaksiPenyewaan->id,
                'tanggal_mulai' => $this->penyewaan->tanggal_penyewaan,
                'tanggal_selesai' => date('Y-m-d', strtotime($this->penyewaan->tanggal_penyewaan . ' +' . $newDurasiSewa . ' days')),
                'durasi_sebelumnya' => $oldDurasiSewa,
                'durasi_baru' => $newDurasiSewa,
                'perbedaan_harga' => $jumlahPembayaran,
                // 'bukti_pembayaran' => $this->bukti_pembayaran ? $this->bukti_pembayaran->store('bukti_pembayaran', 'public') : null,
            ]);
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
