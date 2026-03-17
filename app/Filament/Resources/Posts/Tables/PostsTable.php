<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;



class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("id")
                ->label("ID")
                ->toggleable(isToggledHiddenByDefault:true),
                ImageColumn::make('image')->disk("public")
                ->toggleable(),
                TextColumn::make('title')->sortable()->searchable()->toggleable(),
                TextColumn::make('slug')->searchable()->toggleable(),
                TextColumn::make('category.name')->sortable()->searchable()->toggleable(),
                ColorColumn::make("color")
                ->toggleable(),
                TextColumn::make("created_at")->searchable()
                    ->label("Created at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make("tags")
                ->label("Tags")
                ->toggleable(isToggledHiddenByDefault:true),
                IconColumn::make("published")
                ->boolean()
                ->toggleable(isToggledHiddenByDefault:true)
            ]) //->defaultSort("title","asc"),
                
            ->filters([
                Filter::make("created_at")
                    ->label("Creation date")
                    ->schema([
                        DatePicker::make("created_at")
                            ->label("select Date : ")
                    ])

                    ->query(function ($query, $data) {
                        return $query->when(
                            $data['created_at'],
                            fn ($q, $date) => $q->whereDate('created_at', $date)
                        );
                    }),

                    SelectFilter::make("category_id")
                    ->label("Select Category")
                    ->relationship("category","name")
                    //->preload()
                    ->searchable()
                    

            ])

            ->recordActions([
                EditAction::make(),
                ViewAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
