/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function () {

  'use strict';
  // jQuery UI sortable for the todo list
  $('.todo-list').sortable({
    placeholder         : 'sort-highlight',
    handle              : '.handle',
    forcePlaceholderSize: true,
    zIndex              : 999999
  });
  /* The todo list plugin */
  $('.todo-list').todoList({
    onCheck  : function () {
      window.console.log($(this), 'The element has been checked');
    },
    onUnCheck: function () {
      window.console.log($(this), 'The element has been unchecked');
    }
  });

  $('#add-todo').click(function(){
    $('.add-quickTask').show(200);
    $('.add-quickTask').attr('required',true);
  });

  $('#add-quickTaskText').keyup(function(event){
    event.preventDefault();
    var quicktaskText = $('#add-quickTaskText').val();
    var userId = $('#add-quickTaskUser').val();
    if (event.keyCode == 13) {
      $.ajax({
       type: "POST",
       url: '/savequicktask/savetask',
       data: { 'user_quicktask_content' : quicktaskText, 'user_quicktask_userid' : userId }, // serializes the form's elements.
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       success: function(data)
       {
         var obj = jQuery.parseJSON(data);
          $.each(obj, function(key,value) {

            $("ul.todo-list").append(
              '<li>'+
                '<!-- checkbox -->'+
                '<input type="checkbox" value="">'+
                '<!-- todo text -->'+
                '<span class="text">'+ value.user_quicktask_content +'</span>'+
                '<!-- Emphasis label -->'+
                '<small class="label label-danger"><i class="fa fa-clock-o"></i></small>'+
                '<!-- General tools such as edit or delete-->'+
                '<div class="tools">'+
                '  <i class="fa fa-edit"></i>'+
                '  <i class="fa fa-trash-o"></i>'+
                '  </div>'+
                '</li>'
            );
          });
         $('#add-quickTaskText').val(''); // Clear the textbox.
       }
     });
    }
  })

});
