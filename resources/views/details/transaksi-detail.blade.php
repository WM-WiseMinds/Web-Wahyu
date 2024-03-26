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
                <td class="border px-4 py-2 text-sm font-semibold">Created At</td>
                <td class="border px-4 py-2">{{ $row->created_at }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="p-2 bg-white border border-slate-200 mt-4">
    <h3 class="text-lg font-semibold mb-2">History Transaksi</h3>
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="border px-4 py-2">Tanggal Mulai</th>
                <th class="border px-4 py-2">Tanggal Selesai</th>
                <th class="border px-4 py-2">Durasi Sebelumnya</th>
                <th class="border px-4 py-2">Durasi Baru</th>
                <th class="border px-4 py-2">Biaya</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Bukti Pembayaran</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($row->historyTransaksi as $history)
                <tr>
                    <td class="border px-4 py-2">{{ $history->tanggal_mulai }}</td>
                    <td class="border px-4 py-2">{{ $history->tanggal_selesai }}</td>
                    <td class="border px-4 py-2">{{ $history->durasi_sebelumnya }} hari</td>
                    <td class="border px-4 py-2">{{ $history->durasi_baru }} hari</td>
                    <td class="border px-4 py-2">Rp {{ number_format($history->perbedaan_harga, 0, ',', '.') }}</td>
                    <td class="border px-4 py-2">{{ $history->status }}</td>
                    <td>
                        @if ($history->bukti_pembayaran)
                            <img src="{{ asset('storage/foto-transaksi/' . $history->bukti_pembayaran) }}"
                                alt="{{ $history->transaksi->penyewaan->pelanggan->user->name }}"
                                class="w-32 h-32 mb-5">
                        @endif
                    </td>
                    <td class="border px-4 py-2">
                        @if ($history->durasi_baru > $history->durasi_sebelumnya)
                            @if ($history->status != 'Dikonfirmasi')
                                @can('payment')
                                    <button
                                        wire:click="$dispatch('openModal', { component: 'transaksi-form', arguments: { rowId: {{ $row->id }}, updatingPembayaranOnly: true, historyId: {{ $history->id }} } })"
                                        class="btn btn-active btn-primary mt-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m15 11.25-3-3m0 0-3 3m3-3v7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        Upload Bukti
                                    </button>
                                @endcan
                            @endif
                            @if ($history->bukti_pembayaran)
                                <button class="btn btn-active btn-neutral my-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <a href="{{ asset('storage/foto-transaksi/' . $history->bukti_pembayaran) }}"
                                        download>
                                        Download
                                    </a>
                                </button>
                                @can('verifikasi')
                                    <button class="btn btn-active btn-success text-white mb-2"
                                        wire:click="$dispatch('openModal', { component: 'transaksi-form', arguments: { rowId: {{ $row->id }}, updatingStatusOnly: true, historyId: {{ $history->id }} } })">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        Verifikasi
                                    </button>
                                @endcan
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
