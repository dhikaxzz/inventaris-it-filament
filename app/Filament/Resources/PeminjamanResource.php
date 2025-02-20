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
                Section::make('Detail Peminjaman')->schema([
                    TextInput::make('nama_peminjam')
                        ->required()
                        ->label('Nama Peminjam'),

                    TextInput::make('unit')
                        ->label('Unit'), // Tidak otomatis, bisa diinput manual

                    TextInput::make('tempat')
                        ->required()
                        ->label('Tempat Barang Dipinjam'),

                    TextInput::make('acara')
                        ->label('Acara')
                        ->nullable(),

                    DatePicker::make('tanggal_kembali')
                        ->required()
                        ->label('Tanggal Kembali'),

                    TextInput::make('tanggal_pinjam')
                        ->disabled()
                        ->default(now()->format('Y-m-d H:i'))
                        ->label('Tanggal Pinjam'),
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
