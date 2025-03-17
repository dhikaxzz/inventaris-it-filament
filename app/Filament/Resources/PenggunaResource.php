<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenggunaResource\Pages;
use App\Filament\Resources\PenggunaResource\RelationManagers;
use App\Models\Pengguna;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;

class PenggunaResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'nama';
    public static function getGloballySearchableAttributes(): array
    {
        return ['nama', 'email', 'unit'];
    }
    protected static ?string $model = Pengguna::class;
    protected static ?string $navigationLabel = 'Kelola Pengguna';
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $pluralLabel = 'Pengguna';
    protected static ?string $modelLabel = 'Pengguna';
    protected static ?string $navigationGroup = 'Manajemen';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->placeholder('Masukkan nama lengkap')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->autofocus(),

                TextInput::make('email')
                    ->label('Alamat Email')
                    ->placeholder('Masukkan email aktif')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->columnSpan(1)
                    ->prefixIcon('heroicon-o-envelope'),

                TextInput::make('no_telp')
                    ->label('Nomor Telepon')
                    ->placeholder('Masukkan nomor telepon')
                    ->tel()
                    ->maxLength(15)
                    ->columnSpan(1)
                    ->prefixIcon('heroicon-o-phone'),

                // Unit & Jabatan Sampingan
                Forms\Components\Grid::make(2)
                    ->schema([
                        TextInput::make('jabatan')
                            ->label('Jabatan')
                            ->placeholder('Masukkan jabatan')
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-briefcase'),

                        TextInput::make('unit')
                            ->label('Unit / Departemen')
                            ->placeholder('Masukkan unit atau departemen')
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-building-office'),
                    ]),

                TextInput::make('alamat')
                    ->label('Alamat Tempat Tinggal')
                    ->placeholder('Masukkan alamat lengkap')
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->prefixIcon('heroicon-o-map'),

                // Tambahkan Created At (Tanggal Dibuat)
                DateTimePicker::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->disabled() // Tidak bisa diedit
                    ->default(now()) // Isi otomatis dengan waktu sekarang
                    ->columnSpanFull()
                    ->prefixIcon('heroicon-o-calendar'),
            ]);


    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
        
                TextColumn::make('nama')
                    ->label('Nama Lengkap')
                    ->sortable()
                    ->searchable(),
        
                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
        
                TextColumn::make('no_telp')
                    ->label('No. Telepon')
                    ->searchable()
                    ->sortable(),
        
                TextColumn::make('unit')
                    ->label('Unit / Departemen')
                    ->searchable()
                    ->sortable(),
        
                TextColumn::make('created_at') // Tambahkan kolom waktu dibuat
                    ->label('Pengguna dibuat pada')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPenggunas::route('/'),
            'create' => Pages\CreatePengguna::route('/create'),
            'edit' => Pages\EditPengguna::route('/{record}/edit'),
        ];
    }
}
