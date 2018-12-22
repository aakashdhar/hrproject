<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Holiday;
use Toastr;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $holidayEdit = [];
      $holiday = Holiday::all();
      $this->addData('holiday',$holiday);
      $this->addData('holidayEdit',$holidayEdit);
      return $this->getView('settings.holidays.index');
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
      $holiday = new Holiday;
      $holiday->office_location_id = 1;
      $holiday->holiday_status = 'Active';
      $holiday = $holiday->fill($request->all());
      $res = $holiday->save();
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
      $holiday = Holiday::all();
      $this->addData('holiday',$holiday);

      $holidayEdit = Holiday::find($id);
      $this->addData('holidayEdit',$holidayEdit);

      return $this->getView('settings.holidays.index');
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
      $holiday = Holiday::find($id);
      $holiday->office_location_id = 1;
      $holiday->holiday_status = 'Active';
      $holiday = $holiday->fill($request->all());
      $res = $holiday->save();
      return redirect()->route('holidays.index');
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
}
