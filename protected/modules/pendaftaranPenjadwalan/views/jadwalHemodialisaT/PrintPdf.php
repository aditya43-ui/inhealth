<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<style type="text/css">
	body {
		font-size: 10pt;
	}
	table.hariTgl, table.hariTgl tr td {
		border-collapse: collapse;
	}
	table.tabelIsi tr td.vTop{
		vertical-align: top;
	}
	.backShift{
		background-color: #c4f5c4;
	}
	.backRuangan_1{
		background-color: #009933;
	}
	.backRuangan_2{
		background-color: #007acc;
	}
	table.dataPasien, table.dataPasien tr td{
		border: 1px solid #000;
		border-collapse: collapse;
	}
	table.dataPasien{
		font-size: 8pt;
	}
</style>
	
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>'', 'colspan'=>10)); ?>    
<table width='100%'>
	<thead>
		<tr>
			<th>
				<b>JADWAL PASIEN HEMODIALISIS<br>
				<?php //echo $data->nama_rumahsakit ?></b>
			</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
<?php
@$totalData = $_GET['totalData'];
$format = new MyFormatter();

$criteriaJml=new CDbCriteria;
$criteriaJml->select = 'jadwalhemodialisa_id, jadwalhemodialisa_tgl_ke';
$criteriaJml->group = 'jadwalhemodialisa_id, jadwalhemodialisa_tgl_ke';
$criteriaJml->order = 'jadwalhemodialisa_id DESC';
$criteriaJml->limit=$totalData;
$allJml = PPJadwalhemodialisaT::model()->findAll($criteriaJml);
$tanggalId = array();
$dataSama = '';
foreach ($allJml as $a => $valJml) {
	
	if($dataSama != $valJml->jadwalhemodialisa_tgl_ke){
		$tanggalId[] = $valJml->jadwalhemodialisa_tgl_ke;
	}
	$dataSama = $valJml->jadwalhemodialisa_tgl_ke;
	
}

//print_r($tanggalId);

$criteriaTgl=new CDbCriteria;
$criteriaTgl->select = 'jadwalhemodialisa_tgl_ke';
$criteriaTgl->group = 'jadwalhemodialisa_tgl_ke';
if(is_array($tanggalId)){
	$criteriaTgl->addInCondition('DATE(jadwalhemodialisa_tgl_ke)',$tanggalId);
}else{
	$criteriaTgl->addCondition('DATE(jadwalhemodialisa_tgl_ke) = '.$tanggalId);
}	
$allData = PPJadwalhemodialisaT::model()->findAll($criteriaTgl);
foreach ($allData as $i => $valTgl) {
	
	$criteriaShift=new CDbCriteria;
	$criteriaShift->select = 'shift_id, jadwalhemodialisa_hari';
	$criteriaShift->group = 'shift_id, jadwalhemodialisa_hari';
	$criteriaShift->compare('DATE(jadwalhemodialisa_tgl_ke)', $valTgl->jadwalhemodialisa_tgl_ke);
	$criteriaShift->order = 'shift_id ASC';
	$allShift = PPJadwalhemodialisaT::model()->findAll($criteriaShift);
	foreach ($allShift as $j => $valShift) {
		
		echo '<br>
				<table class="hariTgl">
					<tr>
						<td>HARI / TANGGAL</td><td>:</td>
						<td>'.strtoupper($valShift->jadwalhemodialisa_hari).', '.$format->formatDateTimeForUser($valTgl->jadwalhemodialisa_tgl_ke).'</td>
					</tr>
					<tr class="backShift">
						<td>SHIFT</td><td>:</td>
						<td>'.strtoupper($valShift->shift->shift_nama).'</td>
					</tr>
				</table>';
		
		$criteriaRuangan=new CDbCriteria;
		$criteriaRuangan->select = 'ruangan_id';
		$criteriaRuangan->group = 'ruangan_id';
		$criteriaRuangan->compare('DATE(jadwalhemodialisa_tgl_ke)', $valTgl->jadwalhemodialisa_tgl_ke);
		$criteriaRuangan->order = 'ruangan_id ASC';
		$allRuangan = PPJadwalhemodialisaT::model()->findAll($criteriaRuangan);
		echo '<table width="100%" class="tabelIsi">';
		
		foreach ($allRuangan as $k => $valRuangan) {
			if($k % 2 == 0){
			  echo '<tr>';	
				echo '<td class="vTop" width="50%">';
				$classback = 'backRuangan_1';
			}
			else{
				echo '<td class="vTop" width="50%">';
				$classback = 'backRuangan_2';
			}
				
					$criteriaNama=new CDbCriteria;
					$criteriaNama->select = 'pasien_id';
					$criteriaNama->group = 'pasien_id';
					$criteriaNama->compare('DATE(jadwalhemodialisa_tgl_ke)', $valTgl->jadwalhemodialisa_tgl_ke);
					$criteriaNama->addCondition('shift_id = '.$valShift->shift_id);
					$criteriaNama->addCondition('ruangan_id = '.$valRuangan->ruangan_id);
					$criteriaNama->order = 'pasien_id ASC';
					$allNama = PPJadwalhemodialisaT::model()->findAll($criteriaNama);
					echo'<table width="100%" class="dataPasien">
							<tr>
								<td colspan="3" class="'.$classback.'">'.strtoupper($valRuangan->ruanganrl->ruangan_nama).'</td>
							</tr>';
					$no = 1;
					foreach ($allNama as $l => $valNama) {
						if($l % 3 == 0){
							echo '<tr>';
							  echo '<td>';
						}
						else{
							echo '<td>';
						}
							
							echo $no.') '.ucfirst(strtolower($valNama->pasienrl->nama_pasien));
						
						if($l % 3 == 2){
							  echo '</td>';
							echo '</tr>';
							echo '<tr>
								<td>&nbsp;</td>
								<td></td>
								<td></td>
								</tr>';
						}
						else{
							echo '</td>';
						}
					  $no++;	
					}
					echo'</table>';
					
			if($k % 2 == 1){
				echo '</td>';	
			  echo '</tr>';
			}
			else{
				echo '</td>';
			}
			
		}
		
		echo'</table>';
		
	}
	
}
?>

				
				
			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td>
				<br><br><br>
				Bandung, <?php echo $format->formatDateTimeId(date('Y-m-d')); ?><br>
				<br><br><br>
				<?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
                <u><?php echo $pegawai->nama_pegawai; ?></u>
			</td>
		</tr>
	</tfoot>
</table>


<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    
</div>