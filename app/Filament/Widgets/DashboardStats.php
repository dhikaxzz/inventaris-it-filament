<?php

namespace App\Filament\Widgets;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengguna;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use App\Filament\Widgets\MostActiveBorrowersChart;
use App\Filament\Widgets\MostBorrowedItemsChart;

class DashboardStats extends BaseWidget
{
    protected static ?string $pollingInterval = '10s'; // Auto-refresh setiap 10 detik
    protected static ?int $columns = 3; // Tampilkan dalam 3 kolom otomatis

    protected function getStats(): array
    {
        $totalBarang = Barang::count();
        $barangTersedia = Barang::where('status', 'tersedia')->count();
        $barangDipinjam = Barang::where('status', 'dipinjam')->count();
        $peminjamanAktif = Peminjaman::where('tanggal_kembali', '>=', now())->count();
        $totalPengguna = Pengguna::count();
        $barangRusakLecet = Barang::whereNotNull('kondisi')
            ->where(DB::raw('LOWER(kondisi)'), '!=', 'baik')
            ->count();

        return [
            Stat::make('Total Barang', $totalBarang)
                ->description('Total semua barang dalam sistem')
                ->color('primary')
                ->icon('heroicon-o-archive-box')
                ->chart([$totalBarang - 5, $totalBarang - 3, $totalBarang]), // Simulasi tren

            Stat::make('Barang Tersedia', $barangTersedia)
                ->description('Barang yang bisa dipinjam')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->chart([$barangTersedia - 2, $barangTersedia - 1, $barangTersedia]),

            Stat::make('Barang Dipinjam', $barangDipinjam)
                ->description('Barang yang sedang dipinjam')
                ->color('danger')
                ->icon('heroicon-o-exclamation-triangle')
                ->chart([$barangDipinjam - 1, $barangDipinjam + 1, $barangDipinjam]),

            Stat::make('Peminjaman Aktif', $peminjamanAktif)
                ->description('Peminjaman yang belum dikembalikan')
                ->color('warning')
                ->icon('heroicon-o-clipboard-document-check')
                ->chart([$peminjamanAktif - 2, $peminjamanAktif, $peminjamanAktif + 2]),

            Stat::make('Total Pengguna', $totalPengguna)
                ->description('Jumlah pengguna yang terdaftar')
                ->color('info')
                ->icon('heroicon-o-users')
                ->chart([$totalPengguna - 2, $totalPengguna + 1, $totalPengguna]),

            Stat::make('Barang Rusak/Lecet', $barangRusakLecet)
                ->description('Barang dalam kondisi rusak atau lecet')
                ->color('gray')
                ->icon('heroicon-o-x-circle')
                ->chart([$barangRusakLecet - 1, $barangRusakLecet, $barangRusakLecet + 1]),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            MostBorrowedItemsChart::class,
            MostActiveBorrowersChart::class,
        ];
    }
}
