<?php

namespace App\Filament\Resources\ContractResource\RelationManagers;

use App\Filament\Forms\AddendumForm;
use App\Filament\Tables\AddendumTable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddendumsRelationManager extends RelationManager
{
    protected static string $relationship = 'addendums';

    protected static ?string $title = 'Termos Aditivos';

    protected static ?string $label = 'Termo Aditivo';

    protected static ?string $pluralLabel = 'Termos Aditivos';

    public function form(Form $form): Form
    {
        return $form
            ->schema(AddendumForm::form());
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('number')
            ->columns(AddendumTable::table())
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
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
}
