<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriResource\Pages;
use App\Filament\Resources\KategoriResource\RelationManagers;
use App\Models\Kategori;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KategoriResource extends Resource
{
    protected static ?string $model = Kategori::class;

    protected static ?string $recordTitleAttribute = 'nama_kategori';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Kelola Kategori';

    protected static ?string $pluralLabel = 'Kategori';

    protected static ?string $modelLabel = 'Kategori';

    protected static ?string $navigationGroup = 'Manajemen';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama_kategori')->required()->unique(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nama_kategori')
                ->sortable()
                ->searchable(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(), // Tombol Edit
            Tables\Actions\DeleteAction::make(), // Tombol Hapus
        ])
        ->bulkActions([ // Tambahkan bulk delete
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
            'index' => Pages\ListKategoris::route('/'),
            'create' => Pages\CreateKategori::route('/create'),
            'edit' => Pages\EditKategori::route('/{record}/edit'),
        ];
    }
}
