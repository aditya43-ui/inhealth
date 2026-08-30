<style>
	.table_restraint tr td{
		font-color : black;
	}

	#riwayatrestrain th{
		text-align:center;
	}

	#riwayatrestrain tr td{
		text-align:center;
	}

	#riwayatrestrain .kesadaran{
		text-align:left;
	}

	.keterangan{
		border:1px solid;
		width:100%;
		min-height:100px;
		margin-bottom : 20px;
		padding : 5px;
	}

</style>
<table width="100%" class="table_restraint">
	<tr>
		<td width="15%">Tanggal</td>
		<td width="1%">:</td>
		<td width="34%"><?= MyFormatter::formatdatetimeID($model->tanggal);?></td>
		<td width="15%">Perawat Pengisi</td>
		<td width="1%">:</td>
		<td width="34%"><?= $model->perawat_pengisi;?></td>
	</tr>
	<tr>
		<td>Jam</td>
		<td>:</td>
		<td><?= $model->jam;?></td>
	</tr>
</table>

<table width="100%" id ="riwayatrestrain" class = "table table-bordered table-striped table-condensed">
	<thead>
		<tr>
			<th rowspan="2">No.</th>
			<th colspan="5">TTV</th>
			<th colspan="4">Luka Restraint</th>
			<th rowspan="2">Luka</th>
		</tr>
		<tr>
			<th>Kesadaran</th>
			<th>TD</th>
			<th>HR</th>
			<th>RR</th>
			<th>S</th>
			<th>Taka</th>
			<th>Taki</th>
			<th>Kaka</th>
			<th>Kaki</th>

		</tr>
	</thead>
	<tbody>
	<?php 
	if (!empty($model->observasipemasanganrestrain_id)){
	$modDetail = ObservasipemasanganrestraindetT::model()->findAllByAttributes(array('observasipemasanganrestrain_id'=>$model->observasipemasanganrestrain_id));
	if (count($modDetail) > 0){
		foreach ($modDetail as $i=>$data){?>
			<tr>
				<td><?= $i+1;?></td>
				<td class="kesadaran"> <?php echo $data->kes; ?> </td>       
				<td> <?php echo $data->td; ?> </td>       
				<td> <?php echo $data->hr; ?> </td>
				<td> <?php echo $data->rr; ?> </td>
				<td> <?php echo $data->s; ?> </td>
				<td> <?php
					if ($data->taka == true){
						echo '<i class="icon-form-check"></i>';
					}?> 
				</td>
				<td> <?php 
					if ($data->taki == true){
						echo '<i class="icon-form-check"></i>';
					}?> 
				</td>
				<td> <?php 
					if ($data->kaka == true){
						echo '<i class="icon-form-check"></i>';
					} ?> 
				</td>
				<td> <?php 
					if ($data->kaki == true){
						echo '<i class="icon-form-check"></i>';
					}
				?> </td>    
				<td> <?php echo $data->luka; ?> </td>       
				
			</tr>
		<?php }
	}}?>
	</tbody>
</table>

<div class="keterangan">
	<p>Ket :</p>
	<p>- Maksimal pemasangan restraint selama 24 jam
	<br>- Evaluasi/ Observasi pemasangan restraint dilakukan dalam jangka waktu
	<br>&nbsp;&nbsp;a. Setiap 4 jam pada pasien dewasa &#8805; 18 tahun ke atas
	<br>&nbsp;&nbsp;b. Setiap 2 jam pada pasien anak dan remaja usia 9-17 Tahun
	<br>&nbsp;&nbsp;c. Setiap 1 jam untuk anak < 9 tahun
	<br>&nbsp;&nbsp;d. Untuk pasien dalam kondisi destruktif evaluasi/observasi dilakukan setiap 1 jam setelah pemasangan restraint.</p>
	</p>
</div>