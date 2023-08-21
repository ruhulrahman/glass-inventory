<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInvoiceDetail extends Model
{
    protected $table= 'product_invoice_details';
    protected $guarded=['id'];

	public function invoice(){
		return $this->belongsTo(ProductInvoice::class, 'product_invoice_id');
	}

	public function stock(){
		return $this->belongsTo(ProductStock::class, 'product_stock_id');
	}
}
