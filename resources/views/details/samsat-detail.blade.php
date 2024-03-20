<div class="p-2 bg-white border border-slate-200">
    <table class="table-auto w-full">
        <tbody>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Id</td>
                <td class="border px-4 py-2">{{ $row->id }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Nama Mobil</td>
                <td class="border px-4 py-2">{{ $row->mobil->nama }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Tahun Kendaraan</td>
                <td class="border px-4 py-2">{{ $row->mobil->tahun }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Plat Nomor</td>
                <td class="border px-4 py-2">{{ $row->mobil->plat_nomor }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Keterangan</td>
                <td class="border px-4 py-2">{{ $row->keterangan }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Biaya</td>
                <td class="border px-4 py-2">{{ $row->biaya }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Foto</td>
                <td class="border px-4 py-2">
                    <img src="{{ asset('storage/foto-samsat/' . $row->bukti_pembayaran) }}" alt="{{ $row->nama }}"
                        class="w-32 h-32 mb-5">
                    <x-button>
                        <a href="{{ asset('storage/foto-samsat/' . $row->bukti_pembayaran) }}" download>
                            Download
                        </a>
                    </x-button>
                </td>

            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Created At</td>
                <td class="border px-4 py-2">{{ $row->created_at }}</td>
            </tr>
        </tbody>
    </table>
</div>
