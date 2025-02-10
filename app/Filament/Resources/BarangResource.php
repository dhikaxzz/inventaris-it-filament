<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Filament\Resources\BarangResource\RelationManagers;
use App\Models\Barang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Kategori;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('kode_barang')->required()->unique(),
            Forms\Components\TextInput::make('nama_barang')->required(),
            Forms\Components\Select::make('kategori_id')
                ->label('Kategori')
                ->options(fn () => Kategori::all()->pluck('nama_kategori', 'id'))
                ->required(),
            Forms\Components\Select::make('status')->options([
                'Tersedia' => 'Tersedia',
                'Dipinjam' => 'Dipinjam',
            ])->default('Tersedia'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('kode_barang')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('nama_barang')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('kategori.nama_kategori')->label('Kategori')->sortable(),
            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'Tersedia' => 'success',
                    'Dipinjam' => 'danger',
                ]),
        ])
        ->actions([
            Tables\Actions\Action::make('lihat_qr')
                ->label('Lihat QR')
                ->icon('heroicon-o-qr-code') // Gunakan ikon yang lebih sesuai
                ->modalHeading(fn ($record) => "QR Code - {$record->kode_barang}") // Tampilkan kode barang di modal heading
                ->modalContent(fn ($record) => view('components.qrcode', ['kode_barang' => $record->kode_barang]))
                ->modalButton('Tutup')
                ->color('primary'), // Bikin tombol lebih menarik
            Tables\Actions\EditAction::make(), // Tombol Edit
            Tables\Actions\DeleteAction::make(), // Tombol Hapus
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
