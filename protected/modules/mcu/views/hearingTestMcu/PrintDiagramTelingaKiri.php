<style>
	.panel-heading{
		background: none repeat scroll 0 0 #428bca !important;
		color : #eee !important;
	}
</style>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])){
//    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="middle" colspan="3">
			<b><u><?php echo $judul_print ?></u></b>
		</td>
	</tr>
</table><br>
<table width="100%" style="margin:30px;" cellpadding="0" cellspacing="0">
	<tr>
		<td width="20%">Name</td>
		<td>:</td>
		<td><?php echo $modPasien->namadepan; ?> <?php echo $modPasien->nama_pasien; ?></td>

		<td width="20%"></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td width="20%">Age</td>
		<td>:</td>
		<td><?php echo $modPendaftaran->umur; ?></td>

		<td width="20%"></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td width="20%">Birth Date</td>
		<td>:</td>
		<td><?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?></td>

		<td width="20%"></td>
		<td></td>
		<td></td>
	</tr>
</table>
<table width="100%" style="margin:30px;" cellpadding="0" cellspacing="0">
	<tr>
		<td width="20%"><i>Report Comments:</i></td>
		<td></td>

		<td width="20%"></td>
		<td></td>
		<td></td>
	</tr>
</table><br><br>
<table width="100%" style="margin:30px;" cellpadding="0" cellspacing="0">
	<tr>
		<td width="20%"><i>Measurement Notes:</i></td>
		<td></td>

		<td width="20%"></td>
		<td></td>
		<td></td>
	</tr>
</table><br><br>

<div class="row" style="margin-left:30px;">
	<div class="col-sm-6">
		<div class="panel panel-primary" id="charts_env">
				<div class="panel-heading" style="width: 500px;">
					<div class="panel-title"><p style="margin: 0; text-align: center;">RIGHT</p></div>

					<div class="panel-options">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#line-chart-2" data-toggle="tab"></a></li>
						</ul>
					</div>
				</div>

				<div class="panel-body">
					<div class="tab-content" style="width: 500px;height: 500px">

						<div class="tab-pane active" id="line-chart-2" style="width: 500px;height: 500px">                          
							<div id="line-chart-2" class="morrischart" style="width: 500px;height: 500px"></div>
							<table class="table table-striped table-bordered table-condensed table-responsive">
								<thead>
									<tr>
										<th width="100%" class="col-padding-1">
											<div class="pull-left">
												<div class="h4 no-margin" style="text-align: center;"><p style="margin: 0; text-align: center;">Frequency</p></div>
												<small><?php // echo $dataKolom[6]; ?></small>
											</div>
											<span class="pull-right uniquevisitors">
											</span>
										</th>
									</tr>
								</thead>

							</table>
						</div>
				</div>
			</div> 
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-primary" id="charts_env">
			<div class="panel-heading " style="width: 500px;">
				<div class="panel-title"><p style="margin: 0; text-align: center;">LEFT</p></div>

				<div class="panel-options">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#line-chart" data-toggle="tab"></a></li>
					</ul>
				</div>
			</div>

			<div class="panel-body">
				<div class="tab-content" style="width: 500px;height: 500px">

					<div class="tab-pane active" id="line-chart" style="width: 500px;height: 500px">                          
						<div id="line-chart-1" class="morrischart" style="width: 500px;height: 500px"></div>
						<table class="table table-striped table-bordered table-condensed table-responsive">
							<thead>
								<tr>
									<th width="100%" class="col-padding-1">
										<div class="pull-left">
											<div class="h4 no-margin" style="text-align: center;"><p style="margin: 0; text-align: center;">Frequency</p></div>
											<small><?php // echo $dataKolom[6]; ?></small>
										</div>
										<span class="pull-right uniquevisitors">
										</span>
									</th>
								</tr>
							</thead>

						</table>
						<?php
							if(!isset($caraPrint)){
								echo CHtml::htmlButton(Yii::t('mds','{icon} Print Diagram',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info','type'=>'button','onclick'=>'printGrafik(\'GRAFIK\',\'mets\')'));                 
							}
						?>
					</div>

			</div>


		</div> 
	</div>
</div>
</div>
 
<script type="text/javascript">
$(document).ready(function($) 
{
	var mets_chart_1 = $("#line-chart-1");
	var mets_chart_2 = $("#line-chart-2");
	var td_chart_1 = $("#area-chart-1");
    mets_chart_1.parent().show();
	
	// Area Chart
	Morris.Line({
		element: 'line-chart-1',
        data: [
			<?php 
			if(!empty($modHearingTest)){
//				foreach ($modHearingTest as $i => $chart) { ?>
					{ x: "125", y_1: 0},
					{ x: "250", y_1: 0},
					{ x: "500", y_1: <?php echo isset($modHearingTest->tkr_500) ? $modHearingTest->tkr_500 :0; ?>},
					{ x: "1k", y_1: <?php echo isset($modHearingTest->tkr_1k) ? $modHearingTest->tkr_1k :0; ?>},
					{ x: "2k", y_1: <?php echo isset($modHearingTest->tkr_2k) ? $modHearingTest->tkr_2k :0; ?>},
					{ x: "3k", y_1: <?php echo isset($modHearingTest->tkr_3k) ? $modHearingTest->tkr_3k :0; ?>},
					{ x: "4k", y_1: <?php echo isset($modHearingTest->tkr_4k) ? $modHearingTest->tkr_4k :0; ?>},
					{ x: "6k", y_1: <?php echo isset($modHearingTest->tkr_6k) ? $modHearingTest->tkr_6k :0; ?>},
					{ x: "8k", y_1: <?php echo isset($modHearingTest->tkr_8k) ? $modHearingTest->tkr_8k :0; ?>},
				<?php // }
			}
			?>
		],
		xkey: 'x',
		ykeys: ['y_1','y_2'],
		labels: ['Hearing Level (dB)'],
		parseTime: false,
		lineColors: [getRandomColor(),getRandomColor()],
	});
	mets_chart_1.parent().attr('style', '');
	  
	Morris.Line({
		element: 'line-chart-2',
        data: [
			<?php 
			if(!empty($modHearingTest)){
//				foreach ($modHearingTest as $i => $chart) { ?>
					{ x: "125", y_1: 0},
					{ x: "250", y_1: 0},
					{ x: "500", y_1: <?php echo isset($modHearingTest->tkn_500) ? $modHearingTest->tkn_500 :0; ?>},
					{ x: "1k", y_1: <?php echo isset($modHearingTest->tkn_1k) ? $modHearingTest->tkn_1k :0; ?>},
					{ x: "2k", y_1: <?php echo isset($modHearingTest->tkn_2k) ? $modHearingTest->tkn_2k :0; ?>},
					{ x: "3k", y_1: <?php echo isset($modHearingTest->tkn_3k) ? $modHearingTest->tkn_3k :0; ?>},
					{ x: "4k", y_1: <?php echo isset($modHearingTest->tkn_4k) ? $modHearingTest->tkn_4k :0; ?>},
					{ x: "6k", y_1: <?php echo isset($modHearingTest->tkn_6k) ? $modHearingTest->tkn_6k :0; ?>},
					{ x: "8k", y_1: <?php echo isset($modHearingTest->tkn_8k) ? $modHearingTest->tkn_8k :0; ?>},
				<?php // }
			}
			?>
		],
		xkey: 'x',
		ykeys: ['y_1','y_2'],
		labels: ['Hearing Level (dB)'],
		parseTime: false,
		lineColors: [getRandomColor(),getRandomColor()],
	});
	mets_chart_2.parent().attr('style', '');
});

function getRandomColor() {
    var flat_colors = [
    '#16a085','#27ae60',
    '#2980b9','#8e44ad',
    '#2c3e50','#f39c12',
    '#d35400','#c0392b',
    '#bdc3c7','#7f8c8d',
    '#1abc9c','#2ecc71',
    '#3498db','#9b59b6',
    '#34495e','#f1c40f',
    '#e67e22','#e74c3c',];
    var index = Math.floor((Math.random() * 10)); 
    var color = flat_colors[index];
    return color;
}

/**
* untuk print hasil treadmill diagram
 */
function printGrafik(caraPrint,type)
{
    var hearingtest_id = '<?php echo isset($modHearingTest->hearingtest_id) ? $modHearingTest->hearingtest_id : null ?>';
	var pendaftaran_id = '<?php echo isset($_GET['idPendaftaran']) ? $_GET['idPendaftaran'] : null; ?>';
    window.open('<?php echo $this->createUrl('Grafik'); ?>&hearingtest_id='+hearingtest_id+'&pendaftaran_id='+pendaftaran_id+'&caraPrint='+caraPrint+'&type='+type,'printwin','left=100,top=100,width=1000,height=640');
}
</script>