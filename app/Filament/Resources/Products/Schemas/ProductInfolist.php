<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Product Info")
                ->schema([
                    TextEntry::make("id")
                    ->label("Product ID")
                    ->weight("bold")
                    ->color("primary"),
                    TextEntry::make("name")
                    ->label("Product Name")
                    ->weight("bold")
                    ->color("primary"),
                    TextEntry::make("sku")
                    ->label("Product sku")
                    ->weight("bold")
                    ->color("success")
                    ->badge(),
                    TextEntry::make(name: "description")
                    ->label("Product Description")
                    ->weight("bold")
                    ->color("primary"),
                    TextEntry::make(name: "created_at")
                    ->label("Product creation date")
                    ->weight("bold")
                    ->color("info")
                    ->date("d-m-y")
                ])->columnSpanFull(),
                Section::make("Price & Stock")
                ->schema([
                    TextEntry::make("price")
                    ->icon(Heroicon::CurrencyDollar)
                    ->label("Product price")
                    ->weight("bold")
                    ->color("primary"),
                    TextEntry::make("stock")
                    ->label("Stock")
                    ->weight("bold")
                    ->color("primary"),
                ])->columnSpanFull(),
                Section::make("Media & Status")
                ->schema([
                    ImageEntry::make("image")
                    ->disk("public")
                    ->label("Product Image"),
                    IconEntry::make("is_active")
                    ->label("Is Active")
                    ->boolean(),
                    IconEntry::make("is_featured")
                    ->label("Is Featured")
                    ->boolean()
                ])
            ]);
    }
}
