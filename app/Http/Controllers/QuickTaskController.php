<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuickTask;

class QuickTaskController extends Controller
{
    public function store(Request $request)
    {
        $quickTask = new QuickTask;
        $quickTask = $quickTask->fill($request->all());
        $res = $quickTask->save();

        $quickTaskReturn = QuickTask::where('user_quicktask_userid',$request->input('user_quicktask_userid'))
        ->orderBy('user_quicktask_id','DESC')
        ->take(1)->get()->toJson();

        return $quickTaskReturn;
    }
}
