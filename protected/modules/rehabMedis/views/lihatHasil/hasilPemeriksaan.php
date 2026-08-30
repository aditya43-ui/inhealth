<div class="white-container">
    <?php  $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());?>
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
    </style>
    <?php //if($modHasilPeriksa->printhasillab == '1') {echo '<div class="watermark">';}  ?>

    <?php  //echo $this->renderPartial('application.views.headerReport.headerDefaultSurat');
       echo $this->renderPartial('application.views.headerReport.headerDefault'); ?>
    <p style="margin: 0; text-align: center;">
<!--<h3 style="font-family: Arial; font-size: 16pt;">HASIL PEMERIKSAAN RADIOLOGI</h3>-->
    </p>
    <table style="width:100%;font-family: arial;font-size: 10pt;">
        <tr ><?php $format=new MyFormatter();?>
            <td width="50%" style="border:none;"><p style="margin: 0; text-align: center;"><?php echo $rumahSakit['alamatlokasi_rumahsakit'].", ".$format->formatDateTimeId(date('Y-m-d')); ?></p></td>
            <td width="15%" style="border:none;">Penanggungjawab</td>
            <td width="35%" style="border:none;">: <?php echo $pemeriksa['gelardepan']." ".$pemeriksa['nama_pegawai'].", ".$pemeriksa['gelarbelakang']['gelarbelakang_nama']; ?></td>
        </tr><br>
        <tr> 
            <td style="border:none;"></td>
            <td style="border:none;">Izin</td>
            <td style="border:none;">: YM.01.05/8/455/IV.46/DKK/2008</td>
        </tr>
        <tr>
    </table><br><br>
    <table style="font-family: arial;font-size: 10pt;" class="grid">
        <tr>
            <td width="10%">Nomor Registrasi Radiologi</td>
            <td width="40%">: <?php echo $masukpenunjang->no_masukpenunjang; ?></td>
            <td width="50%" colspan="2" align="center"><b>DATA PERUJUK</b></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>: <?php echo $masukpenunjang->namadepan." ".$masukpenunjang->nama_pasien; ?></td>
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
            <td>Umur </td>
            <td>: <?php echo $masukpenunjang->umur."; ".$masukpenunjang->jeniskelamin; ?></td>
            <td>Alamat</td>
            <td>: <?php echo $masukpenunjang->alamatlengkapperujuk; ?></td>
        </tr>
        <tr>
            <td>Alamat Pasien</td>
            <td>: <?php echo $masukpenunjang->alamat_pasien ?></td>
            <td>No. Telepon</td>
            <td>: <?php echo $masukpenunjang->notelpperujuk; ?></td>
        </tr>
    </table>
    <div style="font-family:arial;font-size:12pt;">
        <b>
        <?php
            echo $masukpenunjang->no_rekam_medik . '/' . $masukpenunjang->ruanganasal_nama . '/' . $masukpenunjang->kelaspelayanan_nama;
        ?>
        </b>
    </div>
    <br>
    <table border="1" width="100%" cellpadding="0" cellspacing="0" class="title">
        <tr>
            <td width="50%">BAGIAN RADIOLOGI</td>
            <td><?php echo $pemeriksa['gelardepan']." ".$pemeriksa['nama_pegawai'].", ".$pemeriksa['gelarbelakang']['gelarbelakang_nama']; ?></td>
        </tr>
    </table>
    <?php foreach($detailHasil as $i=>$detail): ?>
        <table style="border:1px solid #000; margin:4px auto;"  width="100%">
            <tr style="border-bottom: 1px solid #000;">
                <td style="font-family: Arial; font-size: 14pt;font-weight: bold;"><?php echo $detail->pemeriksaanrad->pemeriksaanrad_nama; ?>

                    <?php
                    if($caraPrint != 'PRINT'){
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'print(\'PRINT\',"'.$detail->pemeriksaanrad_id.'");')); 
    //		echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-form-silang icon-white"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'window.parent.$("#dialogLihatHasil").dialog(\'close\')')); 
                    }?>
                </td>
            </tr>
            <tr>
				<td width="20%">Hasil</td>
				<td width="5px">:</td>
                <td class="isi_hasil">
                    <?php echo (strlen($detail->hasilexpertise) > 0 ? $detail->hasilexpertise : ' - '); ?>
                </td>
            </tr>
			<tr>
				<td>Kesan</td>
				<td>:</td>
                <td >
                    <?php echo (strlen($detail->kesan_hasilrad) > 0 ? $detail->kesan_hasilrad : ' - '); ?>
                </td>
            </tr>
			<tr>
				<td>Kesimpulan</td>
				<td>:</td>
                <td >
                    <?php echo (strlen($detail->kesimpulan_hasilrad) > 0 ? $detail->kesimpulan_hasilrad : ' - '); ?>
                </td>
            </tr>
        </table>
    <?php endforeach; ?>

    <br>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td align="left" width="50%">&nbsp;</td>
            <td align="center">PEMERIKSA</td>
        </tr>
        <tr>
            <td align="left">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                Printed By : <?=$masukpenunjang->getNamaPegawai(Yii::app()->user->getState('pegawai_id'))?> <?=date('d/m/Y H:i:s')?>
            </td>
            <td align="center">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>            
                <?=$masukpenunjang->getNamaLengkapDokter($masukpenunjang->pegawai_id)?>
            </td>
        </tr>
    </table>
    <?php
//    if($caraPrint != 'PRINT'){
//        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'print(\'PRINT\');')); 
//        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-form-silang icon-white"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'window.parent.$("#dialogLihatHasil").dialog(\'close\')')); 
//    }
    ?>
</div>
<?php
$urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/HasilPeriksaPrint', array("pendaftaran_id"=>$masukpenunjang->pendaftaran_id,"pasien_id"=>$masukpenunjang->pasien_id,"pasienmasukpenunjang_id"=>$masukpenunjang->pasienmasukpenunjang_id));
$js = <<< JSCRIPT
function print(caraPrint,pemeriksaanrad_id)
{
    if(caraPrint == 'PRINT'){
    var jumlah = 0;
    jumlah++;
    var i = 0;
        for(var i=0;i < jumlah;i++){
            myConfirm("Apakah Anda Akan Mencetak Pemeriksaan Ini?","Perhatian!",function(r) {
                if(r){
                    window.open("${urlPrint}&i="+i+"&caraPrint="+caraPrint+"&pemeriksaanrad_id="+pemeriksaanrad_id,"",'location=_new, width=1024px');
                }
            });
        }
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,  CClientScript::POS_HEAD);
?>
