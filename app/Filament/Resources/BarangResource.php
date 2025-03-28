<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Filament\Resources\BarangResource\RelationManagers;
use App\Models\Barang;
use App\Models\Peminjaman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Kategori;
use App\Models\RiwayatKondisi;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\BarangResource\RelationManagers\RiwayatKondisiRelationManager;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Intervention\Image\Facades\Image;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

// use Intervention\Image\ImageManagerStatic as Image;

class BarangResource extends Resource implements HasShieldPermissions
{
    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'publish'
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nama_barang', 'merek'];
    }

    protected static ?string $recordTitleAttribute = 'nama_barang';
    protected static ?string $model = Barang::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';    
    protected static ?string $navigationLabel = 'Kelola Barang';
    protected static ?string $pluralLabel = 'Barang';
    protected static ?string $modelLabel = 'Barang';
    protected static ?string $navigationGroup = 'Manajemen';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('scan_qr')
                ->label('Scan QR')
                ->icon('heroicon-o-qr-code')
                ->modalHeading('Scan QR Code Barang')
                ->modalContent(view('components.scan-qr')) // Panggil modal untuk scan
                ->modalButton('Tutup')
                ->color('primary'),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('kode_barang')
                ->label('Kode Barang')
                ->required()
                ->unique(ignoreRecord: true)
                ->prefixIcon('heroicon-o-tag')
                ->maxLength(255),
    
            Forms\Components\TextInput::make('serial_number')
                ->label('Serial Number')
                ->nullable()
                ->prefixIcon('heroicon-o-hashtag')
                ->maxLength(255),
    
            Forms\Components\TextInput::make('nama_barang')
                ->label('Nama Barang')
                ->required()
                ->prefixIcon('heroicon-o-archive-box')
                ->maxLength(255),
    
            Forms\Components\TextInput::make('merek')
                ->label('Merek')
                ->maxLength(255)
                ->prefixIcon('heroicon-o-bookmark')
                ->nullable(),
    
            Forms\Components\TextInput::make('model_seri')
                ->label('Model/Seri')
                ->maxLength(255)
                ->prefixIcon('heroicon-o-cube')
                ->nullable(),
    
            Forms\Components\Select::make('kategori_id')
                ->label('Kategori')
                ->options(fn () => Kategori::all()->pluck('nama_kategori', 'id'))
                ->prefixIcon('heroicon-o-list-bullet')
                ->required(),
    
            Forms\Components\TextInput::make('lokasi')
                ->label('Lokasi Barang')
                ->prefixIcon('heroicon-o-map-pin')
                ->required(),
    
            Forms\Components\Select::make('kondisi')
                ->label('Kondisi')
                ->prefixIcon('heroicon-o-shield-check')
                ->options([
                    'Baik' => 'Baik',
                    'Lecet' => 'Lecet',
                    'Rusak' => 'Rusak',
                ])
                ->default('Baik')
                ->afterStateUpdated(function ($state, $record) {
                    if ($record && $record->exists && $record->kondisi !== $state) {
                        $keterangan = "Barang berubah dari kondisi {$record->kondisi} ke {$state}";
                        $record->riwayatKondisi()->create([
                            'kondisi_sebelumnya' => $record->kondisi,
                            'kondisi_setelahnya' => $state,
                            'keterangan' => $keterangan,
                            'tanggal_perubahan' => now(),
                        ]);
                    }
                }),
    
            Forms\Components\Textarea::make('keterangan')
                ->label('Keterangan')
                ->rows(3)
                ->nullable(),

            Forms\Components\TextInput::make('status')
                ->label('Status')
                ->default('Tersedia')
                ->prefixIcon('heroicon-o-check-circle')
                ->disabled(),
    
            Forms\Components\FileUpload::make('foto')
                ->label('Foto Barang')
                ->image()
                ->maxSize(1024)
                ->directory('uploads-barang')
                ->preserveFilenames(),
    
            Forms\Components\TextInput::make('created_at')
                ->label('Tanggal Ditambahkan')
                ->disabled()
                ->hidden()
                ->prefixIcon('heroicon-o-calendar')
                ->formatStateUsing(fn ($state) => $state ? \Carbon\Carbon::parse($state)->format('d M Y H:i') : '-'),
        ]);
    }
    

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('kode_barang')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('serial_number')->label('Serial Number')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('nama_barang')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('kategori.nama_kategori')->label('Kategori')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('merek')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('lokasi')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('kondisi')
            ->sortable()
            ->searchable()
            ->color(fn (string $state): string => match ($state) {
                'Baik' => 'success',
                'Lecet' => 'warning',
                'Rusak' => 'danger',
            }),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->sortable()
                ->searchable()
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
                ->modalCancelAction(false) // Hapus tombol Cancel
                ->modalSubmitAction(false) // Hapus tombol Cancel
                ->icon('heroicon-o-qr-code')
                ->modalHeading(fn ($record) => "QR Code - {$record->kode_barang}")
                ->modalContent(fn ($record) => view('components.qrcode', ['kode_barang' => $record->kode_barang]))
                ->color('primary'),

            Action::make('pengguna_terakhir')
                ->label('Pengguna Terakhir')
                ->modalCancelAction(false)
                ->modalSubmitAction(false)
                ->icon('heroicon-o-user')
                ->modalHeading('Pengguna Terakhir Barang')
                ->modalContent(fn (Model $record) => view('components.pengguna-terakhir', [
                    'barang' => $record,
                    'penggunaTerakhir' => $record->getPenggunaTerakhir(),
                ])),
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
            RiwayatKondisiRelationManager::class,
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
