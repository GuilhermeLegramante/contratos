<?php

namespace App\Filament\Resources;

use App\Filament\Forms\SendingForm;
use App\Filament\Resources\SendingResource\Pages;
use App\Filament\Resources\SendingResource\RelationManagers;
use App\Models\Sending;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SendingResource extends Resource
{
    protected static ?string $model = Sending::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'protocol';

    protected static ?string $modelLabel = 'Envio de RPS';

    protected static ?string $pluralModelLabel = 'envios de RPS';

    protected static ?string $navigationGroup = 'NFSe';

    protected static ?string $slug = 'envio-rps';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(SendingForm::form());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('contract.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('situation')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('protocol')
                    ->searchable(),
                Tables\Columns\TextColumn::make('emission_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('aliquot')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('iss_value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('net_value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rps')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('competence_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Editado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListSendings::route('/'),
            'create' => Pages\CreateSending::route('/criar'),
            // 'edit' => Pages\EditSending::route('/{record}/editar'),
            'view' => Pages\ViewSending::route('/{record}'),
        ];
    }
}
