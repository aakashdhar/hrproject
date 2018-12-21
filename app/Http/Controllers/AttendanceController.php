<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserAttendance;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
use Toastr;
use App\Models\Constants\UserType;
use Carbon\Carbon;
use App\Models\LogTask;
use App\Models\Constants\TaskStatus;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $office_arr = [];
        $this->addData('office_arr',$office_arr);
        $month_id = !empty($request->input('month_id')) ? $request->input('month_id') : 'n';
        $year_id = !empty($request->input('year')) ? $request->input('year') : 'Y';
        $office_id = !empty($request->input('office')) ? $request->input('office') : 1;

        if($month_id != "" && $year_id != "") {
            $working_days = self::getTotalWorkingDays($month_id,$year_id,$office_id);

            $this->addData('month_code',$working_days['month']);
            $this->addData('year_id',$working_days['year_id']);
            $this->addData('month_id',$working_days['month_id']);
            $this->addData('workdays', $working_days['workdays']);
            $this->addData('total',$working_days['total_workday']);
        }

// //        $user_type = ['SuperAdmin','Admin','AccountAdmin','IndiaAdmin','Staff'];
//         $user_type = Role::select('role_name')->distinct()->get();
//         $user_type = $user_type->toArray();

        // $user = User::select('user_first_name','user_last_name','user_id','user_name','user_status','user_type')
        //     ->where('user_status','Active')
        //     ->where('attendance_status','Active')
        //     ->whereIn('user_type',$user_type)
        //     ->where('office_id',$office_id)
        //     ->get();
        // $user_name = $user->pluck('user_first_name','user_id');
        $user = User::whereIn('user_type_id',[3,4])->get();
        $user_name = $user->pluck('user_first_name','user_id');
        $month = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'Octomber', 11 => 'November', 12 => 'December');
        $year = range(2018,2030);
        $year = array_combine($year,$year);
        $attendance = UserAttendance::all();
        $this->addData('attendance',$attendance);
        $this->addData('year',$year);
        $this->addData('month',$month);
        $this->addData('user_name',$user_name);
        $this->addData('user',$user);

        // $view = $this->getView('Attendance/'.strtolower($this->getSystemType()));
        
        $view = $this->getView('Attendance.index');

        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request_arr = array();

        foreach ($request->all() as $key => $value){

            if($key != '_token'){
                $data = explode('-',$key);
                $data[0] = str_replace('/','-',$data[0]);
                $date = date('Y-m-d',strtotime($data[0]));
                $request_arr[$data[0]][$data[1]]['date'] = $date;
                $request_arr[$data[0]][$data[1]]['user_id'] = $data[1];
                $request_arr[$data[0]][$data[1]]['status'] = $value;
            }
        }

        foreach($request_arr as $k => $v){
            foreach($v as $key => $value){
            $attendance = new UserAttendance;
            $attendance->user_id = $value['user_id'];
            $attendance->attendance_status = $value['status'];
            $attendance->attendance_date = $value['date'];
            $attendance->save();
            }
        }
        // send_msg($attendance,'Attendance Updated Successfully','Occuring some error');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getHoilday($date,$office_id){
        $date = str_replace('/','-',$date);
        $date = date('Y-m-d',strtotime($date));
        // $holiday  = Holiday::select('holiday_name')
        //     ->where('holiday_date','=',$date)
        //     ->where('office_location_id','=',$office_id)
        //     ->where('holiday_status','=','Active')
        //     ->first();
            $holiday = [];
        return $holiday;
    }

    public function getTotalWorkingDays($month_id,$year_id,$office_id)
    {

        $total_workday = 0;
        $workdays = array();
        $type = CAL_GREGORIAN;
        $month = date($month_id); // Month ID, 1 through to 12.
        $year = date($year_id); // Year in 4 digit 2009 format.

        $day_count = cal_days_in_month($type, $month, $year); // Get the amount of days
        for ($i = 1; $i <= $day_count; $i++) {
            $date = $year . '/' . $month . '/' . $i; //format date
            $holiday = $this->getHoilday($date, $office_id);
            $get_name = date('l', strtotime($date)); //get week day
            $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
            $date = $i . '/' . $month . '/' . $year; //format date

            $workdays[$i]['day'] = $day_name;
            $workdays[$i]['day_date'] = $date;
            $workdays[$i]['get_name'] = $get_name;
            if (!empty($holiday->holiday_name)) {
                $workdays[$i]['holiday'] = $holiday->holiday_name;
            } else {
                $workdays[$i]['holiday'] = "";
            }
            if ($workdays[$i]['get_name'] != 'Sunday') {
                $total_workday++;
            }


        }
        $data = array();
        $data['year_id'] = $year_id;
        $data['month_id'] = $month_id;
        $data['workdays'] = $workdays;
        $data['month'] = $month;
        $data['total_workday'] = $total_workday;
        return $data;
    }

    public function undoAttendance(Request $request) {
      $user_id = $request->get('undo_user_id');
      $undo_attendance_id = $request->get('undo_attendance_id');
      $undo_key = explode('-', $undo_attendance_id);
      $date = str_replace('/','-',$undo_key[0]);
      $date = date('Y-m-d',strtotime($date));
      $attendance = UserAttendance::where('user_id', '=', $user_id)->where('attendance_date', '=', $date)->first();
      $res = $attendance->delete();

    //   send_msg($res, 'Attendance deleted successfully', 'Could not delete');
      return redirect()->back();

    }



}
