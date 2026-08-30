<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
        height: 24px;
        padding-left:10px;
    }
    .content td{
        height: 48px;
    }
</style>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table width="100%" border="1">
    <tr>
        <td style="width:20%">No. Pendaftaran</td>
        <td style="width:30%"><?php echo $modPendaftaran->no_pendaftaran;  ?></td>
        <td style="width:20%">No. Rekam Medik</td>
        <td style="width:30%"><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Nama</td>
        <td style="width:30%"><?php echo $modPasien->nama_pasien; ?></td>
        <td style="width:20%">Tgl. Lahir / UMUR</td>
        <td style="width:30%"><?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?> / <?php echo CustomFunction::hitungUmur($modPasien->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Jenis Kelamin</td>
        <td style="width:30%"><?php echo $modPasien->jeniskelamin; ?></td>
        <td style="width:20%">No. Pendaftaran</td>
        <td style="width:30%"><?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Perihal</td>
        <td style="width:30%">EVALUASI HASIL MEDICAL CHECK-UP</td>
        <td style="width:20%">Dokter Pemeriksa</td>
        <td style="width:30%"><?php echo !empty($ModKesimpulanMCU->nama_pemeriksa_kes)?$ModKesimpulanMCU->nama_pemeriksa_kes:''; ?></td>
    </tr>
</table>
<br>
<div class="row">
	<div class="span12">
		<fieldset class="well">
			<legend class="rim"><h4>PEMERIKSAAN</h4></legend>
			<table style="width: 100%; border: none;">
				<tr>
					<td width="25%" colspan="2">1. Subyektif</td>
					<td width="70%" colspan="3">: &nbsp; Kel (-)</td>
				</tr>
				<tr>
					<td colspan="5">2. Status Somatik</td>
				</tr>
				<tr>
					<td width="15%"></td>
					<td width="10%">Tinggi</td>
					<td width="30%">: &nbsp; <?php echo !empty($modPemeriksaanFisik->tinggibadan_cm)?$modPemeriksaanFisik->tinggibadan_cm:''; ?> Cm</td>
					<td width="10%">Berat</td>
					<td width="30%">: &nbsp; <?php echo !empty($modPemeriksaanFisik->beratbadan_kg)?$modPemeriksaanFisik->beratbadan_kg:''; ?> Kg</td>
				</tr>
				<tr>
					<td width="15%"></td>
					<td width="10%">Tekanan Darah</td>
					<td width="30%">: &nbsp; <?php echo !empty($modPemeriksaanFisik->tekanandarah)?$modPemeriksaanFisik->tekanandarah:''; ?> mmHg</td>
					<td width="10%">Denyut Nadi</td>
					<td width="30%">: &nbsp; <?php echo !empty($modPemeriksaanFisik->detaknadi)?$modPemeriksaanFisik->detaknadi:''; ?> /mnt</td>
				</tr>
				<tr>
					<td width="15%"></td>
					<td width="10%">Penglihatan</td>
					<td width="10%" colspan="4">
						<?php
						if(!empty($modPeriksaKacamata->hasil_penglihatan)){
							if($modPeriksaKacamata->hasil_penglihatan == 'Normal'){
								echo "[ X ] Normal &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp";
								echo "[ &nbsp; ] Ada Kelainan";
							}else{
								echo "[ &nbsp; ] Normal &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp";
								echo "[ X ] Ada Kelainan";
							}
						}
						?>
					</td>
				</tr>
				<tr>
					<td width="15%"></td>
					<td width="10%">Pendengaran</td>
					<td width="10%" colspan="4">
						<?php
						if(!empty($modHearingTest->penuruankempendengaran)){
							if($modHearingTest->penuruankempendengaran == 'Normal'){
								echo "[ X ] Normal &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp";
								echo "[ &nbsp; ] Ada Kelainan";
							}else{
								echo "[ &nbsp; ] Normal &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp";
								echo "[ X ] Ada Kelainan";
							}
						}
						?>
					</td>
				</tr>
				<tr>
					<td width="15%"></td>
					<td width="10%">Fisik</td>
					<td width="10%" colspan="4">
						<?php
						if(!empty($modPemeriksaanFisik->kelainanpadabagtubuh)){
							if($modPemeriksaanFisik->kelainanpadabagtubuh == 'Normal'){
								echo "[ X ] Normal &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp";
								echo "[ &nbsp; ] Ada Kelainan";
							}else{
								echo "[ &nbsp; ] Normal &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp";
								echo "[ X ] Ada Kelainan";
							}
						}
						
						?>
					</td>
				</tr>
				<tr>
					<td width="25%" colspan="2">3. Rontgen</td>
					<td width="70%" colspan="3">
						<?php
						if(!empty($modHasilPemeriksaanRad)){
							foreach ($modHasilPemeriksaanRad as $i =>$v){
								echo $v->pemeriksaanrad->pemeriksaanrad_nama." &nbsp; : ".(!empty($v->kesimpulan_hasilrad)?$v->kesimpulan_hasilrad:' - ');
								echo "<br>";
							}
						}
						?>
					</td>
				</tr>
				<tr>
					<td width="25%" colspan="2">4. Test Treadmill</td>
					<td width="70%" colspan="3">
						<?php
						if(!empty($modTreadMill->hasiltreadmill)){
							if($modTreadMill->hasiltreadmill == 'Normal'){
								echo "[ X ] Normal &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp";
								echo "[ &nbsp; ] Ada Kelainan";
							}else{
								echo "[ &nbsp; ] Normal &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp";
								echo "[ X ] Ada Kelainan";
							}
						}
						
						?>
					</td>
				</tr>
				<tr>
					<td width="25%" colspan="2">5. Resiko Jantung</td>
					<td width="70%" colspan="3">
						<?php echo !empty($modJantungKoroner->hasil_resiko_persen)?$modJantungKoroner->hasil_resiko_persen:' - '; ?>
					</td>
				</tr>
				<tr>
					<td width="25%" colspan="2">6. Kode ICD</td>
					<td width="70%" colspan="3">
						<?php echo !empty($modPasienMorbiditas->diagnosa_id)?$modPasienMorbiditas->diagnosa->diagnosa_kode." - ".$modPasienMorbiditas->diagnosa->diagnosa_nama:' - '; ?>
					</td>
				</tr>
				<tr>
					<td width="25%" colspan="2">7. Laboratorium</td>
					<td width="70%" colspan="3">
						<?php
						if(!empty($modHasilPemeriksaanLabDetail)){
							foreach ($modHasilPemeriksaanLabDetail as $ii =>$vv){
								echo $vv->pemeriksaanlab->pemeriksaanlab_nama." &nbsp; : ".$vv->hasilpemeriksaan;
								echo "<br>";
							}
						}else{
							echo " - ";
						}
						?>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset class="well">
			<legend class="rim"><h4>KESIMPULAN</h4></legend>
			<table style="width: 100%; border: none;">
				<tr>
					<td width="5%"></td>
					<td width="95%">
						<?php if($ModKesimpulanMCU->kesimpulan1_status==1){echo '[ X ]';}else{echo '[ &nbsp;&nbsp; ]';} ?>
						&nbsp;
						<?php echo $ModKesimpulanMCU->kesimpulan1_desc ?>
					</td>
				</tr>
				<tr>
					<td width="5%"></td>
					<td width="95%">
						<?php if($ModKesimpulanMCU->kesimpulan2_status==1){echo '[ X ]';}else{echo '[ &nbsp;&nbsp; ]';} ?>
						&nbsp;
						<?php echo $ModKesimpulanMCU->kesimpulan2_desc ?>
					</td>
				</tr>
				<tr>
					<td width="5%"></td>
					<td width="95%">
						<?php if($ModKesimpulanMCU->kesimpulan3_status==1){echo '[ X ]';}else{echo '[ &nbsp;&nbsp; ]';} ?>
						&nbsp;
						<?php echo $ModKesimpulanMCU->kesimpulan3_desc ?>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset class="well">
			<legend class="rim"><h4>SARAN</h4></legend>
			<table style="width: 100%; border: none;">
				<tr>
					<td width="5%"></td>
					<td width="95%" colspan="2">
						<?php if($ModKesimpulanMCU->saran1_status==1){echo '[ X ]';}else{echo '[ &nbsp;&nbsp; ]';} ?>
						&nbsp;
						<?php echo $ModKesimpulanMCU->saran1_desc ?>
					</td>
				</tr>
					<tr>
						<td width="2%"></td>
						<td width="3%"></td>
						<td width="95%">
							<?php if($ModKesimpulanMCU->saran1_1_status==1){echo '[ X ]';}else{echo '[ &nbsp;&nbsp; ]';} ?>
							&nbsp;
							<?php echo $ModKesimpulanMCU->saran1_1_desc ?>
						</td>
					</tr>
					<tr>
						<td width="2%"></td>
						<td width="3%"></td>
						<td width="95%">
							<?php if($ModKesimpulanMCU->saran1_2_status==1){echo '[ X ]';}else{echo '[ &nbsp;&nbsp; ]';} ?>
							&nbsp;
							<?php echo $ModKesimpulanMCU->saran1_2_desc ?>
						</td>
					</tr>
					<tr>
						<td width="2%"></td>
						<td width="3%"></td>
						<td width="95%">
							<?php if($ModKesimpulanMCU->saran1_3_status==1){echo '[ X ]';}else{echo '[ &nbsp;&nbsp; ]';} ?>
							&nbsp;
							<?php echo $ModKesimpulanMCU->saran1_3_desc ?>
						</td>
					</tr>
				<tr>
					<td width="5%"></td>
					<td width="95%" colspan="2">
						<?php if($ModKesimpulanMCU->saran2_status==1){echo '[ X ]';}else{echo '[ &nbsp;&nbsp; ]';} ?>
						&nbsp;
						<?php echo $ModKesimpulanMCU->saran2_desc ?>
					</td>
				</tr>
				<tr>
					<td width="5%"></td>
					<td width="95%" colspan="2">
						<?php if($ModKesimpulanMCU->saran3_status==1){echo '[ X ]';}else{echo '[ &nbsp;&nbsp; ]';} ?>
						&nbsp;
						<?php echo $ModKesimpulanMCU->saran3_desc ?>
					</td>
				</tr>
					<tr>
						<td width="2%"></td>
						<td width="3%"></td>
						<td width="95%">
							<?php echo $ModKesimpulanMCU->saran3_1_desc ?>
						</td>
					</tr>
					<tr>
						<td width="2%"></td>
						<td width="3%"></td>
						<td width="95%">
							<?php echo $ModKesimpulanMCU->saran3_2_desc ?>
						</td>
					</tr>
					<tr>
						<td width="2%"></td>
						<td width="3%"></td>
						<td width="95%">
							<?php echo $ModKesimpulanMCU->saran3_3_desc ?>
						</td>
					</tr>
						<tr>
							<td width="2%"></td>
							<td width="3%"></td>
							<td width="95%">&nbsp; &nbsp; &nbsp; &nbsp;
								<?php if($ModKesimpulanMCU->saran3_3_1_status==1){echo '[ X ]';}else{echo '[ &nbsp;&nbsp; ]';} ?>
								&nbsp;
								<?php echo $ModKesimpulanMCU->saran3_3_1_desc ?>
							</td>
						</tr>
						<tr>
							<td width="2%"></td>
							<td width="3%"></td>
							<td width="95%">&nbsp; &nbsp; &nbsp; &nbsp;
								<?php if($ModKesimpulanMCU->saran3_3_2_status==1){echo '[ X ]';}else{echo '[ &nbsp;&nbsp; ]';} ?>
								&nbsp;
								<?php echo $ModKesimpulanMCU->saran3_3_2_desc ?>
							</td>
						</tr>
						<tr>
							<td width="2%"></td>
							<td width="3%"></td>
							<td width="95%">&nbsp; &nbsp; &nbsp; &nbsp;
								<?php if($ModKesimpulanMCU->saran3_3_3_status==1){echo '[ X ]';}else{echo '[ &nbsp;&nbsp; ]';} ?>
								&nbsp;
								<?php echo $ModKesimpulanMCU->saran3_3_3_desc ?>
							</td>
						</tr>
						<tr>
							<td width="2%"></td>
							<td width="3%"></td>
							<td width="95%">&nbsp; &nbsp; &nbsp; &nbsp;<?php echo $ModKesimpulanMCU->saran3_3_4_desc ?></td>
						</tr>
					<tr>
						<td width="2%"></td>
						<td width="3%"></td>
						<td width="95%">
							<?php echo $ModKesimpulanMCU->saran3_4_desc ?>
						</td>
					</tr>
			</table>
		</fieldset>
		<fieldset class="well">
			<legend class="rim"><h4>KETERANGAN</h4></legend>
			<table style="width: 100%; border: none;">
				<tr>
					<td width="5%"></td>
					<td width="95%">
						<?php echo !empty($ModKesimpulanMCU->keterangan_kesimpulanmcu)?$ModKesimpulanMCU->keterangan_kesimpulanmcu:''; ?>
					</td>
				</tr>
			</table>
		</fieldset>
		<br><br>
	</div>
</div>