<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:1%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
    }
');
?>  
<?php
$format = new MyFormatter;
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judul_print, 'colspan'=>10));      
?>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="20%" style="font-weight: bold">Pergantian </td>
		<td>:</td>
		<td width="29%"><?php echo !empty($model->jnstransaksi_km)?$model->jnstransaksi_km:' - '; ?></td>

		<td width="20%" style="font-weight: bold">Departement</td>
		<td>:</td>
		<td width="29%"><?php echo !empty($model->departement_peg)?$model->departement_peg:' - '; ?></td>
	</tr>
	<tr>
		<td style="font-weight: bold">NIP</td>
		<td>:</td>
		<td><?php echo !empty($model->pegawai->nomorindukpegawai)?$model->pegawai->nomorindukpegawai:' - '; ?></td>

		<td style="font-weight: bold">Nama Pasien</td>
		<td>:</td>
		<td><?php echo !empty($model->namapasien_hub)?$model->namapasien_hub:" - "; ?></td>
	</tr>
	<tr>
		<td style="font-weight: bold">Nama Pekerja</td>
		<td>:</td>
		<td><?php echo $model->pegawai->NamaLengkap; ?></td>

		<td style="font-weight: bold">Status Hubungan</td>
		<td>:</td>
		<td><?php echo !empty($model->statushubungan)?$model->statushubungan:' - '; ?></td>
	</tr>
</table>
<br>
<table class="table table-condensed table-bordered" width="100%">
	<thead>
		<tr>
			<th colspan="2"><p style="margin: 0; text-align: center;">VOD</p></th>
	<th colspan="2"><p style="margin: 0; text-align: center;">VOS</p></th>
	<th rowspan="2"><p style="margin: 0; text-align: center;">ADD</p></th>
	</tr>						
	<tr>
		<th>Spheris</th>
		<th>Cylindrys</th>
		<th>Spheris</th>
		<th>Cylindrys</th>
	</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<?php echo $model->vod_spheris; ?>
			</td>
			<td>
				<?php echo $model->vod_cylindrys; ?>
			</td>
			<td>
				<?php echo $model->vos_spheris; ?>
			</td>
			<td>
				<?php echo $model->vos_cylindrys; ?>
			</td>
			<td>
				<?php echo $model->add_kacamata; ?>
			</td>
		</tr>
	</tbody>
</table>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="20%">Due Date</td>
		<td>:</td>
		<td width="29%"><?php echo !empty($model->duedata_kacamata)?MyFormatter::formatDateTimeId($model->duedata_kacamata):' - '; ?></td>
		<td width="20%">Tanggal Penyerahan</td>
		<td>:</td>
		<td width="29%"><?php echo !empty($model->tglpenyerahan)?  MyFormatter::formatDateTimeId($model->tglpenyerahan):' - '; ?></td>
	</tr>
	<tr>
		<td width="20%">Tanggal Ganti Kacamata Berikutnnya</td>
		<td>:</td>
		<td width="29%"><?php echo !empty($model->tglgantikacamata)?MyFormatter::formatDateTimeId($model->tglgantikacamata):' - '; ?></td>
		<td width="20%">Jumlah Harga</td>
		<td>:</td>
		<td width="29%"><?php echo !empty($model->jumlahharga_km)?MyFormatter::formatUang($model->jumlahharga_km):' - '; ?></td>
	</tr>
</table>