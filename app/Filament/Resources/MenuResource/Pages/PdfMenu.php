<?php

namespace App\Filament\Resources\MenuResource\Pages;

use App\Filament\Resources\MenuResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Exceptions\Halt;

use function Filament\authorize;

/**
 * @property Form $form
 */
class PdfMenu extends Page
{
    use InteractsWithFormActions, InteractsWithRecord;

    protected static string $resource = MenuResource::class;

    protected static string $view = 'filament.resources.menu-resource.pages.pdf-menu';

    public ?array $data = [];

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::ScreenTwoExtraLarge;
    }

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->fillForm();
    }

    public function fillForm(): void
    {
        $data = $this->record->attributesToArray();

        $this->form->fill($data);
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            $this->record->update($data);

        } catch (Halt $exception) {
            return;
        }

        $this->getSavedNotification()->send();
    }

    protected function getSavedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'));
    }

    public function form(Form $form): Form
    {
        return $form
            ->live()
            ->schema([
                $this->getTemplateSection(),
            ])
            ->model($this->record)
            ->statePath('data')
            ->operation('edit');
    }

    protected function getTemplateSection(): Component
    {
        return Section::make('Menu')
            ->headerActions([
                Forms\Components\Actions\Action::make('save')
                    ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                    ->submit('save')
                    ->keyBindings(['mod+s'])
            ])
            ->schema([
                Grid::make(1)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('file_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Repeater::make('sections')
                            ->relationship('sections')
                            ->collapsible()
                            ->collapsed()
                            ->itemLabel(fn ($state) => $state['name'] ?? 'Section')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\CheckboxList::make('products')
                                    ->relationship('products', 'name')
                                    ->bulkToggleable()
                                    ->columnSpanFull()
                                    ->columns(2)
                            ])
                    ])->columnSpan(1),
                Grid::make()
                    ->schema([
                        ViewField::make('preview.default')
                            ->columnSpan(2)
                            ->hiddenLabel()
                            ->view('filament.components.pdf')
                    ])->columnSpan(2),
            ])->columns(3);
    }
}
