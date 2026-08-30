
<div class="white-container">
    <?php
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>7)); 
    $no_urut = 1;
    $class='';
    if(isset($_GET['frame']) ){
        $class="table table-striped";
    }
    ?>
	<?php 
	if(count((array)$modKunjungans) > 0){
	foreach($modKunjungans AS $i => $modKunjungan){
		
		$modHasilPemeriksaan = RJHasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$modKunjungan->pasienmasukpenunjang_id));
		
		if(isset($modHasilPemeriksaan)){
			
	?>
	<div style='border:1px solid #cccccc; border-color: #4290d0;'>
		<table style="width: 100%; border: none;">
			<tr>
				<td><?php echo $modKunjungan->getAttributeLabel('no_pendaftaran') ?></td><td>: <?php echo $modKunjungan->no_pendaftaran ?></td>
				<td><?php echo $modKunjungan->getAttributeLabel('no_rekam_medik') ?></td><td>: <?php echo $modKunjungan->no_rekam_medik ?></td>
			</tr>
			<tr>
				<td><?php echo $modKunjungan->getAttributeLabel('tgl_pendaftaran') ?></td><td>: <?php echo $modKunjungan->tgl_pendaftaran ?></td>
				<td><?php echo $modKunjungan->getAttributeLabel('nama_pasien') ?></td><td>: <?php echo $modKunjungan->namadepan." ".$modKunjungan->nama_pasien ?></td>
			</tr>
			<tr>
				<td><?php echo $modKunjungan->getAttributeLabel('no_masukpenunjang') ?></td><td>: <?php echo $modKunjungan->no_masukpenunjang ?></td>
				<td><?php echo $modKunjungan->getAttributeLabel('tanggal_lahir') ?></td><td>: <?php echo $modKunjungan->tanggal_lahir ?></td>
			</tr>
			<tr>
				<td><?php echo $modKunjungan->getAttributeLabel('tglmasukpenunjang') ?></td><td>: <?php echo $modKunjungan->tglmasukpenunjang ?></td>
				<td><?php echo $modKunjungan->getAttributeLabel('jeniskelamin') ?></td><td>: <?php echo $modKunjungan->jeniskelamin ?></td>
			</tr>
			<tr>
				<td><?php echo $modKunjungan->getAttributeLabel('ruangan_nama') ?></td><td>: <?php echo $modKunjungan->ruangan_nama ?></td>
				<td><?php echo $modKunjungan->getAttributeLabel('alamat_pasien') ?></td><td>: <?php echo $modKunjungan->alamat_pasien ?></td>
			</tr>
			<tr>
				<td><?php echo $modHasilPemeriksaan->getAttributeLabel('nohasilperiksalab') ?></td><td>: <?php echo $modHasilPemeriksaan->nohasilperiksalab; ?></td>
			</tr>
			<tr>
				<td><?php echo $modHasilPemeriksaan->getAttributeLabel('tglhasilpemeriksaanlab') ?></td><td>: <?php echo $format->formatDateTimeForUser($modHasilPemeriksaan->tglhasilpemeriksaanlab); ?></td>
			</tr>
		</table>
		<br>
		<br>
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<div style="font-family:arial;font-size:12pt;">
						<b>
							<p style="margin: 0; text-align: center;">
								<h4>HASIL PEMERIKSAAN LABORATORIUM</h4>
							</p>
						</b>
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table width="100%" border="1" class='<?php echo $class; ?>'>
			<thead>
				<th>NO.</th>
				<th width="30%">DETAIL PEMERIKSAAN</th>
				<th>HASIL PEMERIKSAAN</th>
				<th>NILAI RUJUKAN</th>
				<th>SATUAN</th>
				<th>METODE</th>
			</thead>
			<tbody>
				<?php
				$criteria = new CDbCriteria();
				$criteria->join = "
									JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
									JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
									JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
				$criteria->addCondition('t.hasilpemeriksaanlab_id = ' . $modHasilPemeriksaan->hasilpemeriksaanlab_id);
				$criteria->order = "pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
				$modDetailHasilPemeriksaans = RJDetailhasilpemeriksaanlabT::model()->findAll($criteria);
				if(count((array)$modDetailHasilPemeriksaans) > 0){
					foreach($modDetailHasilPemeriksaans AS $i => $modDetail){
						$trpemeriksaan = false;
						if($i == 0){
							echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$modDetailHasilPemeriksaans[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
						}else if(($i) < count((array)$modDetailHasilPemeriksaans)){
							if($modDetailHasilPemeriksaans[$i]->pemeriksaanlab_id != $modDetailHasilPemeriksaans[$i-1]->pemeriksaanlab_id){
								echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$modDetailHasilPemeriksaans[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
								$no_urut--;
							}
						}
				?>   
					<tr>
						<td>
							<?php echo $no_urut; ?>
						</td>
						<td><?php echo $modDetail->pemeriksaandetail->nilairujukan->namapemeriksaandet ?></td>
						<td><?php echo $modDetail->hasilpemeriksaan; ?></td>
						<!--Karena <sup> jadi tidak superscript >> <td><?php // echo htmlentities($modDetail->NilaiRujukan, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></td>-->
						<td><?php echo $modDetail->NilaiRujukan; ?></td>
						<td><?php echo $modDetail->HasilPemeriksaanSatuan; ?></td>
						<td><?php echo $modDetail->HasilPemeriksaanMetode; ?></td>
					</tr>
				<?php 
						$no_urut++;
					}
				}
				?>
			</tbody>
		</table>
		<table style="width: 100%; border: none;">
			<tr>
				<td><br>
					<span style='font-size:9pt'><?php echo $modHasilPemeriksaan->getAttributeLabel('catatanlabklinik') ?> :<br>
					<div style='width: 100%;float:left;'>                
					<?php echo $modHasilPemeriksaan->catatanlabklinik; ?>
					</div>
					</div>
				</td>
			</tr>
			<tr>
				<td><br>
					<span style='font-size:9pt'><?php echo $modHasilPemeriksaan->getAttributeLabel('kesimpulan') ?> :<br>
					<div style='width: 100%;float:left;'>                
					<?php echo $modHasilPemeriksaan->kesimpulan; ?>
					</div>
					</div><br>
				</td>
			</tr>
		</table>
	</div>
	<br>
<?php
	}
}
}else{
		echo '* Tidak ada pemeriksaan labolatorium';
	}
?>
</div>

