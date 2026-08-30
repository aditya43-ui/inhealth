<!DOCTYPE html>
<html>
	<head>
		<title>Garut</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css" />
		<link rel="stylesheet" href="css/MarkerCluster.css" />
		<link rel="stylesheet" href="css/MarkerCluster.Default.css" />
		<link rel="stylesheet" type="text/css" href="css/own_style.css">
		<link rel="stylesheet" href="css/label.css" />
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap-select.min.css">

		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

		<script src="http://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"></script>
		<script src="js/leaflet-hash.js"></script>
		<script src="js/label.js"></script>
		<script src="js/Autolinker.min.js"></script>
		<script src="js/leaflet.markercluster.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>


		<script src="js/moment.min.js"></script>
		<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript" src="js/bootstrap-select.min.js"></script>
		<script src="js/amcharts.js" type="text/javascript"></script>
        <script src="js/pie.js" type="text/javascript"></script>

		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	</head>
	<body>
		<div class="row full-height" >
  <div class="col-md-7">
		<div class="panel panel-primary">
			<div class="panel-heading">
    		Peta Administrasi Garut
  		</div>
			<div class="panel-body">
				<div id="map" style="height: 600px"></div>
			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Filter Tanggal
			</div>

			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<div class='input-group date' id='dateStart'>
							<input type='text' class="form-control" placeholder="start date" />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class='input-group date' id='dateEnd'>
							<input type='text' class="form-control" placeholder="end date" />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				Pilih penyakit
			</div>
			<div class="panel-body">
				<select id="select-penyakit" class="selectpicker show-tick" data-width="100%">
					<option value="reset">- UNSELECTED -</option>
					<option value="one">Demam tifoid dan paratifoid</option>
					<option value="two">Kejang demam</option>
					<option value="three">Demam paratifoid C</option>
					<option value="four">Kista pilonidal dengan abses</option>
					<option value="five">Epilepsi, tidak terspesifikasi</option>
					<option value="six">Kram dan spasme</option>
					<option value="seven">Kolera, tidak terspesifikasi</option>
				</select>
			</div>
		</div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				Penyebaran Penyakit Kecamatan Cisurupan per Desa/Kel
			</div>
			<div class="panel-body">
				<div id="chartdiv" style="width: 100%; height: 345px;"></div>
			</div>
		</div>
	</div>
</div>




		<script src="data/exp_KecamatanJavaBPSJune2010.js"></script>
		<script type="text/javascript" src="js/penyebaran-diagnosa.js"></script>
		<script type="text/javascript" src="js/init-region.js"></script>
		<link rel="stylesheet" type="text/css" href="css/penyebaran-penyakit.css">
	</body>
</html>
