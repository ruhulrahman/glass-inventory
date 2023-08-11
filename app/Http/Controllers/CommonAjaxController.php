<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonAjaxController extends Controller
{
    public function get(Request $req, $name)
    {
        if($name == 'get_common_dropdown_list'){

            $statusGroups = model('StatusGroup')::with('statuses')->where(['active'=>1])->get();

			return res_msg('Common dropdown list', 200, [
				'statusGroups' => $statusGroups,
				// 'times' => time_dropdown_data(),
			]);

		}

		return response(['msg'=>'Sorry!, found no named argument.'], 403);
    }


    public function post(Request $req, $name)
    {
        if($name == 'get_auth_user'){


			return res_msg('Auth User Data', 200, [
				'auth_user' => '$auth_user'
			]);

		}

		return response(['msg'=>'Sorry!, found no named argument.'], 403);
    }
}
