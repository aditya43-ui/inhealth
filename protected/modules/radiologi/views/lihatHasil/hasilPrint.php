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

<table style="width:100%;font-family: arial;font-size: 10pt;">
    <tr ><?php $format=new MyFormatter(); ?>
        <td width="50%" style="border:none;"><p style="margin: 0; text-align: center;"><?php  echo $rumahSakit->kabupaten->kabupaten_nama.", ".$format->formatDateTimeId(date('Y-m-d')); ?></p></td>
        <td width="15%" style="border:none;">Penanggungjawab</td>
        <td width="35%" style="border:none;">: <?php echo $pemeriksa['gelardepan']." ".$pemeriksa['nama_pegawai'].", ".$pemeriksa['gelarbelakang']['gelarbelakang_nama']; ?></td>
    </tr><br>
    <!--tr> 
        <td style="border:none;"></td>
        <td style="border:none;">Izin</td>
        <td style="border:none;">: YM.01.05/8/455/IV.46/DKK/2008</td>
    </tr-->
    <tr>
</table><br><br>
<table style="font-family: arial;font-size: 10pt;" class="grid">
    <tr>
        <td nowrap>No. Registrasi Radiologi</td>
        <td width="40%">: <?php echo $masukpenunjang->no_masukpenunjang; ?></td>
        <td width="50%" colspan="2" style="font-weight: bold;">Data Perujuk</td>
    </tr>
    <tr>
        <td>No. RM / Nama Pasien</td>
        <td>: <?php echo $masukpenunjang->no_rekam_medik." / ".$masukpenunjang->namadepan." ".$masukpenunjang->nama_pasien; ?></td>
        <td width="10%">Nama Perujuk</td>
        <td>: <?php 
        if (isset($masukpenunjang->nama_perujuk)){
            echo $masukpenunjang->nama_perujuk;
        }else{
            echo isset($perujuk->NamaLengkap) ? $perujuk->NamaLengkap:"-";
        }
        ?></td>
    </tr>
    <tr>
        <td>Umur / Jenis Kelamin</td>
        <td>: <?php echo $masukpenunjang->umur." / ".$masukpenunjang->jeniskelamin; ?></td>
        <td>Alamat</td>
        <td>: <?php echo $masukpenunjang->alamatlengkapperujuk; ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>: <?php echo $masukpenunjang->alamat_pasien ?></td>
        <td>No. Telp</td>
        <td>: <?php echo $masukpenunjang->notelpperujuk; ?></td>
    </tr>
    <tr>
        <td>Ruangan / Poli</td>
        <td>: <?php echo $masukpenunjang->ruanganasal_nama; ?> </td>
        <td>Pemeriksaan</td>
        <td><?php echo $detailHasil[0]->pemeriksaanrad->pemeriksaanrad_nama; ?></td>
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
<table border="1" width="100%" cellpadding="0" cellspacing="0" class="title" hidden>
    <tr>
        <td width="50%">BAGIAN RADIOLOGI</td>
        <td><?php echo $pemeriksa['gelardepan']." ".$pemeriksa['nama_pegawai'].", ".$pemeriksa['gelarbelakang']['gelarbelakang_nama'] ?></td>
    </tr>
</table>

<table style="border:1px solid #000; margin:4px auto;"  width="100%">
    <?php if (count((array)$detailHasil) > 0 ){ 
	foreach ($detailHasil as $i=>$hasil) { ?>
    <tr style="border-bottom: 1px solid #000;" hidden>
        <td style="font-family: Arial; font-size: 14pt;font-weight: bold;"><?php echo $hasil->pemeriksaanrad->pemeriksaanrad_nama; ?></td>
    </tr>
    <tr>
        <td class="isi_hasil">
            <div class="sub-judul">Hasil :</div>
            <?php echo (strlen($hasil->hasilexpertise) > 0 ? $hasil->hasilexpertise : ' - '); ?>
        </td>
    </tr>
    <!--<tr>
        <td class="isi_hasil">
            <br>
            <div class="sub-judul">Kesan :</div>
            <?php echo (strlen($hasil->kesan_hasilrad) > 0 ? $hasil->kesan_hasilrad : ' - '); ?>
        </td>
    </tr>-->
    <tr>
        <td class="isi_hasil">
            <br>
            <div class="sub-judul">Kesimpulan :</div>
            <?php echo (strlen($hasil->kesimpulan_hasilrad) > 0 ? $hasil->kesimpulan_hasilrad : ' - '); ?>
        </td>
    </tr>
    <?php }} ?>
</table>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
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
            Printed By : <?=$masukpenunjang->getNamaPegawai(Yii::app()->user->getState('pegawai_id'))?> <?=  MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'))?>
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
            echo empty($pegawai)?"":"Nip.".$pegawai->nomorindukpegawai; ?>
        </td>
    </tr>
</table>
    <?php
    if($caraPrint != 'PRINT'){
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'print(\'PRINT\');')); 
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-remove icon-white"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'window.parent.$("#dialogLihatHasil").dialog(\'close\')')); 
    }
    ?>
<?php
/*
$urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/HasilPeriksaPrint', array("pendaftaran_id"=>$masukpenunjang->pendaftaran_id,"pasien_id"=>$masukpenunjang->pasien_id,"pasienmasukpenunjang_id"=>$masukpenunjang->pasienmasukpenunjang_id));
$js = <<< JSCRIPT
        
        
function print(caraPrint)
{
    if(caraPrint == 'PRINT'){
    var jumlah = ${i};
    jumlah++;
    var i = 0;
        for(var i=0;i < jumlah;i++){
            myConfirm("Apakah Anda Akan Mencetak Pemeriksaan Ke-"+(i+1)+" dari "+jumlah+" pemeriksaan?","Perhatian!",function(r) {
                if(r){
                    window.open("${urlPrint}&i="+i+"&caraPrint="+caraPrint,"",'location=_new, width=1024px');
                }
            });
        }
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,  CClientScript::POS_HEAD);
 * 
 */
?>

