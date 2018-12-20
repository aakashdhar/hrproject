<div class="modal fade" id="updatereminderModal_{{$value->user_reminder_id}}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <form class="form" action="{{route('reminder.update', $value->user_reminder_id)}}" method="post" autocomplete="off">
      @method('PUT')
      {{ csrf_field() }}
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="">Update Reminder</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                  <label for="">Select User</label>
                  <select name="user_id" class="form-control">
                      <option disabled selected>Select user</option>
                       @foreach($user as $val)
                      <option value="{{$val->user_id}}" {{($val->user_id == $value->user_id)?'selected':''}}>
                           {{ucwords($val->user_first_name)}} {{ucwords($val->user_last_name)}} [{{ $val->user_name }}]
                       </option>
                       @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="">Reminder Date</label>
                  <input type="date" name="user_remind_on" class="form-control" id="" value="{{$value->user_remind_on}}" placeholder="Select Date">
                </div>
                <div class="form-group">
                  <label for="">Reminder Details</label>
                  <textarea name="user_reminder_details" rows="6" cols="71" class="form-contol">{{$value->user_reminder_details}}</textarea>
                </div>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>
