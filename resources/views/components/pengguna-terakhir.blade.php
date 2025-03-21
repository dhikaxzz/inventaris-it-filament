<div class="p-4">
    <div class="mt-3 space-y-2">
        <p><span class="font-medium text-gray-600">📄 Kode Barang:</span> <span class="text-gray-800">{{ $barang->kode_barang }}</span></p>
        <p><span class="font-medium text-gray-600">📦 Nama Barang:</span> <span class="text-gray-800">{{ $barang->nama_barang }}</span></p>

        @if(is_array($penggunaTerakhir))
            <p><span class="font-medium text-gray-600">👤 Pengguna Terakhir:</span> <span class="text-gray-800">{{ $penggunaTerakhir['nama'] }}</span></p>
            <p><span class="font-medium text-gray-600">📅 Tanggal Pinjam:</span> <span class="text-gray-800">{{ \Carbon\Carbon::parse($penggunaTerakhir['tanggal_pinjam'])->format('d M Y') }}</span></p>
            <p><span class="font-medium text-gray-600">🔄 Tanggal Kembali:</span> 
                @if($penggunaTerakhir['tanggal_kembali'])
                    <span class="text-gray-800">{{ \Carbon\Carbon::parse($penggunaTerakhir['tanggal_kembali'])->format('d M Y') }}</span>
                @else
                    <span class="text-red-500 font-semibold">Belum dikembalikan</span>
                @endif
            </p>
        @else
            <p class="text-gray-500 italic">🚫 Belum Pernah Dipinjam</p>
        @endif
    </div>
</div>
