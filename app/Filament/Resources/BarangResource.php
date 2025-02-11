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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('kode_barang')
                ->required()
                ->unique(ignoreRecord: true) // Abaikan jika record ID sama
                ->maxLength(255),
    
            Forms\Components\TextInput::make('nama_barang')
                ->required()
                ->maxLength(255),
    
            Forms\Components\Select::make('kategori_id')
                ->label('Kategori')
                ->options(fn () => Kategori::all()->pluck('nama_kategori', 'id'))
                ->required(),
    
            Forms\Components\Select::make('status')
                ->options([
                    'Tersedia' => 'Tersedia',
                    'Dipinjam' => 'Dipinjam',
                ])
                ->default('Tersedia'),
    
            Forms\Components\Select::make('kondisi')
                ->options([
                    'Baik' => 'Baik',
                    'Lecet' => 'Lecet',
                    'Rusak' => 'Rusak',
                ])
                ->default('Baik'),

            Forms\Components\TextInput::make('created_at')
                ->label('Tanggal Ditambahkan')
                ->disabled()
                ->formatStateUsing(fn ($state) => $state ? \Carbon\Carbon::parse($state)->format('d M Y H:i') : '-'),    
    
            Forms\Components\Textarea::make('keterangan')
                ->label('Keterangan')
                ->rows(3)
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('kode_barang')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('nama_barang')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('kategori.nama_kategori')->label('Kategori')->sortable(),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Tersedia' => 'success', 
                    'Dipinjam' => 'danger',
                }),
        ])
        ->filters([
            SelectFilter::make('kategori_id')
                ->label('Kategori')
                ->options(Kategori::all()->pluck('nama_kategori', 'id')),
            SelectFilter::make('status')
                ->label('Status')
                ->options([
                    'Tersedia' => 'Tersedia',
                    'Dipinjam' => 'Dipinjam',
                ]),
            SelectFilter::make('kondisi')
                ->label('Kondisi')
                ->options([
                    'Baik' => 'Baik',
                    'Lecet' => 'Lecet',
                    'Rusak' => 'Rusak',
                ]),
        ])
        ->actions([
            Tables\Actions\Action::make('lihat_qr')
                ->label('Lihat QR')
                ->icon('heroicon-o-qr-code')
                ->modalHeading(fn ($record) => "QR Code - {$record->kode_barang}")
                ->modalContent(fn ($record) => view('components.qrcode', ['kode_barang' => $record->kode_barang]))
                ->modalButton('Tutup')
                ->color('primary'),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
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
