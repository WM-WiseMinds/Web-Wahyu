<div class="p-2 bg-white border border-slate-200">
    <table class="table-auto w-full">
        <tbody>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Id</td>
                <td class="border px-4 py-2">{{ $row->id }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Nama Penyewa</td>
                <td class="border px-4 py-2">{{ $row->pelanggan->user->name }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Alamat Penyewa</td>
                <td class="border px-4 py-2">{{ $row->pelanggan->alamat }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">No HP Penyewa</td>
                <td class="border px-4 py-2">{{ $row->pelanggan->no_hp }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Nama Mobil</td>
                <td class="border px-4 py-2">{{ $row->mobil->nama }}</td>
            </tr>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Merk Mobil</td>
                <td class="border px-4 py-2">{{ $row->mobil->merk }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Plat Nomor</td>
                <td class="border px-4 py-2">{{ $row->mobil->plat_nomor }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Durasi Penyewaan</td>
                <td class="border px-4 py-2">{{ $row->durasi_sewa }} Hari</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Tanggal Penyewaan</td>
                <td class="border px-4 py-2">{{ $row->tanggal_penyewaan_formatted }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Tanggal Pengembalian</td>
                <td class="border px-4 py-2">{{ $row->return_date_formatted }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Harga Sewa Per Hari</td>
                <td class="border px-4 py-2">Rp {{ number_format($row->mobil->harga, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Status Pengembalian</td>
                <td class="border px-4 py-2">
                    @if (!$row->kembali)
                        <div class="badge badge-error text-white text-base">Belum Dikembalikan</div>
                    @else
                        <div class="badge badge-success text-white">Sudah Dikembalikan</div>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="border px-4 py-2 text-sm font-semibold">Foto Mobil</td>
                <td class="border px-4 py-2">
                    <img src="{{ asset('storage/foto-mobil/' . $row->mobil->foto) }}" alt="{{ $row->mobil->nama }}"
                        class="w-32 h-32 mb-5">
                    <x-button>
                        <a href="{{ asset('storage/foto-mobil/' . $row->mobil->foto) }}" download>
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
