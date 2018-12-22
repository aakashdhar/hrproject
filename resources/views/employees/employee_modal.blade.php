{{-- Update employee --}}
<div id="updateAdminModal_{{ $val->user_id }}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <form action="/employee/update/{{ $val->user_id }}" id="updateAdmin_{{ $val->user_id }}" method="POST">
                {{csrf_field()}}
                <input type="hidden" name="type" value="store">
                <input type="hidden" name="user_id" value="{{ $val->user_id }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update admin : {{ $val->user_first_name }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="user_name">User name</label>
                            <input type="text" name="user_name" id="user_name" value="{{ $val->user_name }}" class="form-control" placeholder="First name" required>
                        </div>
                        <div class="col-md-4">
                            <label for="user_first_name">First name</label>
                            <input type="text" name="user_first_name" value="{{ $val->user_first_name }}" id="user_first_name" class="form-control" placeholder="First name" required>
                        </div>
                        <div class="col-md-4">
                            <label for="user_last_name">Last name</label>
                            <input type="text" name="user_last_name" value="{{ $val->user_last_name }}" id="user_last_name" class="form-control" placeholder="Last name">
                        </div>

                    </div>
                    <div class="row" style="margin-top: 2%;">
                        <div class="col-md-4">
                            <label for="user_email">Email</label>
                            <input type="email" name="user_email" value="{{ $val->user_email }}" id="user_email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="col-md-4">
                            <label for="user_contact_no">Contact</label>
                            <input type="text" name="user_contact_no" value="{{ $val->user_contact_no }}" id="user_contact_no" class="form-control" placeholder="Contact no" maxlength="10">
                        </div>
                        <div class="col-md-4"  style="display:none">
                            <label for="user_password">Password</label>
                            <input type="password" name="user_password" value="{{ $val->user_password_raw }}" id="user_password" class="form-control" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 2%;">
                      <div class="col-md-4">
                        <label for="user_address">Address line 1</label>
                        <input name="user_address" class="form-control" value="{{ $val->user_address }}"  id="user_address" placeholder="Address">
                      </div>
                      <div class="col-md-4">
                        <label for="user_city">City</label>
                        <input name="user_city" class="form-control" value="{{ $val->user_city }}"  id="user_city" placeholder="City">
                      </div>
                      <div class="col-md-4">
                        <label for="user_state">State</label>
                        <input name="user_state" class="form-control" value="{{ $val->user_state }}"  id="user_state" placeholder="State">
                      </div>
                    </div>
                    <div class="row" style="margin-top: 2%;">
                      <div class="col-md-4">
                        <label for="user_address">Date of joining</label>
                        <input type="date" name="joining_date" class="form-control" value="{{$val->joining_date}}" id="joining_date" placeholder="Date of Joining">
                      </div>
                      <div class="col-md-4">
                        <label for="user_address">Date of birth</label>
                        <input type="date" name="user_dob" class="form-control" value="{{$val->user_dob}}"  id="user_dob" placeholder="Date of birth">
                      </div>
                      <div class="col-md-4">
                        <label for="user_address">Designation</label>
                        <select name="user_designation" class="form-control">
                            <option disabled selected>Select designation</option>
                             @foreach($designation as $vals)
                               <option value="{{$vals->user_designation_title}}">{{ucwords($vals->user_designation_title)}}</option>
                             @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="row" style="margin-top: 2%;">
                      <div class="col-md-4">
                        <label for="user_leave">Number of Leaves</label>
                        <input name="user_leave" class="form-control" value="{{ $val->user_leave }}" id="user_leave" placeholder="Number of Leaves">
                      </div>
                      <div class="col-md-4">
                        <label for="user_address">Emergency Contact Person</label>
                        <input name="user_emergency_name" class="form-control" value="{{ $val->user_emergency_name }}" id="user_emergency_name" placeholder="Emergency Contact">
                      </div>
                      <div class="col-md-4">
                        <label for="user_address">Emergency Contact number</label>
                        <input name="user_emergency_contact" class="form-control" value="{{ $val->user_emergency_contact }}" id="user_emergency_contact" placeholder="Emergency Contact Number" maxlength="10">
                      </div>
                    </div>
                    <div class="row" style="margin-top: 2%;">
                      <div class="col-md-12">
                        <label for="user_address">Hobbies</label>
                        <input name="user_hobbies" class="form-control" value="{{ $val->user_hobbies }}" id="user_hobbies" placeholder="Hobbies" required>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="viewAdminModal_{{ $val->user_id }}" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
           <h4 class="modal-title">{{ucfirst($val->user_first_name)}} {{ucfirst($val->user_last_name)}}</h4>
         </div>
         <div class="modal-body">
           <div class="row">
               <div class="col-md-4">
                   <label for="user_name">User name</label>
                   <input type="text" name="user_name" id="user_name" value="{{ $val->user_name }}" class="form-control" placeholder="First name" readonly>
               </div>
               <div class="col-md-4">
                   <label for="user_first_name">First name</label>
                   <input type="text" name="user_first_name" value="{{ $val->user_first_name }}" id="user_first_name" class="form-control" placeholder="First name" readonly>
               </div>
               <div class="col-md-4">
                   <label for="user_last_name">Last name</label>
                   <input type="text" name="user_last_name" value="{{ $val->user_last_name }}" id="user_last_name" class="form-control" placeholder="Last name" readonly>
               </div>
           </div>
           <div class="row" style="margin-top: 2%;">
               <div class="col-md-4">
                   <label for="user_email">Email</label>
                   <input type="email" name="user_email" value="{{ $val->user_email }}" id="user_email" class="form-control" placeholder="Email" readonly>
               </div>
               <div class="col-md-4">
                   <label for="user_contact_no">Contact</label>
                   <input type="text" name="user_contact_no" value="{{ $val->user_contact_no }}" id="user_contact_no" class="form-control" placeholder="Contact no" readonly>
               </div>
           </div>
           <div class="row" style="margin-top: 2%;">
             <div class="col-md-4">
               <label for="user_address">Address line 1</label>
               <input name="user_address" class="form-control" value="{{ $val->user_address }}"  id="user_address" placeholder="Address" readonly>
             </div>
             <div class="col-md-4">
               <label for="user_city">City</label>
               <input name="user_city" class="form-control" value="{{ $val->user_city }}"  id="user_city" placeholder="City" readonly>
             </div>
             <div class="col-md-4">
               <label for="user_state">State</label>
               <input name="user_state" class="form-control" value="{{ $val->user_state }}"  id="user_state" placeholder="State" readonly>
             </div>
           </div>
           <div class="row" style="margin-top: 2%;">
             <div class="col-md-4">
               <label for="user_address">Date of joining</label>
               <input type="date" name="joining_date" class="form-control" value="{{$val->joining_date}}" id="joining_date" placeholder="Date of Joining" readonly>
             </div>
             <div class="col-md-4">
               <label for="user_address">Date of birth</label>
               <input type="date" name="user_dob" class="form-control" value="{{$val->user_dob}}"  id="user_dob" placeholder="Date of birth" readonly>
             </div>
             <div class="col-md-4">
               <label for="user_address">Designation</label>
               <input name="user_state" class="form-control" value="{{ $val->user_designation }}"  id="user_state" placeholder="designation" readonly>
             </div>
           </div>
           <div class="row" style="margin-top: 2%;">
             <div class="col-md-4">
               <label for="user_leave">Number of Leaves</label>
               <input name="user_leave" class="form-control" value="{{ $val->user_leave }}" id="user_leave" placeholder="Number of Leaves" readonly>
             </div>
             <div class="col-md-4">
               <label for="user_address">Emergency Contact Person</label>
               <input name="user_emergency_name" class="form-control" value="{{ $val->user_emergency_name }}" id="user_emergency_name" placeholder="Emergency Contact" readonly>
             </div>
             <div class="col-md-4">
               <label for="user_address">Emergency Contact number</label>
               <input name="user_emergency_contact" class="form-control" value="{{ $val->user_emergency_contact }}" id="user_emergency_contact" placeholder="Emergency Contact Number" maxlength="10" readonly>
             </div>
           </div>
          <div class="row" style="margin-top: 2%;">
            <div class="col-md-12">
              <label for="user_address">Hobbies</label>
              <input name="user_hobbies" class="form-control" value="{{ $val->user_hobbies }}" id="user_hobbies" placeholder="Hobbies" readonly>
            </div>
          </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
</div>
<!-- Delete modal  -->
<div id="deleteAdminModal_{{ $val->user_id }}" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="/employee/delete/{{ $val->user_id }}" method="post" id="deleteAdmin_{{ $val->user_id }}">
            {{ csrf_field() }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete admin : {{ $val->user_first_name }}</h4>
            </div>
            <div class="modal-body">
                <p class="lead">Are you sure?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
      </div>
    </div>
</div>
