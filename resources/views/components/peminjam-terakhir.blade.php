<div class="space-y-4">
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Nama Peminjam</th>
                <th class="border px-4 py-2">Unit</th>
                <th class="border px-4 py-2">Tanggal Pinjam</th>
                <th class="border px-4 py-2">Tanggal Kembali</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $pinjam)
                <tr>
                    <td class="border px-4 py-2">{{ $pinjam->nama_peminjam }}</td>
                    <td class="border px-4 py-2">{{ $pinjam->unit }}</td>
                    <td class="border px-4 py-2">{{ $pinjam->tanggal_pinjam }}</td>
                    <td class="border px-4 py-2">{{ $pinjam->tanggal_kembali ?? 'Belum dikembalikan' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-2">Belum ada peminjaman</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
