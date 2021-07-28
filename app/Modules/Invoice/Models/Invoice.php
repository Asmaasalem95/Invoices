<?php

namespace Modules\Invoice\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable= ['creditor_id','debtor_id','status','paid_at','due_date','total_amount','selling_amount','fees_amount'];

}
