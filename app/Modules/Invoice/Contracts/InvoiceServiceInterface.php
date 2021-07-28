<?php


namespace Modules\Invoice\Contracts;
use Illuminate\Database\Eloquent\Model;

Interface InvoiceServiceInterface
{
    /**
     * @param array $data
     * @return Model
     */
    public function store(array $data): Model|bool;

    /**
     * @param $invoiceTotal
     * @return mixed
     */
    public function calculateInvoiceFees($invoiceTotal):float|int ;

    /**
     * @param int $debtorId
     * @param int $creditorId
     * @return bool
     */
    public function checkDebtorLimitations(int $debtorId, int $creditorId): bool;
    /**
     * @param $invoiceId
     * @return bool
     */
    public function makeInvoicePaid($invoiceId): bool;
    /**
     * @param int $invoiceId
     * @return bool
     */
    public function checkIfTheInvoicePaid(int $invoiceId): bool;

}
