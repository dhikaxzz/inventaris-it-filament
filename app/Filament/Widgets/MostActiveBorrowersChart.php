<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Peminjaman;

class MostActiveBorrowersChart extends ChartWidget
{
    protected static ?string $heading = 'Pengguna Paling Banyak Meminjam Barang';

    protected function getData(): array
    {
        // Ambil 5 peminjam dengan jumlah peminjaman terbanyak
        $topUsers = Peminjaman::selectRaw('nama_peminjam, COUNT(*) as total_peminjaman')
            ->groupBy('nama_peminjam')
            ->orderByDesc('total_peminjaman')
            ->limit(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Peminjaman',
                    'data' => $topUsers->pluck('total_peminjaman')->toArray(),
                ],
            ],
            'labels' => $topUsers->pluck('nama_peminjam')->toArray(),
        ];
    }
    
    protected function getType(): string
    {
        return 'bar';
    }
}
