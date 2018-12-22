<?php

namespace App\Http\Controllers\reminder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Reminder;
use Auth;
use App\Models\Tasks;
use Carbon\Carbon;
use Toastr;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $currentUser = Auth::user();

      if ($currentUser->user_type_id != '1') {
        $user = User::where('user_id',$currentUser->user_id)->get();
        
        $reminder = Reminder::where('user_id',$currentUser->user_id)->get();
      }else {
        $user = User::all();
        $reminder = Reminder::all();
      }
      $auth = auth()->user();
      $this->addData('auth', $auth);
      $this->addData('reminder',$reminder);
      $this->addData('user',$user);
      return $this->getView("reminder.index");
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
        $reminder = new Reminder;
        $reminder = $reminder->fill($request->all());
        $res = $reminder->save();
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
      $reminder = Reminder::find($id);
      $reminder->user_reminder_status = 'completed';
      $reminder->save();
      return redirect()->back();
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
        $reminder = Reminder::find($id);
        $reminder = $reminder->fill($request->all());
        $reminder->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $res = Reminder::destroy($id);
      return redirect()->back();
    }

    public function convertToTask(Request $request) {
      $user_reminder_id = $request->get('user_reminder_id');
      $reminder = Reminder::find($user_reminder_id);
      $new_task = new Tasks();
      $new_task->task_assigned_by = Auth::id();
      $new_task->task_title = "Converted this task from reminder by " . auth()->user()->full_name . ".";
      $new_task->task_description = $reminder->user_reminder_details;
      $new_task->task_created_by = Auth::id();
      $new_task->task_assigned_to = $reminder->user_id;
      $new_task->created_at = Carbon::now();
      $res = $new_task->save();
      $reminder->user_reminder_status = 'converted';
      $reminder->update();
      if($res) {
        Toastr::success('Reminder converted to task successfully');
      } else {
        Toastr::error('Could not convert. Something went wrong.');
      }
      return redirect()->back();
    }

}
