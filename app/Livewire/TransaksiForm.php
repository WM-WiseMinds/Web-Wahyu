<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use App\Livewire\TransaksiTable;
use App\Models\HistoryTransaksi;
use Masmerise\Toaster\Toastable;
use Illuminate\Http\UploadedFile;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class TransaksiForm extends ModalComponent
{
    use Toastable;
    use WithFileUploads;

    public Transaksi $transaksi;
    public $id, $status, $bukti_pembayaran, $bukti_pembayaran_url, $history_transaksi_id;
    public $updatingStatusOnly = false;
    public $updatingPembayaranOnly = false;

    public function mount($rowId = null, $updatingStatusOnly = false, $updatingPembayaranOnly = false, $historyId = null)
    {
        $this->updatingPembayaranOnly = $updatingPembayaranOnly;
        $this->updatingStatusOnly = $updatingStatusOnly;
        $this->history_transaksi_id = $historyId;
        $this->transaksi = Transaksi::findOrNew($rowId);
        $this->id = $this->transaksi->id;
        $this->status = $this->transaksi->status;
        $this->bukti_pembayaran = $this->transaksi->bukti_pembayaran;

        if ($this->bukti_pembayaran) {
            $this->bukti_pembayaran_url = Storage::disk('public')->url('foto-transaksi/' . $this->bukti_pembayaran);
        }

        dump($this->history_transaksi_id);
    }

    public function switchToStatusOnlyMode()
    {
        $this->updatingStatusOnly = true;
    }

    public function switchToCreateOrUpdateMode()
    {
        $this->updatingStatusOnly = false;
    }

    public function switchToPembayaranOnlyMode()
    {
        $this->updatingPembayaranOnly = true;
    }

    public function render()
    {
        return view('livewire.transaksi-form');
    }

    public function resetForm()
    {
        $this->reset(['id', 'status', 'bukti_pembayaran', 'bukti_pembayaran']);
    }

    public function store()
    {
        if ($this->updatingPembayaranOnly) {
            $validatedData = $this->validate([
                'bukti_pembayaran' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            if ($this->bukti_pembayaran instanceof UploadedFile) {
                $originalName = pathinfo($this->bukti_pembayaran->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $this->bukti_pembayaran->getClientOriginalExtension();
                $fileName = time() . '-' . $originalName . '.' . $extension;
                if ($this->transaksi->bukti_pembayaran) {
                    Storage::disk('public')->delete('foto-transaksi/' . $this->transaksi->bukti_pembayaran);
                }
                $this->bukti_pembayaran->storeAs('public/foto-transaksi', $fileName);
                $validatedData['bukti_pembayaran'] = $fileName;
            } else {
                $validatedData['bukti_pembayaran'] = $this->transaksi->bukti_pembayaran;
            }

            // Update bukti_pembayaran dan status pada history_transaksi yang spesifik
            HistoryTransaksi::where('id', $this->history_transaksi_id)->update([
                'bukti_pembayaran' => $validatedData['bukti_pembayaran'],
                'status' => 'Menunggu Verifikasi',
            ]);
        } else if ($this->updatingStatusOnly) {
            $validatedData = $this->validate(['status' => 'required']);

            // Update status pada history_transaksi yang spesifik
            HistoryTransaksi::where('id', $this->history_transaksi_id)->update([
                'status' => $validatedData['status'],
            ]);
        }

        $this->closeModalWithEvents([
            TransaksiTable::class => 'transaksiUpdated',
        ]);

        $this->success('History transaksi berhasil diperbarui');

        $this->resetForm();
    }
}
