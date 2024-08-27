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
use Filament\Support\Enums\Alignment;
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
                Tables\Columns\TextColumn::make('contract.client.name')
                    ->label('Cliente')
                    ->sortable(),
                Tables\Columns\TextColumn::make('situation')
                    ->label('Situação')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->alignment(Alignment::Center)
                    ->badge()
                    ->formatStateUsing(
                        fn(string $state): string => match ($state) {
                            '1' => 'NÃO RECEBIDO',
                            '2' => 'NÃO PROCESSADO',
                            '3' => 'PROCESSADO COM ERRO',
                            '4' => 'PROCESSADO COM SUCESSO',
                        }
                    )
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'warning',
                        '2' => 'info',
                        '3' => 'danger',
                        '4' => 'success',
                    }),
                Tables\Columns\TextColumn::make('date')
                    ->label('Data')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('protocol')
                    ->label('Protocolo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('emission_date')
                    ->label('Data de Emissão')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('competence_date')
                    ->label('Data de Competência')
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
