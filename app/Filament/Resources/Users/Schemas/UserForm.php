<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

use Symfony\Component\Mime\Email;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make("name")->required(),
                TextInput::make("email")->email(),
                TextInput::make("password")
                ->password()
                ->revealable()
            ]);
    }
}
