<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SlotResource\Pages;
use App\Filament\Resources\SlotResource\RelationManagers;
use App\Models\Slot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SlotResource extends Resource
{
    protected static ?string $model = Slot::class;
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Machine Management';

       public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('machine_id')
                    ->relationship('machine', 'location')
                    ->required()
                    ->label('Vending Machine'),
                Forms\Components\TextInput::make('slot_number')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                Forms\Components\Select::make('category')
                    ->options([
                        'juice' => 'Juice',
                        'meal' => 'Meal',
                        'snack' => 'Snack',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->suffix('points'),
                Forms\Components\TextInput::make('product_name')
                    ->maxLength(255)
                    ->placeholder('Optional product name'),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('machine.location')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slot_number')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('category')
                    ->colors([
                        'success' => 'juice',
                        'warning' => 'meal',
                        'info' => 'snack',
                    ]),
                Tables\Columns\TextColumn::make('price')
                    ->sortable()
                    ->suffix(' pts'),
                Tables\Columns\TextColumn::make('product_name')
                    ->searchable()
                    ->placeholder('N/A'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'juice' => 'Juice',
                        'meal' => 'Meal',
                        'snack' => 'Snack',
                    ]),
                Tables\Filters\SelectFilter::make('machine')
                    ->relationship('machine', 'location'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSlots::route('/'),
            'create' => Pages\CreateSlot::route('/create'),
            'edit' => Pages\EditSlot::route('/{record}/edit'),
        ];
    }
}
