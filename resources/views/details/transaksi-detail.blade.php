<div class="p-2 bg-white border border-slate-200">
    <table class="table-auto w-full">
        <tbody>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Id</td>
                <td class="border px-4 py-2">{{ $row->id }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Nama Pelanggan</td>
                <td class="border px-4 py-2">{{ $row->nama_pelanggan }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Keterangan</td>
                <td class="border px-4 py-2">{{ $row->keterangan }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Status</td>
                <td class="border px-4 py-2">{{ $row->status }}</td>
            </tr>
            @if ($row->bukti_pembayaran)
                <tr>
                    <td class="border px-4 py-2 text-sm font-semibold">Foto Pembayaran</td>
                    <td class="border px-4 py-2">
                        <img src="{{ asset('storage/foto-transaksi/' . $row->bukti_pembayaran) }}"
                            alt="{{ $row->penyewaan->pelanggan->user->name }}" class="w-32 h-32 mb-5">
                        <x-button>
                            <a href="{{ asset('storage/foto-transaksi/' . $row->bukti_pembayaran) }}" download>
                                Download
                            </a>
                        </x-button>
                    </td>
                </tr>
            @endif
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Created At</td>
                <td class="border px-4 py-2">{{ $row->created_at }}</td>
            </tr>
        </tbody>
    </table>
</div>
