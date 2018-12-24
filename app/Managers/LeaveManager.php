<?php

namespace App\Managers;

use App\Models\User;

use App\Models\LeaveApplication;

use Illuminate\Http\Request;

// use App\Models\Holiday;

use DB;
use App\Models\Holiday;

class LeaveManager
{
	private static $userLeavesBalance = [];

	public function getLeaveApplications($params = [])
	{
		return LeaveApplication::where(function($query) use($params) {

				if(!empty($params['user_id']))
				{
					$query->where('applicant_id', $params['user_id']);
				}

				if(!empty($params['status']) && "All" != $params['status'])
				{
					$query->where('status', $params['status']);
				}

				if(!empty($params['from_date']) && !empty($params['to_date']))
				{
					$query->where(function($que) use($params) {

						$que->where(function($q) use($params) {

							$q->where("from_date", ">=", $params['from_date'])

							->where("from_date", "<=", $params['to_date']);
						});

						$que->orWhere(function($q) use($params) {

							$q->where("to_date", ">=", $params['from_date'])

							->where("to_date", "<=", $params['to_date']);
						});
					});
				}

				if(empty($params["year"]))
				{
					$params["year"] = date("Y");
				}

				$year = $params["year"];

				$query->where(function($q) use($year) {

					$q->where("from_date", ">=", date("{$year}-01-01"))

						->orWhere("to_date", "<=", date("{$year}-12-31"));
				});


			})

			->with($this->getFiledsRelationShips())

			->orderBy('leave_id', 'DESC')

			->get();
	}

	public function getLeaveHistory($params = [])
	{
		return LeaveApplication::where(function($query) use($params) {

				if(!empty($params['user_id']))
				{
					$query->where('applicant_id', $params['user_id']);
				}

				$query->whereIn('status', ['Approved', 'Rejected']);

				if(empty($params["year"]))
				{
					$params["year"] = date("Y");
				}

				$year = $params["year"];

				$query->where(function($q) use($year) {

					$q->where("from_date", ">=", date("{$year}-01-01"))

						->orWhere("to_date", "<=", date("{$year}-12-31"));
				});
			})

			->with($this->getFiledsRelationShips())

			->orderBy('leave_id', 'DESC')

			->get();
	}

	public function getFiledsRelationShips()
	{
		return collect($this->defineLeaveRelationShips())->map(function ($item, $key) {

			return function ($query) use($item) {

				$query->select( isset($item['select']) ? $item['select'] : '*');
			};

		})->toArray();
	}

	public function defineLeaveRelationShips()
	{
		return [

			"applicant" => [

				"select" => ['user_id', 'user_first_name', 'user_last_name'],
			],

			"approver" => [

				"select" => ['user_id', 'user_first_name', 'user_last_name'],
			]
		];
	}
	public function updateLeaveApplication(LeaveApplication $leave_application, array $attributes=[])
	{
		return DB::transaction(function() use($leave_application, $attributes) {

			foreach ($attributes as $key => $value)
			{
				$leave_application->{$key} = $value;
			}

			return $leave_application->save();
		});
	}

	public function doLeaveApproval(LeaveApplication $leave_application, $request)
	{
		$leave = LeaveApplication::find($request->id);
		$leave->approval_comment = $request->approval_comment;
		$leave->status = "Approved";
		$res = $leave->update();
		return $res;
	}

	public function doLeaveRejection(LeaveApplication $leave_application, $request)
	{
		$leave = LeaveApplication::find($request->id);
		$leave->cancel_reason = $request->cancel_reason;
		$leave->status = "Rejected";
		$res = $leave->update();
		return $res;
	}

	public function doLeaveCancellation(LeaveApplication $leave_application, $request)
	{
		$leave = LeaveApplication::find($request->id);
		$leave->cancel_reason = $request->cancel_reason;
		$leave->status = "Cancelled";
		$res = $leave->update();
		return $res;
	}

	public function getUsersLeaveBalance($user_id=null)
	{
		if(empty($user_id))
		{
			$user_id = \Auth::user()->user_id;
		}

		if(isset(self::$userLeavesBalance[$user_id]))
		{
			return self::$userLeavesBalance[$user_id];
		}

		$applied_count = LeaveApplication::where("applicant_id", $user_id)

			->whereIn("status",["Approved", "Pending"])

			->sum('total_days');

		return self::$userLeavesBalance[$user_id] = ( \Auth::user()->user_leave - $applied_count );
	}

	public function getLeaveApprovers()
	{
		return User::where("user_type_id", "1")

			// ->where("user_status", "Active")

			->get()

			->pluck('user_first_name', 'user_id');
	}

	public function getLeaveApplicants()
	{
		// return User::whereIn("user_type_id", ["Admin", "SuperAdmin","AccountAdmin","IndiaAdmin","Staff"])

		// 	->where("user_status", "Active")

		// 	->get()

		// 	->pluck('user_first_name', 'user_id');
		return User::all()->pluck('user_first_name', 'user_id');
	}

	public function getCurrentYearsHolidays()
	{
		return Holiday::all()->pluck('holiday_date');
	}

	public function doApplyForLeave(LeaveApplication $leave_application, array $input = [])
	{
		return DB::transaction(function() use($leave_application, $input) {

			return $leave_application->fill($input)->save();
		});
	}

	public function deleteLeaves(array $input = [])
    {

    return DB::transaction(function() use($input) {

        return LeaveApplication::destroy($input) !== false;
    });
    }

        public function approveLeaves(array $input = []){



        return DB::transaction(function () use($input){
            $leaves = LeaveApplication::whereIn('leave_id',$input)->get()->keyBy('leave_id');
            foreach ($leaves as $k => $v){
                $v->status = "Approved";
                $v->save();
            }
            return true;
        });

    }


}