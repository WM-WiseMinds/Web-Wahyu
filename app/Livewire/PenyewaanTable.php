<?php

namespace App\Livewire;

use App\Models\Penyewaan;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
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

final class PenyewaanTable extends PowerGridComponent
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
                ->view('details.penyewaan-detail')
                ->showCollapseIcon(),
        ];

        if (auth()->user()->can('export')) {
            $setUp[] = Exportable::make('penyewaan')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV);
        }

        return $setUp;
    }

    public function datasource(): Builder
    {
        return Penyewaan::query()->with(['mobil', 'pelanggan', 'user']);
    }

    public function relationSearch(): array
    {
        return [
            'mobil' => ['nama'],
            'pelanggan.user' => ['name'],
            'user' => ['name'],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('pelanggan_id')
            ->add('nama_pelanggan', fn (Penyewaan $model) => $model->pelanggan->user->name)
            ->add('mobil_id')
            ->add('nama_mobil', fn (Penyewaan $model) => $model->mobil->nama)
            ->add('user_id')
            ->add('nama_user', fn (Penyewaan $model) => $model->user->name)
            ->add('tanggal_penyewaan_formatted', fn (Penyewaan $model) => Carbon::parse($model->tanggal_penyewaan)->format('d/m/Y'))
            ->add('durasi_sewa')
            ->add('return_date_formatted', fn (Penyewaan $model) => $model->return_date->format('d/m/Y'))
            ->add('status_kembali', fn (Penyewaan $model) => $model->kembali ? 'Sudah Kembali' : 'Belum Kembali')
            ->add('created_at');
    }

    public function columns(): array
    {
        $canEdit = true;
        return [
            Column::make('Id', 'id'),
            Column::make('Nama Pelanggan', 'nama_pelanggan'),
            Column::make('Nama Mobil', 'nama_mobil'),
            Column::make('Tanggal Penyewaan', 'tanggal_penyewaan_formatted', 'tanggal_penyewaan')
                ->sortable(),

            Column::make('Tanggal Pengembalian', 'return_date_formatted')
                ->sortable()
                ->searchable(),

            // Column::make('Status Kembali', 'status_kembali')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Created at', 'created_at')
            //     ->sortable()
            //     ->searchable(),

            Column::add()
                ->title('Status Kembali')
                ->field('kembali')
                ->toggleable($canEdit, 'yes', 'no'),

            Column::action('Action')
        ];
    }

    public function onUpdatedToggleable($id, $field, $value): void
    {
        $penyewaan = Penyewaan::query()->find($id);
        $penyewaan->update([
            $field => $value,
        ]);

        // Update status mobil
        $mobil = $penyewaan->mobil;
        $mobil->status = $value ? 'Tersedia' : 'Disewa';
        $mobil->save();
    }

    public function filters(): array
    {
        return [
            Filter::select('nama_pelanggan', 'pelanggan_id')
                ->dataSource(Penyewaan::all()->unique('pelanggan_id'))
                ->optionLabel('nama_pelanggan')
                ->optionValue('pelanggan_id'),
            Filter::select('nama_mobil', 'mobil_id')
                ->dataSource(Penyewaan::all()->unique('mobil_id'))
                ->optionLabel('nama_mobil')
                ->optionValue('mobil_id'),

        ];
    }

    public function actions(Penyewaan $row): array
    {
        $actions = [];

        if (auth()->user()->can('update')) {
            $actions[] =
                Button::add('edit')
                ->slot('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>')
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->openModal('penyewaan-form', ['rowId' => $row->id]);
        }
        if (auth()->user()->can('delete')) {
            $actions[] =
                Button::add('delete')
                ->slot('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
            ')
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('delete', ['rowId' => $row->id]);
        }
        return $actions;
    }

    public function header(): array
    {
        $header = [];

        if (auth()->user()->can('create')) {
            $header[] = Button::add('add-penyewaans')
                ->slot(__('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                '))
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700 w-full')
                ->openModal('penyewaan-form', []);
        }

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
                'penyewaanUpdated' => '$refresh',
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
        $pdf = Pdf::loadView('pdf.penyewaans', ['datasource' => $datasource]);
        // Menyimpan file pdf ke folder pdf
        $pdf->save($path . '/penyewaans.pdf');
        // Menampilkan file pdf
        return response()->download($path . '/penyewaans.pdf');
    }

    // Function to delete data
    public function delete($rowId)
    {
        $penyewaan = Penyewaan::findOrFail($rowId);
        $penyewaan->mobil->update(['status' => 'Tersedia']);
        $penyewaan->delete();

        $this->success('Penyewaan berhasil dihapus');
    }
}
