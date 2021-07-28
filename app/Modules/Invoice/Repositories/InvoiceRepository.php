<?php
namespace  Modules\Invoice\Repositories;
use App\Repositories\BaseRepository;
use Modules\Invoice\Contracts\InvoiceRepositoryInterface;
use Modules\Invoice\Models\Invoice;

class InvoiceRepository extends BaseRepository implements InvoiceRepositoryInterface
{
    /**
     * @var Invoice
     */
    protected $model;

    /**
     * InvoiceRepository constructor.
     * @param Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->model = $invoice;
    }

    /**
     * @param $invoices
     * @return int
     */
    public function getInvoicesTotal($invoices) :int|float
    {
        return $invoices->sum('total_amount');
    }

    /**
     * @param $debtorId
     * @param array $columns
     * @return mixed
     */
    public function getUnpaidDebtorInvoices($debtorId,$columns = ['*'])
    {
      return  $this->model->where('debtor_id',$debtorId)->where('status',0)->select($columns)->get();
    }


}
