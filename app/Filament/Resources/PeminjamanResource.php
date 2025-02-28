<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Filament\Resources\PeminjamanResource\RelationManagers;
use App\Models\Peminjaman;
use Filament\Forms\Components\Repeater;
use App\Models\Barang; // Ini untuk model Barang
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
use Filament\Tables\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

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
                        Grid::make(2)
                            ->schema([
                                Select::make('nama_peminjam')
                                    ->label('Nama Peminjam')
                                    ->options(Pengguna::pluck('nama', 'nama'))
                                    ->searchable()
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(fn (Get $get, callable $set) => 
                                        $set('unit', Pengguna::where('nama', $get('nama_peminjam'))->value('unit'))
                                    ),
        
                                TextInput::make('unit')
                                    ->label('Unit')
                                    ->disabled()
                                    ->placeholder('Unit akan otomatis terisi')
                                    ->required(),
        
                                TextInput::make('tempat')
                                    ->required()
                                    ->label('Tempat Barang Dipinjam')
                                    ->placeholder('Lokasi peminjaman')
                                    ->columnSpanFull(),
        
                                TextInput::make('acara')
                                    ->label('Acara')
                                    ->placeholder('Nama acara')
                                    ->required()
                                    ->columnSpanFull(),
        
                                DatePicker::make('tanggal_kembali')
                                    ->required()
                                    ->label('Tanggal Kembali')
                                    ->placeholder('Pilih tanggal kembali')
                                    ->columnSpan(1),
        
                                Placeholder::make('tanggal_pinjam')
                                    ->label('Tanggal Pinjam')
                                    ->content(now()->format('Y-m-d H:i')),
                            ]),
                    ]),
                
                Section::make()
                    ->schema([
                        Repeater::make('detailPeminjaman')
                            ->relationship('detailPeminjaman')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('barang_id')
                                            ->label('Barang')
                                            ->options(function (Get $get, ?string $state) {
                                                // Ambil semua barang tersedia
                                                $availableItems = Barang::where('status', 'tersedia')->pluck('nama_barang', 'id');
                                        
                                                // Jika sedang edit dan barang sudah dipilih sebelumnya, tambahkan ke opsi meskipun tidak tersedia
                                                if ($state) {
                                                    $selectedItem = Barang::where('id', $state)->pluck('nama_barang', 'id');
                                                    return $availableItems->union($selectedItem);
                                                }
                                        
                                                return $availableItems;
                                            })
                                            ->required()
                                            ->searchable()
                                            ->reactive()
                                            ->afterStateUpdated(fn ($state, callable $set) => 
                                                $set('kode_barang', Barang::where('id', $state)->value('kode_barang'))
                                            ),
                
                                        TextInput::make('kode_barang')
                                            ->label('Kode Barang')
                                            ->disabled()
                                            ->required(),
                                    ])
                            ])
                            ->grid(2) // Membuat dua kolom saat menambah barang
                            ->minItems(1),
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


            // Tables\Columns\TextColumn::make('detailPeminjaman.barang.nama_barang')
            // ->label('Barang Dipinjam')
            // ->listWithLineBreaks(),

        ])
        ->filters([
            //
        ])
        ->actions([
            Action::make('cetakPDF')
            ->label('Cetak PDF')
            ->icon('heroicon-o-printer')
            ->color('success')
            ->action(fn ($record) => Response::streamDownload(
                function () use ($record) {
                    $pdf = Pdf::loadView('pdf.peminjaman', ['peminjaman' => $record]);
                    echo $pdf->stream();
                },
                "peminjaman-{$record->id}.pdf"
            )),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make()
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

    public function store()
    {
        $data = request()->all();
        dd($data); // Debug untuk melihat apakah kode_barang dikirim
    }

}
