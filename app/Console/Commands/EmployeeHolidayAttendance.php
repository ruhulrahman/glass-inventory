<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class EmployeeHolidayAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:employee-holiday-attendance';
    protected $signature = 'command:employee_holiday_attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $holiday = model('Holiday')::whereDate('from', '>=', Carbon::now())->whereDate('to', '<=', Carbon::now())->first();

        info($holiday);

        if ($holiday) {
            $employees = model('Employee')::where(['company_id' => $holiday->company_id, 'active' => 1])->get();

            foreach($employees as $employee) {
                model('EmployeeAttendance')::create([
                    'company_id' => $employee->company_id,
                    'employee_id'=> $employee->id,
                    'attendance'=> 'Holiday',
                    'attendance_date'=> Carbon::now(),
                    'created_at'=> Carbon::now(),
                ]);
            }
            // $this->info('command:Employee holiday attendance run successfully!');
        }

    }
}
