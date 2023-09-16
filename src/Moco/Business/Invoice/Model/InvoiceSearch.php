<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Invoice\Model;

use Carbon\Carbon;
use Dreitier\Moco\Business\Company\Model\CompanyId;
use Dreitier\Moco\Business\Project\Model\ProjectId;
use Dreitier\Moco\Business\Purchase\Model\PurchaseStatus;
use Dreitier\Moco\Business\Purchase\PurchaseSearch;
use Dreitier\Moco\Http\ConvertToParameter;
use Dreitier\Moco\Moco;


class InvoiceSearch implements ConvertToParameter
{
    private $ids = [];
    private $updated_after = null;
    private ?PurchaseStatus $status = null;
    private $from = null;
    private $to = null;
    private $service_period_from = null;
    private $service_period_to = null;
    private array $tags = [];
    private ?string $identifier = null;
    private ?string $term = null;

    private ProjectId|null $project_id = null;
    private CompanyId|null $company_id = null;

    public function ids($ids = []): PurchaseSearch
    {
        $this->ids = $ids;
        return $this;
    }

    public function updatedAfter(Carbon $updatedAfter): PurchaseSearch
    {
        $this->updated_after = Moco::toDateString($updatedAfter);
        return $this;
    }

    public function status(?PurchaseStatus $invoiceStatus): PurchaseSearch
    {
        $this->status = $invoiceStatus;
        return $this;
    }

    public function from(Carbon $from): PurchaseSearch
    {
        $this->from = Moco::toDateString($from);
        return $this;
    }

    public function to(Carbon $to): PurchaseSearch
    {
        $this->to = Moco::toDateString($to);
        return $this;
    }

    public function servicePeriodFrom(Carbon $servicePeriodFrom): PurchaseSearch
    {
        $this->service_period_from = Moco::toDateString($servicePeriodFrom);
        return $this;
    }

    public function servicePeriodTo(Carbon $servicePeriodTo): PurchaseSearch
    {
        $this->service_period_to = Moco::toDateString($servicePeriodTo);
        return $this;
    }

    public function tags(array $tags): PurchaseSearch
    {
        $this->tags = $tags;
        return $this;
    }

    public function identifier(?string $identifier): PurchaseSearch
    {
        $this->identifier = $identifier;
        return $this;
    }

    public function term(?string $term): PurchaseSearch
    {
        $this->term = $term;
        return $this;
    }


    public function project(ProjectId|int $projectId): PurchaseSearch
    {
        $this->project_id = is_int($projectId) ? new ProjectId($projectId) : $projectId;
        return $this;
    }

    public function company(CompanyId|int $companyId): PurchaseSearch
    {
        $this->company_id = is_int($companyId) ? new CompanyId($companyId) : $companyId;
        return $this;
    }

    public static function create(): PurchaseSearch
    {
        return new PurchaseSearch();
    }

    public function toArgs(): array
    {
        $r = [];

        $r += sizeof($this->ids) > 0 ? ['ids' => $this->ids] : [];
        $r += $this->updated_after ? ['udpated_after' => $this->updated_after] : [];
        $r += $this->status ? ['status' => $this->status->value] : [];
        $r += $this->from ? ['from' => $this->from] : [];
        $r += $this->to ? ['to' => $this->to] : [];
        $r += $this->service_period_from ? ['from' => $this->service_period_from] : [];
        $r += $this->service_period_to ? ['to' => $this->service_period_to] : [];
        $r += sizeof($this->tags) > 0 ? ['tags' => $this->tags] : [];
        $r += $this->identifier ? ['identifier' => $this->identifier] : [];
        $r += $this->term ? ['term' => $this->term] : [];

        $r += $this->project_id ? ['project_id' => $this->project_id->value] : [];
        $r += $this->company_id ? ['company_id' => $this->company_id->value] : [];

        return $r;
    }
}
