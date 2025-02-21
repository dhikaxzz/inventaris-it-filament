<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Filament\Resources\PeminjamanResource\RelationManagers;
use App\Models\Peminjaman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use App\Models\Pengguna; // Tambahkan model Pengguna
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Get;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Peminjaman';
    protected static ?string $pluralLabel = 'Peminjaman';
    protected static ?string $modelLabel = 'Peminjaman';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Peminjaman')
                    ->description('Isi informasi peminjaman dengan lengkap.')
                    ->schema([
                        Grid::make(2) // Membagi form menjadi 2 kolom
                            ->schema([
                                Select::make('nama_peminjam')
                                    ->label('Nama Peminjam')
                                    ->options(Pengguna::pluck('nama', 'nama')) // Menggunakan nama sebagai key dan value
                                    ->searchable()
                                    ->required()
                                    ->reactive() // Agar bisa memicu perubahan unit
                                    ->afterStateUpdated(fn (Get $get, callable $set) => 
                                        $set('unit', Pengguna::where('nama', $get('nama_peminjam'))->value('unit'))
                                    ), // Mengambil unit sesuai nama peminjam

                                TextInput::make('unit')
                                    ->label('Unit')
                                    ->disabled()
                                    ->placeholder('Unit akan otomatis terisi')
                                    ->required(),

                                TextInput::make('tempat')
                                    ->required()
                                    ->label('Tempat Barang Dipinjam')
                                    ->placeholder('Lokasi peminjaman')
                                    ->columnSpanFull(), // Lebar penuh

                                TextInput::make('acara')
                                    ->label('Acara')
                                    ->placeholder('Nama acara')
                                    ->nullable()
                                    ->required()
                                    ->columnSpanFull(),

                                DatePicker::make('tanggal_kembali')
                                    ->required()
                                    ->label('Tanggal Kembali')
                                    ->placeholder('Pilih tanggal kembali')
                                    ->columnSpan(1),

                                Placeholder::make('tanggal_pinjam')
                                    ->label('Tanggal Pinjam')
                                    ->content(now()->format('Y-m-d H:i')), // Menampilkan tanggal pinjam saat ini
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('nama_peminjam')
                ->label('Nama Peminjam')
                ->searchable(),

            Tables\Columns\TextColumn::make('unit')
                ->label('Unit Peminjam')
                ->searchable(),

            Tables\Columns\TextColumn::make('tempat')
                ->label('Tempat Dipinjam'),

            Tables\Columns\TextColumn::make('acara')
                ->label('Acara'),

            Tables\Columns\TextColumn::make('tanggal_pinjam')
                ->label('Tanggal Pinjam')
                ->dateTime('d M Y H:i'),

            Tables\Columns\TextColumn::make('tanggal_kembali')
                ->label('Tanggal Kembali')
                ->dateTime('d M Y'),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
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
