<style>      
	body{
		padding:1px;
	}
	
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
	
	.border-tr{
		border: 1px solid #333 !important;
	}
	
	.kolom-line{
		line-height: 0 !important;
		margin:0px !important;
		padding:0px !important;
	}
	
	.kolom-line-bottom{		
		padding-bottom: 10px !important;		
	}
    
    
    #tab_norton td, #tab_norton th {
        border: 1px solid black !important;
        font-size: 12px !important;
    }
    
    .noborder2 tbody tr:hover td, .noborder2 tbody tr:hover th {
        border: 1px solid black !important;
    }
    .noborder2 tbody tr td, .noborder2 tbody tr th {
        border: 1px solid black !important;
        font-size: 12px !important;
    }
    
</style>
<?php 
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/themes/neon18/assets/css/custom.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinoutInput.css');

//echo $this->renderPartial($this->path_view.'_headerPrint'); 

?>

<table class="table noborder">
	<tr class="border">
		<th colspan="4" style="text-align:center;">
			PEMERIKSAAN FISIK PASIEN RAWAT INAP
		</th>					
	</tr>
	<tr class="border">
		<td colspan="4">
			<table class="table noborder kolom-line">
				<tr class="kolom-line">
					<th class="kolom-line" width="45%">O :</th>
					<th class="kolom-line">Tanda Vital</th>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="border">
		<td colspan="4">
			<table class="table noborder kolom-line">
                <tr class="kolom-line">
                    <td class="kolom-line kolom-line-bottom">Tekanan darah</td>
                    <td class="kolom-line kolom-line-bottom">:</td>
                    <td class="kolom-line kolom-line-bottom"><u><?php echo $modPemeriksaanFisik->tekanandarah; ?></u></td>
                    <td class="kolom-line kolom-line-bottom">mmHg</td>					
                    <td class="kolom-line kolom-line-bottom">Denyut jantung</td>
                    <td class="kolom-line kolom-line-bottom">:</td>
                    <td class="kolom-line kolom-line-bottom"><u><?php echo $modPemeriksaanFisik->detaknadi; ?></u></td>
                    <td class="kolom-line kolom-line-bottom">/menit</td>					
                    <td class="kolom-line kolom-line-bottom">Saturasi O<sub>2</sub></td>
                    <td class="kolom-line kolom-line-bottom">:</td>
                    <td class="kolom-line kolom-line-bottom"><u><?php echo $modPemeriksaanFisik->tandavital_spo2; ?></u></td>
                    <td class="kolom-line kolom-line-bottom">%</td>					
                    <td class="kolom-line kolom-line-bottom">Pernapasan</td>
                    <td class="kolom-line kolom-line-bottom">:</td>
                    <td class="kolom-line kolom-line-bottom"><u><?php echo $modPemeriksaanFisik->pernapasan; ?></u></td>
                    <td class="kolom-line kolom-line-bottom">/menit</td>
                </tr>
                <tr class="kolom-line">
                    <td class="kolom-line">Suhu</td>
                    <td class="kolom-line">:</td>
                    <td class="kolom-line"><u><?php echo $modPemeriksaanFisik->suhutubuh; ?></u></td>
                    <td class="kolom-line"><sup>0</sup>C</td>					
                    <td class="kolom-line">Berat Badan</td>
                    <td class="kolom-line">:</td>
                    <td class="kolom-line"><u><?php echo $modPemeriksaanFisik->beratbadan_kg; ?></u></td>
                    <td class="kolom-line">/Kg</td>					
                    <td class="kolom-line">Tinggi Badan</td>
                    <td class="kolom-line">:</td>
                    <td class="kolom-line"><u><?php echo $modPemeriksaanFisik->tinggibadan_cm; ?></u></td>
                    <td class="kolom-line">cm</td>					
<!--					<td class="kolom-line">GDS</td>
                    <td class="kolom-line">:</td>
                    <td class="kolom-line"><u><?php //echo $modPemeriksaanFisik->detaknadi; ?></u></td>
                    <td class="kolom-line">/menit</td>-->
                </tr>
			</table>
		</td>
	</tr>
	<tr class="border">
		<td colspan="4">
			<table class="table noborder kolom-line">
				<tr class="kolom-line">
					<td class="kolom-line" width="33%">Skor GCS = <?php echo $modPemeriksaanFisik->namaGCS; ?></td>
					<td class="kolom-line">Reflek Cahaya = <?php echo $modPemeriksaanFisik->tandavital_reflekcahaya; ?></td>
				</tr>
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr class="kolom-line">
					<td class="kolom-line" width="33%">Conjuctiva = <?php 
                        echo !empty($modPemeriksaanFisik->leher_anemia) ? "Anemia" : ""; 
                        echo !empty($modPemeriksaanFisik->leher_leterus) ? "Leterus" : ""; 
                        echo !empty($modPemeriksaanFisik->leher_cyanosis) ? "Cyanosis" : ""; 
                        echo !empty($modPemeriksaanFisik->leher_dyspneu) ? "Dyspneu" : ""; 
                    ?></td>
					<td class="kolom-line" width="33%">Reflek Pupil = <?php echo (!empty($modPemeriksaanFisik->leher_reflekpupil) && $modPemeriksaanFisik->leher_reflekpupil == 1) ? "Positif" : "Negatif"; ?></td>
					<td class="kolom-line">Pupil = <?php echo !empty($modPemeriksaanFisik->leher_pupil) ? $modPemeriksaanFisik->leher_pupil : "-"; ?></td>
				</tr>
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>
                <tr class="kolom-line">
					<td class="kolom-line">Nasal = <?php echo !empty($modPemeriksaanFisik->leher_nasal) ? $modPemeriksaanFisik->leher_nasal : "-"; ?></td>
					<td class="kolom-line">Orofans Pupil = <?php echo !empty($modPemeriksaanFisik->leher_orofans) ? $modPemeriksaanFisik->leher_orofans : "-"; ?></td>
					<td class="kolom-line">Pembesaran KGB = <?php echo (!empty($modPemeriksaanFisik->leher_kelgetahbening_teraba) && $modPemeriksaanFisik->leher_kelgetahbening_teraba == 1) ? "Positif" : "Negatif"; ?></td>
				</tr>
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr class="kolom-line">
					<td class="kolom-line">Pembesaran Kelenjar Thyroid = <?php echo (!empty($modPemeriksaanFisik->leher_kelenjartiroid_teraba) && $modPemeriksaanFisik->leher_kelenjartiroid_teraba == 1) ? "Positif" : "Negatif"; ?></td>
					<td class="kolom-line">JVP = <?php echo (!empty($modPemeriksaanFisik->leher_jvp) && $modPemeriksaanFisik->leher_jvp == 1) ? "Meningkat" : "Tidak Meningkat"; ?></td>
					<td class="kolom-line">Lain-Lain = <?php echo !empty($modPemeriksaanFisik->leher_lainlain) ? $modPemeriksaanFisik->leher_lainlain : "-"; ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="border">
		<td colspan="4">
			<table class="table noborder kolom-line">
				<tr class="kolom-line">
					<td class="kolom-line" width="33%">Mata</td>
					<td class="kolom-line" width="33%">Verbal</td>
					<td class="kolom-line">Motorik</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr class="kolom-line">
					<td class="kolom-line">
						<table class="table noborder kolom-line">
								<?php
									$crit = new CDbCriteria();
									$crit->compare('LOWER(metodegcs_singkatan)',"e");
									$crit->addCondition('metodegcs_nilai is not null');
									$crit->order = 'metodegcs_nilai ASC';

									$eye = RIMetodeGCSM::model()->findAll($crit);

									foreach ($eye as $dt){
										$st = false;
										if ($dt->metodegcs_nilai == $modPemeriksaanFisik->gcs_eye){
											$st = true;
										}
								?>
								<tr class="kolom-line">
									<td class="kolom-line kolom-line-bottom"><?php echo CHtml::radioButton("eye",$st); ?> <label></label></td>
									<td class="kolom-line kolom-line-bottom" style="padding-top: 4px !important;line-height: 1.0 !important;">&nbsp;<?php echo $dt->textMetodeGCSM; ?></td>
								</tr>
								<?php																		
									}
								?>
						</table>
					</td>
					<td class="kolom-line">
						<table class="table noborder kolom-line">
								<?php
									$crit3 = new CDbCriteria();
									$crit3->compare('LOWER(metodegcs_singkatan)',"v");
									$crit3->addCondition('metodegcs_nilai is not null');
									$crit3->order = 'metodegcs_nilai ASC';

									$verbal = RIMetodeGCSM::model()->findAll($crit3);

									foreach ($verbal as $dt2){
										$st2 = false;
										if ($dt2->metodegcs_nilai == $modPemeriksaanFisik->gcs_verbal){
											$st2 = true;
										}
								?>
								<tr class="kolom-line">
									<td class="kolom-line kolom-line-bottom"><?php echo CHtml::radioButton("verbal",$st2); ?><label></label></td>
									<td class="kolom-line kolom-line-bottom" style="padding-top: 4px !important;line-height: 1.0 !important;">&nbsp;<?php echo $dt2->textMetodeGCSM; ?></td>
								</tr>
								<?php																		
									}
								?>
						</table>
					</td>
					<td class="kolom-line">
						<table class="table noborder kolom-line">
								<?php
									$crit2 = new CDbCriteria();
									$crit2->compare('LOWER(metodegcs_singkatan)',"m");
									$crit2->addCondition('metodegcs_nilai is not null');
									$crit2->order = 'metodegcs_nilai ASC';

									$motorik = RIMetodeGCSM::model()->findAll($crit2);

									foreach ($motorik as $dt3){
										$st3 = false;
										if ($dt3->metodegcs_nilai == $modPemeriksaanFisik->gcs_motorik){
											$st3 = true;
										}
								?>
								<tr class="kolom-line">
									<td class="kolom-line kolom-line-bottom"><?php echo CHtml::radioButton("motorik",$st3); ?> <label></label></td>
									<td class="kolom-line kolom-line-bottom" style="margin-left: 10px;padding-top: 4px !important;line-height: 1.0 !important;">&nbsp;<?php echo $dt3->textMetodeGCSM; ?></td>
								</tr>
								<?php																		
									}
								?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="border">
		<td colspan="4">
			<table class="table noborder kolom-line">
				<tr class="kolom-line">
					<td class="kolom-line kolom-line-bottom" width="15%">Kondisi Umum :</td>
					<td class="kolom-line kolom-line-bottom">
						<?php 
							echo $modPemeriksaanFisik->keadaanumum
							
						?>
						
					</td>
				</tr>
			</table>
		</td>
	</tr>	
    
    <tr class="border" hidden>
        <td colspan="4">
            <table class="table noborder kolom-line">
                <tr>
                    <td colspan="2"><b>Kepala dan Leher</b></td>
                </tr>
                <tr>
                    <td width="200">Kondisi</td>
                    <td>: <?php
                        if ($modPemeriksaanFisik->leher_anemia) echo "Anemia";
                        if ($modPemeriksaanFisik->leher_leterus) echo "Anemia";
                        if ($modPemeriksaanFisik->leher_cyanosis) echo "Anemia";
                        if ($modPemeriksaanFisik->leher_dyspneu) echo "Anemia";
                        ?></td>
                </tr>
                <tr>
                    <td>Reflek Pupil</td>
                    <td>: <?php echo $modPemeriksaanFisik->leher_reflekpupil ? "Positif" : "Negatif"; ?></td>
                </tr>
                <tr>
                    <td>Pupil</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->leher_pupil) ? $modPemeriksaanFisik->leher_pupil : "-"; ?></td>
                </tr>
                <tr>
                    <td>Nasal</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->leher_nasal) ? $modPemeriksaanFisik->leher_nasal : "-"; ?></td>
                </tr>
                <tr>
                    <td>Orofans</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->leher_orofans) ? $modPemeriksaanFisik->leher_orofans : "-"; ?></td>
                </tr>
                <tr>
                    <td>Pembesaran KGB</td>
                    <td>: <?php echo $modPemeriksaanFisik->leher_kelgetahbening_teraba ? "Positif" : "Negatif"; ?></td>
                </tr>
                <tr>
                    <td>Pembesaran Kelenjar Thyroid</td>
                    <td>: <?php echo $modPemeriksaanFisik->leher_kelenjartiroid_teraba ? "Positif" : "Negatif"; ?></td>
                </tr>
                <tr>
                    <td>JVP</td>
                    <td>: <?php echo $modPemeriksaanFisik->leher_jvp ? "Positif" : "Negatif"; ?></td>
                </tr>
                <tr>
                    <td>Lain-Lain</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->leher_lainlain) ? $modPemeriksaanFisik->leher_lainlain : "-"; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr class="border">
		<td colspan="4" style="border-right: 1px solid black !important;" width="50%">
            <b>Thorax</b><br><br><br>
            Inspeksi : <?php echo $modPemeriksaanFisik->inspeksi; ?><br><br><br>
            Palpasi : <?php echo $modPemeriksaanFisik->palpasi; ?><br><br><br>
                    Auskultasi : <br><br>
                        <table class="border">
                            <tr></tr>
                            <tr>
                                <td colspan="2"></td>
                                <td>Kanan</td>
                                <td>Kiri</td>
                            </tr>
                            <tr>
                                <td rowspan="3" style="vertical-align:top;">P</td>
                                <td rowspan="3" style="vertical-align:top;">Rh</td>
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
                                <td colspan="2"></td>
                                <td>Kanan</td>
                                <td>Kiri</td>
                            </tr>
                            <tr>
                                <td rowspan="3" style="vertical-align:top;"></td>
                                <td rowspan="3" style="vertical-align:top;">Wh</td>
                                <td><?php echo $modPemeriksaanFisik->au_paruwhkanan_1; ?></td>
                                <td><?php echo $modPemeriksaanFisik->au_paruwhkiri_1; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $modPemeriksaanFisik->au_paruwhkanan_2; ?></td>
                                <td><?php echo $modPemeriksaanFisik->au_paruwhkiri_2; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $modPemeriksaanFisik->au_paruwhkanan_3; ?></td>
                                <td><?php echo $modPemeriksaanFisik->au_paruwhkiri_2; ?></td>
                            </tr>

                            <tr>
                                <td rowspan="4" style="vertical-align:top;">C</td>
                                <td rowspan="4" colspan="2" style="vertical-align:top;">Bunyi Jantung</td>
                                <td>S1 :<?php echo $modPemeriksaanFisik->au_cardios1; ?></td>
                            </tr>
                            <tr>
                                <td>S2 :<?php echo $modPemeriksaanFisik->au_cardios2; ?></td>
                            </tr>
                            <tr>
                                <td>S3 :<?php echo $modPemeriksaanFisik->au_cardios3; ?></td>
                            </tr>
                            <tr>
                                <td>S4 : <?php echo $modPemeriksaanFisik->au_cardios4; ?></td>
                            </tr>
                        </table><br><br><br>
                Bising Jantung: <?php echo $modPemeriksaanFisik->bisingjantung;?><br><br><br>
				Obgyn: <?php echo $modPemeriksaanFisik->panel_obgyn;?>
		</td>
        
	</tr>
    
    <?php
    
    if (!empty($modPemeriksaanFisik->reflekbayi)): ?>
    <tr class="border">
        <td colspan="2">
            
    <?php
    
    if (!empty($modPemeriksaanFisik->reflekbayi)) {
        $modPemeriksaanFisik->reflekbayi = CJSON::decode($modPemeriksaanFisik->reflekbayi);
    ?>
            
            <table id="tblDaftarAnamnesa" width="100%" class="table noborder">
                    <tr>
                        <td colspan="2"><b>Reflek Bayi</b></td>
                    </tr>

                    <?php foreach ($modPemeriksaanFisik->reflekbayi as $label => $val): ?>
                    <tr>
                        <td width="100"><?php echo $label; ?></td>
                        <td><?php echo empty($val) ? "-" : $val; ?></td>
                    </tr>
                    <?php endforeach; ?>
            </table>
            
    <?php      
    }
    
    ?>
        </td>
    
    </tr>
    
    <?php endif; ?>
    
    
    <tr class="border">
        <td colspan="4">
            <b>Integumen: </b><br>
    <?php 
        $integumen = IntegumenT::model()->findByAttributes(array(
            'pemeriksaanfisik_id'=>$modPemeriksaanFisik->pemeriksaanfisik_id,
        ));

        if (!empty($integumen)) : 

        ?>

        <table class="table noborder">
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
                    <div style="font-weight: bold; text-align: center; margin-bottom: 5px;">Skala Norton</div>
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


        </td>
    </tr>
    
    
    <tr class="border">
        
        <td colspan="2" class="border">
            <table class="table noborder kolom-line">
                <tr>
                    <td colspan="2"><b>Cardio</b></td>
                </tr>
                <tr>
                    <td width="150">Inspeksi</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->cardio_inspeksi) ? $modPemeriksaanFisik->cardio_inspeksi : "-"?></td>
                </tr>
                <tr>
                    <td>Palpasi</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->cardio_palpasi) ? $modPemeriksaanFisik->cardio_palpasi : "-"?></td>
                </tr>
                <tr>
                    <td>Perkusi</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->cardio_perkusi) ? $modPemeriksaanFisik->cardio_perkusi : "-"?></td>
                </tr>
                <tr>
                    <td>Auskultasi</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->cardio_auskultasi) ? $modPemeriksaanFisik->cardio_auskultasi : "-"?></td>
                </tr>
            </table>
        </td>
        <td colspan="2" class="border" style="border-right: 1px solid black !important;" width="50%">
            <table class="table noborder kolom-line">
                <tr>
                    <td colspan="2"><b>Pulmo</b></td>
                </tr>
                <tr>
                    <td width="150">Inspeksi</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->pulmo_inspeksi) ? $modPemeriksaanFisik->pulmo_inspeksi : "-"?></td>
                </tr>
                <tr>
                    <td>Palpasi</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->pulmo_palpasi) ? $modPemeriksaanFisik->pulmo_palpasi : "-"?></td>
                </tr>
                <tr>
                    <td>Perkusi</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->pulmo_perkusi) ? $modPemeriksaanFisik->pulmo_perkusi : "-"?></td>
                </tr>
                <tr>
                    <td>Auskultasi</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->pulmo_auskultasi) ? $modPemeriksaanFisik->pulmo_auskultasi : "-"?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr class="border">
        <td colspan="2" class="border">
            <table class="table noborder kolom-line">
                <tr>
                    <td colspan="2"><b>Abdomen</b></td>
                </tr>
                <tr>
                    <td width="150">Inspeksi</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->abd_inspeksi) ? $modPemeriksaanFisik->abd_inspeksi : "-"?></td>
                </tr>
                <tr>
                    <td>Palpasi</td>
                    <td>
                        : <?php echo !empty($modPemeriksaanFisik->abd_palpasi) ? $modPemeriksaanFisik->abd_palpasi : "-"; ?>
                        <ul>
                            <li>Leopold I : <?php echo !empty($modPemeriksaanFisik->leopold_1) ? $modPemeriksaanFisik->leopold_1 : "-"?></li>
                            <li>Leopold II : <?php echo !empty($modPemeriksaanFisik->leopold_2) ? $modPemeriksaanFisik->leopold_2 : "-"?></li>
                            <li>Leopold III : <?php echo !empty($modPemeriksaanFisik->leopold_3) ? $modPemeriksaanFisik->leopold_3 : "-"?></li>
                            <li>Leopold IV : <?php echo !empty($modPemeriksaanFisik->leopold_4) ? $modPemeriksaanFisik->leopold_4 : "-"?></li>
                        </ul></td>
                </tr>
                <tr>
                    <td>Perkusi</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->abd_perkusi) ? $modPemeriksaanFisik->abd_perkusi : "-"?></td>
                </tr>
                <tr>
                    <td>Auskultasi</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->abd_auskultasi) ? $modPemeriksaanFisik->abd_auskultasi : "-"?></td>
                </tr>
            </table>
        </td>
        <td colspan="2" class="border" width="50%"  style="border-right: 1px solid black !important;">
            <table class="table noborder kolom-line">
                <tr>
                    <td colspan="2"><b>Obstetri</b></td>
                </tr>
                <tr>
                    <td width="150">TFU</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->tinggifundus_uteri) ? $modPemeriksaanFisik->tinggifundus_uteri." cm" : "-"?></td>
                </tr>
                <tr>
                    <td>HIS</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->obs_his) ? $modPemeriksaanFisik->obs_his : "-"?></td>
                </tr>
                <tr>
                    <td>Posisi</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->leher_posisijanin) ? $modPemeriksaanFisik->leher_posisijanin : "-"?></td>
                </tr>
                <tr>
                    <td>Denyut</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->denyutjantung_janin) ? $modPemeriksaanFisik->denyutjantung_janin."/menit" : "-"?></td>
                </tr>
                <tr>
                    <td>Vagina Toucher</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->obs_vaginatoucher) ? $modPemeriksaanFisik->obs_vaginatoucher : "-"?></td>
                </tr>
            </table>
        </td>
        
    </tr>
    
    
    
    
    
    
	<tr class="border">
		<td colspan="4">
			<table class="table noborder kolom-line">
				<tr class="kolom-line">
					<td class="kolom-line" style="margin-left: 10px;padding-top: 4px !important;line-height: 1.0 !important;">						
						<table class="table noborder kolom-line">
							<tr class=" kolom-line" style="height:40px;">
								<td>Pemeriksaan Fisik :</td>
							</tr>
							<tr  class=" kolom-line">
								<td class=" kolom-line">
									<table border="1" width="100%">
										<?php 
											if(count((array)$modPemeriksaanGambar)>0){?>
												<tr>
													<td><p style="margin: 0; text-align: center;"><b>No.</b></p></td>
													<td><b>Bagian Tubuh</b></td>
                                                                                                        <td><b>Look</b></td>
                                                                                                        <td><b>Feel</b></td>
                                                                                                        <td><b>Move</b></td>
                                                                                                        <td><b>Sensory</b></td>
                                                                                                        <td><b>Motorik</b></td>
													<td><b>Keterangan</b></td>
												</tr>
												<?php foreach($modPemeriksaanGambar as $i => $v ){ ?>
												<tr>
													<td><p style="margin: 0; text-align: center;"><?= $i+1; ?></p></td>
													<td><?= $v->bagiantubuh->namabagtubuh; ?></td>
                                                                                                        <td><?= $v->look; ?></td>
                                                                                                        <td><?= $v->feel; ?></td>
                                                                                                        <td><?= $v->move; ?></td>
                                                                                                        <td><?= $v->sensory; ?></td>
                                                                                                        <td><?= $v->motorik; ?></td>
													<td><?= $v->keterangan_periksa_gbr; ?></td>
												</tr>
												<?php } ?>
											<?php } ?>
									</table>
									
								</td>
							</tr>
						</table>
					</td>
					<td style="margin-left: 10px;padding-top: 4px !important;line-height: 1.0 !important;width:412px;">						
						<?php 
							$css = '';
							if (count((array)$modGambarTubuh->AllDataGambarAnatomi) > 0)
							{
								$gbrTubuh = $modGambarTubuh->AllDataGambarAnatomi;

								foreach($gbrTubuh as $tbh){		

										$css .= "#imgtag".$tbh->gambartubuh_id."
										{
											position: relative;
											min-width: 300px;
											min-height: 300px;
											float: none;
											border: 3px solid #FFF;
											cursor: crosshair;
											text-align: center;
										}#tagit".$tbh->gambartubuh_id."
											{
													position: absolute;
													top: 0;
													left: 0;
													width: 300px;
													border: 1px solid #D7C7C7;
													z-index: 10;
											}
											#tagit".$tbh->gambartubuh_id." .name
											{
													/*float: left;*/
													background-color: #FFF;
													width: 295px;
													/*height: 92px;*/
													/*padding: 5px;*/
													font-size: 10pt;
													margin:0 auto;
													margin-bottom: 0 auto;
											}
											#tagit".$tbh->gambartubuh_id." DIV.text
											{
													margin-bottom: 5px;
											}
											#tagit".$tbh->gambartubuh_id." INPUT[type=text]
											{
													margin-bottom: 5px;
											}
											#tagit".$tbh->gambartubuh_id." #tagname".$tbh->gambartubuh_id."
											{
													width: 110px;
											}"; 
						?>
									<div align="center" id="imgtag<?php echo $tbh->gambartubuh_id ?>">
										<img id="myImgId" src="<?php echo Yii::app()->request->baseUrl; ?>/images/anatomi.jpg" class="taggd"  style="width:480px;"/> 
									<div id="tagbox"></div>
									</div>
						<?php
								}

								Yii::app()->clientScript->registerCss('anatomi', $css);
							}
						?>
					</td>
				</tr>
			</table>
		</td>		
	</tr>
    
    <tr class="border">
        <td colspan="2">
            <table class="table noborder kolom-line">
                <tr>
                    <td colspan="2"><b>Geniltalia/Dubur</b></td>
                </tr>
                <tr>
                    <td width="150">Inspeksi</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->genitalia_inspeksi) ? $modPemeriksaanFisik->genitalia_inspeksi : "-"?></td>
                </tr>
                <tr>
                    <td>Palpasi</td>
                    <td>: <?php echo !empty($modPemeriksaanFisik->genitalia_palpasi) ? $modPemeriksaanFisik->genitalia_palpasi : "-"?></td>
                </tr>
            </table>
        </td>
    </tr>
    
    
    <tr class="border">
        <td colspan="4">
            <?php echo $this->renderPartial('rawatJalan.views.pemeriksaanFisik.detail._ewsPrint', array(
                'model'=>$modPemeriksaanFisik
            ), true); ?>

        </td>

    </tr>
    
    
	<tr class="border">
		<td colspan="3">
			<table class="table noborder kolom-line">
                <tr class="kolom-line">
					<td class="kolom-line kolom-line-bottom">Diagnosis Kerja</td>					
				</tr>
				<tr class="kolom-line">
					<td class="kolom-line kolom-line-bottom">
						<ol>
						<?php
							$diagnosaK = DiagnosakerjaT::model()->findAllByAttributes(array('pemeriksaanfisik_id' => $modPemeriksaanFisik->pemeriksaanfisik_id));
							$i = 1;
							if (count((array)$diagnosaK)>0){
								foreach ($diagnosaK as $det){
						?>
								<li><?php echo $det->diagnosakerja_isi ?></li>
						<?php
								$i++;
								}
							}else{
						?>
								<li></li>	
								<li></li>	
								<li></li>	
						<?php
							}
						?>
						</ol>
					</td>
				</tr>
				<tr class="kolom-line">
					<td class="kolom-line kolom-line-bottom">Pemeriksaan Penunjang :</td>					
				</tr>		
				<tr class="kolom-line">
					<td class="kolom-line  kolom-line-bottom" style="margin-left: 10px;padding-top: 4px !important;line-height: 1.0 !important;">
						<?php echo strip_tags($modPemeriksaanFisik->periksa_penunjang); ?>						
					</td>
				</tr>
					<tr class="kolom-line">
					<td class="kolom-line">&nbsp;</td>
				</tr>
					<tr class="kolom-line">
					<td class="kolom-line"  >&nbsp;</td>
				</tr>
				<tr class="kolom-line">
					<td class="kolom-line"  >&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="border">
		<td colspan="3" style="width:45%;border:1px solid #333 !important;">
			<table class="table noborder kolom-line">
				<tr class="kolom-line">
					<td class="kolom-line kolom-line-bottom">Terapi IGD :</td>					
				</tr>						
				<tr class="kolom-line">					
					<td class="kolom-line kolom-line-bottom"  style="margin-left: 10px;padding-top: 4px !important;line-height: 1.0 !important;">
						<?php echo $modPemeriksaanFisik->terapi_igd; ?>
					</td>
				</tr>
			</table>
		</td>
		<td class="border">
			<table class="table noborder kolom-line">
				<tr class="kolom-line">
					<td class="kolom-line kolom-line-bottom">Terapi Rawat Inap :</td>					
				</tr>						
				<tr class="kolom-line">					
					<td class="kolom-line kolom-line-bottom" style="margin-left: 10px;padding-top: 4px !important;line-height: 1.0 !important;">
						<?php echo $modPemeriksaanFisik->terapi_igd; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="border">
		<td class="border" colspan="4">
			<table class="table noborder kolom-line">
				<tr class="kolom-line">
					<td class="kolom-line kolom-line-bottom"  style="margin-left: 10px;padding-top: 4px !important;line-height: 1.0 !important;">Monitoring :</td>				
				</tr>						
				<tr class="kolom-line">
					<td colspan="2" class="kolom-line kolom-line-bottom"  style="margin-left: 10px;padding-top: 4px !important;line-height: 1.0 !important;"><?php echo $modPemeriksaanFisik->monitoring; ?></td>				
				</tr>
			</table>
		</td>
	</tr>
	<tr class="border">
		<td style="width:10%;border:1px solid #333 !important;">
			<table class="table noborder kolom-line">									
				<tr class="kolom-line">					
					<td class="kolom-line  kolom-line-bottom"  style="margin-left: 10px;padding-top: 4px !important;line-height: 1.0 !important;padding-right:50px !important;vertical-align: top !important;">
						Rencana Tindakan Lanjut						
					</td>
				</tr>
			</table>
		</td>
		<td colspan="4"  class="border">
			<table class="table noborder kolom-line">
				<tr class="kolom-line">
					<td class="kolom-line" width="20%">Rawat Inap Ruang</td>					
					<td class="kolom-line kolom-line-bottom" width="2%">:</td>					
					<td class="kolom-line kolom-line-bottom" width="30%"><?php echo $modPemeriksaanFisik->tl_rawatinap_ruang ?></td>					
					<td class="kolom-line kolom-line-bottom" width="15%">Indikasi Inap</td>					
					<td class="kolom-line kolom-line-bottom" width="2%">:</td>		
					<td class="kolom-line kolom-line-bottom"><?php echo $modPemeriksaanFisik->tl_indikasi ?></td>					
				</tr>						
				<tr class="kolom-line kolom-line-bottom">
					<td class="kolom-line kolom-line-bottom">DPJP Rawat inap</td>					
					<td class="kolom-line kolom-line-bottom">:</td>
					<td class="kolom-line kolom-line-bottom" colspan="4"><?php echo $modPemeriksaanFisik->tl_rawatinap_dpjp ?></td>
				</tr>						
				<tr class="kolom-line kolom-line-bottom">
					<td class="kolom-line kolom-line-bottom">Pengantar pasien</td>					
					<td class="kolom-line kolom-line-bottom">&nbsp;</td>
					<td class="kolom-line kolom-line-bottom" colspan="4">
						<?php 
						
							if ($modPemeriksaanFisik->tl_pengantar_pasien == true){
								echo "Ada/<del>Tidak</del>";
							}elseif($modPemeriksaanFisik->tl_pengantar_pasien == false){
								echo "<del>Ada</del>/Tidak";
							}else{
								echo "Ada/Tidak";
							}
						?>* (Bila tidak, rujuk ke Pekerja Sosial)</td>
				</tr>	
				<tr class="kolom-line kolom-line-bottom">
					<td colspan="6" class="kolom-line kolom-line-bottom">Rujuk ke :</td>
				</tr>
				<tr class="kolom-line">
					<td colspan="6">
						<table class="table noborder kolom-line">							
							<?php
								$namaR = '';
								$asalRujuk = AsalrujukanM::model()->findAll("asalrujukan_aktif = TRUE ORDER BY asalrujukan_nama ASC ");
								$rujuk = '';
								foreach ($asalRujuk as $ru){
									if ($ru->asalrujukan_id == $modPemeriksaanFisik->tl_asalrujukan_id){
										$cek = true;
										$nama = $modPemeriksaanFisik->rujukandari->namaperujuk;
										$namaR =  $modPemeriksaanFisik->rujukandari->namaperujuk;
										$rujuk = $ru->asalrujukan_nama;
									}else{
										$cek = false;
										$nama = '';										
										//$rujuk = $ru->asalrujukan_nama;
									}
									
								
							?>
							<tr class="kolom-line">
								<td class="kolom-line" width="1%"><?php echo CHtml::checkBox("tindakLanjutRujuk",$cek) ?><label></label></td>
								<td width="90%"><?php echo ucwords(strtolower($ru->asalrujukan_nama)); 
								?> 
									<?php 
											if (strtolower($ru->asalrujukan_nama) == 'homecare'){
												echo '';
											}else{
												echo (empty($nama)?
														"<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>":
														'<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nama.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>'); 
											}	?>																				
								</td>								
							</tr>
							<?php
								}
							?>
						</table>
					</td>
				</tr>				
			</table>
		</td>
	</tr>
	<tr class="border">
		<td style="width:10%;border:1px solid #333 !important;">
			&nbsp;
		</td>
		<td colspan="3"  class="border">
			<table class="table noborder kolom-line">
				<tr class="kolom-line">
					<td class="kolom-line kolom-line-bottom" width="30%">Kontrol Klinik/Homecare di :</td>					
					<td class="kolom-line kolom-line-bottom"><?php echo (strtolower($rujuk) == 'homecare')?$namaR:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';  ?></td>
					<td class="kolom-line kolom-line-bottom">Tanggal :</td>										
					<td class="kolom-line kolom-line-bottom"><?php echo (strtolower($rujuk) == 'homecare')?MyFormatter::formatDateTimeForUser($modPemeriksaanFisik->tl_homecare_tgl):'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';  ?></td>
				</tr>										
			</table>
		</td>
	</tr>
	<tr class="border">
		<td style="width:10%;border:1px solid #333 !important;">
			<table class="table noborder kolom-line">									
				<tr class="kolom-line">					
					<td class="kolom-line  kolom-line-bottom"  style="margin-left: 10px;padding-top: 4px !important;line-height: 1.0 !important;padding-right:50px !important;vertical-align: top !important;">
						Edukasi Pasien
					</td>
				</tr>
			</table>
		</td>
		<?php
			$pasienEdu = false;
			$keluargaEdu = false;
			$tidakEdu = false;
			if ($modPemeriksaanFisik->edukasi_dituju_ke == 'PASIEN'){
				$pasienEdu = true;
			}elseif ($modPemeriksaanFisik->edukasi_dituju_ke == 'KELUARGA'){
				$keluargaEdu = true;
			}elseif ($modPemeriksaanFisik->edukasi_dituju_ke == 'TIDAK BISA'){
				$tidakEdu = true;
			}
		
		?>
		<td colspan="3"  class="border">
			<table class="table noborder kolom-line">
				<tr class="kolom-line kolom-line-bottom">
					<td class="kolom-line kolom-line-bottom" colspan="2">Edukasi awal, disampaikan tentang diagnosa, rencana, dan tujuan terapi kepada :</td>					
				</tr>
				<tr class="kolom-line kolom-line-bottom">
					<td class="kolom-line kolom-line-bottom" width="1%"><?php echo CHtml::checkBox("edukasi",$pasienEdu) ?><label></label></td>
					<td class="kolom-line kolom-line-bottom" style="margin-left: 10px;padding-top: 4px !important;line-height: 1.0 !important;padding-right:50px !important;vertical-align: top !important;">Pasien</td>					
				</tr>
				<tr class="kolom-line kolom-line-bottom">
					<td class="kolom-line kolom-line-bottom" width="1%"><?php echo CHtml::checkBox("edukasi",$keluargaEdu) ?><label></label></td>
					<td class="kolom-line kolom-line-bottom" style="margin-left: 10px;padding-top: 4px !important;line-height: 1.0 !important;padding-right:50px !important;vertical-align: top !important;">
						Keluarga pasien, nama : 
						<u>
							<?php echo (empty($modPemeriksaanFisik->edukasi_nama_keluarga)?"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$modPemeriksaanFisik->edukasi_nama_keluarga."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;") ?>
						</u>
					</td>					
				</tr>
				<tr class="kolom-line kolom-line-bottom">
					<td class="kolom-line kolom-line-bottom" width="1%"><?php echo CHtml::checkBox("edukasi",$tidakEdu) ?><label></label></td>
					<td class="kolom-line kolom-line-bottom" style="margin-left: 10px;padding-top: 4px !important;line-height: 1.0 !important;padding-right:50px !important;vertical-align: top !important;">
						Tidak dapat memberi edukasi kepada pasien atau keluarga karena :
						<u>
							<?php echo (empty($modPemeriksaanFisik->edukasi_alasan_tidakbisa)?"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$modPemeriksaanFisik->edukasi_alasan_tidakbisa."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;") ?>
						</u>
					</td>					
				</tr>
				<tr class="kolom-line kolom-line-bottom">
					<td class="kolom-line kolom-line-bottom" colspan="2">Penanggung Jawab (Tanda Tangan dan Stempel Doter, Tuliskan Tanggal dan Pukul)</td>							
				</tr>										
			</table>
		</td>
	</tr>
	<tr class="border">
		<td colspan="4" style="text-align: center;">
			<table class="noborder table">
				<tr>
					<td style="text-align:center;">Cilacap, <?php echo MyFormatter::formatDateTimeId(date('Y-m-d')); ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>						
				<tr>
					<td style="text-align:center;"><?php echo (isset($modPemeriksaanFisik->pegawai)?$modPemeriksaanFisik->pegawai->namaLengkap:""); ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<script>
	function titikSesudahSimpan(titikX,titikY,urutan,img){
	var titikX=titikX-5;
	var titikY=titikY-5;
	var nomor = urutan+1;
	var color = 'white';
	var size = '5px';
	$(img).append(
			$('<div style="border: 1px solid #333;"><strong style="position:absolute;top:0;left:7px">'+nomor+'</b></div>')
			.css('position', 'absolute')
			.css('top', titikY + 'px')
			.css('left', titikX + 'px')
			.css('width', size)
			.css('height', size)
			.css('background-color', color)
			.css('border', '1px solid #333')
			.css('cursor', 'pointer')
			.css('display', 'block')
			.css('padding', '10px')
			.css('-webkit-border-radius', '50%')
			.css('-moz-border-radius', '50%')
			.css('border-radius', '50%')
			.css('vertical-align','middle')
			.css('color','black')
	);
}

function loadTitikSesudahSimpan(){
	<?php if(!empty($modPemeriksaanGambar)){
		foreach($modPemeriksaanGambar as $i => $v){ ?>
		titikSesudahSimpan(<?= $v->kordinat_tubuh_x; ?>, <?= $v->kordinat_tubuh_y.','.$i; ?>,'#imgtag<?php echo $v->gambartubuh_id ?>');	
	<?php }
	}?>
}
$(document).ready(function(){
	loadTitikSesudahSimpan();
});
</script>
