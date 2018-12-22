<div class="panel">
   <div class="panel-body">
      <table class="table table-condensed table-condensed-stats table-bordered">
         <thead>
            <tr>
               <th class="text-left" colspan="2" align="center">My Leave Statistics</th>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td><strong>Pending Approval</strong></td>
               <td><b>{{ $pending_approval }}</b></td>
            </tr>
            <tr>
               <td><strong>Approved</strong></td>
               <td><b>{{ $taken_leaves }}</b></td>
            </tr>
            <tr>
               <td><strong>Current Balance</strong></td>
               <td><b><i>{{ $leave_balance }}</i></b></td>
            </tr>
            <tr>
               <td><strong>Total</strong></td>
               <td><b><i>{{ $total_allocated_leaves }}</i></b></td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
