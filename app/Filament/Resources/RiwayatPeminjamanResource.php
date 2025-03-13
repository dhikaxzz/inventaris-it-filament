<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiwayatPeminjamanResource\Pages;
use App\Filament\Resources\RiwayatPeminjamanResource\RelationManagers;
use App\Models\RiwayatPeminjaman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;

class RiwayatPeminjamanResource extends Resource
{
    protected static ?string $model = RiwayatPeminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';
    protected static ?string $navigationLabel = 'Riwayat Peminjaman';
    protected static ?string $pluralLabel = 'Riwayat Peminjaman';
    protected static ?string $modelLabel = 'Riwayat Peminjaman';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Form untuk create/edit (opsional, karena riwayat biasanya hanya dibaca)
                Forms\Components\TextInput::make('nama_peminjam')
                    ->label('Nama Peminjam')
                    ->required(),

                Forms\Components\TextInput::make('unit')
                    ->label('Unit')
                    ->required(),

                Forms\Components\TextInput::make('tempat')
                    ->label('Tempat')
                    ->required(),

                Forms\Components\TextInput::make('acara')
                    ->label('Acara')
                    ->required(),

                Forms\Components\DateTimePicker::make('tanggal_pinjam')
                    ->label('Tanggal Pinjam')
                    ->required(),

                Forms\Components\DatePicker::make('tanggal_kembali')
                    ->label('Tanggal Kembali')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom untuk menampilkan data riwayat
                TextColumn::make('nama_peminjam')
                    ->label('Nama Peminjam')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('unit')
                    ->label('Unit')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tempat')
                    ->label('Tempat')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('acara')
                    ->label('Acara')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tanggal_pinjam')
                    ->label('Tanggal Pinjam')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('tanggal_kembali')
                    ->label('Tanggal Kembali')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dicatat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                // Filter opsional
                Tables\Filters\Filter::make('tanggal_pinjam')
                    ->form([
                        Forms\Components\DatePicker::make('tanggal_pinjam_dari')
                            ->label('Tanggal Pinjam Dari'),
                        Forms\Components\DatePicker::make('tanggal_pinjam_sampai')
                            ->label('Tanggal Pinjam Sampai'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['tanggal_pinjam_dari'], fn ($q) => $q->where('tanggal_pinjam', '>=', $data['tanggal_pinjam_dari']))
                            ->when($data['tanggal_pinjam_sampai'], fn ($q) => $q->where('tanggal_pinjam', '<=', $data['tanggal_pinjam_sampai']));
                    }),
            ])
            ->actions([
                // Opsi aksi (opsional)
                Tables\Actions\ViewAction::make(), // Aksi untuk melihat detail
            ])
            ->bulkActions([
                // Opsi bulk action (opsional)
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
            'index' => Pages\ListRiwayatPeminjamen::route('/'),
            'create' => Pages\CreateRiwayatPeminjaman::route('/create'),
            'edit' => Pages\EditRiwayatPeminjaman::route('/{record}/edit'),
        ];
    }
}
