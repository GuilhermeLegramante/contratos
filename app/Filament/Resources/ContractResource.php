<?php

namespace App\Filament\Resources;

use App\Filament\Forms\ContractForm;
use App\Filament\Resources\ContractResource\Pages;
use App\Filament\Resources\ContractResource\RelationManagers;
use App\Filament\Tables\Columns\FileLink;
use App\Models\Contract;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Actions\Action;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    protected static ?string $modelLabel = 'contrato';

    protected static ?string $pluralModelLabel = 'contratos';

    protected static ?string $slug = 'contrato';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(ContractForm::form());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.name')
                    ->label('Cliente')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('hiringMethod.name')
                    ->label('Forma de Contratação')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('number')
                    ->label('Número')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label('Data de Início')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Data de Término')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),
                TextColumn::make('global_value')
                    ->label('Valor Global')
                    ->money('BRL')
                    ->summarize(Sum::make()->label('Total')->money('BRL'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),
                TextColumn::make('monthly_value')
                    ->label('Valor Mensal')
                    ->money('BRL')
                    ->summarize(Sum::make()->label('Total')->money('BRL'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),
                FileLink::make('file')
                    ->label('Arquivo')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Ativo')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Editado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Ativo'),
                SelectFilter::make('client')
                    ->label('Cliente')
                    ->searchable()
                    ->relationship('client', 'name'),
            ])
            ->groups([
                Group::make('client.name')
                    ->label('Cliente')
                    ->collapsible(),
            ])
            ->deferFilters()
            ->filtersApplyAction(
                fn (Action $action) => $action
                    ->link()
                    ->label('Aplicar Filtro(s)'),
            )
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AddendumsRelationManager::class,
            RelationManagers\PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
