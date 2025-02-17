<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Filament\Resources\PeminjamanResource\RelationManagers;
use App\Models\Peminjaman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Barang;
use Illuminate\Support\Facades\Date; // Untuk tanggal otomatis
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Kode peminjaman otomatis
            Forms\Components\TextInput::make('kode_peminjaman')
                ->required()
                ->unique(ignoreRecord: true)
                ->default(fn () => 'PJM-' . strtoupper(uniqid())),

            // Nama peminjam
            Forms\Components\TextInput::make('nama_peminjam')
                ->required(),

            // Unit peminjam
            Forms\Components\TextInput::make('unit')
                ->label('Unit Peminjam')
                ->nullable(),

            // Pilih Barang (Nama dan Kode Barang)
            Forms\Components\Select::make('barang_id')
                ->label('Barang')
                ->options(fn () => Barang::where('status', 'Tersedia')
                    ->pluck('nama_barang', 'id') // Menampilkan nama_barang sebagai label
                    ->mapWithKeys(function ($item, $key) {
                        // Menambahkan kode_barang di samping nama_barang
                        $barang = Barang::find($key); // Ambil data barang
                        return [$key => $item . ' - ' . $barang->kode_barang]; // Gabungkan nama dan kode
                    })
                )
                ->required()
                ->reactive() // Untuk memperbarui form setelah memilih barang
                ->afterStateUpdated(function ($state, $get) {
                    // Update nilai kode_barang secara otomatis setelah memilih barang
                    $barang = Barang::find($state);
                    return $barang ? $barang->kode_barang : null;
                }),

            // Tanggal Pinjam (otomatis, tetapi tersembunyi)
            Forms\Components\DatePicker::make('tanggal_pinjam')
                ->label('Tanggal Pinjam')
                ->default(now()) // Mengambil tanggal saat ini
                ->hidden(),

            // Tanggal Kembali
            Forms\Components\DatePicker::make('tanggal_kembali')
                ->label('Tanggal Kembali')
                ->nullable(),

            // Status peminjaman
            Forms\Components\Select::make('status')
                ->options([
                    'Dipinjam' => 'Dipinjam',
                    'Dikembalikan' => 'Dikembalikan',
                ])
                ->default('Dipinjam'),

            // Keterangan
            Forms\Components\Textarea::make('keterangan')
                ->label('Keterangan')
                ->nullable(),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('kode_peminjaman')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('nama_peminjam')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('barang.nama_barang')
                ->label('Barang')
                ->sortable()
                ->searchable(),  

            // Ganti tanggal_pinjam dengan created_at
            Tables\Columns\TextColumn::make('created_at')
                ->date()  // Format tanggal
                ->sortable(),

            Tables\Columns\TextColumn::make('tanggal_kembali')
                ->date()  // Kolom tanggal kembali
                ->sortable(),

            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Dipinjam' => 'warning',
                    'Dikembalikan' => 'success',
                }),
        ])
        ->filters([])
        ->actions([
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
            'index' => Pages\ListPeminjamen::route('/'),
            'create' => Pages\CreatePeminjaman::route('/create'),
            'edit' => Pages\EditPeminjaman::route('/{record}/edit'),
        ];
    }
}
