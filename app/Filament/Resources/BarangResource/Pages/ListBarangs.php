<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Livewire\Component;
use App\Models\Barang;
use Illuminate\Database\Eloquent\Builder;

class ListBarangs extends ListRecords
{
    protected static string $resource = BarangResource::class;
        
    protected function getTableQuery(): ?Builder
    {
        $kodeBarang = request()->query('q'); // Ambil kode_barang dari URL
        return Barang::query()
            ->when($kodeBarang, fn ($query) => $query->where('kode_barang', 'like', "%{$kodeBarang}%"));
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('scan_qr')
            ->label('Scan QR')
            ->icon('heroicon-o-qr-code')
            ->button()
            ->modalCancelAction(false) // Hapus tombol Cancel
            ->modalSubmitAction(false) // Hapus tombol Cancel
            ->modalContent(fn () => view('components.scan-qr')),
        ];
    }

}
