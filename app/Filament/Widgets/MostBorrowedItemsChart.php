<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;

class MostBorrowedItemsChart extends ChartWidget
{
    protected static ?string $heading = 'Pengguna dengan barang paling banyak dipinjam (aktif)';

    protected function getData(): array
    {
        // Pastikan nama tabel dan kolom sesuai dengan database
        $topUsers = DetailPeminjaman::selectRaw('peminjamen.nama_peminjam, COUNT(detail_peminjaman.id) as total_barang')
            ->join('peminjamen', 'detail_peminjaman.peminjaman_id', '=', 'peminjamen.id') // Perbaikan nama tabel
            ->groupBy('peminjamen.nama_peminjam')
            ->orderByDesc('total_barang')
            ->limit(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Barang Dipinjam',
                    'data' => $topUsers->pluck('total_barang')->toArray(),
                ],
            ],
            'labels' => $topUsers->pluck('nama_peminjam')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}