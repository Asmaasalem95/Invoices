<?php


namespace Modules\Invoice\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface InvoiceRepositoryInterface
{

    public function getInvoicesTotal($invoices) : int|float;

}
