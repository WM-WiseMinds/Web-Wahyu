<?php

namespace App\Livewire;

use App\Models\Transaksi;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Masmerise\Toaster\Toastable;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Detail;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class TransaksiTable extends PowerGridComponent
{
    use WithExport;
    use Toastable;

    public function setUp(): array
    {
        $this->showCheckBox();

        $setUp = [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
            Detail::make()
                ->view('details.transaksi-detail')
                ->showCollapseIcon(),
        ];

        if (auth()->user()->can('export')) {
            $setUp[] = Exportable::make('transaksi')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV);
        }

        return $setUp;
    }

    public function datasource(): Builder
    {
        return Transaksi::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('penyewaan_id')
            ->add('nama_pelanggan', fn ($row) => $row->penyewaan->pelanggan->user->name)
            ->add('nama_mobil', fn ($row) => $row->penyewaan->mobil->nama)
            ->add('jumlah_pembayaran', fn ($row) => 'Rp ' . number_format($row->jumlah_pembayaran, 2, ',', '.'))
            ->add('keterangan')
            ->add('bukti_pembayaran')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Nama Pelanggan', 'nama_pelanggan')->searchable(),
            Column::make('Nama Mobil', 'nama_mobil')->searchable(),
            Column::make('Jumlah pembayaran', 'jumlah_pembayaran')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(),

            // Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [];
    }

    // public function actions(Transaksi $row): array
    // {
    //     $actions = [];
    //     if (auth()->user()->can('payment')) {
    //         if (in_array($row->status, ['Belum Dibayar', 'Menunggu Verifikasi', 'Ditolak'])) {
    //             $actions[] = Button::add('payment')
    //                 ->slot('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
    //             <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
    //             </svg>
    //             ')
    //                 ->id()
    //                 ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
    //                 ->openModal('transaksi-form', ['rowId' => $row->id, 'updatingPembayaranOnly' => true]);
    //         }
    //     }
    //     if (auth()->user()->can('verifikasi')) {
    //         $actions[] = Button::add('edit')
    //             ->slot('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
    //                     <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
    //                     </svg>
    //                     ')
    //             ->id()
    //             ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
    //             ->openModal('transaksi-form', ['rowId' => $row->id, 'updatingStatusOnly' => true]);
    //     }
    //     if (auth()->user()->can('delete')) {
    //         $actions[] =
    //             Button::add('delete')
    //             ->slot('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
    //         <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
    //         </svg>
    //         ')
    //             ->id()
    //             ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
    //             ->dispatch('delete', ['rowId' => $row->id]);
    //     }
    //     return $actions;
    // }

    public function header(): array
    {
        $header = [];

        if (auth()->user()->can('export')) {
            $header[] = Button::add('export-pdf')
                ->slot(__('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>
                '))
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700 w-full')
                ->dispatch('exportPdf', []);
        }
        return $header;
    }

    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'exportPdf',
                'delete',
                'transaksiUpdated' => '$refresh',
            ]
        );
    }

    // Function to export PDF using DomPDF
    public function exportPdf()
    {
        $path = public_path() . '/pdf';
        // Mendapatkan datasource
        $datasource = $this->datasource()->get();
        // Membuat folder pdf jika belum ada
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        // Membuat file pdf
        $pdf = Pdf::loadView('pdf.transaksi', ['datasource' => $datasource]);
        // Menyimpan file pdf ke folder pdf
        $pdf->save($path . '/transaksi.pdf');
        // Menampilkan file pdf
        return response()->download($path . '/transaksi.pdf');
    }

    // Function to delete data
    public function delete($rowId)
    {
        $transaksi = Transaksi::findOrFail($rowId);

        $transaksi->delete();

        $this->success('Transaksi berhasil dihapus');
    }
}
