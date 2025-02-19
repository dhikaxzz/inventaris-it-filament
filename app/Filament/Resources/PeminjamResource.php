<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamResource\Pages;
use App\Filament\Resources\PeminjamResource\RelationManagers;
use App\Models\Peminjam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class PeminjamResource extends Resource
{
    protected static ?string $model = Peminjam::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Kelola Peminjam';

    protected static ?string $pluralLabel = 'Peminjam';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->label('Nama Peminjam')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                    TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->maxLength(255)
                    ->required(fn ($livewire) => $livewire instanceof Pages\CreatePeminjam), // Wajib hanya saat create                
                TextInput::make('unit')
                    ->label('Unit/Departemen')
                    ->required()
                    ->maxLength(255),                                    
                TextInput::make('no_telepon')
                    ->label('Nomor Telepon')
                    ->tel()
                    ->required()
                    ->maxLength(20),
                TextInput::make('alamat')
                    ->label('Alamat')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->label('Nama'),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('unit')->label('Unit'),
                TextColumn::make('no_telepon')->label('No. Telepon'),
                TextColumn::make('created_at')->label('Dibuat Pada Tanggal')->dateTime(),
            ])
            ->filters([
                // Bisa tambahkan filter jika perlu
            ])
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
            'index' => Pages\ListPeminjams::route('/'),
            'create' => Pages\CreatePeminjam::route('/create'),
            'edit' => Pages\EditPeminjam::route('/{record}/edit'),
        ];
    }
}
