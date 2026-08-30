<div class="row-fluid">
    <div class="span11">
        <?php 
            $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$modPemeriksaan,
                'attributes'=>array(
                    array(
                        'name'=>'tglperiksafisik',
                        'value'=>MyFormatter::formatDateTimeForUser($modPemeriksaan->tglperiksafisik),
                    ),
                    array(
                        'name'=>'tekanandarah',
                        'value'=>$modPemeriksaan->tekanandarah." /MmHg",
                    ),
                    array(
                        'name'=>'meanarteripressure',
                        'value'=>$modPemeriksaan->meanarteripressure,
                    ),
                    array(
                        'name'=>'detaknadi',
                        'value'=>$modPemeriksaan->detaknadi." /Menit",
                    ),
                    array(
                        'name'=>'denyutjantung',
                        'value'=>$modPemeriksaan->denyutjantung,
                    ),
                    array(
                        'name'=>'pernapasan',
                        'value'=>$modPemeriksaan->pernapasan." /Menit",
                    ),
                    array(
                        'name'=>'suhutubuh',
                        'value'=>$modPemeriksaan->suhutubuh." °Celcius",
                    ),
                    array(
                        'label'=>'Tinggi Badan / Berat Badan',
                        'value'=>(($modPemeriksaan->tinggibadan_cm) ? $modPemeriksaan->tinggibadan_cm." /Cm" : "")." ".(($modPemeriksaan->beratbadan_kg) ? $modPemeriksaan->beratbadan_kg." /Kg" : ""),
                    ),
                    array(
                        'label'=>'Index Masa Tubuh',
                        'value'=>(($modPemeriksaan->bb_ideal) ? $modPemeriksaan->bb_ideal : ""),
                    ),
					'kelainanpadabagtubuh',
					'inspeksi',
					'palpasi',
                    'perkusi',
                    'auskultasi',
                ),
            )); 
    ?>
	</div>
	<table width="100%" class="content" border="0">
		<tr>
			<td width="70%">
				<div align="center" id="imgtag">
					<img id="myImgId" src="<?php echo Params::urlPhotoAnatomiTubuh().$modGambarTubuh->FileNameGambar; ?>" class="taggd"/> 
				<div id="tagbox"></div>
				</div>
			</td>
			<td width="30%" style="vertical-align:top;">
				<table border="1" width="100%" class="items table table-striped table-condensed">
					<tr>
						<td colspan="3"><center><strong>Anatomi Tubuh</strong></center></td>
					</tr>
					<?php 
					if(count($modPemeriksaanGambar)>0){?>
						<tr>
							<td><center><strong>No.</strong></center></td>
							<td><strong>Bagian Tubuh</strong></td>
							<td><strong>Keterangan</strong></td>
						</tr>
						<?php foreach($modPemeriksaanGambar as $i => $v ){ ?>
						<tr>
							<td><center><?= $i+1; ?></center></td>
							<td><?= isset($v->bagiantubuh->namabagtubuh) ? $v->bagiantubuh->namabagtubuh : ""; ?></td>
							<td><?= isset($v->keterangan_periksa_gbr) ? $v->keterangan_periksa_gbr : ""; ?></td>
						</tr>
						<?php } ?>
					<?php } ?>
				</table>
				<br><br>
			</td>
		</tr>
	</table>
	<table width="100%" class="content" border="0">
		<tr>
			<td width="50%">
				<table border="1" width="100%" class="items table table-striped table-condensed">
					<tr>
						<td colspan="3"><left><strong>Kepala</strong></left></td>
					</tr>
					<tr>
						<td><strong>Rambut</strong></td>
						<td>
							<ul>
								<li>Mengkilat : <?php echo ($modPemeriksaan->rambut_mengkilat)? "Ya" : "Tidak"; ?></li>
								<li>Kusam : <?php echo ($modPemeriksaan->rambut_kusam)? "Ya" : "Tidak"; ?></li>
								<li>Mudah Rontok : <?php echo ($modPemeriksaan->rambut_mudahrontok)? "Ya" : "Tidak"; ?></li>
								<li>Mudah Kotor : <?php echo ($modPemeriksaan->rambut_kotor)? "Ya" : "Tidak"; ?></li>
								<li>Mudah Bersih : <?php echo ($modPemeriksaan->rambut_bersih)? "Ya" : "Tidak"; ?></li>
							</ul>							
						</td>
					</tr>
					<tr>
						<td colspan="3"><left><strong>Mata</strong></left></td>
					</tr>
					<tr>
						<td><strong>Konjungtiva</strong></td>
						<td><?php echo ($modPemeriksaan->mata_konjungtiva_anemis)? "Ya" : "Tidak"; ?></td>
					</tr>
					<tr>
						<td><strong>Sklera</strong></td>
						<td><?php echo ($modPemeriksaan->mata_sklera_ikterik)? "Ya" : "Tidak"; ?></td>
					</tr>
					<tr>
						<td><strong>Penglihatan</strong></td>
						<td><?php echo ($modPemeriksaan->mata_penglihatan)? "Ya" : "Tidak"; ?></td>
					</tr>
					<tr>
						<td colspan="3"><left><strong>Hidung</strong></left></td>
					</tr>
					<tr>
						<td><strong>Sumbatan Jalan Nafas</strong></td>
						<td><?php echo ($modPemeriksaan->sumbatanjalannafas)? "Ya" : "Tidak"; ?></td>
					</tr>
					<tr>
						<td colspan="3"><left><strong>Mulut</strong></left></td>
					</tr>
					<tr>
						<td><strong>Bibir</strong></td>
						<td>Simetris : <?php echo ($modPemeriksaan->bibir_simetris)? "Ya" : "Tidak"; ?></td>
					</tr>
					<tr>
						<td><strong>Jumlah Gigi</strong></td>
						<td><?php echo $modPemeriksaan->jumlahgigi_buah; ?></td>
					</tr>
					<tr>
						<td><strong>Karies</strong></td>
						<td><?php echo ($modPemeriksaan->gigi_karies)? "Ya" : "Tidak"; ?></td>
					</tr>
					<tr>
						<td><strong>Gigi Palsu</strong></td>
						<td><?php echo ($modPemeriksaan->gigipalsu)? "Ya" : "Tidak"; ?><br>
							Bagian : <?php echo isset($modPemeriksaan->gigipalsu_bagian) ? $modPemeriksaan->gigipalsu_bagian : "-"; ?>
						</td>
					</tr>
					<tr>
						<td><strong>Mual</strong></td>
						<td><?php echo ($modPemeriksaan->mual)? "Ya" : "Tidak"; ?></td>
					</tr>
					<tr>
						<td><strong>Muntah</strong></td>
						<td><?php echo ($modPemeriksaan->muntah)? "Ya" : "Tidak"; ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" style="vertical-align:top;">
				<table border="1" width="100%" class="items table table-striped table-condensed" >
					<tr>
						<td colspan="3"><center><strong>Glasgow Coma Scale</strong></center></td>
					</tr>
					<tr>
						<td><strong>GCS Eye</strong></td>
						<td><?php echo !empty($modPemeriksaan->gcs_eye)?$modPemeriksaan->metodegcseye->metodegcs_nama:' - '; ?></td>
					</tr>
					<tr>
						<td><strong>GCS Verbal</strong></td>
						<td><?php echo !empty($modPemeriksaan->gcs_verbal)?$modPemeriksaan->metodegcsverbal->metodegcs_nama:' - '; ?></td>
					</tr>
					<tr>
						<td><strong>GCS Motorik</strong></td>
						<td><?php echo !empty($modPemeriksaan->gcs_motorik)?$modPemeriksaan->metodegcsmotorik->metodegcs_nama:' - '; ?></td>
					</tr>
					<tr>
						<td><strong> Nilai GCS</strong></td>
						<td><?php echo !empty($modPemeriksaan->namaGCS)?$modPemeriksaan->namaGCS:' - '; ?></td>
					</tr>
				</table>
				<br>
				<table border="1" width="100%" class="items table table-striped table-condensed" >
					<tr>
						<td colspan="3"><center><strong>Ekstremitas</strong></center></td>
					</tr>
					<tr>
						<td><strong>Bentuk Ekstrimitas</strong></td>
						<td><?php echo ($modPemeriksaan->bentuk_ekstremitas)? "Ya" : "Tidak"; ?></td>
					</tr>
					<tr>
						<td><strong>Kelainan</strong></td>
						<td>
							<ul>
								<li>Oedema : <?php echo ($modPemeriksaan->ekstremitas_kelainan_oedema)? "Ya" : "Tidak"; ?></li>
								<li>Varies : <?php echo ($modPemeriksaan->ekstremitas_kelainan_varies)? "Ya" : "Tidak"; ?></li>
								<li>Parese : <?php echo ($modPemeriksaan->ekstremitas_kelainan_parese)? "Ya" : "Tidak"; ?></li>
							</ul>							
						</td>
					</tr>
					<tr>
						<td><strong>Kekuatan Otot</strong></td>
						<td><?php echo ($modPemeriksaan->kekuatanotot)? $modPemeriksaan->kekuatanotot : "-"; ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>

<script>
	function titikSesudahSimpan(titikX,titikY,urutan){
	var titikX=titikX-(85*3);
	var titikY=titikY+(17*20);
	var nomor = urutan+1;
	var color = '#000000';
	var size = '2px';
	$("#imgtag").append(
		$('<div><strong>'+nomor+'</strong></div>')
			.css('position', 'absolute')
			.css('top', titikY + 'px')
			.css('left', titikX + 'px')
			.css('width', size)
			.css('height', size)
			.css('background-color', color)
			.css('cursor', 'pointer')
			.css('display', 'block')
			.css('padding', '10px')
			.css('-webkit-border-radius', '50%')
			.css('-moz-border-radius', '50%')
			.css('border-radius', '50%')
			.css('vertical-align','middle')
			.css('color','#FFF')
	);
}

function loadTitikSesudahSimpan(){
	<?php if(!empty($modPemeriksaanGambar)){
		foreach($modPemeriksaanGambar as $i => $v){ ?>
		titikSesudahSimpan(<?= $v->kordinat_tubuh_x; ?>, <?= $v->kordinat_tubuh_y.','.$i; ?>);	
	<?php }
	}?>
}
$(document).ready(function(){
	loadTitikSesudahSimpan();
});
</script>