<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInvoicePaymentHistory extends Model
{
    protected $table= 'product_invoice_payment_histories';
    protected $guarded=['id'];
    public $timestamps = false;

	public function invoice(){
		return $this->belongsTo(ProductInvoice::class, 'product_invoice_id');
	}

}
