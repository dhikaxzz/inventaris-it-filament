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
    protected $listeners = ['qrScanned' => 'searchBarang']; // Tangkap event dari JS
    public $search = '';
    public function searchBarang($kodeBarang)
    {
        $this->search = $kodeBarang; // Simpan hasil scan ke search
    }

    protected function getTableQuery(): ?Builder
    {
        return Barang::query()
            ->when($this->search, fn ($query) => $query->where('kode_barang', 'like', "%{$this->search}%"));
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
            ->modalContent(fn () => view('components.scan-qr')),
        ];
    }

}
