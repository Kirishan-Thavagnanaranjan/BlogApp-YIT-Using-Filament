<?php

namespace App\Filament\Resources\Categories\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Schema $schema): Schema
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
                                    ->rules(["required", "min:3", "max:30"])
                                    ->ascii(),
                                TextInput::make('slug')
                                    ->required()
                                    ->unique()
                                    ->validationMessages([
                                        'unique' => "Slug should be unique"
                                    ]),
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make("slug"),
                TextColumn::make("created_at")
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
