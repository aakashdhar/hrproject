var LeaveApply = (function () {

    var init = function () {
        console.log('here');
        initCustomDateRange($("#from_date"), $("#to_date"));

        $(".selectpicker").select2()

        validateForm();
    }

    var weekends = ["Sat", "Sun"];

    var calculateTotalDays = function (from_date, to_date) {

        if (from_date && to_date) {
            var from = new moment(from_date)

            var to = new moment(to_date)

            var duration = moment.duration(to.diff(from));

            var days = duration.asDays() + 1;

            weekends.indexOf(from.format('ddd')) > -1 && holidays.indexOf(from.format('YYYY-MM-DD')) <= -1 && holidays.push(from.format('YYYY-MM-DD'))

            var day = from;

            for (var i = 0; i < days - 1; i++) {
                day.add(1, 'd');

                weekends.indexOf(day.format('ddd')) > -1 && holidays.indexOf(day.format('YYYY-MM-DD')) <= -1 && holidays.push(day.format('YYYY-MM-DD'))
            }

            from = new moment(from_date).add(-1, 'd')

            to = new moment(to_date).add(1, 'd')

            $.each(holidays, function (index, value) {

                moment(value).isBetween(from.format("YYYY-MM-DD"), to.format("YYYY-MM-DD")) && days--;
            });

            days = days > 0 ? days : 0;

            $("#total_days").val(days);

            $("#remaining_leaves").html(leave_balance - days);
        }
    }

    var validateForm = function () {

        $("#leave_form").validate({

            ignore: '',

            rules: {

                from_date: {

                    required: true
                },

                to_date: {

                    required: true,
                },

                total_days: {

                    required: true,

                    min: 1,

                    max: leave_balance
                },

                reason: {

                    required: true,
                },

                approver_id: {

                    required: true
                }
            },

            errorPlacement: function (error, element) {

                switch (element.attr("name")) {
                    case 'approver_id':

                        error.insertAfter(element.parent().find('.select2-container'));

                        break;

                    case 'from_date':

                    case 'to_date':

                        error.insertAfter(element.closest('.input-group'));

                        break;

                    default:

                        error.insertAfter(element);

                        break;
                }
            },

            messages: {

                total_days: {

                    min: "Leave application must contain at least 1 working day.",

                    max: "Leave balance must not exceed."
                }
            }
        })
    }

    var initCustomDateRange = function (fromElement, toElement) {

        fromElement.datepicker({

            format: "dd-mm-yy",

            autoclose: true,

            // startDate : '+0'

        }).on("changeDate", function (e) {

            var toDate;
            toDate = toElement.datepicker("getDate")

            if (!toDate || (toDate.valueOf() < e.date.valueOf())) {
                toElement.datepicker("setDate", e.date);

                !toDate ? toElement.datepicker("show") : '';
            }

            calculateTotalDays(e.date, toDate)

        }).on("click focusin", function (e) {

            $(this).datepicker("show");
        });

        toElement.datepicker({

            format: "dd-mm-yy",

            autoclose: true,

            // startDate : '+0'

        }).on("changeDate", function (e) {

            var fromDate;
            fromDate = fromElement.datepicker("getDate")

            if (!fromDate || (fromDate.valueOf() > e.date.valueOf())) {
                fromElement.datepicker("setDate", e.date);

                !fromDate ? fromElement.datepicker("show") : '';
            }

            calculateTotalDays(fromDate, e.date)

        }).on("click focusin", function (e) {

            $(this).datepicker("show");
        });
    }

    return {

        init: init,
    }
})();

$(function () {

    LeaveApply.init();
});