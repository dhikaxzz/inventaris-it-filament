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
use App\Models\RiwayatKondisi;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\BarangResource\RelationManagers\RiwayatKondisiRelationManager;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Intervention\Image\Facades\Image;
use Filament\Notifications\Notification;
// use Intervention\Image\ImageManagerStatic as Image;

class BarangResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'nama_barang';
    
    public static function getGloballySearchableAttributes(): array
    {
        return ['nama_barang', 'merek'];
    }

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
                ->required()
                ->unique(ignoreRecord: true) // Abaikan jika record ID sama
                ->maxLength(255),

            Forms\Components\TextInput::make('serial_number')
                ->label('Serial Number')
                ->nullable()
                ->maxLength(255),

    
            Forms\Components\TextInput::make('nama_barang')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('merek')
                ->label('Merek')
                ->maxLength(255)
                ->nullable(),

            Forms\Components\TextInput::make('model_seri')
                ->label('Model/Seri')
                ->maxLength(255)
                ->nullable(),
    
            Forms\Components\Select::make('kategori_id')
                ->label('Kategori')
                ->options(fn () => Kategori::all()->pluck('nama_kategori', 'id'))
                ->required(),
    
            Forms\Components\TextInput::make('lokasi')
                ->label('Lokasi Barang')
                ->required(),
    
            Forms\Components\Select::make('kondisi')
                ->label('Kondisi')
                ->options([
                    'Baik' => 'Baik',
                    'Lecet' => 'Lecet',
                    'Rusak' => 'Rusak',
                ])
                ->default('Baik') // Set default biar nggak kosong
                ->afterStateUpdated(function ($state, $record) {
                    if ($record && $record->exists && $record->kondisi !== $state) { 
                        $keterangan = "Barang berubah dari kondisi {$record->kondisi} ke {$state}";
            
                        // Simpan ke riwayat kondisi
                        $record->riwayatKondisi()->create([
                            'kondisi_sebelumnya' => $record->kondisi,
                            'kondisi_setelahnya' => $state,
                            'keterangan' => $keterangan,
                            'tanggal_perubahan' => now(),
                        ]);
                    }
                }),



            Forms\Components\TextInput::make('status')
                ->default('Tersedia')
                ->disabled(),
    
            Forms\Components\Textarea::make('keterangan')
                ->label('Keterangan')
                ->rows(3)
                ->nullable(),

            Forms\Components\TextInput::make('created_at')
                ->label('Tanggal Ditambahkan')
                ->disabled()
                ->formatStateUsing(fn ($state) => $state ? \Carbon\Carbon::parse($state)->format('d M Y H:i') : '-'),    
                
            Forms\Components\FileUpload::make('foto')
                ->label('Foto Barang')
                ->image()
                ->maxSize(1024) // Maksimal 1MB
                ->directory('uploads-barang') // Simpan di storage/app/public/uploads-barang
                ->preserveFilenames(),
                // ->afterStateUploaded(function ($state) {
                //     $image = Image::make($state->getRealPath());
                //     $image->resize(800, 600, function ($constraint) {
                //         $constraint->aspectRatio();
                //     })->save();
                // }),         
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
                ->icon('heroicon-o-qr-code')
                ->modalHeading(fn ($record) => "QR Code - {$record->kode_barang}")
                ->modalContent(fn ($record) => view('components.qrcode', ['kode_barang' => $record->kode_barang]))
                ->modalButton('Tutup')
                ->color('primary'),
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
