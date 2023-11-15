<?php

namespace App\Http\Controllers\API\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
	public function sign_up(Request $req){

		$v=validate_ajax([
			'name'=>'required',
			'username'=>'required|unique:users',
			'email'=>'required|email|unique:users',
			'password'=>'required|string|min:8',
			// 'password'=>'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
		]);

		if($v->error) return $v->msg;

		$user= model('User')::create([
			'name'=>$req->name,
			'username'=>$req->username,
			'email'=>$req->email,
			'password'=>bcrypt($req->password),
			'user_type'=> 'admin'
		]);

		// Mail::to($req->email)->send(new EmailVerificationLink($user));

		return res_msg(
			'Account created successfully!'
		);

		// return res_msg(
		// 	'Account created successfully!, please verify your email address.'
		// );

	}

	public function verify_email(Request $req){

		if(empty($req->token)){
			return res_msg('Sorry, invalid email verification token.', 403);
		}

		$hash_ids=new Hashids('email_verification_link_hash', 64);

		$dHash=$hash_ids->decode($req->token);

		if(empty($dHash[0])){
			return res_msg('Sorry, invalid email verification token.', 403);
		}else{
			$user_id=$dHash[0];
		}

		$auth_user= model('User')::where('id', $user_id)->first();

		if($auth_user){
			model('User')::where('id', $user_id)->update([
				'email_verified_at'=> date("Y-m-d h:i:s")
			]);

			$err_txt='Given credentials do not match with our records';

			if(empty($auth_user)) return res_msg($err_txt, 422); //unauthorised http status code 422;

			//if(empty($user->company)) return res_msg($err_txt, 422);

			$sanctum_token=$auth_user->createToken('client_api_login_token');

			return res_msg('Account verified successfully!.', 200, [
				'api_token'=>$sanctum_token->plainTextToken,
				'auth_user'=>$auth_user,
				'permission_disable'=>config('permission.disable_role_permission', FALSE),
				'company'=>$auth_user->company
			]);
		}else{
			return res_msg('Sorry, failed to verify this email. Please try again later.', 403);
		}

	}

	public function sign_in(Request $req){

		$validator= Validator::make($req->all(), [
			'identity'=>'required',
			'password'=>'required|string|min:8|max:30'
		]);

		if($validator->fails()){

				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);

		}

		$auth_user=model('User')::where(function($q) use ($req) {
			$q->where('username', $req->identity)->orWhere('email', $req->identity);
		})
		->where('user_type', 'admin')
		->orwhere('user_type', 'system_admin')
		->orwhere('user_type', 'super_admin')
		->orwhere('user_type', 'user')->first();
		// ->orwhere([
		// 	'user_type' => 'user',
		// 	'manager' => 1,
		// ]);


		$err_txt='Given credentials do not match with our records';

		if(empty($auth_user)) return res_msg($err_txt, 422); //unauthorised http status code 422;

        $permissionIds = model('PermissionRole')::where('role_id', $auth_user->role_id)->pluck('permission_id');
        $auth_user->permission_codes = model('Permission')::whereIn('id', $permissionIds)->pluck('code');
        $permission_codes = model('Permission')::whereIn('id', $permissionIds)->pluck('code');

		if(Hash::check($req->password, $auth_user->password)){
			// return $auth_user;

			// $auth_user->update([
			// 	'last_timezone'=>$req->timezone
			// ]);

			$sanctum_token=$auth_user->createToken('client_api_login_token');

			return res_msg('User authenticated successfully!.', 200, [
				'api_token'=>$sanctum_token->plainTextToken,
				'auth_user'=>$auth_user,
                'user_permissions' => $permission_codes,
				// 'permission_disable'=>config('permission.disable_role_permission', FALSE),
			]);

		}else return res_msg($err_txt, 422);

	}



	public function logout(Request $req){

		$auth_user = auth('sanctum')->user();
        // Revoke all tokens...
        // $auth_user->tokens()->delete();

		if($auth_user){
			$auth_user->currentAccessToken()->delete();
		}

		return res_msg('User logged out successfully!.');

	}

    public function set_new_password(Request $req){
        $validator= Validator::make($req->all(), [
            'email'=>'required|email|exists:password_resets,email',
            'password'=>'required|string|min:8|max:30|required_with:confirm_password|same:confirm_password',
            'confirm_password'=>'required|string|min:8|max:30',
            'password_reset_token'=>'required'
        ]);

        if($validator->fails()){
            $errors=$validator->errors()->all();
            return response(['msg'=>$errors[0]], 422);
        }

        $password_reset = DB::table('password_resets')->where(
            'email', $req->email
        )->orderBy('created_at', 'DESC')->first();

        $user = model('User')::where('email', $req->email)->first();

        if(empty($user))return response(['msg'=>'Invalid user!.'], 403);


        if (Hash::check($req->password_reset_token, $password_reset->token)) {

            $user->password = Hash::make($req->password);
            $user->update();

            DB::table('password_resets')->where('email', $user->email)->delete();

			// Mail::to($user->email)->send(new \App\Mail\AfterPasswordResetEmail($user));

            return response(['msg'=>'New password set successfully!.'], 200);
        }else{
            return response(['msg'=>'Invalid reset password token!.'], 403);
        }


    }

    public function send_reset_link(Request $req){

        $validator= Validator::make($req->all(), [
            'email'=>'required|email|exists:users,email'
        ]);

        if($validator->fails()){

            $errors=$validator->errors()->all();
            return response(['msg'=>$errors[0]], 422);

        }

        $user = model('User')::where([
            'email'=>$req->email,
        ])->first();

        if(empty($user)) return res_msg("Given email address do not match with our records.", 422);

		// Mail::to($user->email)->send(new \App\Mail\ResetPasswordLink($user));

        return res_msg('A password reset link has been sent to your registered email inbox.', 200);
    }

    public function generate_invoice_pdf(Request $req){

        // $user = model('User')::first();
        // // $user = Auth::user();

        // $invoice = model('ProductInvoice')::with('customer', 'payment_status', 'details')->find($req->id);

        //     if ($invoice) {
        //         foreach($invoice->details as $item) {
        //            $productStock = model('ProductStock')::with('type', 'color', 'unit', 'category')->find($item->product_stock_id);
        //            if ($productStock) {
        //             $item->product_type_id = $productStock->product_type_id;
        //             $item->product_type = $productStock->type ? $productStock->type->name : '';
        //             $item->category_id = $productStock->category_id;
        //             $item->category = $productStock->category ? $productStock->category->name : '';
        //             $item->color_id = $productStock->color_id;
        //             $item->color = $productStock->color ? $productStock->color->name : '';
        //             $item->unit_id = $productStock->unit_id;
        //             $item->unit = $productStock->unit ? $productStock->unit->name : '';
        //            }
        //         }
        //     }

        //     $company = $user->company;

            // return view('pdf.invoice', compact('company', 'invoice'));

			$invoice_number = '#2306001';

            $pdf = PDF::loadView('pdf.invoice',compact('invoice_number'));
            return $pdf->download('invoice.pdf');

            // $pdf = PDF::Make();
            // $pdf->loadView('pdf.invoice', compact('company', 'invoice'));
            // return $pdf->stream('invoice.pdf');
    }
}
