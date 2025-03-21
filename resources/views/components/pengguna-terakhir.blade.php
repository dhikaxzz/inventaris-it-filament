<div>
    <p><strong>Kode Barang:</strong> {{ $barang->kode_barang }}</p>
    <p><strong>Nama Barang:</strong> {{ $barang->nama_barang }}</p>

    @if($penggunaTerakhir !== 'Belum Pernah Dipinjam')
        <p><strong>Pengguna Terakhir:</strong> {{ $penggunaTerakhir }}</p>
    @else
        <p><em>Belum Pernah Dipinjam</em></p>
    @endif
</div>
