<!--div class="white-container"-->
    <?php  
		$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
		?>
    <style>
        .watermark
        {
           background-image: url(<?php echo Yii::app()->baseUrl; ?>/images/watermark_print.png);
           background-position: center 350px;
           background-size: 300px; /* CSS3 only, but not really necessary if you make a large enough image */
           position: absolute;
           background-repeat: no-repeat;
           width: 100%;
           margin: 0;
           z-index: 1000;
        }

    </style>
    <?php // if (isset($caraPrint)){ ?>
    <style>
        th {
            border: 1px solid;        
            background-color: transparent;
        }
        .grid td{
            border: 1px solid;
            background-color: transparent;
        }
        th{
            text-align: center;
            font-size: 14px;
        }
        table{
            width: 100%;
        }
        .title td{
            font-size: 16px;
            text-align: center;
            font-weight: bold;
            padding: 5px;
            background: #309C5C;
        }
        .sub-judul {
            font-weight: bold;
        }
    </style>
    <?php //if($modHasilPeriksa->printhasillab == '1') {echo '<div class="watermark">';}  ?>

    <?php  //echo $this->renderPartial('application.views.headerReport.headerDefaultSurat');
       echo $this->renderPartial('application.views.headerReport.headerDefault'); ?>
    <p style="margin: 0; text-align: center;">
<!--<h3 style="font-family: Arial; font-size: 16pt;">HASIL PEMERIKSAAN RADIOLOGI</h3>-->
    </p>
    <table  class="table noborder">
        <tr ><?php $format=new MyFormatter();?>
            <td width="50%" style="border:none;"><p style="margin: 0; text-align: center;"><?php echo $rumahSakit->kabupaten->kabupaten_nama.", ".$format->formatDateTimeId(date('Y-m-d')); ?></p></td>
            <td width="15%" style="border:none;">Penanggungjawab</td>
            <td width="35%" style="border:none;">: <?php echo !empty($pemeriksa->namaLengkap) ? $pemeriksa->namaLengkap : "-" ; ?></td>
        </tr><br>
        <!--tr> 
            <td style="border:none;"></td>
            <td style="border:none;">Izin</td>
            <td style="border:none;">: YM.01.05/8/455/IV.46/DKK/2008</td>
        </tr-->
        <tr>
    </table><br><br>
    <table  class="table border">
        <tr>
            <td nowrap>No. Registrasi Radiologi</td>
            <td width="40%">: <?php echo $masukpenunjang->no_masukpenunjang; ?></td>
            <td width="50%" colspan="2" align="center"><b>DATA PERUJUK</b></td>
        </tr>
        <tr>
            <td>No. RM / Nama Pasien</td>
            <td>: <?php echo $masukpenunjang->no_rekam_medik." / ".$masukpenunjang->namadepan." ".$masukpenunjang->nama_pasien; ?></td>
            <td width="10%">Nama Perujuk</td>
            <td>: 
            <?php 
            if (isset($masukpenunjang->nama_perujuk)){
                echo $masukpenunjang->nama_perujuk;
            }else{
                echo isset($perujuk->NamaLengkap) ? $perujuk->NamaLengkap:"-";
            }
            ?>
        </td>
        </tr>
        <tr>
            <td>Umur / Jenis Kelamin</td>
            <td>: <?php echo $masukpenunjang->umur." / ".$masukpenunjang->jeniskelamin; ?></td>
            <td>Alamat</td>
            <td>: <?php echo $masukpenunjang->alamatlengkapperujuk; ?></td>
        </tr>
        <tr>
            <td>Alamat Pasien</td>
            <td>: <?php echo $masukpenunjang->alamat_pasien ?></td>
            <td>No. Telepon</td>
            <td>: <?php echo $masukpenunjang->notelpperujuk; ?></td>
        </tr>
        <tr>
            <td>Ruangan / Poli</td>
            <td>: <?php echo $masukpenunjang->ruanganasal_nama; ?> </td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <div style="font-family:arial;font-size:12pt;">
        <b>
        <?php
            // echo $masukpenunjang->no_rekam_medik . '/' . $masukpenunjang->ruanganasal_nama . '/' . $masukpenunjang->kelaspelayanan_nama;
        ?>
        </b>
    </div>
    <br>
    <table  class="table border">
        <tr>
            <td width="50%">BAGIAN RADIOLOGI</td>
            <td><?php echo !empty($pemeriksa->namaLengkap) ? $pemeriksa->namaLengkap : "-"; ?></td>
        </tr>
    </table>
    <?php 
    
    // $masukpenunjang->no_rekam_medik = "11561645";
    $res_list = ListAllOrder::getLoadHasilList($masukpenunjang->no_rekam_medik);
    // var_dump($res_list); die;
    foreach($res_list as $i=>$res): 
        
        //$res = ListAllOrder::getLoadHasil($detail);
        // var_dump($res); die;
        ?>
        <table  class="table border">
            <tr style="border-bottom: 1px solid #000;">
                <td style="font-family: Arial; font-size: 14pt;font-weight: bold;"><?php echo $res['reques']; ?>

                    <?php
                    if($caraPrint != 'PRINT'){
                    //echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'print(\'PRINT\',"'.$detail->pemeriksaanrad_id.'");')); 
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'print(\'PRINT\',\''.$masukpenunjang->pasienmasukpenunjang_id.'\', \''.$res['nofoto'].'\');')); 
                    echo CHtml::link(Yii::t('mds', '{icon} Lihat Foto', array('{icon}'=>'<i class="entypo-eye"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'printFoto("'.$masukpenunjang->no_rekam_medik.'","'.$res['nofoto'].'");')); 
    //		echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-remove icon-white"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'window.parent.$("#dialogLihatHasil").dialog(\'close\')')); 
                    }?>
                </td>
            </tr>
            <tr>
                <td class="isi_hasil">
                    <div class="sub-judul">Hasil :</div>
                    <?php 
                        echo $res['jawaban'] ?? "-";
                    ?>
                </td>
            </tr>
        </table>
    <?php endforeach; ?>

    <br>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <!-- <tr>
            <td align="left" width="50%">&nbsp;</td>
            <td align="center">Salam Sejawat,</td>
        </tr>
        <tr>
            <td align="left">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                Printed By : <?=$masukpenunjang->getNamaPegawai(Yii::app()->user->getState('pegawai_id'))?> <?=MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'))?>
            </td>
            <td align="center">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>            
                <div style="text-decoration: underline; font-weight: bold;"><?=$masukpenunjang->getNamaLengkapDokter($masukpenunjang->pegawai_id)?></div>
                <?php 
                $pegawai = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);
                echo empty($pegawai)?"":"NIP.".$pegawai->nomorindukpegawai; ?>
            </td>
        </tr> -->
    </table>
    <?php
//    if($caraPrint != 'PRINT'){
//        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'print(\'PRINT\');')); 
//        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-remove icon-white"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'window.parent.$("#dialogLihatHasil").dialog(\'close\')')); 
//    }
    ?>
<!--/div-->
<?php
//$urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/HasilPeriksaPrint', array("pendaftaran_id"=>$masukpenunjang->pendaftaran_id,"pasien_id"=>$masukpenunjang->pasien_id,"pasienmasukpenunjang_id"=>$masukpenunjang->pasienmasukpenunjang_id));
$urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/daftarPasien/printPemeriksaanRad');
$urlPrintFoto=  Yii::app()->createAbsoluteUrl($this->module->id.'/daftarPasien/viewFoto');
$js = <<< JSCRIPT
function print(caraPrint, pasienmasukpenunjang_id, nofoto)
{
    if(caraPrint == 'PRINT'){
    var jumlah = 0;
    jumlah++;
    var i = 0;
        for(var i=0;i < jumlah;i++){
            myConfirm("Apakah Anda Akan Mencetak Pemeriksaan Ini?","Perhatian!",function(r) {
                if(r){
                   // window.open("${urlPrint}&i="+i+"&caraPrint="+caraPrint+"&pemeriksaanrad_id="+pemeriksaanrad_id,"",'location=_new, width=1024px');
				    window.open("${urlPrint}&i="+i+"&caraPrint="+caraPrint+"&pasienmasukpenunjang_id="+pasienmasukpenunjang_id+"&nofoto="+nofoto,"",'location=_new, width=1024px');
                }
            });
        }
    }
}

function printFoto(no_register, nofoto) {
    window.open("${urlPrintFoto}&no_register=" + no_register + "&nofoto="+nofoto,"",'location=_new, width=1024px');   
}



JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,  CClientScript::POS_HEAD);
?>
