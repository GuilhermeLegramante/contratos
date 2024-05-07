<?php

namespace App\Filament\Resources;

use App\Filament\Forms\AddendumForm;
use App\Filament\Resources\AddendumResource\Pages;
use App\Filament\Resources\AddendumResource\RelationManagers;
use App\Filament\Tables\AddendumTable;
use App\Models\Addendum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddendumResource extends Resource
{
    protected static ?string $model = Addendum::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'number';

    protected static ?string $modelLabel = 'termo aditivo';

    protected static ?string $pluralModelLabel = 'termos aditivos';

    protected static ?string $slug = 'termo-aditivo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(AddendumForm::form());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(AddendumTable::table())
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAddendums::route('/'),
            'create' => Pages\CreateAddendum::route('/criar'),
            'edit' => Pages\EditAddendum::route('/{record}/editar'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
