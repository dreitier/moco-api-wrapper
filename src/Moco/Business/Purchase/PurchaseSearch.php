<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Purchase;

use Carbon\Carbon;
use Dreitier\Moco\Business\Company\Model\CompanyId;
use Dreitier\Moco\Business\Purchase\Model\CategoryId;
use Dreitier\Moco\Business\Purchase\Model\PaymentMethod;
use Dreitier\Moco\Business\Purchase\Model\PurchaseStatus;
use Dreitier\Moco\Http\ConvertToParameter;
use Dreitier\Moco\Moco;


class PurchaseSearch implements ConvertToParameter
{
    private $id = null;
    private ?string $term = null;
    private ?PurchaseStatus $status = null;
    private array $tags = [];
    private $date = null;
    private ?bool $unpaid = null;
    private ?PaymentMethod $payment_method = null;

    private CategoryId|null $category_id = null;
    private CompanyId|null $company_id = null;

    public function id($id): PurchaseSearch
    {
        $this->id = $id;
        return $this;
    }

    public function term(?string $term): PurchaseSearch
    {
        $this->term = $term;
        return $this;
    }

    public function status(?PurchaseStatus $purchaseStatus): PurchaseSearch
    {
        $this->status = $purchaseStatus;
        return $this;
    }

    public function tags(array $tags): PurchaseSearch
    {
        $this->tags = $tags;
        return $this;
    }

    public function date(Carbon $date): PurchaseSearch
    {
        $this->date = Moco::toDateString($date);
        return $this;
    }

    public function unpaid(?bool $onlyUnpaid): PurchaseSearch
    {
        $this->unpaid = $onlyUnpaid;
        return $this;
    }

    public function paymentMethod(?PaymentMethod $paymentMethod): PurchaseSearch
    {
        $this->payment_method = $paymentMethod;
        return $this;
    }

    public function category(CategoryId|int $categoryId): PurchaseSearch
    {
        $this->category_id = is_int($categoryId) ? new CategoryId($categoryId) : $categoryId;
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

        $r += $this->id ? ['id' => $this->id] : [];
        $r += $this->term ? ['term' => $this->term] : [];
        $r += $this->status ? ['status' => $this->status->value] : [];
        $r += sizeof($this->tags) > 0 ? ['tags' => $this->tags] : [];
        $r += $this->date ? ['date' => $this->date] : [];
        $r += $this->unpaid !== null ? ['unpaid' => $this->unpaid] : [];
        $r += $this->payment_method ? ['payment_method' => $this->payment_method] : [];


        $r += $this->category_id ? ['category_id' => $this->category_id->value] : [];
        $r += $this->company_id ? ['company_id' => $this->company_id->value] : [];

        return $r;
    }
}
