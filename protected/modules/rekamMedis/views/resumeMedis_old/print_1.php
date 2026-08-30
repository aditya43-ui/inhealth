<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
/*        font-size: 8pt !important;*/
        height: 24px;
        padding-left:10px;
    }
    body{
/*        width: 21.7cm;*/
    }
    .content td{
        height: 12px;
    }
    .diagnosa td{
/*        height: 30px;*/
    }
    .penunjang td{
/*        height: 30px;*/
    }
	.table_border{border: 1px solid #000;}
	.table_border td {border: 1px solid #000;}
</style>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table style="width: 100%; border: none;">
    <tr>
		<div class="header">
		<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());?></div>
    </tr>
</table>
<table style="width:100%;" class="table_border">
	<tr>
		<td colspan="5" style="text-align: center"><h3><u><?php echo strtoupper($judul_print); ?></u></h3></td>
	</tr>
	<tr style="height:30px;">
		<td colspan="3">Nama : <?php echo isset($modKunjungan->namadepan)?$modKunjungan->namadepan.$modKunjungan->nama_pasien:$modKunjungan->nama_pasien; ?></td>
		<td rowspan="3"><?php echo $modKunjungan->jeniskelamin; ?></td>
		<td colspan="2" style="text-align: center">No Register : <?php echo $modKunjungan->no_pendaftaran; ?></td>
	</tr>
	<tr style="height:30px;">
		<td>Umur : <?php echo $modKunjungan->umur; ?></td>
		<td>
			Ruang : 
			<?php 
			if(!empty($modKunjungan->pasienadmisi_id)){
				$admisi = PasienadmisiT::model()->findByPk($modKunjungan->pasienadmisi_id);
				echo $admisi->ruangan->ruangan_nama;
			}else{
				echo $modKunjungan->ruangan_nama; 
			}
			?>
		</td>
		<td>Dokter Pemeriksa : <?php echo $modKunjungan->dokterlengkap($modKunjungan->dokterpenanggungjawab_id); ?></td>
		<td style="text-align: center">No Rekam Medik : <?php echo $modKunjungan->no_rekam_medik; ?></td>
	</tr>
    <tr>
        <td>Tgl. Lahir Pasien : <?php echo MyFormatter::formatDateTimeForUser($modKunjungan->tanggal_lahir); ?></td>
        <td>Tgl. Masuk : <?php echo MyFormatter::formatDateTimeForUser($modKunjungan->tgl_pendaftaran); ?></td>
        <td>Tgl. Keluar : <?php
        $pulang = PasienpulangT::model()->findByAttributes(array(
            'pendaftaran_id'=>$modKunjungan->pendaftaran_id
        ), array(
            'condition'=>"carakeluar_id <> ".Params::CARAKELUAR_ID_RAWATINAP,
        ));
        
        if (!empty($pulang)) {
            echo MyFormatter::formatDateTimeForUser($pulang->tglpasienpulang);
        } else {
            echo "-";
        }
        
        
        ?></td>
    </tr>
</table>
<br>
<table width="100%" class="content" style="border: none;">
	<tr class="diagnosa">
        <td width="70%"><b>ANAMNESE :</b> 
			<?php
			if(!empty($modAnamnesa)){
				if(!empty($modAnamnesa->keluhanutama)){
					echo ' Keluhan Utama : '.$modAnamnesa->keluhanutama;
				}
				if(!empty($modAnamnesa->keluhantambahan)){
					echo ', Keluhan Utama : '.$modAnamnesa->keluhantambahan;
				}
				if(!empty($modAnamnesa->riwayatperjalananpasien)){
					echo ', Riwayat Perjalanan Penyakit : '.$modAnamnesa->riwayatperjalananpasien;
				}
				if(!empty($modAnamnesa->riwayatpenyakitterdahulu)){
					echo ', Riwayat Penyakit Terdahulu : '.$modAnamnesa->riwayatpenyakitterdahulu;
				}
				if(!empty($modAnamnesa->riwayatpenyakitkeluarga)){
					echo ', Riwayat Penyakit Keluarga : '.$modAnamnesa->riwayatpenyakitkeluarga;
				}
				if(!empty($modAnamnesa->riwayatalergiobat)){
					echo ', Riwayat Alergi Obat : '.$modAnamnesa->riwayatalergiobat;
				}
				if(!empty($modAnamnesa->riwayatmakanan)){
					echo ', Riwayat Makanan : '.$modAnamnesa->riwayatmakanan;
				}
				if(!empty($modAnamnesa->riwayatkelahiran)){
					echo ', Riwayat Kelahiran : '.$modAnamnesa->riwayatkelahiran;
				}
				if(!empty($modAnamnesa->riwayatimunisasi)){
					echo ', Riwayat Imunisasi : '.$modAnamnesa->riwayatimunisasi;
				}
				/*if(!empty($modAnamnesa->catatandiagnosautama_dokter)){
					echo ', Catatan Diagnosa Utama : '.$modAnamnesa->catatandiagnosautama_dokter;
				}
				if(!empty($modAnamnesa->catatandiagnosatambahan_dokter)){
					echo ', Catatan Diagnosa Tambahan : '.$modAnamnesa->catatandiagnosatambahan_dokter;
				}*/
			}
                        ?>
                        <br><b>PEMERIKSAAN FISIK :</b> 
                        <?php
			if(!empty($modPeriksaFisik)){
				if(!empty($modPeriksaFisik->keadaanumum)){
					echo ' Keadaan Umum : '.$modPeriksaFisik->keadaanumum;
				}
				if(!empty($modPeriksaFisik->tekanandarah) && $modPeriksaFisik->tekanandarah != "000 / 000"){
					echo ', Tekanan Darah : '.$modPeriksaFisik->tekanandarah;
				}
				if(!empty($modPeriksaFisik->detaknadi)){
					echo ', Detak Nadi : '.$modPeriksaFisik->detaknadi;
				}
				if(!empty($modPeriksaFisik->denyutjantung)){
					echo ', Denyut Jantung : '.$modPeriksaFisik->denyutjantung;
				}
				if(!empty($modPeriksaFisik->pernapasan) && $modPeriksaFisik->pernapasan!=0){
					echo ', Pernapasan : '.$modPeriksaFisik->pernapasan.' /Menit';
				}
				if(!empty($modPeriksaFisik->suhutubuh) && $modPeriksaFisik->suhutubuh!=0){
					echo ', Suhu Tubuh : '.$modPeriksaFisik->suhutubuh.' Celcius';
				}
				if(!empty($modPeriksaFisik->tinggibadan_cm) && $modPeriksaFisik->tinggibadan_cm!=0){
					echo ', Tinggi Badan : '.$modPeriksaFisik->tinggibadan_cm.' cm';
				}
				if(!empty($modPeriksaFisik->beratbadan_kg) && $modPeriksaFisik->beratbadan_kg!=0){
					echo ', Berat Badan : '.$modPeriksaFisik->beratbadan_kg.' kg';
				}
				if(!empty($modPeriksaFisik->bb_ideal) && $modPeriksaFisik->bb_ideal!=0){
					echo ', Berat Badan Ideal : '.$modPeriksaFisik->bb_ideal.' kg';
				}
				if(!empty($modPeriksaFisik->kelainanpadabagtubuh)){
					echo ', Kelainan Pada Tubuh : '.$modPeriksaFisik->kelainanpadabagtubuh;
				}
				if(!empty($modPeriksaFisik->gcs_eye)){
					$crit = new CDbCriteria();
					$crit->compare('LOWER(metodegcs_singkatan)', "e");
					$crit->addCondition('metodegcs_nilai is not null');
					$crit->addCondition('metodegcs_nilai ='.$modPeriksaFisik->gcs_eye);
					$crit->order = 'metodegcs_nilai ASC';
					$crit->limit = 1;
					$array = MetodegcsM::model()->findAll($crit);
					foreach ($array as $value) {
						echo '-Gcs Eye : '.$value->metodegcs_nama.". ";
					}
				}
				if(!empty($modPeriksaFisik->gcs_verbal)){
					$crit = new CDbCriteria();
					$crit->compare('LOWER(metodegcs_singkatan)', "v");
					$crit->addCondition('metodegcs_nilai is not null');
					$crit->addCondition('metodegcs_nilai ='.$modPeriksaFisik->gcs_verbal);
					$crit->order = 'metodegcs_nilai ASC';
					$crit->limit = 1;
					$array = MetodegcsM::model()->findAll($crit);
					foreach ($array as $value) {
						echo '-Gcs Verbal : '.$value->metodegcs_nama.". ";
					}
				}
				if(!empty($modPeriksaFisik->gcs_motorik)){
					$crit = new CDbCriteria();
					$crit->compare('LOWER(metodegcs_singkatan)', "m");
					$crit->addCondition('metodegcs_nilai is not null');
					$crit->addCondition('metodegcs_nilai ='.$modPeriksaFisik->gcs_motorik);
					$crit->order = 'metodegcs_nilai ASC';
					$crit->limit = 1;
					$array = MetodegcsM::model()->findAll($crit);
					foreach ($array as $value) {
						echo '-Gcs Motorik : '.$value->metodegcs_nama.". ";
					}
				}
				if(!empty($modPeriksaFisik->namaGCS) && $modPeriksaFisik->namaGCS!=0){
					echo '-Nilai Gcs : '.$modPeriksaFisik->namaGCS.". ";
				}
				if($modPeriksaFisik->jn_paten==true || $modPeriksaFisik->jn_obstruktifpartial==true || $modPeriksaFisik->jn_obstruktifnormal==true || $modPeriksaFisik->jn_stridor==true || $modPeriksaFisik->jn_gargling==true){
					echo '<br>Jalan Nafas : ';
					if($modPeriksaFisik->jn_paten==true){
						echo ' -Paten.';
					}
					if($modPeriksaFisik->jn_obstruktifpartial==true){
						echo ' -Obstruktif Partial.';
					}
					if($modPeriksaFisik->jn_obstruktifnormal==true){
						echo ' -Obstruktif Normal.';
					}
					if($modPeriksaFisik->jn_stridor==true){
						echo ' -Stridor.';
					}
					if($modPeriksaFisik->jn_gargling==true){
						echo ' -Gargling.';
					}
				}
				if($modPeriksaFisik->pgp_normal==true || $modPeriksaFisik->pgp_kussmaul==true || $modPeriksaFisik->pgp_takipnea==true || $modPeriksaFisik->pgp_retraktif==true || $modPeriksaFisik->pgp_dangkal==true){
					echo '<br>Pernapasan : ';
					if($modPeriksaFisik->pgp_normal==true){
						echo ' -Normal.';
					}
					if($modPeriksaFisik->pgp_kussmaul==true){
						echo ' -Kussmaul.';
					}
					if($modPeriksaFisik->pgp_takipnea==true){
						echo ' -Takipnea.';
					}
					if($modPeriksaFisik->pgp_retraktif==true){
						echo ' -Retraktif.';
					}
					if($modPeriksaFisik->pgp_dangkal==true){
						echo ' -Dangkal.';
					}
				}
			}
                        //if(count((array)$modAnamnesa)){
//                            if(!empty($modAnamnesa->catatandiagnosautama_dokter)){
//                                    echo '<br>Catatan diagnosa utama : '.$modAnamnesa->catatandiagnosautama_dokter;
//                            }
//                            if(!empty($modAnamnesa->catatandiagnosatambahan_dokter)){
//                                    echo '<br>Catatan diagnosa tambahan : '.$modAnamnesa->catatandiagnosatambahan_dokter;
//                            }
			//}
			?>
		</td>
        <td width="50%"><b>KONSULTASI DOKTER SPESIALIS LAIN :</b>
			<?php
			if(count((array)$modKosul)>0){
				foreach ($modKosul as $value) {
                    $ruangan = empty($value->ruangan) ? "-" : $value->ruangan->ruangan_nama;
                    $pegawai = empty($value->pegawai) ? "-" : $value->pegawai->nama_pegawai;
                    
					echo "<br>-".$ruangan." ( ".$pegawai." )";
				}
			}
			?>
		</td>
    </tr>
</table>
<table width="100%" border="" class="content">
	 <tr>
        <td align="center" valign="middle" colspan="3" style="font-weight:bold"><b>PEMERIKSAAN PENUNJANG</b></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
	 <tr class="penunjang">
		<td width="30%"><b>A. LABOLATORIUM</b></td>
        <td>
			<?php 
                        $modResume->resume_pemeriksaanlab = str_replace("<br>", ", ", $modResume->resume_pemeriksaanlab);
                        $modResume->resume_pemeriksaanlab = str_replace("<p>", " ", $modResume->resume_pemeriksaanlab);
                        $modResume->resume_pemeriksaanlab = str_replace("</p>", ", ", $modResume->resume_pemeriksaanlab);
                        echo $modResume->resume_pemeriksaanlab;
//			if(count((array)$modTindakanLab)>0){
//				foreach ($modTindakanLab as $value) {
//					echo $value->daftartindakan->daftartindakan_nama;
//					echo ', ';
//				}
//			}
			?>
		</td>
    </tr>
	 <tr class="penunjang">
		<td width="30%"><b>B. RADIOLOGI</b></td>
        <td>
			<?php 
                        $modResume->resume_pemeriksaanrad = str_replace("<br>", ", ", $modResume->resume_pemeriksaanrad);
                        $modResume->resume_pemeriksaanrad = str_replace("<p>", ", ", $modResume->resume_pemeriksaanrad);
                        $modResume->resume_pemeriksaanrad = str_replace("</p>", ", ", $modResume->resume_pemeriksaanrad);
                        echo $modResume->resume_pemeriksaanrad;
//			if(count((array)$modTindakanRad)>0){
//				foreach ($modTindakanRad as $value) {
//					echo $value->daftartindakan->daftartindakan_nama;
//					echo ', ';
//				}
//			}
			?>
		</td>
    </tr>
	 <tr class="penunjang">
		<td width="30%"><b>C. PEMERIKSAAN CT-SCAN</b></td>
        <td></td>
    </tr>
	 <tr class="penunjang">
		<td width="30%"><b>D. PEMERIKSAAN LAINNYA</b></td>
        <td>
        <?php
            $modResume->resume_pemeriksaanfisik = str_replace("<br>", ", ", $modResume->resume_pemeriksaanfisik);
            $modResume->resume_pemeriksaanfisik = str_replace("<p>", "", $modResume->resume_pemeriksaanfisik);
            $modResume->resume_pemeriksaanfisik = str_replace("</p>", ", ", $modResume->resume_pemeriksaanfisik);
            echo $modResume->resume_pemeriksaanfisik;
        ?>
        </td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
	<tr class="penunjang">
		<td width="30%"><b>DIAGNOSA UTAMA :</b></td>
        <td style="text-align:center;"><b>KODE ICD-X</b></td>
    </tr>
	<tr class="penunjang">
		<?php
		if(!empty($modDiadnosaUtama)){
		?>
		<td width="30%"><?php echo $modDiadnosaUtama->diagnosa->diagnosa_nama;?></td>
        <td style="text-align:center;"><?php echo $modDiadnosaUtama->diagnosa->diagnosa_kode;?></td>
		<?php	
		}else{
		?>
		<td width="30%"></td>
        <td style="text-align:center;"></td>
		<?php	
		}
		?>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
	<tr class="penunjang">
		<td width="30%"><b>DIAGNOSA TAMBAHAN :</b></td>
        <td style="text-align:center;"><b>KODE ICD-X</b></td>
    </tr>
	<?php 
	if(count((array)$modDiadnosaTambahan)){
		$no = 1;
		foreach ($modDiadnosaTambahan as $value) {
	?>
			<tr class="penunjang">
				<td width="30%"><?php echo $no.'. '.$value->diagnosa->diagnosa_nama; ?></td>
				<td style="text-align:center;"><?php echo $value->diagnosa->diagnosa_kode;?></td>
			</tr>
	<?php
		$no++;
		}
	}else{
	?>
	<tr class="penunjang">
		<td width="30%"></td>
        <td style="text-align:center;"></td>
    </tr>
	<?php
	}
	?>
</table>
<table width="100%" class="content" style="border: none;">
	<tr class="penunjang">
		<td width="30%"><b>DIAGNOSA TINDAKAN :</b></td>
        <td style="text-align:center;"><b>KODE ICD-IX</b></td>
    </tr>
	<?php 
	if(count((array)$modDiadnosaTindakan)){
		$no = 1;
		foreach ($modDiadnosaTindakan as $value) {
			if(!empty($value->diagnosaicdix_id)){
	?>
			<tr class="penunjang">
				<td width="30%"><?php echo $no.'. '.$value->diagnosatindakan->diagnosaicdix_nama; ?></td>
				<td style="text-align:center;"><?php echo $value->diagnosatindakan->diagnosaicdix_kode;?></td>
			</tr>
	<?php
		$no++;
			}
		}
	}else{
	?>
	<tr class="penunjang">
		<td width="30%"></td>
        <td style="text-align:center;"></td>
    </tr>
	<?php
	}
	?>
</table>
<table width="100%" class="content" style="border: none;">
    <tr class="penunjang">
        <td><b>INSTRUKSI TINDAK LANJUT</b></td>
    </tr>
    <tr class="penunjang">
        <td><?php 
        
        echo $modResume->saran_resume;
        
        ?></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
    <tr class="penunjang">
        <td><b>CARA KELUAR</b></td>
        <td><b>KONDISI KELUAR</b></td>
    </tr>
    <tr class="penunjang">
        <td><?php 
        
        
        echo $modResume->carakeluar;
        
        ?></td>
        <td><?php 
        
        echo $modResume->kondisipulang;
        
        ?></td>
    </tr>
</table>
<table width="100%" border="" class="content">
	 <tr>
        <td align="center" valign="middle" colspan="3" style="font-weight:bold"><b>PENGOBATAN</b></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
	<tr class="diagnosa">
        <!--<td><b>Pengobatan yang sudah dilakukan : </b> <?php // echo isset($modAnamnesa->pengobatanygsudahdilakukan)? $modAnamnesa->pengobatanygsudahdilakukan : ''; ?></td>-->
        <td><b>Pengobatan yang sudah dilakukan : </b><?php echo $modResume->terapiperawatan; ?></td>
	</tr>
	<tr class="diagnosa">
            <td><b>Keterangan : </b><?php echo isset($modAnamnesa->keterangananamesa)? $modAnamnesa->keterangananamesa : ''; ?></td>
	</tr>
</table>

<table style="width: 100%; border: none;">
    <tr>
        <td colspan="4" align="center" valign="middle"></td>
        <td colspan="4" style="width:170px;"></td>
        <!--<td colspan="3" align="center" valign="middle"><?php // echo Yii::app()->user->getState('kabupaten_nama').", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?><br></td>-->
        <?php if((Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RI || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_PI) && !empty($modKunjungan->tglpasienpulang)){?>
            <td colspan="4" align="center" valign="middle"><?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format::FormatDateTimeForUser(date('Y-m-d', strtotime($modKunjungan->tgl_pendaftaran))); ?><br></td>
        <?php }else{?>
            <td colspan="4" align="center" valign="middle"><?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format::FormatDateTimeForUser(date('Y-m-d', strtotime($modKunjungan->tgl_pendaftaran))); ?><br></td>
        <?php }?>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4" align="center" valign="middle"></td>
        <td colspan="4" style="width:170px;"></td>
        <!--<td colspan="3" align="center" valign="middle"><?php // echo (isset($modKunjungan->pegawai->gelardepan)?$modKunjungan->pegawai->gelardepan:'').' '.$modKunjungan->pegawai->nama_pegawai.' '.(isset($modKunjungan->pegawai->gelarbelakang_nama)?$modKunjungan->pegawai->gelarbelakang_nama:''); ?></td>-->
        <td colspan="4" align="center" valign="middle"><?php echo $modKunjungan->dokterlengkap($modKunjungan->dokterpenanggungjawab_id); ?></td>
    </tr>

</table>
