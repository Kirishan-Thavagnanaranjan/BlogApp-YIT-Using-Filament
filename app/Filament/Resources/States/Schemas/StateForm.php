<?php

namespace App\Filament\Resources\States\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

use function Laravel\Prompts\select;

class StateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make("country_id")
                    ->label("Country")
                    ->relationship("country", "name")
                    ->required(),
                TextInput::make('name')
                    ->label("state")
                    ->required(),
            ]);
    }
}
