<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="panel-title">Kunjungan Poliklinik Bulan Ini</div>
		<div class="panel-options">
			<a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
			<a data-rel="reload" href="#"><i class="entypo-arrows-ccw"></i></a>
		</div>
	</div>

	<div class="panel-body">
		<div id="bar-chart-1" style="height: 250px"></div>
	</div>
</div>
<script type="text/javascript">

$(document).ready(function(){
	var data = [
		<?php 
		if(count($dataBarChart) > 0){
			foreach($dataBarChart AS $i => $bar){?>
						{x: '<?php echo $bar['ruangan_nama']; ?>' ,y: <?php echo $bar['jumlah']; ?>},
		<?php }
		} 
		
		?>
	];
	
	
	// Bar Charts
	Morris.Bar({
		element: 'bar-chart-1',
		axes: true,
		data: data,
		xkey: 'x',
		ykeys: ['y'],
		labels: ['Jumlah'],
		barColors: [getRandomColor()],
	});
});
</script>