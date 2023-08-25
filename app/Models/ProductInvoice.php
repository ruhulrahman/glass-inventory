<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInvoice extends Model
{
    protected $table= 'product_invoices';
    protected $guarded=['id'];

	public function company(){
		return $this->belongsTo(Company::class, 'company_id');
	}

	public function customer(){
		return $this->belongsTo(Customer::class, 'customer_id');
	}

	public function payment_status(){
		return $this->belongsTo(Status::class, 'payment_status_id');
	}

	public function details(){
		return $this->hasMany(ProductInvoiceDetail::class, 'product_invoice_id');
	}

	public function creator(){
		return $this->belongsTo(User::class, 'creator_id');
	}

	public function editor(){
		return $this->belongsTo(User::class, 'editor_id');
	}
}
