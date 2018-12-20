<?php

namespace App\Http\Controllers\reminder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Reminder;
use Auth;

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
        $reminder = Reminder::wher('user_id',$currentUser->user_id)->get();
      }else {
        $user = User::all();
        $reminder = Reminder::all();
      }

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
}
