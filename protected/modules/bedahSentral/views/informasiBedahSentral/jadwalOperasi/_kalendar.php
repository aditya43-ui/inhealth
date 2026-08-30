<link rel="stylesheet" href="themes/neon18/assets/js/fullcalendar-2/fullcalendar.min.css">

<script src='themes/neon18/assets/js/fullcalendar-2/lib/moment.min.js'></script>
<script src='themes/neon18/assets/js/fullcalendar-2/fullcalendar.min.js'></script>
<script src='themes/neon18/assets/js/fullcalendar-2/lang/id.js'></script>

<div id="calendar"></div>

<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogCalendar',
        'options' => array(
            'title' => 'List',
            'autoOpen' => false,
            'width' => 200,
            'height' => 200,
            'resizable' => true,
        ),
    )
);

echo "<div id='render-detail'></div>";

$this->endWidget();
?>

<script>
    var fetched = null;

    var options = {
        header: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        defaultDate: '<?php echo date('Y-m-01'); ?>',
        //dayRender: function( date, cell ) {

        //},
        options: {
            height: 'auto',
        },
        selectable: false,
        selectHelper: false,
        editable: false,
        eventLimit: 3,
        eventLimitText: 'lainnya',
        eventLimitClick: function(cellInfo, jsEvent) {
            var link = '';
            $(cellInfo.segs).each(function(index, val) {
                link += "<a data-html='true' data-toggle='popover' data-trigger='click' data-placement='top' data-content='" + val.event.keterangan + "' data-original-title='" + cellInfo.date + "' href='javascript:;' class='fc-day-grid-event fc-event fc-not-start fc-not-end showpop'   style='color:#fff;width:100%;margin:1px;background:" + val.event.color + " !important;border-color:" + val.event.color + "  !important'>" + val.event.title2 + "</a>";
            });

            // link = link.replace("\n", "<br>");
            console.log(link);

            $("#render-detail").html(link);
            $("#dialogCalendar").dialog('open');

            $('.showpop').popover();

        },
        events: function(start, end, timezone, callback) {
            var current_tgl = $('#calendar').fullCalendar('getDate');
            var tgl = moment(current_tgl).format('YYYY-MM-DD');
            $('#calendar').fullCalendar('removeEvents');
            fetched = null;
            $('#calendar').addClass("animation-loading");
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('jadwalOperasi'); ?>',
                dataType: 'json',
                data: {
                    date: tgl,
                },
                success: function(data) {
                    $("#calendar").addClass("animation-loading");

                    fetched = data.event;

                    callback(data.event);

                    $('#calendar').removeClass("animation-loading");
                    tgl_now();
                }
            });
        },
        eventRender: function(event, element) {
            element.popover({
                title: event.title,
                content: event.keterangan,
                html: true,
                trigger: 'click',
                placement: 'top',
                container: 'body'
            });
        },
    };

    set_calendar();

    function set_calendar() {
        $('#calendar').fullCalendar(options);
    }

    function to_calendar() {
        $("#pan_calendar").show();
        $("#pan_table").hide();
        $("#btn_calendar").show();
        $("#btn_table").hide();

        if (fetched != null) {
            $("#calendar").fullCalendar("removeEventSource", fetched);
        }
    }

    function to_table() {
        $("#pan_calendar").hide();
        $("#pan_table").show();
        $("#btn_calendar").hide();
        $("#btn_table").show();
    }

    // $('#calendar').fullCalendar(option);



    function tgl_now() {

        var now = $(".fc-content-skeleton > table > thead > tr > td.fc-today").html();

        $(".fc-content-skeleton > table > thead > tr > td.fc-today").html('<span class="hari-ini">' + now + '</span>');
    }
</script>

<style>
    .fc-sun {
        background: #d31d1d;
        color: #fff;
    }

    .hari-ini {
        border-radius: 50%;
        background: #0066cc;
        color: #fff;
        padding: 5px 10px 5px 10px;
    }

    .popover-title {
        border: none;
        box-shadow: none;
        width: 100%;
    }

    .popover-content {
        border: none;
        box-shadow: none;
        width: 100%;
    }

    .popover-inner {
        background: none;
        padding: 0;
        box-shadow: none;
        width: 100%;
    }
</style>