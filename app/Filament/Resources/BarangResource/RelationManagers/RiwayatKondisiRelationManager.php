<?php

namespace App\Filament\Resources\BarangResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class RiwayatKondisiRelationManager extends RelationManager
{
    protected static string $relationship = 'riwayatKondisi';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kondisi')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('kondisi_sebelumnya')
                ->label('Kondisi Sebelumnya')
                ->sortable(),
            Tables\Columns\TextColumn::make('kondisi_setelahnya')
                ->label('Kondisi Setelahnya')
                ->sortable(),
            Tables\Columns\TextColumn::make('keterangan')
                ->label('Keterangan')
                ->sortable(),
            Tables\Columns\TextColumn::make('tanggal_perubahan')
                ->label('Tanggal Perubahan')
                ->dateTime(),
        ]);
    }
}
