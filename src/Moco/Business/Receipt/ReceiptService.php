<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Receipt;

use Carbon\Carbon;
use Dreitier\Moco\Business\User\Model\UserId;
use Dreitier\Moco\Http\Client;
use Dreitier\Moco\Moco;

class ReceiptService
{
    public function __construct(public readonly Client $client)
    {
    }

    public function create(UserId $mocoUserId, Carbon $date, $title, $purchaseCategoryId, $items = [], $info = '')
    {
        $data = [
            'date' => Moco::toDateString($date),
            'title' => $title,
//			'purchase_category_id' => $purchaseCategoryId,
            'info' => $info,
            'billable' => true,
            'items' => $items
        ];

        return $this->client->post('', $data);
    }
}
