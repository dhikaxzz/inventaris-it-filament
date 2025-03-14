<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Peminjaman;

class MostActiveBorrowersChart extends ChartWidget
{
    protected static ?string $heading = 'Pengguna dengan peminjaman terbanyak (aktif)';
    protected static ?int $sort = 2; // Menentukan urutan widget jika ada beberapa

    protected function getData(): array
    {
        // Mengambil 5 pengguna dengan jumlah peminjaman terbanyak
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
                    'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                    'borderWidth' => 1,
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
