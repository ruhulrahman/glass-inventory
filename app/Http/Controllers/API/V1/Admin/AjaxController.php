<?php

namespace App\Http\Controllers\API\V1\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

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

			$list = model('Department')::with('parent')->paginate($default_per_page);

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_department_list') {

			$list = model('Department')::with('parent')->get();

			foreach ($list as $item) {
				$item->value = $item->id;
				$item->label = $item->name;
			}

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_designation_list') {

			$list = model('Designation')::with('department')->get();

			foreach ($list as $item) {
				$item->value = $item->id;
				$item->label = $item->name;
			}

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_supplier_list_with_pagination') {

			$list = model('Supplier')::paginate($default_per_page);

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_supplier_list') {

			$list = model('Supplier')::get();

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_product_list_with_pagination') {

			$list = model('Product')::with('supplier', 'category')->paginate($default_per_page);

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_product_list') {

			$list = model('Product')::with('supplier', 'category')->get();

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_user_list_with_pagination') {

			$list = model('User')::paginate($default_per_page);

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_user_list') {

			$list = model('User')::get();

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_product_category_list_with_pagination') {

			$list = model('ProductCategory')::paginate($default_per_page);

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_product_category_list') {

			$list = model('ProductCategory')::get();

			return res_msg('list Data', 200, [
				'data' => $list
			]);
		} else if ($name == 'get_company_list') {
			$companies = model('Company')::query()->orderBy('id','desc')->get();
			return res_msg('list Data', 200, [
				'data' => $companies
			]);
		 }else if ($name == 'get_company_bank_list') {
			$banks = model('CompanyBankInfo')::query()->orderBy('id','desc')->get();
			return res_msg('list Data', 200, [
				'data' => $banks
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
				'email' => 'required|email|unique:suppliers,email',
				'address' => 'required',
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
				'name' => $req->name,
				'email' => $req->email,
				'address' => $req->address,
				'phone1' => $req->phone1,
				'phone2' => $req->phone2,
				'note' => $req->note,
			]);

			return res_msg('Supplier inserted successfully!', 200);
		} else if ($name == 'update_supplier_data') {

			$validator = Validator::make($req->all(), [
				'name' => 'required',
				'email' => 'required|email|unique:suppliers,email,' . $req->id,
				'address' => 'required',
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
			]);

			return res_msg('Supplier updated successfully!', 200);
		} else if ($name == 'delete_supplier_data') {

			$supplier = model('Supplier')::find($req->id);

			$supplier->delete();

			return res_msg('Supplier deleted successfully!', 200);
		} else if ($name == 'store_product_data') {

			$validator = Validator::make($req->all(), [
				'name' => 'required',
				'price' => 'required|numeric',
				'cost' => 'required|numeric',
				'category_id' => 'required',
				'supplier_id' => 'required',
				'product_code' => 'required',
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			model('Product')::create([
				'name' => $req->name,
				'price' => $req->price,
				'cost' => $req->cost,
				'in_stock' => $req->in_stock,
				'min_stock' => $req->min_stock,
				'category_id' => $req->category_id,
				'supplier_id' => $req->supplier_id,
				'product_code' => $req->product_code,
				'last_sale' => $carbon,
				'company_id' => $user->company_id,
				'creator_id' => $user->id,
			]);

			return res_msg('Product inserted successfully!', 200);
		} else if ($name == 'update_product_data') {

			$validator = Validator::make($req->all(), [
				'name' => 'required',
				'price' => 'required|numeric',
				'cost' => 'required|numeric',
				'category_id' => 'required',
				'supplier_id' => 'required',
				'product_code' => 'required',
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			$product = model('Product')::find($req->id);

			$product->update([
				'name' => $req->name,
				'price' => $req->price,
				'cost' => $req->cost,
				'in_stock' => $req->in_stock,
				'min_stock' => $req->min_stock,
				'category_id' => $req->category_id,
				'supplier_id' => $req->supplier_id,
				'product_code' => $req->product_code,
				'last_sale' => $carbon,
				'editor_id' => $user->id,
			]);

			return res_msg('Product updated successfully!', 200);
		} else if ($name == 'delete_product_data') {

			$product = model('Product')::find($req->id);

			$product->delete();

			return res_msg('Product deleted successfully!', 200);
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

					$req->photo->move(public_path('uploads/photo'), $fileName);
				}

				model('User')::create([
					'name' => $req->name,
					'username' => $req->username,
					'email' => $req->email,
					'photo' => $fileName,
					'user_type' => $req->user_type,
					'is_employee' => $req->is_employee == 'false' ? 0 : 1,
					'created_at' => $carbon,
				]);
	
				
				DB::commit();
				return res_msg('User inserted successfully!', 200);

			} catch (\Throwable $e) {
				return response(['msg' => str_ireplace("Method Illuminate\Http\Request::", "", $e->getMessage())], 422);
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
				$user = model('User')::find($req->id);

				if ($user->photo != NULL && file_exists(public_path('uploads/photo/'.$user->photo)) && $req->file('photo')) {
					unlink(public_path('uploads/photo/'.$user->photo));
				}

				$fileName = NULL;

				if ($req->file('photo')) {
					$fileName = 'photo-' . time() . '.' . $req->photo->extension();

					$req->photo->move(public_path('uploads/photo'), $fileName);
				}

				model('User')::where('id', $req->id)->update([
					'name' => $req->name,
					'username' => $req->username,
					'email' => $req->email,
					'photo' => $fileName ? $fileName : $user->photo,
					'user_type' => $req->user_type,
					'is_employee' => $req->is_employee == 'false' ? 0 : 1,
					'created_at' => Carbon::now()
					
				]);
				DB::commit();
				return res_msg('User updated successfully!', 200);

			} catch (\Throwable $e) {
				return response(['msg' => str_ireplace("Method Illuminate\Http\Request::", "", $e->getMessage())], 422);
				DB::rollback();
			}

		} else if ($name == 'delete_user_data') {

			$user = model('User')::find($req->id);

			$user->delete();

			return res_msg('User deleted successfully!', 200);
		} else if ($name == 'store_product_category_data') {

			$validator = Validator::make($req->all(), [
				'name' => 'required',
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			model('ProductCategory')::create([
				'category_name' => $req->category_name,
				'company_id' => $user->company_id,
				'creator_id' => $user->id,
			]);

			return res_msg('Product category inserted successfully!', 200);
		} else if ($name == 'update_product_category_data') {

			$validator = Validator::make($req->all(), [
				'name' => 'required',
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			$ProductCategory = model('ProductCategory')::find($req->id);
			$ProductCategory->update([
				'category_name' => $req->category_name,
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
				return response(['msg' => str_ireplace("Method Illuminate\Http\Request::", "", $e->getMessage())], 422);
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
				return response(['msg' => str_ireplace("Method Illuminate\Http\Request::", "", $e->getMessage())], 422);
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
		}

		return response(['msg' => 'Sorry!, found no named argument.'], 403);
	}
}
