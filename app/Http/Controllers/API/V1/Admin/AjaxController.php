<?php

namespace App\Http\Controllers\API\V1\Admin;

use Carbon\Carbon;
use Nette\Utils\Random;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AjaxController extends Controller
{
	public function get(Request $req, $name)
	{
		$user = Auth::user();
		$data['user'] = $user;
		$default_per_page = 10;
		$carbon = new Carbon();
        $request = $req;

		if ($name == 'get_auth_user') {

			$auth_user = model('User')::find($user->id);

			return res_msg('Auth User Data', 200, [
				'auth_user' => $user
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
		} else if ($name == 'get_weekend_list') {

			$list = model('Weekend')::with('creator')->where('company_id', $user->company_id)->get();

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		} else if ($name == 'get_designation_list') {

			$list = model('Designation')::with('department')
            ->where('company_id', $user->company_id)
            ->orderBy('ranking_number', 'asc')
            ->get();

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

			$list = model('User')::with('employee', 'role')->where('company_id', $user->company_id)->orderBy('id', 'desc')->paginate($default_per_page);

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
                if ($item->phone && $item->name) {
                    $item->label = "$item->name ($item->phone)";
                } else if($item->phone) {
                    $item->label = $item->phone;
                } else {
                    $item->label = $item->name;
                }
            }

			$paymentStatuses = get_statuses('payment_statuses');

            foreach($paymentStatuses as $item) {
                $item->value = $item->id;
                $item->label = $item->name;
            }

			return res_msg('list Data', 200, [
				'categories' => $categories,
				'categoryList' => $categories,
				'suppliers' => $suppliers,
				'supplierList' => $suppliers,
				'productUnits' => $productUnits,
				'productUnitList' => $productUnits,
				'productColors' => $productColors,
				'productColorList' => $productColors,
				'productTypes' => $productTypes,
				'productTypeList' => $productTypes,
				'customers' => $customers,
				'customerList' => $customers,
				'paymentStatuses' => $paymentStatuses,
				'paymentStatusList' => $paymentStatuses,
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

			$list = model('ProductInvoice')::with('customer', 'payment_status', 'details')
            ->where('company_id', $user->company_id)
            ->orderBy('id','desc')
            ->get();

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		} else if ($name == 'get_customer_due_list') {

			$query = model('ProductInvoice')::with('customer', 'payment_status')
            ->where('company_id', $user->company_id)
            ->where('due_amount', '>', 0);

            if ($req->customer_id) {
                $query->where('customer_id', $req->customer_id);
            }

            if ($req->invoice_code) {
                $query->where('invoice_code', $req->invoice_code);
            }

            if ($req->invoice_date) {
                $query->whereDate('invoice_date', $req->invoice_date);
            }

            $totalDueAmount = $query->sum('due_amount');

            $list = $query->orderBy('id','desc')->get();

			return res_msg('list Data', 200, [
				'data' => $list,
				'totalDueAmount' => $totalDueAmount,
			]);

		} else if ($name == 'get_attendance_employee_list') {
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

			if($req->employee_id){
                $query->where('employee_id', $req->employee_id);
			}

			$attendances = $query->get();
			$employees = NULL;

			if($req->from || $req->to || $req->status_type && count($attendances) > 0){
				foreach ($attendances as $key => $value) {
					$count_present = model('EmployeeAttendance')::where(['employee_id' => $value->employee_id, 'present' => 'Yes'])->whereRaw("DATE(date) >= ? AND DATE(date) <=?", [$req->from, $req->to])->count();
					$count_absent = model('EmployeeAttendance')::where(['employee_id' => $value->employee_id, 'present' => 'No'])->whereRaw("DATE(date) >= ? AND DATE(date) <=?", [$req->from, $req->to])->count();

					$employees[$key] =  model('Employee')::where('active', 1)->where('id', $value->employee_id)->first();
					$employees[$key]->present = $value->present;
					$employees[$key]->date = $value->date;
					$employees[$key]->count_present = $count_present;
					$employees[$key]->count_absent = $count_absent;
				}

			}else{

				if(count($attendances) > 0){
					$employees = model('Employee')::where('active', 1)->get();
                    // info($attendances);
					foreach ($attendances as $key => $value) {
                        // info($key);
                        // info($value);
						if($employees[$key]->id == $value->employee_id){
							$count_present = model('EmployeeAttendance')::where(['employee_id' => $employees[$key]->id, 'present' => 'Yes'])->whereMonth('date', Carbon::today())->count();
							$count_absent = model('EmployeeAttendance')::where(['employee_id' => $employees[$key]->id, 'present' => 'No'])->whereMonth('date', Carbon::today())->count();
							$employees[$key]->present = $value->present;
							$employees[$key]->date = $value->date;
							$employees[$key]->count_present = $count_present;
							$employees[$key]->count_absent = $count_absent;
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
		} else if ($name == 'get_attendance_employee_list_v2') {

            $attendanceQuery = model('EmployeeAttendance')::with('creator', 'editor')->where([
                'company_id' => $user->company_id,
            ])->whereDate('attendance_date', new Carbon($req->attendance_date));

            if($req->status_type){
                $attendanceQuery->where('attendance', $req->status_type);
            }

            $employeeIds = (clone $attendanceQuery)->pluck('employee_id');

            info($employeeIds);

            $employeeQuery = model('Employee')::where([
                'company_id' => $user->company_id,
                'active' => 1,
            ]);

			if($req->employee_id){
                $employeeQuery->where('id', $req->employee_id);
			}

			// if(count($employeeIds)){
            //     $employeeQuery->whereIn('id', $employeeIds);
			// }

			if($req->employee_name){
                $employeeQuery->where('name', 'LIKE', "%$req->employee_name%");
			}


            $employees = (clone $employeeQuery)->get();
            info($employees);

            foreach($employees as $employee) {

                $employeeAttendance = (clone $attendanceQuery)->where('employee_id', $employee->id)->first();

                if ($employeeAttendance) {
                    $employee->attendance_id = $employeeAttendance->id;
                    $employee->attendance = $employeeAttendance->attendance;
                    $employee->attendance_date = $employeeAttendance->attendance_date;
                    $employee->creator = $employeeAttendance->creator;
                    $employee->editor = $employeeAttendance->editor;
                } else {
                    $employee->attendance_id = NULL;
                    $employee->attendance = NULL;
                    $employee->attendance_date = new Carbon($req->attendance_date);
                    $employee->creator = NULL;
                    $employee->editor = NULL;
                }
            }

			return res_msg('list Data', 200, [
				'data' => $employees,
			]);

		} else if($name == "get_holiday_list"){
			$holidays = model('Holiday')::where(['company_id' => $user->company_id])
            ->latest()
            ->get();

			return res_msg('list Data', 200, [
				'data' => $holidays
			]);
		} else if($name == "get_holiday_and_employee_dob_list"){
			$holidays = model('Holiday')::where(['company_id' => $user->company_id, 'status' => 1])
            ->select('name', 'from', 'to', 'total')
            // ->whereYear('from', Carbon::now())
            // ->whereYear('to', Carbon::now())
            ->get()->toArray();

            $employees = model('Employee')::where(['company_id' => $user->company_id, 'active' => 1])
            ->whereNotNull('dob')
            ->select('name', 'dob')
            ->get();

            $employee_birth_list = [];

            foreach($employees as $item) {
                $data = [];
                $data['name'] = "Birthday Of: $item->name";
                $data['from'] = $item->dob;
                $data['to'] = $item->dob;
                $data['total'] = 1;

                array_push($employee_birth_list, $data);
            }

            $result = array_merge($holidays, $employee_birth_list);


			return res_msg('list Data', 200, [
				'data' => $result
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
		}else if($name == "get_employee_attendance_list"){

			$attendances = model('EmployeeAttendance')::where('employee_id', $req->id)->get();
			$count_present = model('EmployeeAttendance')::where(['employee_id' => $req->id, 'present' => 'Yes' ])->whereMonth('date', Carbon::today())->count();
			$count_absent = model('EmployeeAttendance')::where(['employee_id' => $req->id, 'present' => 'No' ])->whereMonth('date', Carbon::today())->count();

            return res_msg('list Data', 200, [
				'data' => $attendances,
				'count_present' => $count_present,
				'count_absent' => $count_absent
			]);

		} else if($name == "get_employee_monthly_attendance_list"){

            $attendanceDate = new Carbon($req->attendance_date);

			$employee = model('Employee')::find($req->employee_id);

			$attendanceQuery = model('EmployeeAttendance')::where([
                'employee_id' => $req->employee_id,
            ])->whereMonth('attendance_date', $attendanceDate);

			$attendances = (clone $attendanceQuery)->get();

            $attendanceCount = new \stdClass;

			$attendanceCount->present = (clone $attendanceQuery)->where(['attendance' => 'Present'])->count();
			$attendanceCount->absent = (clone $attendanceQuery)->where(['attendance' => 'Absent'])->count();
			$attendanceCount->holiday = (clone $attendanceQuery)->where(['attendance' => 'Holiday'])->count();
			$attendanceCount->leave = (clone $attendanceQuery)->where(['attendance' => 'Leave'])->count();
			$attendanceCount->total_attendance = $attendanceCount->present + $attendanceCount->holiday + $attendanceCount->leave;

            $month = Carbon::createFromFormat('Y-m-d H:i:s', $attendanceDate)->format('M-Y');
            $monthNumber = Carbon::createFromFormat('Y-m-d H:i:s', $attendanceDate)->format('m');
            $monthYear = Carbon::createFromFormat('Y-m-d H:i:s', $attendanceDate)->format('Y');

            $month_days = cal_days_in_month(CAL_GREGORIAN,$monthNumber,$monthYear);

            if ($employee->current_salary) {
                // $perDaySalary = (int) ($employee->current_salary / $month_days);
                $perDaySalary = (int) ($employee->current_salary / 26);
            } else {
                $perDaySalary = 0;
            }

            $attendanceWiseSalary = $perDaySalary * $attendanceCount->total_attendance;

            return res_msg('list Data', 200, [
				'data' => $attendances,
				'attendanceCount' => $attendanceCount,
                'month' => $month,
                'month_days' => $month_days,
                'perDaySalary' => $perDaySalary,
                'employee' => $employee,
                'attendanceWiseSalary' => $attendanceWiseSalary,
                'dayName' => date('l'),
			]);

		} else if ($name == 'get_benefit_and_loss_by_invoice_wise') {

			$list = model('ProductInvoice')::where('company_id', $user->company_id)
            ->orderBy('id','desc')
            ->get();

            foreach($list as $item) {
                $detailsQuery = model('ProductInvoiceDetail')::where('product_invoice_id', $item->id);
                $item->benefit_amount = (clone $detailsQuery)->sum('benefit_amount');
                $item->loss_amount = (clone $detailsQuery)->sum('loss_amount');
                $item->invoice_date = dDate($item->invoice_date, 'd-m-Y');
            }

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		} else if ($name == 'get_benefit_and_loss_by_product_wise') {
            $validator = Validator::make($req->all(), [
				'invoice_date' => 'required',
			], [
				'invoice_date.required' => 'Please select invoice date',
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

            $query = DB::table('product_invoice_details')
            ->leftJoin('product_invoices', 'product_invoice_details.product_invoice_id', 'product_invoices.id')
            ->leftJoin('product_stocks', 'product_invoice_details.product_stock_id', 'product_stocks.id')
            ->leftJoin('product_types', 'product_stocks.product_type_id', 'product_types.id')
            ->leftJoin('product_categories', 'product_stocks.category_id', 'product_categories.id')
            ->leftJoin('product_units', 'product_stocks.unit_id', 'product_units.id')
            ->leftJoin('product_colors', 'product_stocks.color_id', 'product_colors.id')
            ->where('product_invoice_details.company_id', $user->company_id);

            if($req->invoice_code) {
                $query->where('product_invoices.invoice_code', $req->invoice_code);
            }

            if($req->invoice_date) {
                $invoice_start_date = new Carbon($req->invoice_start_date);
                $invoice_end_date = new Carbon($req->invoice_end_date);
                $query->whereDate('product_invoices.invoice_date', '>=', $invoice_start_date)
                ->whereDate('product_invoices.invoice_date', '<=', $invoice_end_date);
            }

            if($req->product_type_id) {
                $query->where('product_types.id', $req->product_type_id);
            }

            if($req->category_id) {
                $query->where('product_categories.id', $req->category_id);
            }

            if($req->unit_id) {
                $query->where('product_units.id', $req->unit_id);
            }

            if($req->color_id) {
                $query->where('product_colors.id', $req->color_id);
            }

            $query->select(
                'product_invoice_details.*',
                'product_invoices.invoice_code',
                'product_invoices.invoice_date',
                'product_types.name as product_type_name',
                'product_categories.name as category_name',
                'product_colors.name as color_name',
                'product_units.name as unit_name',
            );

            // $list = $query->paginate($default_per_page);
            $list = $query->get();

            // foreach($list as $item) {
            //     $item->invoice_date = dDate($item->invoice_date, 'd-M-Y');
            // }

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		} else if ($name == 'get_benefit_and_loss_by_item_wise') {

            $query = DB::table('product_invoice_details')
            ->leftJoin('product_invoices', 'product_invoice_details.product_invoice_id', 'product_invoices.id')
            ->leftJoin('product_stocks', 'product_invoice_details.product_stock_id', 'product_stocks.id')
            ->leftJoin('product_types', 'product_stocks.product_type_id', 'product_types.id')
            ->leftJoin('product_categories', 'product_stocks.category_id', 'product_categories.id')
            ->leftJoin('product_units', 'product_stocks.unit_id', 'product_units.id')
            ->leftJoin('product_colors', 'product_stocks.color_id', 'product_colors.id')
            ->where('product_invoice_details.company_id', $user->company_id);

            if($req->invoice_code) {
                $query->where('product_invoices.invoice_code', $req->invoice_code);
            }

            if($req->invoice_date) {
                $query->whereDate('product_invoices.invoice_date', $req->invoice_date);
            }

            if($req->product_type_id) {
                $query->where('product_types.id', $req->product_type_id);
            }

            if($req->category_id) {
                $query->where('product_categories.id', $req->category_id);
            }

            if($req->unit_id) {
                $query->where('product_units.id', $req->unit_id);
            }

            if($req->color_id) {
                $query->where('product_colors.id', $req->color_id);
            }

            $query->select(
                'product_invoice_details.*',
                'product_invoices.invoice_code',
                'product_invoices.invoice_date',
                'product_stocks.product_type_id',
                'product_stocks.category_id',
                'product_stocks.color_id',
                'product_stocks.unit_id',
                'product_types.name as product_type_name',
                'product_categories.name as category_name',
                'product_colors.name as color_name',
                'product_units.name as unit_name',
            );

            if($req->product_type_id) {
                $query->groupBy('product_stocks.product_type_id');
            }

            if($req->category_id) {
                $query->groupBy('product_stocks.category_id');
            }

            if($req->unit_id) {
                $query->groupBy('product_stocks.unit_id');
            }

            if($req->color_id) {
                $query->groupBy('product_stocks.color_id');
            }

            // $list = $query->paginate($default_per_page);
            $list = $query->get();

            // foreach($list as $item) {
            //     $item->invoice_date = dDate($item->invoice_date);
            // }

			return res_msg('list Data', 200, [
				'data' => $list
			]);

		} else if ($name == 'get_dashboard_caculation_data') {

            $dashboardData = new \StdClass;

            $dashboardData->total_user = model('User')::where(['status' => 1, 'company_id' => $user->company_id])->count();
            $dashboardData->total_employee = model('Employee')::where(['active' => 1, 'company_id' => $user->company_id])->count();
            $dashboardData->total_customer = model('Customer')::where(['is_active' => 1, 'company_id' => $user->company_id])->count();
            $dashboardData->total_supplier = model('Supplier')::where(['active' => 1, 'company_id' => $user->company_id])->count();

            $invoiceQuery = model('ProductInvoice')::where(['company_id' => $user->company_id]);

            $dashboardData->total_due_today = (clone $invoiceQuery)->whereDate('created_at', Carbon::now())->sum('due_amount');
            $dashboardData->total_due_this_month = (clone $invoiceQuery)->whereMonth('created_at', Carbon::now())->sum('due_amount');
            $dashboardData->total_due_last_6th_month = (clone $invoiceQuery)->whereDate('created_at', '<=', Carbon::now())
            ->whereDate('created_at', '>=', Carbon::now()->subMonth(6))
            ->sum('due_amount');
            $dashboardData->total_due_this_year = (clone $invoiceQuery)->whereYear('created_at', Carbon::now())->sum('due_amount');
            $dashboardData->total_due = (clone $invoiceQuery)->sum('due_amount');

            $product_invoice_ids_today = (clone $invoiceQuery)->whereDate('created_at', Carbon::now())->pluck('id');
            $product_invoice_ids_this_month = (clone $invoiceQuery)->whereMonth('created_at', Carbon::now())
            ->pluck('id');
            $product_invoice_ids_last_6th_month = (clone $invoiceQuery)->whereDate('created_at', '<=', Carbon::now())
            ->whereDate('created_at', '>=', Carbon::now()->subMonth(6))
            ->pluck('id');
            $product_invoice_ids_this_year = (clone $invoiceQuery)->whereYear('created_at', Carbon::now())->pluck('id');


            $pInvoiceDetailQuery = model('ProductInvoiceDetail')::where(['company_id' => $user->company_id]);
            $dashboardData->total_sale_today = (clone $pInvoiceDetailQuery)->whereIn('product_invoice_id', $product_invoice_ids_today)->sum('amount');
            $dashboardData->total_sale_this_month = (clone $pInvoiceDetailQuery)->whereIn('product_invoice_id', $product_invoice_ids_this_month)->sum('amount');
            $dashboardData->total_sale_last_6th_month = (clone $pInvoiceDetailQuery)->whereIn('product_invoice_id', $product_invoice_ids_last_6th_month)->sum('amount');
            $dashboardData->total_sale_this_year = (clone $pInvoiceDetailQuery)->whereIn('product_invoice_id', $product_invoice_ids_this_year)->sum('amount');

            $dashboardData->total_earning_today = (clone $pInvoiceDetailQuery)->whereIn('product_invoice_id', $product_invoice_ids_today)->sum('benefit_amount');
            $dashboardData->total_earning_this_month = (clone $pInvoiceDetailQuery)->whereIn('product_invoice_id', $product_invoice_ids_this_month)->sum('benefit_amount');
            $dashboardData->total_earning_last_6th_month = (clone $pInvoiceDetailQuery)->whereIn('product_invoice_id', $product_invoice_ids_last_6th_month)->sum('benefit_amount');
            $dashboardData->total_earning_this_year = (clone $pInvoiceDetailQuery)->whereIn('product_invoice_id', $product_invoice_ids_this_year)->sum('benefit_amount');

            $dashboardData->total_loss_today = (clone $pInvoiceDetailQuery)->whereIn('product_invoice_id', $product_invoice_ids_today)->sum('loss_amount');
            $dashboardData->total_loss_this_month = (clone $pInvoiceDetailQuery)->whereIn('product_invoice_id', $product_invoice_ids_this_month)->sum('loss_amount');
            $dashboardData->total_loss_last_6th_month = (clone $pInvoiceDetailQuery)->whereIn('product_invoice_id', $product_invoice_ids_last_6th_month)->sum('loss_amount');
            $dashboardData->total_loss_this_year = (clone $pInvoiceDetailQuery)->whereIn('product_invoice_id', $product_invoice_ids_this_year)->sum('loss_amount');

            $dashboardData->productStocks = model('ProductStock')::with('type', 'category', 'unit', 'color')->where(['active' => 1, 'company_id' => $user->company_id])->orderBy('sale_count', 'desc')->get();

            $dashboardData->topTenCustomers = (clone $invoiceQuery)->with('customer')->selectRaw("customer_id,count(id) as product_buy_count")
              ->groupBy('customer_id')
              ->orderBy('product_buy_count','DESC')
              ->limit(10)
              ->get();

            $dashboardData->topTenPurchaseCustomers = (clone $invoiceQuery)->with('customer')->addSelect(DB::raw('SUM(total_payable_amount) as purchase_total, customer_id'))
            ->groupBy('customer_id')->take(10)
            ->orderBy('purchase_total', 'DESC')->get();

            $salesQuery = (clone $invoiceQuery)->selectRaw('DATE(created_at) as date, SUM(sub_total) AS sales')
                ->whereDate('created_at', '>=', Carbon::now()->subDays(20))
                ->whereDate('created_at', '<=', Carbon::now())
                ->groupBy(DB::raw('date'))
                ->orderBy('date', 'DESC');


            $dashboardData->last20DaysSales = $salesQuery->get();
            $dashboardData->maxPayableAmount = $dashboardData->last20DaysSales->max('sales');
            $dashboardData->totalAmount = $dashboardData->last20DaysSales->sum('sales');

            $day = 0;
            $max = $dashboardData->maxPayableAmount + 10000;
            // $max = 1000000;
            $last20DaysSales = [];
            foreach($dashboardData->last20DaysSales as $item) {
                // $item->label = "Date: $item->date";
                // $item->max = $max;
                // $item->sales = (integer) $item->sales;
                // $item->label = $day."D";
                // $day += 1;
                $data = [];
                $data['label'] = "Date: ".dDate($item->date, 'd-m-Y');
                $data['max'] = $max;;
                $data['sales'] = (integer) $item->sales;

                array_push($last20DaysSales, $data);
            }

			return res_msg('list Data', 200, [
				'dashboardData' => $dashboardData,
				'last20DaysSales' => $last20DaysSales,
			]);

		} else if ($name == 'generate_invoice_pdf') {

            $invoice = model('ProductInvoice')::with('customer', 'payment_status', 'details')->find($req->id);

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

            $company = $user->company;

            $pdf = PDF::loadView('pdf.invoice', compact('company', 'invoice'))->setPaper('a4', 'portrait');


            return $pdf->stream('invoice.pdf');

			// return res_msg('list Data', 200, [
			// 	'invoice' => $invoice,
			// ]);

		} else if ($name == "get_permission_list") {

            $query = model('Permission')::with('parent')->latest();

            if ($request->name) {
                $query = $query->where('name', 'like', "%$req->name%");
            }

            if ($req->type) {
                $query = $query->where('type', $req->type);
            }

            if ($req->code) {
                $query = $query->where('code', $req->code);
            }

            $list = $query->paginate($default_per_page);

            foreach ($list as $item) {
                $item->active = $item->active == 1 ? TRUE : FALSE;
            }

            return response()->json([
                'success' => true,
                'message' => 'Data fetch Sucessfully!',
                'data' => $list
            ], 200);

        } else if ($name == "get_permission_parent_list") {

            $list = model('Permission')::whereNull('parent_id')->select('id as value', 'name as label', 'type')->get();

            if (!$list) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Not Found!'
                ], 402);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data fetch Sucessfully!',
                'data' => $list
            ], 200);
        } else if ($name == "get_permission_parent_and_child_list") {

            $rolePermissionIds = model('PermissionRole')::where('role_id', $req->role_id)->pluck('permission_id')->toArray();

            $query = model('Permission')::query();

            $permissionParentList = (clone $query)->whereNull('parent_id')->orderBy('name', 'asc')->get();

            foreach($permissionParentList as $item) {
                $item->children_pages = (clone $query)->where([
                    'parent_id' => $item->id,
                    'type' => 'Page',
                ])->orderBy('name', 'asc')->get();

                $item->children_operations = (clone $query)->where([
                    'parent_id' => $item->id,
                    'type' => 'Feature',
                ])->orderBy('name', 'asc')->get();

                $permission_ids = (clone $query)->where([
                    'parent_id' => $item->id,
                ])->pluck('id')->toArray();

                $parent_permission_ids = [$item->id];
                $item->children_permission_ids = array_merge($permission_ids, $parent_permission_ids);

                $permissionCheck = false;

                foreach($item->children_permission_ids as $permissionId) {

                    $permissionCheck = in_array($permissionId, $rolePermissionIds);

                }

                $item->checkAll = $permissionCheck;
            }

            return response()->json([
                'success' => true,
                'message' => 'Data fetch Sucessfully!',
                'data' => $permissionParentList,
                // 'userPermissionIds' => $userPermissionIds,
            ], 200);

        } else if ($name == "get_permissions_by_role_id") {

            $validator = Validator::make($req->all(), [
                'role_id' => 'required',
            ]);

            if ($validator->fails()) {

                $errors = $validator->errors()->all();
                return response(['msg' => $errors[0]], 422);
            }


            $role = model('Role')::find($req->role_id);


            $role->role_permission_ids = model('PermissionRole')::where('role_id', $req->role_id)->pluck('permission_id');

            return response()->json([
                'success' => true,
                'message' => 'Data fetch Sucessfully!',
                'data' => $role,
            ], 200);

        } else if ($name == "get_role_list") {

            $query = DB::table('roles')->latest();

            if ($req->name) {
                $query = $query->where('name', 'like', "%{$req->name}%");
            }

            if ($req->type) {
                $query = $query->where('type', $req->type);
            }

            if ($req->code) {
                $query = $query->where('code', $req->code);
            }

            $list = $query->paginate($default_per_page);

            foreach ($list as $item) {
                $item->active = $item->active == 1 ? TRUE : FALSE;
            }

            if (!$list) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Not Found!'
                ], 402);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data fetch Sucessfully!',
                'data' => $list
            ], 200);
        } else if ($name == "get_role_dropdown_list") {

            $list = DB::table('roles')
            ->where('active', 1)
            ->select('id', 'id as value', 'name', 'name as label')
            ->orderBy('name', 'asc')
            ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data fetch Sucessfully!',
                'data' => $list
            ], 200);
        }

		return response(['msg' => 'Sorry!, found no named argument.'], 403);
	}



	// Post functions are here .............
	public function post(Request $req, $name)
	{
		$user = Auth::user();
		$data['user'] = $user;
		$carbon = new Carbon();
        $request = $req;

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

		} else if ($name == 'delete_weekend_data') {

			$weekend = model('Weekend')::find($req->id);

			$weekend->delete();

			return res_msg('Weekend deleted successfully!', 200);

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
				'bank_info' => $req->bank_info,
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
				'bank_info' => $req->bank_info,
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
                'product_code' => $req->product_code,
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
                    'product_code' => $req->product_code,
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
				'role_id' => 'required',
				// 'password'=>'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			DB::beginTransaction();

			try {

				$user = model('User')::create([
					'company_id' => $user->company_id,
					'name' => $req->name,
					'username' => $req->username,
					'email' => $req->email,
					'user_type' => $req->user_type,
					'role_id' => $req->role_id,
					'active' => $req->active == 'false' ? 0 : 1,
					'is_employee' => $req->is_employee == 'false' ? 0 : 1,
					'created_at' => $carbon,
				]);

                if ($req->photo instanceof \Illuminate\Http\UploadedFile) {

                    $media = upload_media($req->photo, [
                        'model' => get_class($user),
                        'model_id' => $user->id,
                    ]);

					if ($media) {
                        $user->media_id = $media ? $media->id : NULL;
                        $user->save();
                    }
                }

				if($req->is_employee == 'true'){

				model('Employee')::create([
					'employee_code'=>substr(strtolower($req->name), 0, 3).'-'.str_pad($user->id, 3, "0", STR_PAD_LEFT),
					'company_id' => $user->company_id,
					'first_name' => $req->name,
					'user_id' => $user->id,
					'email' => $req->email,
					'created_at' => $carbon
				]);

			 }


				DB::commit();
				return res_msg('User inserted successfully!', 200);

			} catch (\Throwable $e) {
				return response([ 'msg' => 'Wrong data entry', 'error' => $e ], 422);
				DB::rollback();
			}

		} else if ($name == 'update_user_data') {

			$validator = Validator::make($req->all(), [
				'name' => 'required',
				'email' => 'required|email|unique:users,email,' . $req->id,
				// 'mobile' => 'required|numeric',
				'user_type' => 'required',
				'role_id' => 'required',
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

				$user = model('User')::find($req->id);

				$user->update([
					'name' => $req->name,
					'username' => $req->username,
					'email' => $req->email,
					'user_type' => $req->user_type,
					'role_id' => $req->role_id,
					'active' => $req->active == 'false' ? 0 : 1,
					'is_employee' => $req->is_employee == 'false' ? 0 : 1,
					'created_at' => Carbon::now()

				]);

                if ($req->photo instanceof \Illuminate\Http\UploadedFile) {

                    if ($user->media_id) {
                        delete_media($user->media_id);
                    }

                    $media = upload_media($req->photo, [
                        'model' => get_class($user),
                        'model_id' => $user->id,
                    ]);

					if ($media) {
                        $user->media_id = $media ? $media->id : NULL;
                        $user->save();
                    }
                }


				DB::commit();
				return res_msg('User updated successfully!', 200);

			} catch (\Throwable $e) {
				return response([ 'msg' => 'Wrong data entry', 'error' => $e ], 422);
				DB::rollback();
			}

		} else if ($name == 'delete_user_data') {

			$user = model('User')::find($req->id);

			$employee = model('Employee')::where('user_id',$req->id)->first();

            if ($employee) {
                model('EmployeeSalaryHistory')::where('employee_id', $employee->id)->delete();
                $employee->delete();
            }

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
				'phone' => 'required',
				'email' => 'required|unique:companies,email',
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
					'phone' => $req->phone,
					'phone2' => $req->phone2,
					'email' => $req->email,
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
				DB::rollback();
				return response([ 'msg' => 'Wrong data entry', 'error' => $e ], 422);
			}

		} else if ($name == 'update_company_data') {

			$validator = Validator::make($req->all(), [
				'id' => 'required',
				'name' => 'required|unique:companies,name,' . $req->id,
				'phone' => 'required',
				'email' => 'required|unique:companies,email,'. $req->id,
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
					'phone' => $req->phone,
					'phone2' => $req->phone2,
					'email' => $req->email,
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
				DB::rollback();
				return response([ 'msg' => 'Wrong data entry', 'error' => $e ], 422);
			}
		} else if($name == 'delete_company_data'){

			$company = model('Company')::find($req->id);
			$company->delete();
			return res_msg('Company deleted successfully!', 200);

		} else if ($name == 'store_company_bank_data') {

			$validator = Validator::make($req->all(), [
				'bank_name' => 'required|unique:company_bank_infos,bank_name',
				'account_name' => 'required',
				'account_number' => 'required',
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

            $activeBank = model('CompanyBankInfo')::where('status', 1)->first();

            if ($activeBank) {
                if ($req->status == 'true') {
                    model('CompanyBankInfo')::where('status', 1)->update(['status' => 0]);
                }
            }

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
				'bank_name' => 'required|unique:company_bank_infos,bank_name,' . $req->id,
                'account_name' => 'required',
                'account_number' => 'required',
			]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

            $activeBank = model('CompanyBankInfo')::where('status', 1)->first();

            if ($activeBank) {
                if ($req->status == 'true') {
                    model('CompanyBankInfo')::where('status', 1)->update(['status' => 0]);
                }
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
				'name' => 'required',
				'current_salary' => 'required',
				'joining_date' => 'required',
			],[
                'name.required' => 'The Name field is required',
                'current_salary.required' => 'The Current Salary field is required',
                'joining_date.required' => 'The Joining date field is required',
            ]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			DB::beginTransaction();

			try {

				$employee = model('Employee')::create([
					'company_id' => $user->company_id,
					'name' => $req->name,
					'email' => $req->email ? $req->email : NULL,
					'phone1' => $req->phone1 ? $req->phone1 : NULL,
					'phone2' => $req->phone2 ? $req->phone2 : NULL,
					'present_address' => $req->present_address ? $req->present_address : NULL,
					'permanent_address' => $req->permanent_address ? $req->permanent_address : NULL,
					'dob' => $req->dob ? new Carbon($req->dob): NULL,
					'nid' => $req->nid ? $req->nid : NULL,
					'gender' => $req->gender ? $req->gender : NULL,
					'religion' => $req->religion ? $req->religion : NULL,
					'current_salary' => $req->current_salary ? $req->current_salary : NULL,
					'designation_id' => $req->designation_id ? $req->designation_id : NULL,
					'joining_date' => $req->joining_date ? new Carbon($req->joining_date) : NULL,
					'active' => $req->active == 'false' ? 0 : 1,
					'created_at' => Carbon::now()
				]);

				if ($req->photo instanceof \Illuminate\Http\UploadedFile) {

                    $media = upload_media($req->photo, [
                        'model' => get_class($employee),
                        'model_id' => $employee->id,
                    ]);

					if ($media) {
                        $employee->media_id = $media ? $media->id : NULL;
                        $employee->save();
                    }
                }

				model('Employee')::where('id', $employee->id)->update([
					'employee_code'=>substr(strtolower($req->name), 0, 3).'-'.str_pad($employee->id, 3, "0", STR_PAD_LEFT)
				]);

				model('EmployeeSalaryHistory')::create([
					'company_id' => $user->company_id,
					'employee_id' => $employee->id,
					'salary' => $req->current_salary,
					'start_date' => $req->joining_date,
					'active' => $req->active == 'false' ? 0 : 1,
					'created_at' => Carbon::now()
				]);

				DB::commit();

				return res_msg('Employee created successfully!', 200);

			} catch (\Throwable $e) {
				DB::rollback();
				return response([ 'msg' => 'Wrong data entry', 'error' => $e ], 422);
			}
		}else if($name == "update_employee_data"){

            $validator = Validator::make($req->all(), [
				'id' => 'required',
				'name' => 'required',
				'current_salary' => 'required',
				'joining_date' => 'required',
			],[
                'name.required' => 'The Name field is required',
                'current_salary.required' => 'The Current Salary field is required',
                'joining_date.required' => 'The Joining date field is required',
            ]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

            // info($req->all());

			DB::beginTransaction();

			try {

                $employee = model('Employee')::find($req->id);

				$employee->update([
					'name' => $req->name,
					'email' => $req->email == 'null' ? NULL : $req->email,
					'phone1' => $req->phone1 == 'null' ? NULL : $req->phone1,
					'phone2' => $req->phone2 == 'null' ? NULL : $req->phone2,
					'present_address' => $req->present_address == 'null' ? NULL : $req->present_address,
					'permanent_address' => $req->permanent_address == 'null' ? NULL : $req->permanent_address,
					'dob' => $req->dob == 'null' ? NULL : new Carbon($req->dob),
					'nid' => $req->nid == 'null' ? NULL : $req->nid,
					'gender' => $req->gender == 'null' ? NULL : $req->gender,
					'religion' => $req->religion == 'null' ? NULL : $req->religion,
					'designation_id' => $req->designation_id == 'null' ? NULL : $req->designation_id,
					'joining_date' => $req->joining_date == 'null' ? NULL : new Carbon($req->joining_date),
					// 'photo'=>$fileName ? $fileName : NULL,
					'active' => $req->active == 'false' ? 0 : 1,
					'current_salary' => $req->current_salary,
					'updated_at' => Carbon::now()
				]);

                if ($req->photo instanceof \Illuminate\Http\UploadedFile) {

                    if ($employee->media_id) {
                        delete_media($employee->media_id);
                    }

                    $media = upload_media($req->photo, [
                        'model' => get_class($employee),
                        'model_id' => $employee->id,
                    ]);

					if ($media) {
                        $employee->media_id = $media ? $media->id : NULL;
                        $employee->save();
                    }
                }


				DB::commit();

				return res_msg('Employee updated successfully!', 200);

			} catch (\Throwable $e) {
                DB::rollback();
				return response([ 'msg' => 'Wrong data entry', 'error' => $e ], 422);
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
				DB::rollback();
				return response([ 'msg' => 'Wrong data entry', 'error' => $e ], 422);
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
				DB::rollback();
				return response([ 'msg' => 'Wrong data entry', 'error' => $e ], 422);
			}

		} else if ($name == 'delete_customer_data') {

			$customer = model('Customer')::find($req->id);
			$customer->delete();

			return res_msg('Customer deleted successfully!', 200);

		} else if($name == 'update_employee_attendance'){

			$employeeAttendance = model('EmployeeAttendance')::where([
                'company_id' => $req->company_id,
                'employee_id'=> $req->id
            ])->whereDate('attendance_date', new Carbon($req->attendance_date))
            ->first();

			if($employeeAttendance){

                $employeeAttendance->attendance = $req->attendance;
                $employeeAttendance->editor_id = $user->id;
                $employeeAttendance->updated_at = Carbon::now();
				$employeeAttendance->update();

			} else {
                model('EmployeeAttendance')::create([
                    'company_id' => $req->company_id,
                    'employee_id'=> $req->id,
                    'attendance'=> $req->attendance,
                    'attendance_date'=> new Carbon($req->attendance_date),
                    // 'present'=> $req->present == 'Present' ? 'Yes' : 'No',
                    // 'date'=> new Carbon($req->date),
                    'creator_id'=> $user->id,
                    'created_at'=> Carbon::now(),
                ]);
            }

			return res_msg('Attendance updated successfully!', 200);

		} else if ($name == 'store_product_invoice_data') {

            if (!$req->customer_id && !$req->customer_phone) {
                return response(['msg' => 'Customer name or phone number is missing'], 422);
            }

			$validator = Validator::make($req->all(), [
				// 'invoice_date' => 'required',
				'payment_status_id' => 'required',
				'sub_total' => 'required',
				'total_payable_amount' => 'required',
				'details' => 'array|required',
				'details.*.product_type_id' => 'required',
				'details.*.category_id' => 'required',
				'details.*.color_id' => 'required',
				'details.*.unit_id' => 'required',
				'details.*.product_stock_id' => 'required',
				'details.*.price' => 'required',
				'details.*.quantity' => 'required',
				'details.*.amount' => 'required',
			], [
                // 'invoice_date.required' => 'Invoice date filed is required',
                'payment_status_id.required' => 'Payment status filed is required',
                'payment_status_id.required' => 'Payment status filed is required',
                'sub_total.required' => 'Sub-Total value is required',
                'total_payable_amount.required' => 'Total Payable Amount is required',
                'details.*.product_type_id.required' => 'Product type field is required',
                'details.*.category_id.required' => 'Category field is required',
                'details.*.color_id.required' => 'Color field is required',
                'details.*.unit_id.required' => 'Unit field is required',
                'details.*.unit_id.required' => 'Unit field is required',
                'details.*.product_stock_id.required' => 'Product stock id is required',
                'details.*.price.required' => 'Price field is required',
                'details.*.quantity.required' => 'Quantity field is required',
                'details.*.amount.required' => 'Amount field is required',
            ]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

            $customer_id = $req->customer_id;

            // return $req->all();

            DB::beginTransaction();

            try {

                if (empty($req->customer_id)) {

                    $customer = model('Customer')::create([
                        'company_id' => $user->company_id,
                        'name' => $req->customer_name,
                        'email' => $req->email,
                        'phone' => $req->customer_phone,
                        'is_active' => 1,
                        'creator_id' => $user->id,
                        'created_at' => $carbon,
                    ]);

                    $customer_id = $customer->id;
                }

                $productInvoice = model('ProductInvoice')::create([
                    'company_id' => $user->company_id,
                    // 'invoice_code' => $req->invoice_code ? $req->invoice_code : rand(10000,1000000),
                    'customer_id' => $customer_id,
                    // 'invoice_date' => new Carbon($req->invoice_date),
                    'invoice_date' => Carbon::now(),
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

                    $productInvoiceDetail = model('ProductInvoiceDetail')::create([
                        'company_id' => $user->company_id,
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

                    $productStock->product_in_stock = $productStock->product_in_stock - $productInvoiceDetail->quantity;
                    $productStock->last_sale_date = Carbon::now();
                    $productStock->sale_count = $productStock->sale_count + 1;
                    $productStock->save();

                }

                DB::commit();

                return res_msg('Product invoice saved successfully!', 200, [
                    'productInvoice' => $productInvoice
                ]);

            } catch (\Throwable $e) {
				DB::rollback();
				return response(['msg' => 'Wrong data entry', 'error' => $e], 422);
			}


		} else if ($name == 'update_product_invoice_data') {

			$validator = Validator::make($req->all(), [
				// 'invoice_date' => 'required',
				'payment_status_id' => 'required',
				'sub_total' => 'required',
				'total_payable_amount' => 'required',
				'details' => 'array|required',
				'details.*.product_type_id' => 'required',
				'details.*.category_id' => 'required',
				'details.*.color_id' => 'required',
				'details.*.unit_id' => 'required',
				'details.*.product_stock_id' => 'required',
				'details.*.price' => 'required',
				'details.*.quantity' => 'required',
				'details.*.amount' => 'required',
			], [
                // 'invoice_date.required' => 'Invoice date filed is required',
                'payment_status_id.required' => 'Payment status filed is required',
                'payment_status_id.required' => 'Payment status filed is required',
                'sub_total.required' => 'Sub-Total value is required',
                'total_payable_amount.required' => 'Total Payable Amount is required',
                'details.*.product_type_id.required' => 'Product type field is required',
                'details.*.category_id.required' => 'Category field is required',
                'details.*.color_id.required' => 'Color field is required',
                'details.*.unit_id.required' => 'Unit field is required',
                'details.*.unit_id.required' => 'Unit field is required',
                'details.*.product_stock_id.required' => 'Product stock id is required',
                'details.*.price.required' => 'Price field is required',
                'details.*.quantity.required' => 'Quantity field is required',
                'details.*.amount.required' => 'Amount field is required',
            ]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

            DB::beginTransaction();
            try {

                $productInvoice = model('ProductInvoice')::find($req->id);

                if ($productInvoice) {

                    $productInvoice->due_date = new Carbon($req->due_date);
                    $productInvoice->customer_id = $req->customer_id;
                    $productInvoice->notes = $req->notes;
                    $productInvoice->po_no = $req->po_no;
                    $productInvoice->payment_status_id = $req->payment_status_id;
                    $productInvoice->sub_total = $req->sub_total;
                    $productInvoice->discount_percentage = $req->discount_percentage;
                    $productInvoice->discount_amount = $req->discount_amount;
                    $productInvoice->vat_percentage = $req->vat_percentage;
                    $productInvoice->vat_amount = $req->vat_amount;
                    $productInvoice->tax_percentage = $req->tax_percentage;
                    $productInvoice->tax_amount = $req->tax_amount;
                    $productInvoice->total_payable_amount = $req->total_payable_amount;
                    $productInvoice->paid_amount = $req->paid_amount;
                    $productInvoice->due_amount = $req->due_amount;
                    $productInvoice->editor_id = $user->id;
                    $productInvoice->save();

                    model('ProductInvoiceDetail')::where([
                        'company_id' => $user->company_id,
                        'product_invoice_id' => $productInvoice->id,
                    ])->delete();

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
                            'company_id' => $user->company_id,
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

                    DB::commit();

                    return res_msg('Product invoice saved successfully!', 200, [
                        'productInvoice' => $productInvoice
                    ]);

                } else {
                    return res_msg('Product invoice Not found!', 422);
                }
            } catch (\Throwable $e) {
				DB::rollback();
				return response(['msg' => 'Wrong data entry', 'error' => $e], 422);
			}

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
            $productInvoice->notes = $req->notes;
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
				'company_id'=> $user->company_id,
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

		} else if($name == 'delete_attendance_data'){

			model('EmployeeAttendance')::where('id', $req->id)->delete();
			return res_msg('Attendance deleted successfully', 200, []);

		} else if($name == 'forgot_password'){

			$validator= Validator::make($req->all(), [
				'email'=>'required|email|exists:users,email',
				'password'=>'required|string|min:8|max:30|required_with:confirm_password|same:confirm_password',
				'confirm_password'=>'required|string|min:8|max:30'
			]);

			if($validator->fails()){
				$errors=$validator->errors()->all();
				return response(['msg'=>$errors[0]], 422);
			}

			model('User')::where(['id'=> $req->id, 'email'=>$req->email])->update([
				'password'=>Hash::make($req->password)
			]);

			return res_msg('Password updated successfully', 200, []);

		} else if ($name == 'store_weekend_data') {

			$validator = Validator::make($req->all(), [
				'day_name' => 'required',
			], [
                'day_name.required' => 'Weekend Name is required',
            ]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			model('Weekend')::create([
				'company_id' => $user->company_id,
				'day_name' => $req->day_name,
				'creator_id' => $user->id,
				'created_at' => Carbon::now(),
			]);

			return res_msg('Weekend inserted successfully!', 200);

		} else if ($name == 'update_weekend_data') {

			$validator = Validator::make($req->all(), [
				'day_name' => 'required',
			], [
                'day_name.required' => 'Weekend Name is required',
            ]);

			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				return response(['msg' => $errors[0]], 422);
			}

			$weekend = model('Weekend')::find($req->id);

			$weekend->update([
				'day_name' => $req->day_name,
				'editor_id' => $user->id,
				'created_at' => Carbon::now(),
			]);

			return res_msg('Weekend updated successfully!', 200);

		} else if ($name == 'delete_permission_data') {

            try {
                $permissionDelete = model('Permission')::find($req->id);

                if (!$permissionDelete) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data not found',
                    ], 422);
                }

                $permissionDelete->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Data deleted Successfully',
                    'data'  => $permissionDelete
                ], 201);
            } catch (\Throwable $th) {
                return response()->json([
                    'success' => false,
                    'message' => $th->getMessage()
                ], 500);
            }
        } else if ($name == 'store_permission_data') {

            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'type' => 'required',
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validate->errors()
                ], 422);
            }

            try {

                $input = $request->all();
                $input['active'] = $request->active == 'true' ? 1 : 0;
                $model = model('Permission')::create($input);

                return response()->json([
                    'success' => true,
                    'message' => 'Data Created Successfully',
                    'data'  => $model
                ], 201);

            } catch (\Throwable $th) {
                return response()->json([
                    'success' => false,
                    'message' => $th->getMessage()
                ], 500);
            }
        } else if ($name == 'update_permission_data') {

            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'type' => 'required'
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validate->errors()
                ], 422);
            }

            $permission = model('Permission')::find($req->id);

            if (!$permission) {
                return response([
                    'success' => false,
                    'message' => 'Data not found.'
                ]);
            }

            try {

                $permission->type  = $request->type;
                $permission->name  = $request->name;
                // $permission->code  = $request->code;
                $permission->parent_id = $request->parent_id;
                $permission->active = $request->active == 'true' ? 1 : 0;
                $permission->save();
            } catch (\Throwable $th) {
                return response()->json([
                    'success' => false,
                    'message' => $th->getMessage()
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data updated Successfully',
                'data'    => $permission
            ], 200);
        } else if ($name == 'toggle_permission_active_status') {

            $Permission = model('Permission')::find($req->id);
            $Permission->active = $req->active == 'true' ? 1 : 0;
            $Permission->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
                'data'    => $Permission
            ], 200);

            // return res_msg('Permission active status updated successfully!', 200);
        } else  if ($name == 'store_role_data') {
            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'type' => 'required',
                'code' => 'required'
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validate->errors()
                ], 422);
            }

            try {

                $input = $request->all();
                $model = model('Role')::create($input);

                return response()->json([
                    'success' => true,
                    'message' => 'Data Created Successfully',
                    'data'  => $model
                ], 201);
            } catch (\Throwable $th) {
                return response()->json([
                    'success' => false,
                    'message' => $th->getMessage()
                ], 500);
            }
        } else if ($name == 'update_role_data') {

            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'type' => 'required',
                'code' => 'required'
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validate->errors()
                ], 422);
            }

            $role = model('Role')::find($req->id);

            if (!$role) {
                return response([
                    'success' => false,
                    'message' => 'Data not found.'
                ]);
            }

            try {
                $role->type  = $request->type;
                $role->name  = $request->name;
                $role->code  = $request->code;
                $role->save();
            } catch (\Throwable $th) {
                return response()->json([
                    'success' => false,
                    'message' => $th->getMessage()
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data update Successfully',
                'data'    => $role
            ], 200);
        } else  if ($name == 'store_role_permission_data') {

            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'type' => 'required',
                'code' => 'required'
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'validation error',
                    'errors' => $validate->errors()
                ], 422);
            }

            try {

                if (!$req->role_permission_ids || count($req->role_permission_ids) < 1) {
                    return res_msg('Please select permissions', 422);
                }

                $role = model('Role')::create([
                    'company_id' => $user->company_id,
                    'type' => $req->type,
                    'name' => $req->name,
                    'code' => $req->code,
                ]);

                foreach($req->role_permission_ids as $permission_id) {
                    model('PermissionRole')::create([
                        'permission_id' => (int) $permission_id,
                        'role_id' => $role->id,
                    ]);
                }

                return res_msg('Role permission inserted Successfully', 201);

            } catch (\Throwable $th) {
                return response()->json([
                    'success' => false,
                    'message' => $th->getMessage()
                ], 500);
            }

        } else  if ($name == 'update_role_permission_data') {

            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'type' => 'required',
                'code' => 'required'
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validate->errors()
                ], 422);
            }

            try {

                if (!$req->role_permission_ids || count($req->role_permission_ids) < 1) {
                    return res_msg('Please select permissions', 422);
                }

                $role = model('Role')::find($req->id);
                $role->update([
                    // 'type' => $req->type,
                    'name' => $req->name,
                    // 'code' => $req->code,
                ]);

                model('PermissionRole')::where('role_id', $role->id)->delete();

                foreach($req->role_permission_ids as $permission_id) {
                    model('PermissionRole')::create([
                        'permission_id' => (int) $permission_id,
                        'role_id' => $role->id,
                    ]);
                }

                return res_msg('Role permission updated Successfully', 200);

            } catch (\Throwable $th) {
                return response()->json([
                    'success' => false,
                    'message' => $th->getMessage()
                ], 500);
            }

        } else if ($name == 'toggle_role_active_status') {

            $role = model('Role')::find($req->id);
            $role->active = $req->active == 'true' ? 1 : 0;
            $role->save();

            return res_msg('Status Changed successfully!', 200,[
                'data'    => $role
            ]);

        } else if ($name == 'delete_role_data') {

            $roleDelete = model('Role')::find($req->id);

            if (!$roleDelete) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data not found.'
                ]);
            }
            $roleDelete->delete();

            return res_msg('Role deleted successfully!', 200);

        } else if ($name == 'delete_role_permission_data') {

            $role = model('Role')::find($req->id);

            if (!$role) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data not found.'
                ]);
            }
            model('PermissionRole')::where('role_id', $role->id)->delete();
            $role->delete();

            return res_msg('Role permission deleted successfully!', 200);

        }

		return response(['msg' => 'Sorry!, found no named argument.'], 403);
	}


	// public function download_pdf() {

	// 	$pdf = PDF::loadView('pdf.invoice')->setPaper('a4', 'portrait');
    //     return $pdf->stream('invoice.pdf');

	// }
}
