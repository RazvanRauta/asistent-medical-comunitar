<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Forms\Components\Card;
use App\Forms\Components\VulnerabilityChips;
use App\Models\Beneficiary;
use App\Models\Catagraphy;
use Filament\Forms\Components\View;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View as ViewContract;

class CatagraphySummary extends ViewRecord implements WithSidebar
{
    use Concerns\HasActions;
    use Concerns\HasRecordBreadcrumb;
    use Concerns\HasSidebar;

    protected static string $resource = BeneficiaryResource::class;

    public function getTitle(): string
    {
        return __('beneficiary.section.catagraphy');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Card::make()
                    ->header(__('catagraphy.header.vulnerabilities'))
                    ->footer($this->getVulnerabilitiesFooter())
                    ->schema($this->getVulnerabilitiesFormSchema()),

                Card::make()
                    ->header(__('catagraphy.header.recommendations'))
                    ->schema([
                        View::make('vendor.tables.components.empty-state.index')
                            ->viewData([
                                'icon' => 'icon-clipboard',
                                'heading' => __('catagraphy.recommendation.empty.title'),
                                'description' => __('catagraphy.recommendation.empty.description'),
                            ]),
                    ]),
            ]);
    }

    protected function getVulnerabilitiesFormSchema(): array
    {
        /** @var Beneficiary */
        $beneficiary = $this->getRecord();

        if (! $beneficiary->catagraphy->created_at) {
            return [
                View::make('vendor.tables.components.empty-state.index')
                    ->viewData([
                        'icon' => 'icon-empty-state',
                        'heading' => __('catagraphy.vulnerability.empty.title'),
                        'description' => __('catagraphy.vulnerability.empty.description'),
                        'actions' => [
                            Action::make('create')
                                ->label(__('catagraphy.vulnerability.empty.create'))
                                ->url(static::getResource()::getUrl('catagraphy.edit', ['record' => $this->getRecord()]))
                                ->button()
                                ->color('secondary'),
                        ],
                    ]),
            ];
        }

        return [
            VulnerabilityChips::make('socioeconomic_vulnerabilities')
                ->label(__('catagraphy.vulnerability.socioeconomic'))
                ->model($beneficiary->catagraphy),

            VulnerabilityChips::make('health_vulnerabilities')
                ->label(__('catagraphy.vulnerability.health'))
                ->model($beneficiary->catagraphy),

            VulnerabilityChips::make('reproductive_health')
                ->label(__('catagraphy.vulnerability.reproductive_health'))
                ->model($beneficiary->catagraphy),
        ];
    }

    protected function getVulnerabilitiesFooter(): ?ViewContract
    {
        /** @var Catagraphy */
        $catagraphy = $this->getRecord()->catagraphy;

        if (! $catagraphy->created_at) {
            return null;
        }

        return view('catagraphy.last_updated', [
            'created_at' => $catagraphy->created_at->toFormattedDateTime(),
            'updated_at' => $catagraphy->updated_at->toFormattedDateTime(),
            'name' => $catagraphy->nurse->full_name,
            'history_url' => static::getResource()::getUrl('history', $this->getRecord()),
        ]);
    }

    protected function getRelationManagers(): array
    {
        return [];
    }
}
