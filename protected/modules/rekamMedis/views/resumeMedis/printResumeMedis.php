<style>
* {
    font-family: Tahoma, sans-serif !important;
}


.hr {

    border: 1px dashed black;
    /*page-break-after: always;*/

}

.horizontal-line {
    padding-top: 30px;
    padding-bottom: 30px;
    border-bottom: 5px solid #f0f0f0;
}

.barcode-label {
    margin-top: -20px;
    z-index: 1;
    text-align: center;
    letter-spacing: 10px;
}

td,
th {
    font-size: 10pt !important;
    min-height: 54px;
    /* padding-left:10px; */
}

body {
    /*        width: 21.7cm;*/
}

.content td {
    height: 12px;
}

.diagnosa td {
    height: 30px;
    font-family: Tahoma, sans-serif;
}

.penunjang td {
    /*        height: 30px;*/
    font-family: Tahoma, sans-serif;

}

.td-header {
    border-top: 1px solid black;
    border-left: 1px solid black;
    border-right: 1px solid black;
    border-bottom: none;
}

.a1 {
    display: block;
    margin-left: auto;
    margin-right: auto;
}

#ringkasan-content>tbody>tr>td {
    height: 25px;
    vertical-align: middle;
    font-family: Tahoma, sans-serif;
}

#diagnosis-sek-content>tbody>tr>td,
#diagnosis-content>tbody>tr>td,
#tindakan-content>tbody>tr>td {
    height: 25px;
    font-family: Tahoma, sans-serif;
}

.table_border {
    border: 1px solid #000;
}

.table_border td {
    border: 1px solid #000;
}

.mydiv{
    position:relative
}
.mydiv img{
    position:absolute;
    top:20;
    right:150px;
	height: 121px;
	max-height: 121px;
	float: right;
	z-index:-1;
}
</style>


<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<?php

$penjamin = 'UMUM';
$modul_id = Yii::app()->user->getState('modul_id');

$modCaraBayar = CarabayarM::model()->findByPk($modPendaftaran->carabayar_id);
$modModul = ModulK::model()->findByPk($modul_id);

$modResume = ResumemedisR::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), array('order' => 'resumemedis_id DESC'));
$modResume1 = ResumemedisR::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), array('order' => 'resumemedis_id DESC'));


// echo '<pre>'; var_dump(); die();

?>
<table style="width: 100%; border: 1px solid black;">
    <tr style="">
        <td class="td-header" style="width: 100px;">
            <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?>"
                style="max-width: 150px; width:150px;" class='image_report a1' />
        </td>
        <td
            style="text-align: center; vertical-align: middle; border: 1px solid black; border-bottom: none;font-size: 10pt !important">
            <?php
				echo '<strong>RESUME ' . ' RAWAT JALAN' . '<br>' . $modCaraBayar->carabayar_namalainnya . '</strong>';
			?>
        </td>
        <td style="border: 1px solid black; border-bottom: none; text-align: center;">
            <img src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->no_pendaftaran; ?>&is_text="
                style="transform:scale(0.6); margin-left: -88px; margin-right: 500px; margin-top: -20px; position: absolute; z-index: -1;">
            &emsp;&emsp;&emsp;&emsp;<br><br>
            <b><?php echo $modPendaftaran->no_pendaftaran ?></b>
        </td>
        <td style="border: 1px solid black; border-bottom: none; text-align: center; vertical-align: middle;">
            <h2><?php echo $modPasien->no_rekam_medik ?></h2>
        </td>
    </tr>
</table>
<table style="width: 100%; border: 1px solid black;">
    <tr>
        <td style="width: 50%;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 35%;">
                        Nama Pasien&emsp;
                    </td>

                    <td>
                        <?php echo isset($modKunjungan->namadepan)?$modKunjungan->namadepan.$modKunjungan->nama_pasien:$modKunjungan->nama_pasien; ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 35%;">
                        Tgl. Lahir/JK/Umur&emsp;
                    </td>
                    <td>
                        <?php 
						if($modKunjungan->jeniskelamin == 'LAKI-LAKI'){
							$jk = 'L';
						} else {
							$jk = 'P';
						}
						echo MyFormatter::formatDateTimeId($modKunjungan->tanggal_lahir) . "/" . $jk . "/" . substr( $modKunjungan->umur, 0, 3 ) . ' Tahun' 
					?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 35%;">
                        Alamat&emsp;
                    </td>
                    <td>
                        <?php echo $modKunjungan->alamat_pasien; ?>
                    </td>
                </tr>
            </table>
        </td>
        <td style="border-left: 1px solid black;">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="width: 35%;">
                        Tgl. Masuk&emsp;
                    </td>
                    <td>
                        <?php echo MyFormatter::formatDateTimeId($modKunjungan->tgl_pendaftaran); ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 35%;">
                        Tgl. Keluar&emsp;
                    </td>
                    <td>
                        <?php
        				$pulang = PasienpulangT::model()->findByAttributes(array(
            			'pendaftaran_id'=>$modKunjungan->pendaftaran_id
        				), array(
            			'condition'=>"carakeluar_id <> ".Params::CARAKELUAR_ID_RAWATINAP,
       					 ));
        
       					 if (!empty($pulang)) {
            				echo MyFormatter::formatDateTimeId($pulang->tglpasienpulang);
        				} else {
            				echo "-";
        				}
      				  ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 35%;">
                        Lokasi&emsp;
                    </td>
                    <td>
                        <?php echo $modKunjungan->ruangan_nama . " / " . $modPendaftaran->no_urutantri; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
    </tr>
</table>
<table style="width: 100%; border: 1px solid black;" id="ringkasan-content">
    <tr class="tr-content">
        <td style="width: 30%;">
            Ringkasan Riwayat Penyakit
        </td>
        <td style="border-left: 1px solid black;">
            <?php

            if(!empty($modResume1)) {

                echo $modResume1->ikhtisarkliniksingkat;
            } else {

                if(!empty($modAnamnesa)){
                    if(!empty($modAnamnesa->keluhanutama)){
                        echo ' Keluhan Utama : '.$modAnamnesa->keluhanutama;
                    }
                    if(!empty($modAnamnesa->keluhantambahan)){
                        echo ', Keluhan Tambahan : '.$modAnamnesa->keluhantambahan;
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
             
                }

            }

			
            ?>
        </td>
    </tr>
    <tr>
        <td style="width: 30%; border-top: 1px solid black;">
            Pemeriksaan Fisik
        </td>
        <td style="border-left: 1px solid black;border-top: 1px solid black;">
            <?php

            // echo ''; var_dump($modResume1->resume_pemeriksaanfisik); die;

            if(!empty($modResume1)) {
                echo $modResume1->resume_pemeriksaanfisik;
            } else {
                if(!empty($modPeriksaFisik)){
                    // if(!empty($modPeriksaFisik->keadaanumum)){
                    // 	echo ' Keadaan Umum : '.$modPeriksaFisik->keadaanumum;
                    // }
                    if(!empty($modPeriksaFisik->tekanandarah) && $modPeriksaFisik->tekanandarah != "000 / 000"){
                        echo 'Tekanan Darah : '.$modPeriksaFisik->tekanandarah;
                    }
                    if(!empty($modPeriksaFisik->detaknadi)){
                        echo ', Detak Nadi : '.$modPeriksaFisik->detaknadi;
                    }
               
                    if(!empty($modPeriksaFisik->suhutubuh) && $modPeriksaFisik->suhutubuh!=0){
                        echo ', Suhu Tubuh : '.$modPeriksaFisik->suhutubuh.' Celcius';
                    }
                    if(!empty($modPeriksaFisik->tandavital_spo2)){
                        echo ', SPO<sub>2</sub> : '.$modPeriksaFisik->tandavital_spo2;
                    }
               
                }

            }
			
            ?>
        </td>
    </tr>
    <tr>
        <td style="width: 30%; border-top: 1px solid black;">
            Pemeriksaan Penunjang/<br>Diagnosa Terpenting
        </td>
        <td style="border-left: 1px solid black;border-top: 1px solid black;">
            <?php

         
                echo "Terlampir";
          
			
            ?>
        </td>
    </tr>
    <tr>
        <td style="width: 30%; border-top: 1px solid black;">
            Terapi Pengobatan Selama di Rumah Sakit
        </td>
        <td style="border-left: 1px solid black;border-top: 1px solid black;">
            <?php

			if(!empty($modResume1)){
				
                echo $modResume1->terapiperawatan;
			}
			
            ?>
        </td>
    </tr>
</table>
<table width="100%" class=""
    style="border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;"
    id="diagnosis-content">
    <tr class="">
        <?php
			if(!empty($modDiadnosaUtama)){
		?>
        <td width="30%" style="font-family: Tahoma, sans-serif;">
            <div style="font-family: Tahoma, sans-serif;">Diagnosis Utama
                :<?php echo $modDiadnosaUtama->diagnosa->diagnosa_nama;?></div>
        </td>
        <td style="text-align:center;width:30%;">ICD 10 :<?php echo $modDiadnosaUtama->diagnosa->diagnosa_kode;?></td>
        <?php	
			}else{
		?>
        <td width="30%">Diagnosis Utama : </td>
        <td style="text-align:center;width:30%;">ICD 10 : </td>
        <?php	
			}
		?>
    </tr>
</table>
<table width="100%" class=""
    style="border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;"
    id="diagnosis-sek-content">
    <tr class="">
        <td>Diagnosa Sekunder</td>
        <td style="text-align:center;width:30%;">ICD 10</td>
    </tr>
    <?php 
	if(count((array)$modDiadnosaTambahan)){
		$no = 1;
		foreach ($modDiadnosaTambahan as $value) {
	?>
    <tr class="">
        <td width="30%"><?php echo $no.'. '.$value->diagnosa->diagnosa_nama; ?></td>
        <td style="text-align:center;"><?php echo $value->diagnosa->diagnosa_kode;?></td>
    </tr>
    <?php
		$no++;
		}
	}else{
	?>
    <tr class="">
        <td width="30%"></td>
        <td style="text-align:center;"></td>
    </tr>
    <?php
	}
	?>
</table>
<table width="100%" class="" style="border-right: 1px solid black; border-left: 1px solid black;" id="tindakan-content">
    <tr class="">
        <td>Tindakan/Prosedur</td>
        <td></td>
        <!-- <td style="text-align:center;width:30%;">ICD 9</td> -->
    </tr>
    <?php 
	$modTindakan = Pasienicd9cmT::model()->findAll("pendaftaran_id = $modPendaftaran->pendaftaran_id");
	if(!empty($modTindakan)) {
		foreach($modTindakan as $j => $td) {
			echo "<tr>";
			echo "<td>" . ($j + 1) . ". " . $td->diagnosatindakan->diagnosaicdix_nama . "</td>";
			echo "<td style='text-align:center;width:50%;'>" . $td->diagnosatindakan->diagnosaicdix_kode . "</td>";
			echo "</tr>";
		}
	}
?>
</table>
<table width="100%" class=""
    style="border-right: 1px solid black; border-left: 1px solid black; border-top: 1px solid black;">
    <tr>
        <td style="text-align: left;">
            <?php
				$tglrenkontrol = '-';
				if(!empty($modPendaftaran)):
					if(!empty($modPendaftaran->tglrenkontrol)):
						$tglrenkontrol = MyFormatter::formatDateTimeId($modPendaftaran->tglrenkontrol);
					endif;
				endif;
			?>
            Tanggal Kontrol Poliklinik: <?=$tglrenkontrol;?>
        </td>
    <tr>
</table>
<?php
$modPegawai = PegawaiM::model()->findByPk($modKunjungan->dokterpenanggungjawab_id);
$url_ttd = (!empty($modPegawai->ttd_pegawaistempel) ? Params::urlPegawaiDirectory() . $modPegawai->ttd_pegawaistempel : Params::urlPegawaiDirectory() . "atina.png");
?>

<div class="mydiv">
    <img src="<?php echo $url_ttd; ?>" />
    <table width="100%" class=""
        style="border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;">
        <tr>
            <td colspan="4" align="center" valign="middle"></td>
            <td colspan="4" style="width:170px;"></td>
            <!--<td colspan="3" align="center" valign="middle"><?php // echo Yii::app()->user->getState('kabupaten_nama').", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?><br></td>-->
            <?php if((Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RI || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_PI) && !empty($modKunjungan->tglpasienpulang)){?>
            <td colspan="4" align="center" valign="middle">
                <?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format::formatDateTimeId(date('Y-m-d', strtotime($modKunjungan->tgl_pendaftaran))); ?><br>
            </td>
            <?php }else{?>
            <td colspan="4" align="center" valign="middle">
                <?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format::formatDateTimeId(date('Y-m-d', strtotime($modKunjungan->tgl_pendaftaran))); ?><br>
            </td>
            <?php }?>
        </tr>
        <tr>
            <td colspan="4" align="center" valign="middle"></td>
            <td colspan="4" style="width:170px;"></td>
            <!--<td colspan="3" align="center" valign="middle"><?php // echo Yii::app()->user->getState('kabupaten_nama').", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?><br></td>-->
            <td colspan="4" align="center" valign="middle">Dokter Penanggung Jawab Pelayanan<br></td>
        </tr>
        <tr>
            <td colspan="4" align="center" valign="middle"></td>
            <td colspan="4" style="width:170px;"></td>
            <!--<td colspan="3" align="center" valign="middle"><?php // echo (isset($modKunjungan->pegawai->gelardepan)?$modKunjungan->pegawai->gelardepan:'').' '.$modKunjungan->pegawai->nama_pegawai.' '.(isset($modKunjungan->pegawai->gelarbelakang_nama)?$modKunjungan->pegawai->gelarbelakang_nama:''); ?></td>-->
            <td colspan="4" align="center" valign="middle"><br><br><br><br>
                <?php echo $modKunjungan->dokterlengkap($modKunjungan->dokterpenanggungjawab_id); ?></td>
        </tr>
    </table>
</div>