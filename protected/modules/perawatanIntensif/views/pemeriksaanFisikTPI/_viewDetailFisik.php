<style>
	#imgtag
			{
				position: relative;
				min-width: 300px;
				min-height: 300px;
				float: none;
				border: 3px solid #FFF;
				cursor: crosshair;
				text-align: center;
			}
            
            .tab_thorax td {
                border: 1px solid black;
            }
            
            .tab_thorax {
                border: 1px solid black;
            }
</style>
<table style="width: 100%; border: none;">
    <tr>
        <td >
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?>
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('tgl_pendaftaran')); ?>:</label>
            <?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran)); ?>
        </td>
    </tr><br>
    <tr>
        <td>
                <label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?>
        </td>
        <td>
             <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
        </td>
    </tr><br>
    <tr>
        <td>
                <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->umur); ?>
        </td>
        <td>
             <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Kelas Pelayanan')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->kelaspelayanan->kelaspelayanan_nama); ?>
        </td>
    </tr><br>
    <tr>
        <td>
                <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Jenis Penjamin / Penjamin ')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?> / <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?>
            
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Nama Dokter')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai); ?>
        </td>
    </tr> 
    <tr>
        <td></td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPemeriksaanFisik->getAttributeLabel('Nama Perawat')); ?>:</label>
            <?php echo CHtml::encode($modPemeriksaanFisik->paramedis_nama); ?>
            
        </td>
    </tr>
</table>

<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
    <?php
        if ($modPemeriksaanFisik->gcs_jenis == TRUE){
            $gcs_eye = PIMetodeGCSM::model()->findByAttributes(array(
                'metodegcs_nilai'=>$modPemeriksaanFisik->gcs_eye,
                'metodegcs_aktif'=>true,
            ), array(
                'condition'=>"LOWER(metodegcs_singkatan) = 'be'",
            ));
            $gcs_verbal = PIMetodeGCSM::model()->findByAttributes(array(
                'metodegcs_nilai'=>$modPemeriksaanFisik->gcs_verbal,
                'metodegcs_aktif'=>true,
            ), array(
                'condition'=>"LOWER(metodegcs_singkatan) = 'bv'",
            ));
            $gcs_motorik = PIMetodeGCSM::model()->findByAttributes(array(
                'metodegcs_nilai'=>$modPemeriksaanFisik->gcs_motorik,
                'metodegcs_aktif'=>true,
            ), array(
                'condition'=>"LOWER(metodegcs_singkatan) = 'bm'",
            ));

            $gcs_jenis_jd = "Bayi";
            
        } else {
            $gcs_eye = PIMetodeGCSM::model()->findByAttributes(array(
                'metodegcs_nilai'=>$modPemeriksaanFisik->gcs_eye,
                'metodegcs_aktif'=>true,
            ), array(
                'condition'=>"LOWER(metodegcs_singkatan) = 'e'",
            ));
            $gcs_verbal = PIMetodeGCSM::model()->findByAttributes(array(
                'metodegcs_nilai'=>$modPemeriksaanFisik->gcs_verbal,
                'metodegcs_aktif'=>true,
            ), array(
                'condition'=>"LOWER(metodegcs_singkatan) = 'v'",
            ));
            $gcs_motorik = PIMetodeGCSM::model()->findByAttributes(array(
                'metodegcs_nilai'=>$modPemeriksaanFisik->gcs_motorik,
                'metodegcs_aktif'=>true,
            ), array(
                'condition'=>"LOWER(metodegcs_singkatan) = 'm'",
            ));

            $gcs_jenis_jd = "Dewasa/Anak";
        }

        $hasil = (empty($modPemeriksaanFisik->gcs_eye ) ? 0 : $modPemeriksaanFisik->gcs_eye)
               + (empty($modPemeriksaanFisik->gcs_verbal) ? 0 : $modPemeriksaanFisik->gcs_verbal)
               + (empty($modPemeriksaanFisik->gcs_motorik) ? 0 : $modPemeriksaanFisik->gcs_motorik);

        
    ?>
    <tr>
        <td colspan="4"><b>Glasgow Coma Scale</b> <?php echo $gcs_jenis_jd; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">GCS Mata (Eye)</td>
        <td colspan="2" width="70%"><?php echo !empty(isset($gcs_eye))?$gcs_eye->textMetodeGCSM:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">GCS Verbal</td>
        <td colspan="2" width="70%"><?php echo !empty($gcs_verbal)?$gcs_verbal->textMetodeGCSM:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">GCS Motorik</td>
        <td colspan="2" width="70%"><?php echo !empty($gcs_motorik)?$gcs_motorik->textMetodeGCSM:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Hasil</td>
        <td colspan="2" width="70%"><?php echo isset($hasil)?$hasil:" - "; ?></td>
    </tr>
</table>

<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
    <tr>
        <td colspan="2" width="30%">Tekanan Darah</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->tekanandarah)?$modPemeriksaanFisik->tekanandarah:" - ").' /MmHg'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Mean Arterial Pressure</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->meanarteripressure)?$modPemeriksaanFisik->meanarteripressure:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Detak Nadi</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->detaknadi)?$modPemeriksaanFisik->detaknadi:" - ").' /Menit'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Denyut Jantung</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->denyutjantung)?$modPemeriksaanFisik->denyutjantung:" - "); ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Pernapasan</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->pernapasan)?$modPemeriksaanFisik->pernapasan:" - ").' /Menit'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Suhu Tubuh</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->suhutubuh)?$modPemeriksaanFisik->suhutubuh:" - ").' &deg; Celcius'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Tinggi badan / Berat badan</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->tinggibadan_cm)?$modPemeriksaanFisik->tinggibadan_cm:" - ").' Cm / '.(isset($modPemeriksaanFisik->beratbadan_kg)?$modPemeriksaanFisik->beratbadan_kg:" - ").' Kg'; ?></td>
    </tr>
    <?php
    $bmi_definisi = "-";
    $bmi = "-";
    if (!empty($modPemeriksaanFisik->tinggibadan_cm) && !empty($modPemeriksaanFisik->beratbadan_kg)) {
        $bmi = floor($modPemeriksaanFisik->beratbadan_kg / ($modPemeriksaanFisik->tinggibadan_cm * $modPemeriksaanFisik->tinggibadan_cm / 10000));
        
        $criteria2 = new CDbCriteria();
        $criteria2->select = 'max(bmi_minimum) as max_bmi';
        $modBMI = BodymassindexM::model()->find($criteria2);
        $criteria = new CDbCriteria();
        $criteria->addCondition($bmi . ' >= bmi_minimum');
        $criteria->addCondition($bmi . ' <= bmi_maksimum');
        $data = array();
        $bmi_hasil = BodymassindexM::model()->find($criteria);
        
        $bmi_definisi = (!empty($bmi_hasil->bmi_defenisi) ? $bmi_hasil->bmi_defenisi : "");
    } 
    
    ?>
    <tr>
        <td colspan="2" width="30%">Index Masa Tubuh</td>
        <td colspan="2" width="70%"><?php echo $bmi." - ".$bmi_definisi; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Kelainan Pada Bagian Tubuh</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->kelainanpadabagtubuh)?$modPemeriksaanFisik->kelainanpadabagtubuh:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Reflek Cahaya</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->tandavital_reflekcahaya)?$modPemeriksaanFisik->tandavital_reflekcahaya:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">SPO2</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->tandavital_spo2)?$modPemeriksaanFisik->tandavital_spo2:" - "; ?></td>
    </tr>
</table>

<?php echo $this->renderPartial('perawatanIntensif.views.pemeriksaanFisikTPI.detail._kepalaLeher', array(
    'modPemeriksaanFisik'=>$modPemeriksaanFisik
), true); ?>

<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
    <tr>
        <td colspan="2"><b>Thorax</b></td>
    </tr>
    <tr>
        <td width="30%">Inspeksi</td>
        <td width="70%"><?php echo isset($modPemeriksaanFisik->inspeksi)?$modPemeriksaanFisik->inspeksi:" - "; ?></td>
    </tr>
    <tr>
        <td width="30%">Palpasi</td>
        <td width="70%"><?php echo isset($modPemeriksaanFisik->palpasi)?$modPemeriksaanFisik->palpasi:" - "; ?></td>
    </tr>
    <tr>
        <td width="30%">Bising Jantung</td>
        <td width="70%"><?php echo isset($modPemeriksaanFisik->bisingjantung)?$modPemeriksaanFisik->bisingjantung:" - "; ?></td>
    </tr>
    <tr>
        <td width="30%">Obgyn</td>
        <td width="70%"><?php echo isset($modPemeriksaanFisik->panel_obgyn)?$modPemeriksaanFisik->panel_obgyn:" - "; ?></td>
    </tr>
    <tr>
        <td width="30%">Auskultasi</td>
        <td>
            <table class="tab_thorax">
                <tr>
                    <td width="50"></td>
                    <td width="60">Kiri</td>
                    <td width="60">Kanan</td>
                </tr>
                <tr>
                    <td rowspan="3">Rh</td>
                    <td><?php echo $modPemeriksaanFisik->au_parurhkanan_1; ?></td>
                    <td><?php echo $modPemeriksaanFisik->au_parurhkiri_1; ?></td>
                </tr>
                <tr>
                    <td><?php echo $modPemeriksaanFisik->au_parurhkanan_2; ?></td>
                    <td><?php echo $modPemeriksaanFisik->au_parurhkiri_2; ?></td>
                </tr>
                <tr>
                    <td><?php echo $modPemeriksaanFisik->au_parurhkanan_3; ?></td>
                    <td><?php echo $modPemeriksaanFisik->au_parurhkiri_3; ?></td>
                </tr>
                <tr>
                    <td width="50">&nbsp;</td>
                    <td width="60"></td>
                    <td width="60"></td>
                </tr>
                <tr>
                    <td rowspan="3">Wh</td>
                    <td><?php echo $modPemeriksaanFisik->au_paruwhkanan_1; ?></td>
                    <td><?php echo $modPemeriksaanFisik->au_paruwhkiri_1; ?></td>
                </tr>
                <tr>
                    <td><?php echo $modPemeriksaanFisik->au_paruwhkanan_2; ?></td>
                    <td><?php echo $modPemeriksaanFisik->au_paruwhkiri_2; ?></td>
                </tr>
                <tr>
                    <td><?php echo $modPemeriksaanFisik->au_paruwhkanan_3; ?></td>
                    <td><?php echo $modPemeriksaanFisik->au_paruwhkiri_3; ?></td>
                </tr>
            </table>
            <table class="tab_thorax">
                <tr>
                    <td rowspan="4" width="80">Bunyi<br>Jantung</td>
                    <td width="30">S1</td>
                    <td width="60"><?php echo $modPemeriksaanFisik->au_cardios1; ?></td>
                </tr>
                <tr>
                    <td>S2</td>
                    <td><?php echo $modPemeriksaanFisik->au_cardios2; ?></td>
                </tr>
                <tr>
                    <td>S3</td>
                    <td><?php echo $modPemeriksaanFisik->au_cardios3; ?></td>
                </tr>
                <tr>
                    <td>S4</td>
                    <td><?php echo $modPemeriksaanFisik->au_cardios4; ?></td>
                </tr>
            </table>
            
            
        </td>
    </tr>
</table>

<?php
if (!empty($modPemeriksaanFisik->reflekbayi)) {
    $modPemeriksaanFisik->reflekbayi = CJSON::decode($modPemeriksaanFisik->reflekbayi);
    echo $this->renderPartial('perawatanIntensif.views.pemeriksaanFisikTPI.detail._reflekBayi', array(
        'modPemeriksaanFisik'=>$modPemeriksaanFisik
    ), true);
}
?>

<?php 
$integumen = IntegumenT::model()->findByAttributes(array(
    'pemeriksaanfisik_id'=>$modPemeriksaanFisik->pemeriksaanfisik_id,
));

if (!empty($integumen)) : 

?>

<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
    <tr>
        <td colspan="2"><b>Integumen</b></td>
    </tr>
    <tr>
        <td width="30%">Warna</td>
        <td><?php echo empty($integumen->warna) ? "-" : $integumen->warna; ?></td>
    </tr>
    <tr>
        <td width="30%">Turgor</td>
        <td><?php echo empty($integumen->tugor) ? "-" : $integumen->tugor; ?></td>
    </tr>
    <tr>
        <td width="30%">Integritas</td>
        <td><?php echo empty($integumen->integritas) ? "-" : $integumen->integritas; ?></td>
    </tr>
    <tr>
        <td colspan="2">
            <div style="font-weight: bold; text-align: center">Skala Norton</div>
            <table width="100%" id="tab_norton">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>4</th>
                        <th>3</th>
                        <th>2</th>
                        <th>1</th>
                        <th>Skor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Kondisi Fisik</td>
                        <td><span class="fa fa<?php echo $integumen->norton_kondisifisik == 4 ? '-check' : '' ?>-square-o"></span> Baik</label></td>
                        <td><span class="fa fa<?php echo $integumen->norton_kondisifisik == 3 ? '-check' : '' ?>-square-o"></span> Sedang</label></td>
                        <td><span class="fa fa<?php echo $integumen->norton_kondisifisik == 2 ? '-check' : '' ?>-square-o"></span> Buruk</label></td>
                        <td><span class="fa fa<?php echo $integumen->norton_kondisifisik == 1 ? '-check' : '' ?>-square-o"></span> Sangat Buruk</label></td>
                        <td style="text-align: right;"><?php echo $integumen->norton_kondisifisik; ?></td>
                    </tr>
                    <tr>
                        <td>Status Mental</td>
                        <td><span class="fa fa<?php echo $integumen->norton_statusmental == 4 ? '-check' : '' ?>-square-o"></span> Sadar</label></td>
                        <td><span class="fa fa<?php echo $integumen->norton_statusmental == 3 ? '-check' : '' ?>-square-o"></span> Apatis</label></td>
                        <td><span class="fa fa<?php echo $integumen->norton_statusmental == 2 ? '-check' : '' ?>-square-o"></span> Bingung</label></td>
                        <td><span class="fa fa<?php echo $integumen->norton_statusmental == 1 ? '-check' : '' ?>-square-o"></span> Stupor</label></td>
                        <td style="text-align: right;"><?php echo $integumen->norton_statusmental; ?></td>
                    </tr>
                    <tr>
                        <td>Aktifitas</td>
                        <td><span class="fa fa<?php echo $integumen->norton_aktifitas == 4 ? '-check' : '' ?>-square-o"></span> Jalan Sendiri</label></td>
                        <td><span class="fa fa<?php echo $integumen->norton_aktifitas == 3 ? '-check' : '' ?>-square-o"></span> Jalan dengan Bantuan</label></td>
                        <td><span class="fa fa<?php echo $integumen->norton_aktifitas == 2 ? '-check' : '' ?>-square-o"></span> Kursi Roda</label></td>
                        <td><span class="fa fa<?php echo $integumen->norton_aktifitas == 1 ? '-check' : '' ?>-square-o"></span> Ditempat Tidur</label></td>
                        <td style="text-align: right;"><?php echo $integumen->norton_aktifitas; ?></td>
                    </tr>
                    <tr>
                        <td>Mobilitas</td>
                        <td><span class="fa fa<?php echo $integumen->norton_mobilitas == 4 ? '-check' : '' ?>-square-o"></span> Bebas Bergerak</td>
                        <td><span class="fa fa<?php echo $integumen->norton_mobilitas == 3 ? '-check' : '' ?>-square-o"></span> Agak Terbatas</td>
                        <td><span class="fa fa<?php echo $integumen->norton_mobilitas == 2 ? '-check' : '' ?>-square-o"></span> Sangat Terbatas</td>
                        <td><span class="fa fa<?php echo $integumen->norton_mobilitas == 1 ? '-check' : '' ?>-square-o"></span> Tidak Mampu Bergerak</td>
                        <td style="text-align: right;"><?php echo $integumen->norton_mobilitas; ?></td>
                    </tr>
                    <tr>
                        <td>Inkontinesia</td>
                        <td><span class="fa fa<?php echo $integumen->norton_inkontinesia == 4 ? '-check' : '' ?>-square-o"></span> Kontinen</td>
                        <td><span class="fa fa<?php echo $integumen->norton_inkontinesia == 3 ? '-check' : '' ?>-square-o"></span> Kadang Inkontinensia Uri</td>
                        <td><span class="fa fa<?php echo $integumen->norton_inkontinesia == 2 ? '-check' : '' ?>-square-o"></span> Selalu Inkontinensia Uri</td>
                        <td><span class="fa fa<?php echo $integumen->norton_inkontinesia == 1 ? '-check' : '' ?>-square-o"></span> Inkontinensia Uri & Alfi</td>
                        <td style="text-align: right;"><?php echo $integumen->norton_inkontinesia; ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align: right;">Total Skor</td>
                        <td style="text-align: right;"><?php echo $integumen->norton_totalskor; ?></td>
                    </tr>
                    <tr>
                        <td colspan="6">Hasil : <?php 
                        
                        if ($integumen->norton_totalskor < 12) {
                            echo "Resiko Tinggi Terjadi Dekubitus";
                        } else if ($integumen->norton_totalskor < 16) {
                            echo "Resiko Sedang (Rentang Terjadi Dekubitus)";
                        } else {
                            echo "Tidak ada Resiko Terjadi Dekubitus";
                        }
                        
                        ?></td>
                    </tr>
                </tfoot>
            </table>
        </td>
    </tr>
    <tr>
        <td width="30%">Kesimpulan</td>
        <td><?php echo empty($integumen->kesimpulan) ? "-" : $integumen->kesimpulan; ?></td>
    </tr>
</table>

<?php
endif; 
?>

<?php echo $this->renderPartial('perawatanIntensif.views.pemeriksaanFisikTPI.detail._cardio', array(
    'modPemeriksaanFisik'=>$modPemeriksaanFisik
), true); ?>
<?php echo $this->renderPartial('perawatanIntensif.views.pemeriksaanFisikTPI.detail._pulmo', array(
    'modPemeriksaanFisik'=>$modPemeriksaanFisik
), true); ?>
<?php echo $this->renderPartial('perawatanIntensif.views.pemeriksaanFisikTPI.detail._abdomen', array(
    'modPemeriksaanFisik'=>$modPemeriksaanFisik
), true); ?>
<?php echo $this->renderPartial('perawatanIntensif.views.pemeriksaanFisikTPI.detail._obstetri', array(
    'modPemeriksaanFisik'=>$modPemeriksaanFisik
), true); ?>

<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
	<tr>
		<td width="412">
			<div align="center" id="imgtag_detail">
				<img id="myImgId" src="<?php echo Params::urlPhotoAnatomiTubuh().$modGambarTubuh->FileNameGambar; ?>" class="taggd"/> 
			<div id="tagbox"></div>
			</div>
		</td>
		<td style="vertical-align:top;">
			<table border="1" width="100%">
				<?php 
				if(count((array)$modPemeriksaanGambar)>0){?>
					<tr>
						<td><p style="margin: 0; text-align: center;"><b>No.</b></p></td>
						<td><b>Bagian Tubuh</b></td>
						<td><b>Keterangan</b></td>
					</tr>
					<?php foreach($modPemeriksaanGambar as $i => $v ){ ?>
					<tr>
						<td><p style="margin: 0; text-align: center;"><?= $i+1; ?></p></td>
						<td><?= $v->bagiantubuh->namabagtubuh; ?></td>
						<td>
                            <?= $v->keterangan_periksa_gbr; ?>
                            <ul>
                                <li><b>Look : </b><?php echo empty($v->look) ? "-" : $v->look; ?></li>
                                <li><b>Feel : </b><?php echo empty($v->feel) ? "-" : $v->feel; ?></li>
                                <li><b>Move : </b><?php echo empty($v->move) ? "-" : $v->move; ?></li>
                                <li><b>Sensory : </b><?php echo empty($v->sensory) ? "-" : $v->sensory; ?></li>
                                <li><b>Motorik : </b><?php echo empty($v->motorik) ? "-" : $v->motorik; ?></li>
                            </ul>
                        </td>
					</tr>
					<?php } ?>
				<?php } ?>
			</table>
		</td>
	</tr>
</table>

<?php echo $this->renderPartial('perawatanIntensif.views.pemeriksaanFisikTPI.detail._genitalia', array(
    'modPemeriksaanFisik'=>$modPemeriksaanFisik
), true); ?>

<?php echo $this->renderPartial('perawatanIntensif.views.pemeriksaanFisikTPI.detail._ews', array(
    'model'=>$modPemeriksaanFisik
), true); ?>

<?php echo $this->renderPartial('perawatanIntensif.views.pemeriksaanFisikTPI.detail._lainlain', array(
    'modPemeriksaanFisik'=>$modPemeriksaanFisik
), true); ?>
<table>
<tr>
    <td><?php echo CHtml::link(Yii::t('mds', '{icon} Print Detail', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printFisik();return false")); ?></td>
</tr>
</table>
<script type="text/javascript">
    function printFisik()
{
    window.open('<?php echo $this->createUrl('printPemeriksaanFisik',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'pemeriksaanfisik_id'=>$modPemeriksaanFisik->pemeriksaanfisik_id)); ?>','printwin','left=100,top=100,width=640,height=480');
}

function titikSesudahSimpanDetail(titikX,titikY,urutan){
	var titikX=$("#imgtag_detail").position().left + titikX - 10;
	var titikY=$("#imgtag_detail").position().top + titikY;
	var nomor = urutan+1;
	var color = '#000000';
	var size = '5px';
	$("#imgtag_detail").append(
		$('<div class="dot_gambar"><b>'+nomor+'</b></div>')
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

function loadTitikSesudahSimpanDetail(){
    $("#imgtag_detail .dot_gambar").remove();
	<?php if(!empty($modPemeriksaanGambar)){
		foreach($modPemeriksaanGambar as $i => $v){ ?>
		titikSesudahSimpanDetail(<?= $v->kordinat_tubuh_x; ?>, <?= $v->kordinat_tubuh_y.','.$i; ?>);	
	<?php }
	}?>
}

$("#contentDetailFisik").on("load_detail_periksagambar", function() {
    loadTitikSesudahSimpanDetail();
});

$(document).ready(function(){
//	loadTitikSesudahSimpan();
});

</script>