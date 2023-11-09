<?php

namespace App\Http\Controllers\API\V1\Admin;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfDownloadController extends Controller{

    public function index(Request $req, $name, $hash_args=[]){

        // $hashids = new \Hashids\Hashids('sams_pay_export_hash_salt', 30);
        // $args = $hashids->decode($hash_args);

        if($name == 'generate_invoice_pdf'){

			$searchingData = new \stdClass;
			// $searchingData->heading = 'Glass Inventory Invoice';

            $invoice = model('ProductInvoice')::with('customer', 'payment_status', 'details')->find($req->product_invoice_id);

            if ($invoice) {
                foreach($invoice->details as $item) {
                    $productStock = model('ProductStock')::with('type', 'color', 'unit', 'category')->find($item->product_stock_id);
                    if ($productStock) {
                        $item->product_type_id = $productStock->product_type_id;
                        $item->product_type = $productStock->type ? $productStock->type->name : '';
                        $item->category_id = $productStock->category_id;
                        $item->category = $productStock->category ? $productStock->category->name : '';
                        $item->color_id = $productStock->color_id;
                        $item->color = $productStock->color ? $productStock->color->name : '';
                        $item->unit_id = $productStock->unit_id;
                        $item->unit = $productStock->unit ? $productStock->unit->name : '';
                    }
                }
            }


            $auth_user = model('User')::with('company')->find($req->auth_user_id);
            $company = $auth_user->company;
            $searchingData->generated_by = $auth_user->name;
            // $searchingData->generated_at =  date("d M Y H:i:s a");
            $searchingData->generated_at =  date("d M Y");

            // info($company);

            $pdf = PDF::loadView('pdf.invoice',compact('invoice', 'searchingData', 'company'));
            $fileName = 'invoice-#'.$invoice->invoice_code.'-'.date("d-m-Y-H-i-s");
            // return $pdf->download($fileName.'.pdf');
            return $pdf->stream($fileName.'.pdf');

        }

    }

}
