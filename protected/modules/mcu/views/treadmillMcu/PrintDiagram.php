<style>
    .panel-heading {
        background: none repeat scroll 0 0 #428bca !important;
        color: #eee !important;
    }
</style>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])) {
    echo $this->renderPartial($this->path_view . '_headerPrint');
}
$umur = substr($modPendaftaran->umur, 0, 2);
?>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" valig="middle" colspan="3">
            <b><?php // echo $judul_print 
                ?></b>
        </td>
    </tr>
    <tr>
        <td>Born</td>
        <td>:</td>
        <td><?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?></td>

        <td>Max Mets</td>
        <td>:</td>
        <td><?php echo $modTreadmillDetailMax->mets_treadmill ?> Mets</td>
    </tr>
    <tr>
        <td>Age</td>
        <td>:</td>
        <td><?php echo isset($modPendaftaran->umur) ? $modPendaftaran->umur : ""; ?></td>

        <td>Max. Hearrate</td>
        <td>:</td>
        <td><?php echo $modTreadmillDetailMax->heartrate_treadmill; ?> (<?php echo ($modTreadmillDetailMax->heartrate_treadmill - $umur); ?>) /Min</td>
    </tr>
    <tr>
        <td>Sex</td>
        <td>:</td>
        <td><?php echo isset($modPasien->jeniskelamin) ? $modPasien->jeniskelamin : ""; ?></td>

        <td>Max. BP</td>
        <td>:</td>
        <td><?php echo $modTreadmillDetailMax->td_systolic; ?> / <?php echo $modTreadmillDetailMax->td_diastolic; ?> mmHg</td>
    </tr>
    <tr>
        <td>Height</td>
        <td>:</td>
        <td><?php echo ""; ?></td>

        <td>Max. BP X HR</td>
        <td>:</td>
        <td><?php echo (($modTreadmillDetailMax->heartrate_treadmill - $umur) * $modTreadmillDetailMax->td_systolic * 0.01); ?> mmHg/Min</td>
    </tr>
    <tr>
        <td>Weight</td>
        <td>:</td>
        <td><?php echo ""; ?></td>

        <td>Min. BP X HR</td>
        <td>:</td>
        <td><?php echo (($modTreadmillDetailMax->heartrate_treadmill - $umur) * $modTreadmillDetailMax->td_diastolic * 0.01); ?> mmHg/Min</td>
    </tr>
    <tr>
        <td>Indic</td>
        <td>:</td>
        <td><?php echo ""; ?></td>

        <td>DP-Factor</td>
        <td>:</td>
        <td>0.0</td>
    </tr>
    <tr>
        <td>Med</td>
        <td>:</td>
        <td><?php echo ""; ?></td>

        <td>Body-Surface</td>
        <td>:</td>
        <td>0.0</td>
    </tr>
</table><br>

<div class="panel panel-primary" id="charts_env">

    <div class="panel-heading">
        <div class="panel-title">
            Diagram Treadmill
        </div>

        <!--		<div class="panel-options">
			<ul class="nav nav-tabs">
				<li class="<?php echo isset($type) &&  ($type == 'mets') ? "active" : null; ?>"><a href="#line-chart" data-toggle="tab">Mets Diagram</a></li>
				<li class="<?php echo isset($type) &&  ($type == 'tekanandarah') ? "active" : null; ?>"><a href="#area-chart" data-toggle="tab">Tekanan Daraha Diagram</a></li>
			</ul>
		</div>-->
    </div>

    <div class="panel-body">
        <div class="tab-content">

            <div class="tab-pane <?php echo isset($type) &&  ($type == 'mets') ? "active" : null; ?>" id="line-chart">
                <div id="line-chart-1" class="morrischart" style="height: 220px;"></div>
            </div>

            <div class="tab-pane <?php echo isset($type) &&  ($type == 'tekanandarah') ? "active" : null; ?>" id="area-chart">
                <div id="area-chart-1" class="morrischart" style="height: 220px;"></div>
            </div>
        </div>

    </div>

    <table class="table table-striped table-bordered table-condensed table-responsive">

        <thead>
            <tr>
                <th width="100%" class="col-padding-1">
                    <div class="pull-left">
                        <div class="h4 no-margin" style="text-align: center;">
                            <p style="margin: 0; text-align: center;">Duration (min)</p>
                        </div>
                        <small><?php // echo $dataKolom[6]; 
                                ?></small>
                    </div>
                    <span class="pull-right uniquevisitors">
                    </span>
                </th>
            </tr>
        </thead>

    </table>

</div>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <th>Rest Time</th>
        <td></td>
        <td><?php echo $modTreadmill->resttime_menit; ?></td>

        <th>Work Time</th>
        <td></td>
        <td><?php echo $modTreadmill->worktime_menit; ?></td>

        <th>Recovery Time</th>
        <td></td>
        <td><?php echo $modTreadmill->recoverytime_menit; ?></td>

        <th>Total Time</th>
        <td></td>
        <td><?php echo $modTreadmill->totaltime_menit; ?></td>
    </tr>
    <tr>
        <td colspan="12">
            <hr>
        </td>
    </tr>
    <tr>
        <th>Interpretation</th>
        <td></td>
        <td><?php echo $modTreadmill->interpretation_tradmill; ?></td>

        <th></th>
        <td></td>
        <td></td>

        <th></th>
        <td></td>
        <td></td>

        <th></th>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <th>Validate By</th>
        <td></td>
        <td><?php echo $modTreadmill->resttime_menit; ?></td>

        <th></th>
        <td></td>
        <td></td>

        <th></th>
        <td></td>
        <td></td>

        <th></th>
        <td></td>
        <td></td>
    </tr>
</table>
<script type="text/javascript">
    $(document).ready(function($) {
        var mets_chart_1 = $("#line-chart-1");
        var td_chart_1 = $("#area-chart-1");
        var type = '<?php echo $type; ?>';
        mets_chart_1.parent().show();

        // Area Chart
        Morris.Line({
            element: 'line-chart-1',
            data: [
                <?php
                if (count((array)$modTreadmillDetail) > 0) {
                    foreach ($modTreadmillDetail as $i => $chart) { ?> {
                            x: "<?php echo $chart['duration_treadmill']; ?>",
                            y_1: <?php echo isset($chart['mets_treadmill']) ? $chart['mets_treadmill'] : 1; ?>,
                            y_2: <?php echo isset($chart['heartrate_treadmill']) ? $chart['heartrate_treadmill'] : 0; ?>
                        },
                <?php }
                }
                ?>
            ],
            xkey: 'x',
            ykeys: ['y_1', 'y_2'],
            labels: ['METS', 'HR (/Min)'],
            parseTime: false,
            lineColors: [getRandomColor(), getRandomColor()],
        });
        mets_chart_1.parent().attr('style', '');

        Morris.Line({
            element: 'area-chart-1',
            data: [
                <?php
                if (count((array)$modTreadmillDetail) > 0) {
                    foreach ($modTreadmillDetail as $i => $chart) { ?> {
                            x: "<?php echo $chart['duration_treadmill']; ?>",
                            y_1: <?php echo isset($chart['td_systolic']) ? $chart['td_systolic'] : 1; ?>,
                            y_2: <?php echo isset($chart['td_diastolic']) ? $chart['td_diastolic'] : 0; ?>
                        },
                <?php }
                }
                ?>
            ],
            xkey: 'x',
            ykeys: ['y_1', 'y_2'],
            labels: ['Systolic', 'Diastolic'],
            parseTime: false,
            lineColors: [getRandomColor(), getRandomColor()],
        });
        td_chart_1.parent().attr('style', '');

        // Line Chart
        //	Morris.Line({
        //		element: 'line-chart-1',
        //		data: [
        //			<?php
                        if (count((array)$modTreadmillDetail) > 0) {
                            foreach ($modTreadmillDetail as $i => $chart) { ?>//
        //					{ x: "<?php echo $chart['duration_treadmill']; ?>", y_1: <?php echo isset($chart['mets_treadmill']) ? $chart['mets_treadmill'] : 1; ?>, y_2: <?php echo isset($chart['heartrate_treadmill']) ? $chart['heartrate_treadmill'] : 0; ?> },
        //				<?php }
                        }
                            ?>//
        //			
        //		],
        //		xkey: 'x',
        //		ykeys: ['y_1','y_2'],
        //		labels: ['METS', 'HR (/min)'],
        //		parseTime: false,
        //		lineColors: [getRandomColor(),getRandomColor()],
        //	});

    });

    function getRandomColor() {
        var flat_colors = [
            '#16a085', '#27ae60',
            '#2980b9', '#8e44ad',
            '#2c3e50', '#f39c12',
            '#d35400', '#c0392b',
            '#bdc3c7', '#7f8c8d',
            '#1abc9c', '#2ecc71',
            '#3498db', '#9b59b6',
            '#34495e', '#f1c40f',
            '#e67e22', '#e74c3c',
        ];
        var index = Math.floor((Math.random() * 10));
        var color = flat_colors[index];
        return color;
    }

    /**
     * untuk print hasil treadmill diagram
     */
    function printGrafik(caraPrint) {
        var treadmill_id = '<?php echo isset($modTreadmill->treadmill_id) ? $modTreadmill->treadmill_id : null ?>';
        var pendaftaran_id = '<?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null; ?>';
        window.open('<?php echo $this->createUrl('Grafik'); ?>&treadmill_id=' + treadmill_id + '&pendaftaran_id=' + pendaftaran_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
</script>