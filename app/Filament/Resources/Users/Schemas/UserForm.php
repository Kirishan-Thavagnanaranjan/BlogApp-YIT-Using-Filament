<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\QueryBuilder\Constraints\Operators\Operator;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Operation;

use function Laravel\Prompts\select;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("basic")
                    ->schema([
                        TextInput::make("name")->required(),
                        TextInput::make("email")->email(),
                        TextInput::make("password")
                            ->password()
                            ->revealable()
                            // ->hiddenOn(Operation::Edit)
                            ->visibleOn(Operation::Create),
                    ]),

                Section::make("location")
                    ->schema([
                        Select::make("country_id")
                            ->label("Country")
                            ->options(Country::pluck("name", "id"))
                            ->reactive()
                            ->afterStateUpdated(function($state,callable $set){
                                $set('state_id',null);
                                $set('city_id',null);
                            }),
                            //->afterStateUpdated(fn($state, $set) => [$set('state_id', null), $set('city_id', null)]),
                        Select::make("state_id")
                            ->label("State")
                            //->options(fn($get)=>State::where('country_id',$get('country_id'))->pluck("name","id"))
                            ->options(function (callable $get) {
                                $country = $get("country_id");
                                if (!$country) {
                                    return [];
                                } else {
                                    return State::whereCountryId($country)
                                        ->pluck('name', 'id');
                                }
                            })
                            ->reactive()
                            ->afterStateUpdated(fn($state, $set) =>  $set('city_id', null)),
                        Select::make("city_id")
                            ->label("City")
                            ->options(fn($get) => City::where('state_id', $get('state_id'))->pluck('name', 'id'))
                            ->reactive()
                    ])

            ]);
    }
}
