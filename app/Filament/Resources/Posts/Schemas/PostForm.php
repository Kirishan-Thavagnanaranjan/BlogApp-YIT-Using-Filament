<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\category;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Components\Group;
use Filament\Support\Icons\Heroicon;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("fields")
                    ->description("Fill all the fields")
                    ->icon(Heroicon::RocketLaunch)
                    ->schema([
                        Group::make()
                            ->schema([
                                TextInput::make('title')
                                ->rules(["required","min:3","max:10"])
                                ->ascii(),
                                TextInput::make('slug')
                                ->required()
                                ->unique()
                                ->validationMessages([
                                    'unique' => "Slug should be unique"
                                ]),
                                Select::make("category_id")
                                    ->label('category')
                                    ->options(category::all()->pluck('name', 'id')),
                                ColorPicker::make('color'),
                            ])->Columns(2),

                        MarkdownEditor::make('body')
                    ])->columnSpan(2),

                Group::make()
                    ->schema([
                        Section::make("Image upload")
                            ->schema([
                                FileUpload::make("image")
                                    ->disk("public")
                                    ->directory("posts")
                            ]),


                        Section::make("Meta")
                            ->schema([
                                TagsInput::make("tags"),
                                Checkbox::make('published'),
                                DatePicker::make('published_at')
                            ])

                    ])->columnSpan(1)


            ])->columns(3);
    }
}
