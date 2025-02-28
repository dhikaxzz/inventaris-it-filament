<?php

namespace App\Filament\Widgets;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengguna;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class DashboardStats extends BaseWidget
{
    protected static ?string $pollingInterval = '10s'; // Auto-refresh setiap 10 detik
    protected static ?int $columns = 3; // Tampilan dalam 3 kolom

    protected function getStats(): array
    {
        return [
            Stat::make('Total Barang', Barang::count())
                ->description('Total semua barang dalam sistem')
                ->color('primary')
                ->icon('heroicon-o-archive-box'),

            Stat::make('Barang Tersedia', Barang::where('status', 'tersedia')->count())
                ->description('Barang yang masih bisa dipinjam')
                ->color('success')
                ->icon('heroicon-o-check-circle'),

            Stat::make('Barang Dipinjam', Barang::where('status', 'dipinjam')->count())
                ->description('Barang yang sedang dipinjam')
                ->color('danger')
                ->icon('heroicon-o-exclamation-triangle'),

                Stat::make('Peminjaman Berlangsung', Peminjaman::where('tanggal_kembali', '>=', now())->count())
                ->description('Peminjaman yang masih aktif')
                ->color('warning')
                ->icon('heroicon-o-clipboard-document-check'),            

            Stat::make('Total Pengguna', Pengguna::count())
                ->description('Jumlah pengguna yang terdaftar')
                ->color('info')
                ->icon('heroicon-o-users'),

                Stat::make('Total Barang Rusak/Lecet', Barang::whereNotNull('kondisi')->where(DB::raw('LOWER(kondisi)'), '!=', 'baik')->count())
                ->description('Barang dengan kondisi rusak atau lecet')
                ->color('gray')
                ->icon('heroicon-o-x-circle'),            
        ];
    }
}
