<?php


namespace Modules\Invoice\Services;

use App\Helpers\InvoiceStatus;
use App\Repositories\SettingRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Company\Repositories\CompanyRepository;
use Modules\Invoice\Contracts\InvoiceRepositoryInterface;
use Modules\Invoice\Contracts\InvoiceServiceInterface;


class InvoiceService implements InvoiceServiceInterface
{

    /**
     * @var InvoiceRepositoryInterface
     */
    private $invoiceRepo;
    /**
     * @var CompanyRepository
     */
    private $companyRepo;
    /**
     * @var SettingRepository
     */
    private $settingRepo;

    /**
     * InvoiceService constructor.
     * @param InvoiceRepositoryInterface $invoiceRepository
     * @param CompanyRepository $companyRepository
     * @param SettingRepository $settingRepository
     */
    public function __construct(InvoiceRepositoryInterface $invoiceRepository,
                                CompanyRepository $companyRepository,
                                SettingRepository $settingRepository
    )
    {
        $this->invoiceRepo = $invoiceRepository;
        $this->companyRepo = $companyRepository;
        $this->settingRepo = $settingRepository;
    }

    /**
     * @param array $data
     * @return Model
     */
    public function store(array $data) :Model|bool
    {
        //validate debtor limitations
        $limitationsChecker = $this->checkDebtorLimitations($data['debtor_id'], $data['creditor_id']);
        if ($limitationsChecker) {
            //make calculations
            $sellingFees = $this->calculateInvoiceFees($data['total_amount']);
            $data['selling_amount'] = $data['total_amount'] - $sellingFees;
            $data['fees_amount'] = $sellingFees;
            $data['due_date'] = Carbon::parse($data['due_date'])->format('y-m-d');
            // store
            $createdInvoice = $this->invoiceRepo->create($data);
            return $createdInvoice;
        } else return false;
    }

    /**
     * @param int $debtorId
     * @param int $creditorId
     * @return bool
     */
    public function checkDebtorLimitations(int $debtorId, int $creditorId): bool
    {
        //get creditor company
        $creditor = $this->companyRepo->find($creditorId);
        //get unpaid debtor's invoices total
        $invoices = $this->invoiceRepo->getUnpaidDebtorInvoices($debtorId, ['total_amount']);

        $invoiceTotal = $this->invoiceRepo->getInvoicesTotal($invoices);
        if ($invoices->count() > 0 && $invoiceTotal >= $creditor->debtor_total_limit)
            return false;
        else return true;
    }

    /**
     * @param $invoiceTotal
     * @return float
     */
    public function calculateInvoiceFees($invoiceTotal) :float|int
    {
        $feesPercentage = $this->settingRepo->findByKey('selling_fees_percentage')->value;
        return $invoiceTotal * $feesPercentage / 100;

    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->settingRepo->all();
    }


    /**
     * @param $invoiceId
     * @return bool
     */
    public function makeInvoicePaid($invoiceId): bool
    {
        $data = ['status' => InvoiceStatus::PAID, 'paid_at' => Carbon::now()];
        $updated = $this->invoiceRepo->update($invoiceId, $data);
        return $updated;
    }

    /**
     * @param int $invoiceId
     * @return bool
     */
    public function checkIfTheInvoicePaid(int $invoiceId): bool
    {
        $invoice = $this->invoiceRepo->find($invoiceId);
        return $invoice->status == InvoiceStatus::PAID ? true : false;

    }


}
