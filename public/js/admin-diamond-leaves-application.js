var LeaveApplication = ({

    init: function () {

        var that = this;

        this.handleFormEvents()

        this.initCustomDateRange($("#from_date"), $("#to_date"));
    },

    initCustomDateRange: function (fromElement, toElement) {

        fromElement.datepicker({

            // format : "yyyy-mm-dd",
            dateFormat: "dd-mm-yy",

            autoclose: true

        }).on("changeDate", function (e) {
            console.log(e);
            var toDate;

            toDate = toElement.datepicker("getDate")

            if (!toDate || (toDate.valueOf() < e.date.valueOf())) {
                toElement.datepicker("setDate", e.date);

                !toDate ? toElement.datepicker("show") : '';
            }

        }).on("click focusin", function (e) {

            $(this).datepicker("show");
        });

        toElement.datepicker({

            // format : "yyyy-mm-dd",
            dateFormat: "yy-mm-dd",

            autoclose: true

        }).on("changeDate", function (e) {

            var fromDate;

            fromDate = fromElement.datepicker("getDate")

            if (!fromDate || (fromDate.valueOf() > e.date.valueOf())) {
                fromElement.datepicker("setDate", e.date);

                !fromDate ? fromElement.datepicker("show") : '';
            }

        }).on("click focusin", function (e) {

            $(this).datepicker("show");
        });
    },

    handleFormEvents: function () {

        $("#select_all").change(function () {

            if ($(this).is(":checked")) {
                $(".leave-chk").each(function () {

                    $(this).prop("checked", true);
                })
            }
            else {
                $(".leave-chk").each(function () {

                    $(this).prop("checked", false);
                })
            }

            $.uniform.update()
        });

        $("#delete_leaves").click(function (e) {

            if (!$(".leave-chk:checked").length) {
                toastr.options.positionClass = "toast-top-right";

                toastr["error"]("Please select any record to delete.", "No record selected.");

                return false;
            }

            var chk = [];

            $(".leave-chk:checked").each(function () {

                chk.push($(this).val())
            })

            $("#delete_confirm").modal("show").find("#confirm_delete").one('click', function () {

                $.ajax({

                    url: delete_url,

                    data: { leaves: chk },

                    type: 'POST',

                    dataType: 'JSON',

                    success: function (response) {

                        $("#delete_confirm").modal("hide");

                        location.reload();
                    }
                })
            })
        });

        $("#approve_leaves").click(function (e) {

            if (!$(".leave-chk:checked").length) {
                toastr.options.positionClass = "toast-top-right";

                toastr["error"]("Please select any record to Approve.", "No record selected.");

                return false;
            }

            var chk = [];

            $(".leave-chk:checked").each(function () {

                chk.push($(this).val())
            });
            console.log(approve_url);
            $("#approve_confirm").modal("show").find("#approve_confirm").one('click', function () {

                $.ajax({

                    url: approve_url,

                    data: { leaves: chk },

                    type: 'POST',

                    dataType: 'JSON',

                    success: function (response) {

                        $("#approve_confirm").modal("hide");

                        location.reload();
                    }
                })
            })
        });

        $(".approve-link,.reject-link").click(function (e) {

            e.preventDefault();

            var element = $(this);

            $("#approve_modal,#reject_modal").on('show.bs.modal', function (e) {

                if (element.is(".approve-link")) {
                    $("#modal_title").text("Approve Leave")

                    $("#approve_reason_block").show();

                    $("#reject_reason_block").hide();

                    $("#submit_btn").val("Approve Leave");
                }
                else {
                    $("#modal_title").text("Reject Leave")

                    $("#reject_reason_block").show();

                    $("#approve_reason_block").hide();

                    $("#submit_btn").val("Reject Leave");
                }

                $("#approve_form").attr("action", element.attr("href"));

                $("#applicant").html(element.closest('tr').find('.applicant-name').text());

                $("#modal_from_date").val(element.closest('tr').find('.from-date').text());

                $("#modal_to_date").val(element.closest('tr').find('.to-date').text());

                $("#total_days").val(element.closest('tr').find('.total-days').text());

            }).modal('show');
        })
    }

}).init()
