<?php

namespace App\Http\Controllers\API\V1\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Random;

class AjaxController extends Controller
{
	public function get(Request $req, $name)
	{
		$user = Auth::user();
		$data['user'] = $user;
		$default_per_page = 10;
		$carbon = new Carbon();

		if ($name == 'get_auth_user') {

			$auth_user = model('User')::find($user->id);

			return res_msg('Auth User Data', 200, [
				'auth_user' => $auth_user
			]);
		} else if ($name == "get_statuses_with_groups") {

			return res_msg('Statuses and status group list', 200, [
				'status_groups' => model('StatusGroup')::with('statuses')->get(),
				'statuses' => model('Status')::with('group')->orderBy('serial', 'asc')->get()
			]);
		} else if ($name == 'get_department_list_with_pagination') {

			$list = model('Department')::with('parent')->where('company_id', $user->company_id)->paginate($default_per_page);

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_department_list') {

			$list = model('Department')::with('parent')->where('company_id', $user->company_id)->get();

			foreach ($list as $item) {
				$item->value = $item->id;
				$item->label = $item->name;
			}

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_designation_list') {

			$list = model('Designation')::with('department')->where('company_id', $user->company_id)->get();

			foreach ($list as $item) {
				$item->value = $item->id;
				$item->label = $item->name;
			}

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_supplier_list_with_pagination') {

			$list = model('Supplier')::where('company_id', $user->company_id)->paginate($default_per_page);

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_supplier_list') {

			$list = model('Supplier')::where('company_id', $user->company_id)->get();

            foreach($list as $item) {
                $item->value = $item->id;
                $item->label = $item->name;
            }

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_product_stock_list_with_pagination') {

			$list = model('ProductStock')::with('type', 'unit', 'color', 'supplier', 'category', 'histories')
                    ->where('company_id', $user->company_id)
                    ->paginate($default_per_page);

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		} else if ($name == 'get_product_stock_list') {

			$list = model('ProductStock')::with(
                'type',
                'unit',
                'color',
                'supplier',
                'category',
                'histories.supplier',
                'histories.creator',
                )->where('company_id', $user->company_id)->get();

            foreach($list as $item) {
                $item->value = $item->id;
                $item->label = $item->name;
            }

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_user_list_with_pagination') {

			$list = model('User')::where('company_id', $user->company_id)->orderBy('id', 'desc')->paginate($default_per_page);

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_user_list') {

			$list = model('User')::where('company_id', $user->company_id)->orderBy('id', 'desc')->get();

            foreach($list as $item) {
                $item->value = $item->id;
                $item->label = $item->name;
            }

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_product_category_list_with_pagination') {

			$list = model('ProductCategory')::where('company_id', $user->company_id)->paginate($default_per_page);

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if($name == 'get_product_category_list'){

            $list = model('ProductCategory')::with('parent')->where('company_id', $user->company_id)->get();

            foreach($list as $item) {
                $item->value = $item->id;
                $item->label = $item->name;
            }

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		} else if($name == 'get_product_unit_list'){

            $list = model('ProductUnit')::where('company_id', $user->company_id)->get();

            foreach($list as $item) {
                $item->value = $item->id;
                $item->label = $item->name;
            }

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		} else if($name == 'get_product_color_list'){

            $list = model('ProductColor')::where('company_id', $user->company_id)->get();

            foreach($list as $item) {
                $item->value = $item->id;
                $item->label = $item->name;
            }

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if($name == 'get_product_type_list'){

            $list = model('ProductType')::where('company_id', $user->company_id)->get();

            foreach($list as $item) {
                $item->value = $item->id;
                $item->label = $item->name;
            }

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_company_list') {
			$companies = model('Company')::query()->orderBy('id','desc')->get();
			return res_msg('list Data', 200, [
				'data' => $companies
			]);
		} else if ($name == 'get_company_bank_list') {
			$banks = model('CompanyBankInfo')::where('company_id', $user->company_id)->orderBy('id','desc')->get();
			return res_msg('list Data', 200, [
				'data' => $banks
			]);
		} else if ($name == 'get_product_initial_dropdown_list') {

			$categories = model('ProductCategory')::where([
                'company_id' => $user->company_id,
                'active' => 1,
            ])->get();

            foreach($categories as $item) {
                $item->value = $item->id;
                $item->label = $item->name;
            }

			$suppliers = model('Supplier')::where([
                'company_id' => $user->company_id,
                'active' => 1,
            ])->get();

            foreach($suppliers as $item) {
                $item->value = $item->id;
                $item->label = $item->name;
            }

			$productUnits = model('ProductUnit')::where([
                'company_id' => $user->company_id,
                'active' => 1,
            ])->get();

            foreach($productUnits as $item) {
                $item->value = $item->id;
                $item->label = $item->name;
            }

			$productColors = model('ProductColor')::where([
                'company_id' => $user->company_id,
                'active' => 1,
            ])->get();

            foreach($productColors as $item) {
                $item->value = $item->id;
                $item->label = $item->name;
            }

			$productTypes = model('ProductType')::where([
                'company_id' => $user->company_id,
                'active' => 1,
            ])->get();

            foreach($productTypes as $item) {
                $item->value = $item->id;
                $item->label = $item->name;
            }

			$customers = model('Customer')::where([
                'company_id' => $user->company_id,
                'is_active' => 1,
            ])->get();

            foreach($customers as $item) {
                $item->value = $item->id;
                $item->label = $item->name;
            }

			$paymentStatuses = get_statuses('payment_statuses');

            foreach($paymentStatuses as $item) {
                $item->value = $item->id;
                $item->label = $item->name;
            }

			return res_msg('list Data', 200, [
				'categories' => $categories,
				'suppliers' => $suppliers,
				'productUnits' => $productUnits,
				'productColors' => $productColors,
				'productTypes' => $productTypes,
				'customers' => $customers,
				'customerList' => $customers,
				'paymentStatuses' => $paymentStatuses,
            ]);

		} else if ($name == 'get_employee_list') {
			$employees = model('Employee')::with('designation')->orderBy('id','desc')->get();
			return res_msg('list Data', 200, [
				'data' => $employees
			]);
		} else if($name == 'get_customer_list'){
			$customers = model('Customer')::orderBy('id','desc')->get();
			return res_msg('list Data', 200, [
				'data' => $customers
			]);
		} else if ($name == 'get_product_price_by_filter') {

			$query = model('ProductStock')::where([
                'company_id' => $user->company_id,
            ]);

            if ($req->product_type_id) {
                $query->where('product_type_id', $req->product_type_id);
            }

            if ($req->color_id) {
                $query->where('color_id', $req->color_id);
            }

            if ($req->unit_id) {
                $query->where('unit_id', $req->unit_id);
            }

            if ($req->category_id) {
                $query->where('category_id', $req->category_id);
            }

            $productStock = $query->first();

			return res_msg('list Data', 200, [
				'data' => $productStock
			]);
		} else if ($name == 'get_product_invoice_list') {

			$list = model('ProductInvoice')::with('customer', 'payment_status', 'details')->orderBy('id','desc')->get();

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		}else if ($name == 'get_attendance_employee_list') {
			// return $req->all();

			$count = model('EmployeeAttendance')::whereDate('date',Carbon::today())->count();

			if ($count == 0) {
				$employees = model('Employee')::where('active', 1)->select('id')->get();
				foreach ($employees as $key => $value) {
					model('EmployeeAttendance')::create([
						'company_id' => $user->company_id,
						'employee_id' => $value->id,
						'date' => Carbon::today(),
						'present' => 'No',
						'creator_id' => $user->id,
						'created_at' => Carbon::now()
					]);
				}
			}

			$query = model('EmployeeAttendance')::query();

			if ($req->from && $req->to) {
				$query->whereBetween('date',[Carbon::parse($req->from), Carbon::parse($req->to)]);
			}else if($req->from){
                $query->whereDate('date',Carbon::parse($req->from));
			}else if($req->to){
                $query->whereDate('date',Carbon::parse($req->to));
			}

			if($req->status_type){
                $query->where('present', $req->status_type);
			}

			if(!$req->from && !$req->to){
                $query->whereDate('date', Carbon::today());
			}

			$attendances = $query->get();
			// return $attendances;
			$employees = NULL;

			if($req->from || $req->to || $req->status_type && count($attendances) > 0){
				foreach ($attendances as $key => $value) {
					$employees[$key] =  model('Employee')::where('active', 1)->where('id', $value->employee_id)->first();
					$employees[$key]->present = $value->present;
					$employees[$key]->date = $value->date;
				}

			}else{

				if(count($attendances) > 0){
					$employees = model('Employee')::where('active', 1)->get();
					foreach ($attendances as $key => $value) {
						if($employees[$key]->id == $value->employee_id){
							$employees[$key]->present = $value->present;
							$employees[$key]->date = $value->date;
						}
					}
				}
			}

			$holidays = model('Holiday')::where('status',1)->get();

			$day = false;
			$holiday_name = false;

			foreach ($holidays as $key => $value) {

				if($value->from && $value->to){
					$from = explode('-', $value->from);

					for ($i=0; $i <$value->total ; $i++) {
						$date = Carbon::parse($from[0].'-'.$from[1].'-'.$from[2]+$i);
						if(Carbon::today()->eq($date)){
                            $day = true;
							$holiday_name = $value->name;
						}

					}
				}

				if ($day == true) {
					break;
				}
			}


			return res_msg('list Data', 200, [
				'data' => $employees,
				'day' => $day,
				'holiday_name' => $holiday_name
			]);
		}else if($name == "get_holiday_list"){
			$holidays = model('Holiday')::all();

			return res_msg('list Data', 200, [
				'data' => $holidays
			]);
		} else if ($name == 'get_product_invoice_data_by_id') {

			$productInvoice = model('ProductInvoice')::with('customer', 'payment_status', 'details')->find($req->id);

            if ($productInvoice) {
                foreach($productInvoice->details as $item) {
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

			return res_msg('list Data', 200, [
				'productInvoice' => $productInvoice
			]);
		}

		return response(['msg' => 'Sorry!, found no named argument.'], 403);
	}



	// Post functions are here .............
	public function post(Request $req, $name)
	{
		$user = Auth::user();
		$data['user'] = $user;
		$carbon = new Carbon();

		if ($name == 'store_department_data') {

			$validator = Validator::make($req->all(), [
				'name' => 'required',
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			model('Department')::create([
				'company_id' => $user->company_id,
				'name' => $req->name,
				'parent_id' => $req->parent_id,
				'creator_id' => $user->id,
				'active' => $req->active == 'true' ? 1 : 0,
				'created_at' => Carbon::now(),
			]);

			return res_msg('Department inserted successfully!', 200);
		} else if ($name == 'update_department_data') {

			$validator = Validator::make($req->all(), [
				'name' => 'required',
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			$department = model('Department')::find($req->id);

			$department->update([
				'name' => $req->name,
				'parent_id' => $req->parent_id,
				'editor_id' => $user->id,
				'active' => $req->active == 'true' ? 1 : 0,
				'created_at' => Carbon::now(),
			]);

			return res_msg('Department updated successfully!', 200);
		} else if ($name == 'delete_department_data') {

			$department = model('Department')::find($req->id);

			$department->delete();

			return res_msg('Department deleted successfully!', 200);
		} else if ($name == 'department_active_status_change') {

			$department = model('Department')::find($req->id);

			if ($department) {
				$department->active = !$department->active;
				$department->save();
			}

			return res_msg('Department active status updated successfully!', 200);
		} else if ($name == 'store_designation_data') {

			$validator = Validator::make($req->all(), [
				'name' => 'required',
				'department_id' => 'required',
			], [
				'department_id.required' => 'Department filed is required',
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			model('Designation')::create([
				'company_id' => $user->company_id,
				'name' => $req->name,
				'department_id' => $req->department_id,
				'ranking_number' => $req->ranking_number,
				'creator_id' => $user->id,
				'active' => $req->active == 'true' ? 1 : 0,
				'created_at' => Carbon::now(),
			]);

			return res_msg('Designation inserted successfully!', 200);
		} else if ($name == 'update_designation_data') {

			$validator = Validator::make($req->all(), [
				'name' => 'required',
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			$Designation = model('Designation')::find($req->id);

			$Designation->update([
				'name' => $req->name,
				'department_id' => $req->department_id,
				'ranking_number' => $req->ranking_number,
				'editor_id' => $user->id,
				'active' => $req->active == 'true' ? 1 : 0,
				'updated_at' => Carbon::now(),
			]);

			return res_msg('Designation updated successfully!', 200);
		} else if ($name == 'delete_designation_data') {

			$Designation = model('Designation')::find($req->id);

			$Designation->delete();

			return res_msg('Designation deleted successfully!', 200);
		} else if ($name == 'designation_active_status_change') {

			$Designation = model('Designation')::find($req->id);

			if ($Designation) {
				$Designation->active = !$Designation->active;
				$Designation->save();
			}

			return res_msg('Designation active status updated successfully!', 200);
		} else if ($name == 'store_supplier_data') {

			$validator = Validator::make($req->all(), [
				'name' => 'required',
				// 'email' => 'required|email|unique:suppliers,email',
				// 'address' => 'required',
				'phone1' => 'required|numeric',
			], [
				'phone1.required' => 'The Phone field is required',
				'phone1.numeric' => 'The Phone must be number',
			]);

			if ($req->phone2) {
				$validator = Validator::make($req->all(), [
					'phone2' => 'numeric',
				], [
					'phone2.numeric' => 'The Alternative Phone must be number',
				]);
			}

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			model('Supplier')::create([
				'company_id' => $user->company_id,
				'name' => $req->name,
				'email' => $req->email,
				'address' => $req->address,
				'phone1' => $req->phone1,
				'phone2' => $req->phone2,
				'note' => $req->note,
				'active' => $req->active == 'true' ? 1 : 0,
				'creator_id' => $user->id,
			]);

			return res_msg('Supplier inserted successfully!', 200);
		} else if ($name == 'update_supplier_data') {

			$validator = Validator::make($req->all(), [
				'name' => 'required',
				// 'email' => 'required|email|unique:suppliers,email,' . $req->id,
				// 'address' => 'required',
				'phone1' => 'required|numeric',
			], [
				'phone1.required' => 'The Phone field is required',
				'phone1.numeric' => 'The Phone must be number',
			]);

			if ($req->phone2) {
				$validator = Validator::make($req->all(), [
					'phone2' => 'numeric',
				], [
					'phone2.numeric' => 'The Alternative Phone must be number',
				]);
			}

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			$supplier = model('Supplier')::find($req->id);

			$supplier->update([
				'name' => $req->name,
				'email' => $req->email,
				'address' => $req->address,
				'phone1' => $req->phone1,
				'phone2' => $req->phone2,
				'note' => $req->note,
				'active' => $req->active == 'true' ? 1 : 0,
				'editor_id' => $user->company_id,
				'updated_at' => Carbon::now(),
			]);

			return res_msg('Supplier updated successfully!', 200);

		} else if ($name == 'delete_supplier_data') {

			$supplier = model('Supplier')::find($req->id);

			$supplier->delete();

			return res_msg('Supplier deleted successfully!', 200);

		} else if ($name == 'store_product_stock_data') {

			$validator = Validator::make($req->all(), [
				// 'name' => 'required',
				'price' => 'required|numeric',
				'quantity' => 'required|numeric',
				'cost' => 'required|numeric',
				'category_id' => 'required',
				// 'supplier_id' => 'required',
				'product_type_id' => 'required',
				// 'product_code' => 'required',
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			$product = model('ProductStock')::where([
				'company_id' => $user->company_id,
				'category_id' => $req->category_id,
				'color_id' => $req->color_id,
				'unit_id' => $req->unit_id,
				'product_type_id' => $req->product_type_id,
            ])->first();

            if ($product) {

                $product->price = $req->price;
                $product->quantity = $req->quantity;
                $product->product_in_stock = $product->product_in_stock + $req->quantity;
                $product->cost = $req->cost;
                $product->selling_price = $req->selling_price;
                $product->supplier_id = $req->supplier_id;
                $product->save();

            } else {
                $product = model('ProductStock')::create([
                    'price' => $req->price,
                    'quantity' => $req->quantity,
                    'cost' => $req->cost,
                    'product_in_stock' => $req->quantity,
                    'selling_price' => $req->selling_price,
                    'category_id' => $req->category_id,
                    'supplier_id' => $req->supplier_id,
                    'color_id' => $req->color_id,
                    'unit_id' => $req->unit_id,
                    'product_type_id' => $req->product_type_id,
                    'company_id' => $user->company_id,
                    'creator_id' => $user->id,
                ]);
            }

			model('ProductHistory')::create([
                'company_id' => $user->company_id,
				'product_id' => $product->id,
				'price' => $req->price,
				'quantity' => $req->quantity,
				'cost' => $req->cost,
				'selling_price' => $req->selling_price,
				'product_type_id' => $req->product_type_id,
				'creator_id' => $user->id,
			]);

			return res_msg('Product stock added successfully!', 200);

		} else if ($name == 'update_product_stock_data') {

			$validator = Validator::make($req->all(), [
				// 'name' => 'required',
				'price' => 'required|numeric',
				'cost' => 'required|numeric',
				'category_id' => 'required',
				// 'supplier_id' => 'required',
				'product_type_id' => 'required',
				// 'product_code' => 'required',
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			$product = model('ProductStock')::find($req->id);

			$product->update([
				// 'name' => $req->name,
				'price' => $req->price,
				'quantity' => $req->quantity,
				'cost' => $req->cost,
				'selling_price' => $req->selling_price,
				'category_id' => $req->category_id,
				'supplier_id' => $req->supplier_id,
				'color_id' => $req->color_id,
				'unit_id' => $req->unit_id,
				'product_type_id' => $req->product_type_id,
				// 'product_code' => $req->product_code,
				// 'last_sale' => $carbon,
				'editor_id' => $user->id,
			]);

            $ProductHistory = model('ProductHistory')::where([
                'company_id' => $user->company_id,
				'product_id' => $product->id,
				'supplier_id' => $req->supplier_id,
				'price' => $req->price,
            ])->first();

            if (!$ProductHistory) {

                model('ProductHistory')::create([
                    'company_id' => $user->company_id,
                    'product_id' => $product->id,
                    'price' => $req->price,
                    'quantity' => $req->quantity,
                    'cost' => $req->cost,
                    'selling_price' => $req->selling_price,
                    'supplier_id' => $req->supplier_id,
                    'product_type_id' => $req->product_type_id,
                    'creator_id' => $user->id,
                ]);

            }

			return res_msg('Product stock updated successfully!', 200);

		} else if ($name == 'delete_product_stock_data') {

			$product = model('ProductStock')::find($req->id);

			$product->delete();

			return res_msg('Product Stock deleted successfully!', 200);

		} else if ($name == 'store_user_data') {

			$validator = Validator::make($req->all(), [
				'name' => 'required',
				'email' => 'required|email|unique:users,email',
				'username'=>'required',
				// 'mobile' => 'required|numeric',
				// 'password' => 'required|string|min:8',
				'user_type' => 'required',
				// 'password'=>'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			DB::beginTransaction();

			try {
				$fileName = '';

				if ($req->file('photo')) {
					$fileName = 'photo-' . time() . '.' . $req->photo->extension();

				}

				$data = model('User')::create([
					'company_id' => $user->company_id,
					'name' => $req->name,
					'username' => $req->username,
					'email' => $req->email,
					'photo' => $fileName,
					'user_type' => $req->user_type,
					'is_employee' => $req->is_employee == 'false' ? 0 : 1,
					'created_at' => $carbon,
				]);

				if($req->is_employee == 'true'){

				model('Employee')::create([
					'employee_code'=>substr(strtolower($req->name), 0, 3).'-'.str_pad($data->id, 3, "0", STR_PAD_LEFT),
					'company_id' => $user->company_id,
					'first_name' => $req->name,
					'user_id' => $data->id,
					'email' => $req->email,
					'created_at' => $carbon
				]);

			 }


				DB::commit();
				$fileName ? $req->photo->move(public_path('uploads/photo'), $fileName) : '';
				return res_msg('User inserted successfully!', 200);

			} catch (\Throwable $e) {
				return response(['msg' => 'Wrong data entry'], 422);
				DB::rollback();
			}

		} else if ($name == 'update_user_data') {

			$validator = Validator::make($req->all(), [
				'name' => 'required',
				'email' => 'required|email|unique:users,email,' . $req->id,
				// 'mobile' => 'required|numeric',
				'user_type' => 'required',
				// 'password'=>'required|string|min:8',
				// 'password'=>'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}


			DB::beginTransaction();

			try {
				$user_data = model('User')::find($req->id);

				if ($user_data->photo != NULL && file_exists(public_path('uploads/photo/'.$user_data->photo)) && $req->file('photo')) {
					unlink(public_path('uploads/photo/'.$user_data->photo));
				}

				$fileName = NULL;

				if ($req->file('photo')) {
					$fileName = 'photo-' . time() . '.' . $req->photo->extension();

				}

				model('User')::where('id', $req->id)->update([
					'name' => $req->name,
					'username' => $req->username,
					'email' => $req->email,
					'photo' => $fileName ? $fileName : $user_data->photo,
					'user_type' => $req->user_type,
					'is_employee' => $req->is_employee == 'false' ? 0 : 1,
					'created_at' => Carbon::now()

				]);

				if($req->is_employee == 'true'){

					$employee = model('Employee')::where('user_id', $req->id)->first();

					if($employee){

						model('Employee')::where('user_id', $req->id)->update([
							'name' => $req->name,
							'email' => $req->email,
							'updated_at' => $carbon
						]);
					}else{

						model('Employee')::create([
							'employee_code'=>substr(strtolower($req->name), 0, 3).'-'.str_pad($req->id, 3, "0", STR_PAD_LEFT),
							'company_id' => $user->company_id,
							'name' => $req->name,
							'user_id' => $req->id,
							'email' => $req->email,
							'created_at' => $carbon
						]);
					}

			    }


				DB::commit();
				$fileName ? $req->photo->move(public_path('uploads/photo'), $fileName) : '';
				return res_msg('User updated successfully!', 200);

			} catch (\Throwable $e) {
				return response(['msg' => 'Wrong data entry'], 422);
				DB::rollback();
			}

		} else if ($name == 'delete_user_data') {

			$user = model('User')::find($req->id);

			$employee = model('Employee')::where('user_id',$req->id)->first();
			model('EmployeeSalaryHistory')::where('employee_id',$employee->id)->delete();

			$employee->delete();
			$user->delete();

			return res_msg('User deleted successfully!', 200);
		} else if($name == 'store_product_category_data'){

			$validator= Validator::make($req->all(), [
				'name' => 'required',
			], [
				'name.required' => 'Category name is required',
            ]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			model('ProductCategory')::create([
				'name' => $req->name,
				'company_id' => $user->company_id,
				'active' => $req->active == 'true' ? 1 : 0,
				'creator_id' => $user->id,
			]);

			return res_msg('Product category inserted successfully!', 200);
		} else if($name == 'update_product_category_data'){

			$validator= Validator::make($req->all(), [
				'name'=>'required',
			], [
				'name.required' => 'Category name is required',
            ]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			$ProductCategory = model('ProductCategory')::find($req->id);
			$ProductCategory->update([
				'name' => $req->name,
				'active' => $req->active == 'true' ? 1 : 0,
				'editor_id' => $user->id,
				'updated_at' => $carbon,
			]);

			return res_msg('Product category updated successfully!', 200);
		} else if ($name == 'delete_product_category_data') {

			$ProductCategory = model('ProductCategory')::find($req->id);

			$ProductCategory->delete();

			return res_msg('Product category deleted successfully!', 200);
		} else if ($name == 'store_company_data') {
			$validator = Validator::make($req->all(), [
				'name' => 'required|unique:companies,name',
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			// return $req->all();

			DB::beginTransaction();

			try {
				$fileName = '';

				if ($req->file('logo')) {
					$fileName = 'logo-' . time() . '.' . $req->logo->extension();

					$req->logo->move(public_path('uploads/logo'), $fileName);
				}

				model('Company')::create([
					'name' => $req->name,
					'title' => $req->title,
					'logo' => $fileName,
					'address' => $req->address,
					'number_of_employees' => $req->number_of_employees,
					'description' => $req->description,
					'creator_id' => $user->id,
					'created_at' => Carbon::now(),
				]);

				DB::commit();
				return res_msg('Company created successfully!', 200);
			} catch (\Throwable $e) {
				return response(['msg' => 'Wrong data entry'], 422);
				DB::rollback();
			}
		} else if ($name == 'update_company_data') {

			$validator = Validator::make($req->all(), [
				'id' => 'required',
				'name' => 'required|unique:companies,name,' . $req->id
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			DB::beginTransaction();

			try {
				$company = model('Company')::find($req->id);

				if ($company->logo != NULL && file_exists(public_path('uploads/logo/'.$company->logo)) && $req->file('logo')) {
					unlink(public_path('uploads/logo/'.$company->logo));
				}

				$fileName = NULL;

				if ($req->file('logo')) {
					$fileName = 'logo-' . time() . '.' . $req->logo->extension();

					$req->logo->move(public_path('uploads/logo'), $fileName);
				}

				model('Company')::where('id', $req->id)->update([
					'name' => $req->name,
					'title' => $req->title,
					'title' => $req->title,
					'logo' => $fileName ? $fileName : $company->logo,
					'address' => $req->address,
					'number_of_employees' => $req->number_of_employees,
					'description' => $req->description,
					'editor_id' => $user->id,
					'updated_at' => Carbon::now()
				]);
				DB::commit();

				return res_msg('Company updated successfully!', 200);
			} catch (\Throwable $e) {
				return response(['msg' => 'Wrong data entry'], 422);
				DB::rollback();
			}
		} else if($name == 'delete_company_data'){
			$company = model('Company')::find($req->id);
			$company->delete();
			return res_msg('Company deleted successfully!', 200);
		} else if ($name == 'store_company_bank_data') {
			$validator = Validator::make($req->all(), [
				'bank_name' => 'required|unique:company_bank_infos,bank_name',
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			// return $req->all();

			model('CompanyBankInfo')::create([
				'company_id' => $user->company_id,
				'bank_name' => $req->bank_name,
				'branch_name' => $req->branch_name,
				'account_name' => $req->account_name,
				'account_number' => $req->account_number,
				'routing_number' => $req->routing_number,
				'swift_code' => $req->swift_code,
				'address' => $req->address,
				'details' => $req->details,
				'status' => $req->status == 'false' ? 0 : 1,
				'created_by' => $user->id,
				'created_at' => Carbon::now(),
			]);

			return res_msg('Company created successfully!', 200);

		} else if ($name == 'update_company_bank_data') {

			$validator = Validator::make($req->all(), [
				'id' => 'required',
				'bank_name' => 'required|unique:company_bank_infos,bank_name,' . $req->id
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			model('CompanyBankInfo')::where('id', $req->id)->update([
				'company_id' => $user->company_id,
				'bank_name' => $req->bank_name,
				'branch_name' => $req->branch_name,
				'account_name' => $req->account_name,
				'account_number' => $req->account_number,
				'routing_number' => $req->routing_number,
				'swift_code' => $req->swift_code,
				'address' => $req->address,
				'details' => $req->details,
				'status' => $req->status == 'false' ? 0 : 1,
				'updated_by' => $user->id,
				'updated_at' => Carbon::now()
			]);

			return res_msg('Company bank info updated successfully!', 200);

		} else if($name == 'delete_company_bank_data'){
			$company = model('CompanyBankInfo')::find($req->id);
			$company->delete();
			return res_msg('Company bank deleted successfully!', 200);

		} else if($name == 'store_product_unit_data'){

			$validator= Validator::make($req->all(), [
				'name'=>'required',
			], [
				'name.required' => 'Unit name is required',
            ]);

			if($validator->fails()){
				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);
			}

			model('ProductUnit')::create([
				'name' => $req->name,
				'company_id' => $user->company_id,
				'active' => $req->active == 'true' ? 1 : 0,
				'creator_id' => $user->id,
			]);

			return res_msg('Product unit inserted successfully!', 200);

		} else if($name == 'update_product_unit_data'){

			$validator= Validator::make($req->all(), [
				'name'=>'required',
			], [
				'name.required' => 'Unit name is required',
            ]);

			if($validator->fails()){
				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);
			}

			$ProductUnit = model('ProductUnit')::find($req->id);
			$ProductUnit->update([
				'name' => $req->name,
				'company_id' => $user->company_id,
				'active' => $req->active == 'true' ? 1 : 0,
				'editor_id' => $user->id,
				'updated_at' => $carbon,
			]);

			return res_msg('Product unit updated successfully!', 200);

		} else if($name == 'delete_product_unit_data'){

			$ProductUnit = model('ProductUnit')::find($req->id);

			$ProductUnit->delete();

			return res_msg('Product unit deleted successfully!', 200);

		} else if($name == 'store_product_color_data'){

			$validator= Validator::make($req->all(), [
				'name'=>'required',
			], [
				'name.required' => 'Color name is required',
            ]);

			if($validator->fails()){
				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);
			}

			model('ProductColor')::create([
				'name' => $req->name,
				'company_id' => $user->company_id,
				'active' => $req->active == 'true' ? 1 : 0,
				'creator_id' => $user->id,
			]);

			return res_msg('Product color inserted successfully!', 200);

		} else if($name == 'update_product_color_data'){

			$validator= Validator::make($req->all(), [
				'name'=>'required',
			], [
				'name.required' => 'Color name is required',
            ]);

			if($validator->fails()){
				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);
			}

			$ProductColor = model('ProductColor')::find($req->id);
			$ProductColor->update([
				'name' => $req->name,
				'active' => $req->active == 'true' ? 1 : 0,
				'editor_id' => $user->id,
				'updated_at' => $carbon,
			]);

			return res_msg('Product color updated successfully!', 200);

		} else if($name == 'delete_product_color_data'){

			$ProductColor = model('ProductColor')::find($req->id);

			$ProductColor->delete();

			return res_msg('Product color deleted successfully!', 200);

		} else if($name == 'store_product_type_data'){

			$validator= Validator::make($req->all(), [
				'name'=>'required',
			], [
				'name.required' => 'Type name is required',
            ]);

			if($validator->fails()){
				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);
			}

			model('ProductType')::create([
				'name' => $req->name,
				'company_id' => $user->company_id,
				'active' => $req->active == 'true' ? 1 : 0,
				'creator_id' => $user->id,
			]);

			return res_msg('Product type inserted successfully!', 200);

		} else if($name == 'update_product_type_data'){

			$validator= Validator::make($req->all(), [
				'name'=>'required',
			], [
				'name.required' => 'Type name is required',
            ]);

			if($validator->fails()){
				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);
			}

			$ProductType = model('ProductType')::find($req->id);
			$ProductType->update([
				'name' => $req->name,
				'active' => $req->active == 'true' ? 1 : 0,
				'editor_id' => $user->id,
				'updated_at' => $carbon,
			]);

			return res_msg('Product type updated successfully!', 200);

		} else if($name == 'delete_product_type_data'){

			$ProductType = model('ProductType')::find($req->id);

			$ProductType->delete();

			return res_msg('Product type deleted successfully!', 200);
		}else if($name == "store_employee_data"){
            $validator = Validator::make($req->all(), [
				'name' => 'required'
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			DB::beginTransaction();

			try {

				$fileName = NULL;

				if ($req->file('photo')) {
					$fileName = 'emp-' . time() . '.' . $req->photo->extension();
				}

				$data = model('Employee')::create([
					'company_id' => $user->company_id,
					'name' => $req->name,
					'email' => $req->email,
					'phone1' => $req->phone1,
					'phone2' => $req->phone2,
					'present_address' => $req->present_address,
					'permanent_address' => $req->permanent_address,
					'dob' => $req->dob,
					'nid' => $req->nid,
					'gender' => $req->gender,
					'religion' => $req->religion,
					'current_salary' => $req->current_salary,
					'designation_id' => $req->designation_id,
					'joining_date'=>$req->joining_date,
					'photo'=>$fileName ? $fileName : NULL,
					'active' => $req->active == 'false' ? 0 : 1,
					'created_at' => Carbon::now()
				]);

				model('Employee')::where('id', $data->id)->update([
					'employee_code'=>substr(strtolower($req->name), 0, 3).'-'.str_pad($data->id, 3, "0", STR_PAD_LEFT)
				]);

				model('EmployeeSalaryHistory')::create([
					'company_id' => $user->company_id,
					'employee_id' => $data->id,
					'salary' => $req->current_salary,
					'start_date'=>$req->joining_date,
					'active' => $req->active == 'false' ? 0 : 1,
					'created_at' => Carbon::now()
				]);

				DB::commit();

				$fileName ? $req->photo->move(public_path('uploads/photo'), $fileName) : '';

				return res_msg('Employee created successfully!', 200);
			} catch (\Throwable $e) {
				DB::rollback();
				return response(['msg' => 'Wrong data entry'], 422);
			}
		}else if($name == "update_employee_data"){

            $validator = Validator::make($req->all(), [
				'id' => 'required',
				'name' => 'required'
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

            // info($req->all());

			DB::beginTransaction();

			try {
                $Employee = model('Employee')::find($req->id);

				if ($Employee->photo != NULL && file_exists(public_path('uploads/photo/'.$Employee->photo)) && $req->file('photo')) {
					unlink(public_path('uploads/photo/'.$Employee->photo));
				}

				$fileName = NULL;

				if ($req->file('photo')) {
					$fileName = 'emp-' . time() . '.' . $req->photo->extension();
				}

				$data = $Employee->update([
					'name' => $req->name,
					'email' => $req->email,
					'phone1' => $req->phone1,
					'phone2' => $req->phone2,
					'present_address' => $req->present_address,
					'permanent_address' => $req->permanent_address,
					'dob' => $req->dob == 'null' ? NULL : new Carbon($req->dob),
					'nid' => $req->nid,
					'gender' => $req->gender,
					'religion' => $req->religion,
					'designation_id' => $req->designation_id == 'null' ? NULL : $req->designation_id,
					'joining_date' => $req->joining_date == 'null' ? NULL : new Carbon($req->joining_date),
					// 'photo'=>$fileName ? $fileName : NULL,
					'active' => $req->active == 'false' ? 0 : 1,
					'updated_at' => Carbon::now()
				]);


				DB::commit();

				$fileName ? $req->photo->move(public_path('uploads/photo'), $fileName) : '';

				return res_msg('Employee updated successfully!', 200);
			} catch (\Throwable $e) {
				// return response(['msg' => 'Wrong data entry'], 422);
				return response(['msg' => $e->errorInfo], 422);
				DB::rollback();
			}
		} else if($name == 'delete_employee_data'){

			$employee = model('Employee')::find($req->id);

			model('EmployeeSalaryHistory')::where('employee_id',$req->id)->delete();

			$employee->delete();

			return res_msg('Employee deleted successfully!', 200);
		} else if ($name == 'store_customer_data') {

			$validator = Validator::make($req->all(), [
				'name' => 'required',
				'phone' => 'required',
			]);

            if ($req->email) {
                $validator = Validator::make($req->all(), [
                    'email' => 'email|unique:customers,email'
                ]);
            }

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			DB::beginTransaction();

			try {

				$data = model('Customer')::create([
					'company_id' => $user->company_id,
					'name' => $req->name,
					'email' => $req->email,
					'phone' => $req->phone,
					'address' => $req->address,
					'website' => $req->website,
					'is_active' => $req->is_active == 'false' ? 0 : 1,
					'creator_id' => $user->id,
					'created_at' => $carbon,
				]);

				DB::commit();

				return res_msg('Customer inserted successfully!', 200);

			} catch (\Throwable $e) {
				return response(['msg' => 'Wrong data entry'], 422);
				DB::rollback();
			}

		} else if ($name == 'update_customer_data') {

            $validator = Validator::make($req->all(), [
				'name' => 'required',
				'phone' => 'required',
			]);

            if ($req->email) {
                $validator = Validator::make($req->all(), [
                    'email' => 'email|unique:customers,email,' . $req->id,
                ]);
            }

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}


			DB::beginTransaction();

			try {

				model('Customer')::where('id', $req->id)->update([
					'name' => $req->name,
					'email' => $req->email,
					'phone' => $req->phone,
					'address' => $req->address,
					'website' => $req->website,
					'is_active' => $req->is_active == 'false' ? 0 : 1,
					'updated_at' => Carbon::now()
				]);

				DB::commit();

				return res_msg('Customer updated successfully!', 200);

			} catch (\Throwable $e) {
				return response(['msg' => 'Wrong data entry'], 422);
				DB::rollback();
			}

		} else if ($name == 'delete_customer_data') {

			$customer = model('Customer')::find($req->id);
			$customer->delete();

			return res_msg('Customer deleted successfully!', 200);
		} else if($name == 'update_attendance'){

			$data = model('EmployeeAttendance')::where(['company_id' => $req->company_id, 'employee_id'=> $req->id])->whereDate('date', Carbon::today())->first();

			if($data){

                $data->present = $req->present == 'Present' ? 'Yes' : 'No';
                $data->editor_id = $user->id;
                $data->updated_at = Carbon::now();
				$data->update();
			}

			return res_msg('Attendance updated successfully!', 200);
		} else if ($name == 'store_product_invoice_data') {

			$validator = Validator::make($req->all(), [
				'invoice_date' => 'required',
				// 'due_date' => 'required',
				'payment_status_id' => 'required',
				'sub_total' => 'required',
				'total_payable_amount' => 'required',
				'details.*' => 'array',
				'details.*product_stock_id' => 'required',
				'details.*price' => 'required',
				'details.*quantity' => 'required',
				'details.*amount' => 'required',
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

            $customer_id = $req->customer_id;

            if (empty($req->customer_id)) {

                $customer = model('Customer')::create([
					'company_id' => $user->company_id,
					'name' => $req->customer_name,
					'email' => $req->email,
					'phone' => $req->phone,
					'is_active' => 1,
					'creator_id' => $user->id,
					'created_at' => $carbon,
				]);

                $customer_id = $customer->id;
            }

			$productInvoice = model('ProductInvoice')::create([
				'company_id' => $user->company_id,
				'invoice_code' => $req->invoice_code ? $req->invoice_code : rand(10000,1000000),
				'customer_id' => $customer_id,
				'invoice_date' => new Carbon($req->invoice_date),
				'due_date' => new Carbon($req->due_date),
				'notes' => $req->notes,
				'po_no' => $req->po_no,
				'payment_status_id' => $req->payment_status_id,
				'sub_total' => $req->sub_total,
				'discount_percentage' => $req->discount_percentage,
				'discount_amount' => $req->discount_amount,
				'vat_percentage' => $req->vat_percentage,
				'vat_amount' => $req->vat_amount,
				'tax_percentage' => $req->tax_percentage,
				'tax_amount' => $req->tax_amount,
				'total_payable_amount' => $req->total_payable_amount,
				'paid_amount' => $req->paid_amount,
				'due_amount' => $req->due_amount,
				'creator_id' => $user->id,
            ]);

            foreach($req->details as $item) {

                $productStock = model('ProductStock')::find($item['product_stock_id']);

                $benefit_per_product = $item['price'] - $productStock->price;
                if($benefit_per_product > -1) {
                    $benefit_amount = $benefit_per_product * $item['quantity'];
                } else {
                    $benefit_amount = 0.00;
                }

                $loss_per_product = $productStock->price - $item['price'];

                if($loss_per_product > -1) {
                    $loss_amount = $loss_per_product * $item['quantity'];
                } else {
                    $loss_amount = 0.00;
                }

                model('ProductInvoiceDetail')::create([
                    'product_invoice_id' => $productInvoice->id,
                    'product_stock_id' => $item['product_stock_id'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'amount' => $item['amount'],
                    'benefit_per_product' => $benefit_per_product > -1 ? $benefit_per_product : NULL,
                    'benefit_amount' => $benefit_amount,
                    'loss_per_product' => $loss_per_product > -1 ? $loss_per_product : NULL,
                    'loss_amount' => $loss_amount,
                ]);
            }

			return res_msg('Product invoice saved successfully!', 200);

		} else if ($name == 'update_product_invoice_data') {

			$validator = Validator::make($req->all(), [
				'invoice_date' => 'required',
				// 'due_date' => 'required',
				'payment_status_id' => 'required',
				'sub_total' => 'required',
				'total_payable_amount' => 'required',
				'details.*' => 'array',
				'details.*product_stock_id' => 'required',
				'details.*price' => 'required',
				'details.*quantity' => 'required',
				'details.*amount' => 'required',
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

            $customer_id = $req->customer_id;

            if (empty($req->customer_id)) {

                $customer = model('Customer')::create([
					'company_id' => $user->company_id,
					'name' => $req->customer_name,
					'email' => $req->email,
					'phone' => $req->phone,
					'is_active' => 1,
					'creator_id' => $user->id,
					'created_at' => $carbon,
				]);

                $customer_id = $customer->id;
            }

			$productInvoice = model('ProductInvoice')::find($req->id);

            if ($productInvoice) {

                $productInvoice->update([
                    'customer_id' => $customer_id,
                    'invoice_date' => new Carbon($req->invoice_date),
                    'due_date' => new Carbon($req->due_date),
                    'notes' => $req->notes,
                    'po_no' => $req->po_no,
                    'payment_status_id' => $req->payment_status_id,
                    'sub_total' => $req->sub_total,
                    'discount_percentage' => $req->discount_percentage,
                    'discount_amount' => $req->discount_amount,
                    'vat_percentage' => $req->vat_percentage,
                    'vat_amount' => $req->vat_amount,
                    'tax_percentage' => $req->tax_percentage,
                    'tax_amount' => $req->tax_amount,
                    'total_payable_amount' => $req->total_payable_amount,
                    'paid_amount' => $req->paid_amount,
                    'due_amount' => $req->due_amount,
                    'editor_id' => $user->id,
                ]);

                model('ProductInvoiceDetail')::where([
                    'product_invoice_id' => $productInvoice->id,
                ])->delete();

                foreach($req->details as $item) {

                    model('ProductInvoiceDetail')::create([
                        'product_invoice_id' => $productInvoice->id,
                        'product_stock_id' => $item['product_stock_id'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'amount' => $item['amount'],
                    ]);
                }

            }

			return res_msg('Product invoice saved successfully!', 200);

		} else if ($name == 'delete_product_invoice_data') {

			$productInvoice = model('ProductInvoice')::find($req->id);

            if ($productInvoice) {

                model('ProductInvoiceDetail')::where([
                    'product_invoice_id' => $productInvoice->id,
                ])->delete();

                $productInvoice->delete();
            }

			return res_msg('Product invoice deleted successfully!', 200);

		} else if ($name == 'store_product_invoice_payment_data') {

			$validator= Validator::make($req->all(), [
                'product_invoice_id'=>'required',
                'paid_amount'=>'required',
                'payment_status_id'=>'required',
            ]);

			if($validator->fails()){
                $errors=$validator->errors()->all();
                return response(['msg'=>$errors[0]], 422);
            }

			$productInvoice = model('ProductInvoice')::find($req->product_invoice_id);

            if ($req->paid_amount > 0) {

                $PaymentHistory = model('ProductInvoicePaymentHistory')::create([
                    'product_invoice_id' => $productInvoice->id,
                    'paid_amount' => $req->paid_amount,
                    'creator_id' => $user->id,
                ]);

                $productInvoice->paid_amount = $productInvoice->paid_amount + $PaymentHistory->paid_amount;
                $productInvoice->due_amount = $productInvoice->total_payable_amount - $productInvoice->paid_amount;

            }

            $productInvoice->payment_status_id = $req->payment_status_id;
            $productInvoice->save();

			return res_msg("Invoice payment added successfully", 200);

		}else if($name == "update_holiday_data"){
			$validator = Validator::make($req->all(), [
				'name' => 'required',
				'from' => 'required'
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			$diff = 0;

			if($req->from && $req->to){
				$from = explode('-', $req->from);
				$to = explode('-', $req->to);

				$total = $to[2] - $from[2];
				$diff = $total == 0 ? $total+1 : $total+1;
			}

			$holidays = model('Holiday')::where('id', $req->id)->update([
				'name'=>$req->name,
				'from'=> $req->from,
				'to'=> $req->to,
				'total'=>$diff == 0 ? 1 : $diff,
				'editor_id'=>$user->id
			]);

			return res_msg('Holiday update successfully', 200, []);
		}else if($name == "store_holiday_data"){
			$validator = Validator::make($req->all(), [
				'name' => 'required',
				'from' => 'required'
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			$diff = 0;

			if($req->from && $req->to){
				$from = explode('-', $req->from);
				$to = explode('-', $req->to);

				$total = $to[2] - $from[2];
				$diff = $total == 0 ? $total+1 : $total+1;
			}

			$holidays = model('Holiday')::create([
				'name'=>$req->name,
				'from'=> $req->from,
				'to'=> $req->to,
				'total'=>$diff == 0 ? 1 : $diff,
				'creator_id'=>$user->id
			]);


			return res_msg('Holiday create successfully', 200, []);
		}else if($name == 'delete_holiday_data'){
			model('Holiday')::where('id', $req->id)->delete();
			return res_msg('Holiday deleted successfully', 200, []);
		}
		else if($name == 'delete_attendance_data'){
			model('EmployeeAttendance')::where('id', $req->id)->delete();
			return res_msg('Attendance deleted successfully', 200, []);
		}

		return response(['msg' => 'Sorry!, found no named argument.'], 403);
	}
}
