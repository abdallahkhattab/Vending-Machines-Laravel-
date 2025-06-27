<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Transaction;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Reports & Analytics';

      public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Read-only form for viewing transaction details
                Forms\Components\TextInput::make('employee.full_name')
                    ->label('Employee')
                    ->disabled(),
                Forms\Components\TextInput::make('machine.location')
                    ->label('Machine Location')
                    ->disabled(),
                Forms\Components\TextInput::make('slot.slot_number')
                    ->label('Slot Number')
                    ->disabled(),
                Forms\Components\TextInput::make('points_deducted')
                    ->disabled()
                    ->suffix('points'),
                Forms\Components\Select::make('status')
                    ->options([
                        'success' => 'Success',
                        'failure' => 'Failure',
                    ])
                    ->disabled(),
                Forms\Components\Textarea::make('failure_reason')
                    ->disabled()
                    ->rows(2),
                Forms\Components\DateTimePicker::make('transaction_time')
                    ->disabled(),
            ]);
    }


        public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction_time')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee.full_name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('machine.location')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slot.slot_number')
                    ->sortable()
                    ->prefix('Slot '),
                Tables\Columns\TextColumn::make('slot.category')
                    ->badge()
                    ->colors([
                        'success' => 'juice',
                        'warning' => 'meal',
                        'info' => 'snack',
                    ]),
                Tables\Columns\TextColumn::make('points_deducted')
                    ->sortable()
                    ->suffix(' pts'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'success',
                        'danger' => 'failure',
                    ]),
                Tables\Columns\TextColumn::make('failure_reason')
                    ->limit(30)
                    ->tooltip(function (Transaction $record): ?string {
                        return $record->failure_reason;
                    }),
            ])
            ->defaultSort('transaction_time', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'success' => 'Success',
                        'failure' => 'Failure',
                    ]),
                Tables\Filters\SelectFilter::make('employee')
                    ->relationship('employee', 'full_name'),
                Tables\Filters\SelectFilter::make('machine')
                    ->relationship('machine', 'location'),
                Filter::make('transaction_date')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('transaction_time', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('transaction_time', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // No bulk actions for transactions (read-only)
            ]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Transactions are created through API only
    }

    public static function canEdit($record): bool
    {
        return false; // Transactions cannot be edited
    }

    public static function canDelete($record): bool
    {
        return false; // Transactions cannot be deleted
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
