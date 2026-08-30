<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="panel-title">
			Kunjungan Pasien Bulan Ini
			<br />
			<small><i>Berdasarkan Kelompok Penjamin</i></small>
		</div>
		<div class="panel-options">
			<a data-rel="collapse" href="#">
				<i class="entypo-down-open"></i>
			</a>
			<a data-rel="reload" href="#">
				<i class="entypo-arrows-ccw"></i>
			</a>
		</div>
	</div>
	<div class="panel-body no-padding">
		<div id="pie-chart-1" style="text-align: center;">
			<span class="chart"></span>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function($) 
{
	var values = [
		<?php
		foreach($dataPieChart AS $i => $pie){ ?>
			<?php echo $pie['jumlah']; ?>,
		<?php
		}
		?>
	];
	var tooltips = {
		<?php
		foreach($dataPieChart AS $i => $pie){ ?>
			'<?php echo $i; ?>':'<?php echo $pie['penjamin_nama']; ?>',
		<?php
		}
		?>
	};
	$("#pie-chart-1").sparkline(values, {
		type: 'pie',
		tooltipFormat: '{{offset:offset}} ({{percent.0}}%)',
		tooltipValueLookups: {
			'offset': tooltips,
		},
		barColor: getRandomColor(),
		height: '320px',
		barWidth: 10,
		barSpacing: 2
	});
});
</script>