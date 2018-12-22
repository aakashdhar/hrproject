<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Managers\LeaveManager;
use Auth;
use Session;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\UserAttendance;
use App\Models\LeaveApplication;
use DB;

class LeaveController extends Controller
{
    private $leave_manager;

    private static $weekends = ["Saturday", "Sunday"];

    public function __construct(LeaveManager $leave_manager)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->leave_manager = $leave_manager;
    }
    public function index(Request $request)
    {
        $user = \Auth::user();

        $this->addArray($this->standardData());

		/* Get User's all Leave Applications */

        $users_leaves = $this->leave_manager->getLeaveApplications([

            'user_id' => $user->user_id,
        ]);

		/* Get User's all Leave Applications Ends Here */

		/* Collect Pending Leaves */

        $pending_applications = $users_leaves->where("status", "Pending");

		/* Collect Pending Leaves Ends Here */

		/* Collect approved */

        $approved_leaves = $users_leaves->where("status", 'Approved');

        $taken_leaves = $approved_leaves->sum(function ($item) {

            return $item->total_days;
        });

        $pending_approval = $pending_applications->sum(function ($item) {

            return $item->total_days;
        });

		/* Collect approved Ends Here*/

		/* History */

        $leave_history = $users_leaves->whereIn("status", ['Approved', 'Rejected', 'Cancelled']);

		/* History */

		/* Total Allocated Leaves */
        $total_allocated_leaves = $user->total_leaves;

        $leave_balance = $total_allocated_leaves - ($taken_leaves + $pending_approval);

        if ($user->user_type_id == 1) {
            $total_pending_leaves = $this->leave_manager->getLeaveApplications([

                "status" => "Pending"

            ])->count();

            $this->addData('total_pending_leaves', $total_pending_leaves);
        }

        $attendace_detail = self::getAttendanceDetails($user);

        $this->addData('attendace_detail', $attendace_detail);
        $this->addData('pending_applications', $pending_applications);

        $this->addData('approved_leaves', $approved_leaves);

        $this->addData('leave_history', $leave_history);

        $this->addData('user', $user);

        $this->addArray(compact('taken_leaves', 'total_allocated_leaves', 'leave_balance', 'pending_approval'));

        return $this->getView('leaves.index');
    }

    public function applications(Request $request)
    {
        if (\Auth::user()->user_type_id != 1) {
            return redirect("leaves/list");
        }

        $user_id = $request->user_id;

        $status = $request->has('status') ? $request->status : 'Pending';

        $from_date = $request->from_date;

        $to_date = $request->to_date;

        $this->addArray($this->standardData());

        $params = compact('user_id', 'status', 'from_date', 'to_date');

        $leave_applications = $this->leave_manager->getLeaveApplications($params);

        $leave_history = $this->leave_manager->getLeaveHistory($params);

        $user = \Auth::user();

        $attendace_detail = self::getAttendanceDetails($user);

        $this->addData('attendace_detail', $attendace_detail);

        $this->addData('leave_applications', $leave_applications);

        $this->addData('leave_history', $leave_history);

        $this->addArray($params);

        return $this->getView('leaves.applications');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, LeaveApplication $leave_application)
    {
        $user = \Auth::user();
        
        $leave_balance = $this->leave_manager->getUsersLeaveBalance($user->user_id);
        
        
        // if (!$leave_balance) {
            
        //     return redirect()->back();
        // }

        $approvers = $this->leave_manager->getLeaveApprovers();

        $holidays = $this->leave_manager->getCurrentYearsHolidays();

        $this->addData('holidays', $holidays);

        $this->addData('approvers', $approvers);

        $this->addData('leave_application', $leave_application);

        $this->addData('leave_balance', $leave_balance);

        return $this->getView('leaves.leaveForm');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, LeaveApplication $leave_application)
    {
        $user = \Auth::user();

        $leave_balance = $this->leave_manager->getUsersLeaveBalance($user->user_id);

        if (!$leave_balance) {
            return redirect("leaves/list");
        }

        $from = Carbon::createFromFormat("Y-m-d", $request->from_date);

        $to = Carbon::createFromFormat("Y-m-d H:i:s", $request->to_date . " 23:59:59");

        $total_days = $from->diffInDays($to) + 1;

        $holidays = $this->leave_manager->getCurrentYearsHolidays();

        $interval = CarbonInterval::days(1);

        $days = new \DatePeriod($from, $interval, $to);

        foreach ($days as $day) {
            if (in_array($day->format('l'), self::$weekends)) {
                !$holidays->contains($day->format('Y-m-d')) && $holidays->push($day->format('Y-m-d'));
            }
        }

        foreach ($holidays as $holiday) {
            $holiday = Carbon::createFromFormat("Y-m-d", $holiday);

            $holiday->between($from, $to) && $total_days--;
        }

        if ($total_days > $leave_balance) {

            return redirect("leaves/apply");
        }

        $result = $this->leave_manager->doApplyForLeave($leave_application, [

            'from_date' => $request->from_date,

            'to_date' => $request->to_date,

            'approver_id' => $request->approver_id,

            'reason' => $request->reason,

            'total_days' => $total_days,

            'applicant_id' => $user->user_id,
        ]);

        return redirect('leaves/list');
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

    public function approveBulk(Request $request)
    {

        if (\Auth::user()->user_type_id != 1) {
            return response()->json([

                "success" => false,

                "message" => "You are not Authorized person to perform this action."

            ], 422);
        }

        if (!$request->has('leaves') && $request->leaves) {

            return response()->json([

                "success" => false,

                "message" => "Please select any record to Approve."

            ], 422);
        }

        $result = $this->leave_manager->approveLeaves($request->leaves);

        return response()->json([

            "success" => $result,

            "message" => $result ? "Leaves Approved Successfully" : "There were some errors. Please try again."

        ], 200);

    }

    public function deleteBulk(Request $request)
    {
        if (\Auth::user()->user_type_id != 1) {

            return response()->json([

                "success" => false,

                "message" => "You are not Authorized person to perform this action."

            ], 422);
        }


        if (!$request->has('leaves') && $request->leaves) {

            return response()->json([

                "success" => false,

                "message" => "Please select any record to delete."

            ], 422);
        }

        $result = $this->leave_manager->deleteLeaves($request->leaves);


        return response()->json([

            "success" => $result,

            "message" => $result ? "Records deleted Successfully" : "There were some errors. Please try again."

        ], 200);
    }

    private function standardData()
    {
        $user = Auth::user();

        $applicants = $this->leave_manager->getLeaveApplicants();
        return compact('user', 'applicants');
    }

    public function approveLeave(LeaveApplication $leave_application, Request $request)
    {
        if ($leave_application->approver_id != \Auth::user()->user_id) {

            return redirect('leaves/applications');
        }

        $result = $this->leave_manager->doLeaveApproval($leave_application, $request->approval_comment);


        return redirect('leaves/applications');
    }

    public function rejectLeave(LeaveApplication $leave_application, Request $request)
    {
        if ($leave_application->approver_id != \Auth::user()->user_id) {

            return redirect('leaves/applications');
        }

        $result = $this->leave_manager->doLeaveRejection($leave_application, $request->approval_comment);


        return redirect('leaves/applications');
    }

    public function cancelLeave(LeaveApplication $leave_application, Request $request)
    {
        if ($leave_application->applicant_id != \Auth::user()->user_id) {

            return redirect('leaves/list');
        }

        $result = $this->leave_manager->doLeaveCancellation($leave_application, $request->cancel_reason);


        return redirect('leaves/list');
    }


    public function getAttendanceDetails($user){

        $month_array = DB::table("user_attendance")
            ->select(DB::raw("MONTH(attendance_date) as month"),DB::raw("YEAR(attendance_date) as year"))
            ->groupBy(DB::raw("MONTH(attendance_date)"),DB::raw("YEAR(attendance_date)"))
            ->get();
        $month = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
        $count = array();

        $user_attendance = UserAttendance::all();
        $user_attendance = $user_attendance->groupBy('user_id');

                foreach($user_attendance as $key_attendance => $value_attendance) {
                    foreach ($month_array as $key => $value){

                    $count[$key_attendance][$value->year]['user_id'] = $key_attendance;
                    $count[$key_attendance][$value->year]['year'] = $value->year;

                    }
        }

        return $count;

    }

    public static function getAttendance($user_id,$year){

        $user_attendance = UserAttendance::where('user_id','=',$user_id)->whereYear('attendance_date','=',$year);
        $user_attendance_present = $user_attendance->select(DB::raw("MONTH(attendance_date) as month"),DB::raw("COUNT(*) as count"))->where('attendance_status','=','Present')->groupBy(DB::raw("MONTH(attendance_date)"));
        $user_attendance_present = $user_attendance_present->get();
                        $presentMonth = $user_attendance_present->pluck('month')->toArray();
                        $allMonths = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
                        foreach ($allMonths as $key => $value) {
                            if (!in_array($value, $presentMonth)) {
                                if ($user_attendance_present->count() > 0) {
                                    $cloned = clone $user_attendance_present[0];
                                    $cloned->month = $value;
                                    $cloned->count = 0;
                                    $user_attendance_present->push($cloned);
                                }
                            }
                        }
                        $user_attendance_present = $user_attendance_present->sortBy('month');

        $user_attendance_absent = UserAttendance::where('user_id','=',$user_id)->whereYear('attendance_date','=',$year);
        $user_attendance_absent = $user_attendance_absent->select(DB::raw("MONTH(attendance_date) as month"),DB::raw("COUNT(*) as count"))->where('attendance_status','=','Absent')->groupBy(DB::raw("MONTH(attendance_date)"));
        $user_attendance_absent = $user_attendance_absent->get();
                        $absentMonth = $user_attendance_absent->pluck('month')->toArray();
                        foreach ($allMonths as $key => $value) {
                            if (!in_array($value, $absentMonth)) {
                                if ($user_attendance_absent->count() > 0) {
                                    $cloned = clone $user_attendance_absent[0];
                                    $cloned->month = $value;
                                    $cloned->count = 0;
                                    $user_attendance_absent->push($cloned);
                                }
                            }
                        }
                        $user_attendance_absent = $user_attendance_absent->sortBy('month');
                        
        $user_attendance_half_day = UserAttendance::where('user_id','=',$user_id)->whereYear('attendance_date','=',$year);
        $user_attendance_half_day = $user_attendance_half_day->select(DB::raw("MONTH(attendance_date) as month"),DB::raw("COUNT(*) as count"))->where('attendance_status','=','1/2 Day')->groupBy(DB::raw("MONTH(attendance_date)"));
        $user_attendance_half_day = $user_attendance_half_day->get();
                        $halfdayMonth = $user_attendance_half_day->pluck('month')->toArray();
                        foreach ($allMonths as $key => $value) {
                            if (!in_array($value, $halfdayMonth)) {
                                if ($user_attendance_half_day->count() > 0) {
                                    $cloned = clone $user_attendance_half_day[0];
                                    $cloned->month = $value;
                                    $cloned->count = 0;
                                    $user_attendance_half_day->push($cloned);
                                }
                            }
                        }
                        $user_attendance_half_day = $user_attendance_half_day->sortBy('month');
        $count = array();
        foreach($user_attendance_present as $k => $v){
            $count['present'][$k]['month'] = $v->month;
            $count['present'][$k]['count'] = $v->count;
            $count['present'][$k]['status'] = 'Present';
        }

        foreach($user_attendance_absent as $k => $v){
            $count['absent'][$k]['month'] = $v->month;
            $count['absent'][$k]['count'] = $v->count;
            $count['absent'][$k]['status'] = 'Absent';
        }

        foreach($user_attendance_half_day as $k => $v){
            $count['half'][$k]['month'] = $v->month;
            $count['half'][$k]['count'] = $v->count;
            $count['half'][$k]['status'] = '1/2 Day';
        }
        return $count;
    }


}
