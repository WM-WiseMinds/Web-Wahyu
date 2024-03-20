<div class="p-2 bg-white border border-slate-200">
    <table class="table-auto w-full">
        <tbody>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Id</td>
                <td class="border px-4 py-2">{{ $row->id }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Nama Mobil</td>
                <td class="border px-4 py-2">{{ $row->nama }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Merk</td>
                <td class="border px-4 py-2">{{ $row->merk }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Warna</td>
                <td class="border px-4 py-2">{{ $row->warna }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Tahun</td>
                <td class="border px-4 py-2">{{ $row->tahun }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Plat Nomor</td>
                <td class="border px-4 py-2">{{ $row->plat_nomor }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Keterangan</td>
                <td class="border px-4 py-2">{{ $row->keterangan }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Kapasitas Penumpang</td>
                <td class="border px-4 py-2">{{ $row->kapasitas_penumpng }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Harga</td>
                <td class="border px-4 py-2">Rp {{ number_format($row->harga, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Status</td>
                <td class="border px-4 py-2">{{ $row->status }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Foto</td>
                <td class="border px-4 py-2">
                    <img src="{{ asset('storage/foto-mobil/' . $row->foto) }}" alt="{{ $row->nama }}"
                        class="w-32 h-32 mb-5">
                    <x-button>
                        <a href="{{ asset('storage/foto-mobil/' . $row->foto) }}" download>
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
