<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Form;

class EditArea extends EditRecord
{
    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Repeater::make('areas')
                    ->relationship()
                    ->label(__('user.profile.section.area'))
                    ->createItemButtonLabel(__('user.profile.field.area.create'))
                    ->minItems(1)
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-location-marker')
                            ->schema([
                                Location::make(),
                            ]),
                    ]),
            ]);
    }
}
