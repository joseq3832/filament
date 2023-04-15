<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('email')
                        ->email()
                        ->required(),
                    TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(
                            static fn (null|string $state): null|string =>
                            filled(
                                $state ? Hash::make($state) : null,
                            )
                        )->required(
                            static fn (Page $livewire): string =>
                            $livewire instanceof CreateUser,
                        )->maxLength(255)
                        ->dehydrated(
                            static fn (null|string $state): bool =>
                            filled($state),
                        )->label(
                            static fn (Page $livewire): string =>
                            ($livewire instanceof EditUser) ? 'Nueva contraseña' : 'Contraseña'
                        ),
                    Select::make('roles')
                        ->required()
                        ->multiple()
                        ->relationship('roles', 'description'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->toggleable(),
                TextColumn::make('name')->label('Nombre')->sortable()->searchable(),
                TextColumn::make('email')->label('Email')->sortable()->searchable(),
                IconColumn::make('email_verified_at')->label('Email verificado')->boolean(),
                TextColumn::make('roles.description')->label('Rol/s'),
                TextColumn::make('created_at')->dateTime('j \d\e M, Y')->label('Creado el')->toggleable(),
            ])
            ->filters([
                Filter::make('name')->label('nombre'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
