<?php

namespace App\Http\Controllers\API\V1\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AjaxController extends Controller
{
    public function get(Request $req, $name)
    {
        $user= Auth::user();
		$data['user']=$user;
		$default_per_page = 10;
		$carbon = new Carbon();

        if($name == 'get_auth_user'){

            $auth_user = model('User')::find($user->id);

			return res_msg('Auth User Data', 200, [
				'auth_user' => $auth_user
			]);

		} else if($name=="get_statuses_with_groups"){

			return res_msg('Statuses and status group list', 200, [
				'status_groups'=>model('StatusGroup')::with('statuses')->get(),
				'statuses'=>model('Status')::with('group')->orderBy('serial', 'asc')->get()
			]);

		} else if($name == 'get_department_list_with_pagination'){

            $list = model('Department')::with('parent')->paginate($default_per_page);

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		} else if($name == 'get_department_list'){

            $list = model('Department')::with('parent')->get();

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		} else if($name == 'get_supplier_list_with_pagination'){

            $list = model('Supplier')::paginate($default_per_page);

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		} else if($name == 'get_supplier_list'){

            $list = model('Supplier')::get();

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		} else if($name == 'get_product_list_with_pagination'){

            $list = model('Product')::with('supplier', 'category')->paginate($default_per_page);

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		} else if($name == 'get_product_list'){

            $list = model('Product')::with('supplier', 'category')->get();

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		} else if($name == 'get_user_list_with_pagination'){

            $list = model('User')::paginate($default_per_page);

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		} else if($name == 'get_user_list'){

            $list = model('User')::get();

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		} else if($name == 'get_product_category_list_with_pagination'){

            $list = model('ProductCategory')::paginate($default_per_page);

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		} else if($name == 'get_product_category_list'){

            $list = model('ProductCategory')::get();

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		}

		return response(['msg'=>'Sorry!, found no named argument.'], 403);
    }



	// Post functions are here .............
    public function post(Request $req, $name)
    {
        $user= Auth::user();
		$data['user']=$user;
		$carbon = new Carbon();

		if($name == 'store_department_data'){

			$validator= Validator::make($req->all(), [
				'name'=>'required',
				'vat_group_id'=>'required',
			]);

			if($validator->fails()){
				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);
			}

			model('Department')::create([
				'company_id' => $user->company_id,
				'name' => $req->name,
				'parent_id' => $req->parent_id,
				'creator_id' => $user->id,
				'active' => 1,
				'created_at' => Carbon::now(),
			]);

			return res_msg('Department inserted successfully!', 200);

		} else if($name == 'update_department_data'){

			$validator= Validator::make($req->all(), [
				'name'=>'required',
				'vat_group_id'=>'required',
			]);

			if($validator->fails()){
				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);
			}

			$department = model('Department')::find($req->id);

			$department->update([
				'name' => $req->name,
				'parent_id' => $req->parent_id,
				'editor_id' => $user->id,
				'active' => $req->active,
				'created_at' => Carbon::now(),
			]);

			return res_msg('Department updated successfully!', 200);

		} else if($name == 'delete_department_data'){

			$department = model('Department')::find($req->id);

			$department->delete();

			return res_msg('Department deleted successfully!', 200);

		} else if($name == 'department_active_status_change'){

			$department = model('Department')::find($req->id);

			if ($department) {
				$department->active = !$department->active;
				$department->save();
			}

			return res_msg('Department active status updated successfully!', 200);

		} else if($name == 'store_supplier_data'){

			$validator= Validator::make($req->all(), [
				'name'=>'required',
				'email'=>'required|email|unique:suppliers,email',
				'address'=>'required',
				'phone1'=>'required|numeric',
			],[
				'phone1.required' => 'The Phone field is required',
				'phone1.numeric' => 'The Phone must be number',
			]);

			if ($req->phone2) {
				$validator= Validator::make($req->all(), [
					'phone2'=>'numeric',
				],[
					'phone2.numeric' => 'The Alternative Phone must be number',
				]);

			}

			if($validator->fails()){
				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);
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

		} else if($name == 'update_supplier_data'){

			$validator= Validator::make($req->all(), [
				'name'=>'required',
				'email'=>'required|email|unique:suppliers,email,'.$req->id,
				'address'=>'required',
				'phone1'=>'required|numeric',
			],[
				'phone1.required' => 'The Phone field is required',
				'phone1.numeric' => 'The Phone must be number',
			]);

			if ($req->phone2) {
				$validator= Validator::make($req->all(), [
					'phone2'=>'numeric',
				],[
					'phone2.numeric' => 'The Alternative Phone must be number',
				]);

			}

			if($validator->fails()){
				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);
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

		} else if($name == 'delete_supplier_data'){

			$supplier = model('Supplier')::find($req->id);

			$supplier->delete();

			return res_msg('Supplier deleted successfully!', 200);

		} else if($name == 'store_product_data'){

			$validator= Validator::make($req->all(), [
				'name'=>'required',
				'price'=>'required|numeric',
				'cost'=>'required|numeric',
				'category_id'=>'required',
				'supplier_id'=>'required',
				'product_code'=>'required',
			]);

			if($validator->fails()){
				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);
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

		} else if($name == 'update_product_data'){

			$validator= Validator::make($req->all(), [
				'name'=>'required',
				'price'=>'required|numeric',
				'cost'=>'required|numeric',
				'category_id'=>'required',
				'supplier_id'=>'required',
				'product_code'=>'required',
			]);

			if($validator->fails()){
				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);
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

		} else if($name == 'delete_product_data'){

			$product = model('Product')::find($req->id);

			$product->delete();

			return res_msg('Product deleted successfully!', 200);

		} else if($name == 'store_user_data'){

			$validator= Validator::make($req->all(), [
				'name'=>'required',
				'email'=>'required|email|unique:users,email',
				'mobile'=>'required|numeric',
				'password'=>'required|string|min:8',
				'user_type'=>'required',
				// 'password'=>'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
			]);

			if($validator->fails()){
				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);
			}

			model('User')::create([
				'name' => $req->name,
				'username' => $req->username,
				'email' => $req->email,
				'phone' => $req->phone,
				'mobile' => $req->mobile,
				'address' => $req->address,
				'password' => bcrypt($req->password),
				'user_type' => $req->user_type,
				'manager' => $req->manager == 'true' || $req->manager == 1 ? 1 : 0,
				'created_at' => $carbon,
			]);

			return res_msg('User inserted successfully!', 200);

		} else if($name == 'update_user_data'){

			$validator= Validator::make($req->all(), [
				'name'=>'required',
				'email'=>'required|email|unique:users,email,'.$req->id,
				'mobile'=>'required|numeric',
				'user_type'=>'required',
				// 'password'=>'required|string|min:8',
				// 'password'=>'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
			]);

			if($validator->fails()){
				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);
			}

			$user = model('User')::find($req->id);
			$user->update([
				'name' => $req->name,
				'username' => $req->username,
				'email' => $req->email,
				'phone' => $req->phone,
				'mobile' => $req->mobile,
				'address' => $req->address,
				// 'password' => bcrypt($req->password),
				'user_type' => $req->user_type,
				'manager' => $req->manager == 'true' || $req->manager == 1 ? 1 : 0,
			]);

			return res_msg('User updated successfully!', 200);

		} else if($name == 'delete_user_data'){

			$user = model('User')::find($req->id);

			$user->delete();

			return res_msg('User deleted successfully!', 200);

		} else if($name == 'store_product_category_data'){

			$validator= Validator::make($req->all(), [
				'name'=>'required',
			]);

			if($validator->fails()){
				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);
			}

			model('ProductCategory')::create([
				'category_name' => $req->category_name,
				'company_id' => $user->company_id,
				'creator_id' => $user->id,
			]);

			return res_msg('Product category inserted successfully!', 200);

		} else if($name == 'update_product_category_data'){

			$validator= Validator::make($req->all(), [
				'name'=>'required',
			]);

			if($validator->fails()){
				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);
			}

			$ProductCategory = model('ProductCategory')::find($req->id);
			$ProductCategory->update([
				'category_name' => $req->category_name,
				'editor_id' => $user->id,
				'updated_at' => $carbon,
			]);

			return res_msg('Product category updated successfully!', 200);

		} else if($name == 'delete_product_category_data'){

			$ProductCategory = model('ProductCategory')::find($req->id);

			$ProductCategory->delete();

			return res_msg('Product category deleted successfully!', 200);

		}

		return response(['msg'=>'Sorry!, found no named argument.'], 403);
    }
}
