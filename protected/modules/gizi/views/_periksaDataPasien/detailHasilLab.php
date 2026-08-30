<?php
$pathTemplate = "application.modules.laboratorium.views.daftarPasien.template.";
?>
<style>
    .watermark
    {
       background-image: url(http://localhost/ehospitaljk/images/watermark_print.png);
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
        font-size: 11pt;
    }
    table{
        width: 100%;
    }
    body{
        font-size: 11pt;
    }
</style>
<?php if($modHasilPeriksa->printhasillab == '1') {echo '<div class="watermark">';}  ?>
<?php /*
<div style="height:3cm;">
    &nbsp;
</div>
<table style="width:100%;font-family: arial;font-size: 9pt;">
    <tr ><?php $format=new MyFormatter();?>
        <td width="50%" style="border:none;"><p style="margin: 0; text-align: center;"><?php echo "Tasikmalaya, ".$format->formatDateTimeId(date('Y-m-d')); ?></p></td>
        <td width="15%" style="border:none;">Penanggungjawab</td>
        <td width="35%" style="border:none;">: <?php echo $pemeriksa->gelardepan." ".$pemeriksa->nama_pegawai.", ".$pemeriksa->gelarbelakang->gelarbelakang_nama; ?></td>
    </tr><br>
    <tr> 
        <td style="border:none;"></td>
        <td style="border:none;">Izin</td>
        <td style="border:none;">: YM.01.05/8/455/IV.46/DKK/2008</td>
    </tr>
    <tr>
</table><br><br>
 * 
 */ ?>
<table style="font-family: arial;font-size: 9pt;" class="grid">
    <tr>
        <td width="10%">No. Lab</td>
        <td width="40%">: <?php echo $masukpenunjang->no_masukpenunjang; ?></td>
        <td width="50%" colspan="2"></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>: <?php echo $modHasilPeriksa->namadepan." ".$modHasilPeriksa->nama_pasien; ?></td>
        <td width="10%">Dokter</td>
        <td>: <?php echo $masukpenunjang->namaperujuk; ?></td>
    </tr>
    <tr>
        <td>Umur </td>
        <td>: <?php echo $modHasilPeriksa->umur."; ".$modHasilPeriksa->jeniskelamin; ?></td>
        <td>Alamat</td>
        <td>: <?php echo $masukpenunjang->alamatlengkapperujuk; ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>: <?php echo $modHasilPeriksa->alamat_pasien ?></td>
        <td>No. Telp</td>
        <td>: <?php echo $masukpenunjang->notelpperujuk; ?></td>
    </tr>
</table>
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

    <div style="clear:both;border:none;">
        <?php
            $menu = array(
                '4'=>'URIN LENGKAP',
                '64'=>'TEST KEHAMILAN',
                '65'=>'URIN KHUSUS',
                '6'=>'FEACES LENGKAP',
                '66'=>'FEACES KHUSUS',
                '24'=>'Hematologi',
                '53'=>'KARBOHIDRAT',
                '55'=>'KARBOHIDRAT',
                '57'=>'IMUNO-SEROLOGI',
                '1'=>'Serologi',
                '69'=>'ANALISA SPERMA',
//                '70'=>'ANALISA BATU GINJAL',
                '51'=>'HUMADRUG',
                '52'=>'LAIN - LAIN',
                '5'=>'Mikrobiologi',
            );
            foreach($data as $jenisperiksa => $kelompok)
            {
                if(array_key_exists($jenisperiksa, $menu))
                {
                    $this->renderPartial(
                        $pathTemplate.'__hasilPemeriksaan_' . $jenisperiksa,
                        array(
                            'params'=>$kelompok['grid'],
                            'jenisperiksa'=>$kelompok['tittle'],
                        )
                    );
                }else{
                    $this->renderPartial(
                        $pathTemplate.'__hasilPemeriksaan',
                        array(
                            'params'=>$kelompok['grid'],
                            'jenisperiksa'=>$kelompok['tittle'],
                        )
                    );                    
                }

            }
        ?>
    </div>

    <?php
    /*KETERANGAN RADIOLOGI TERLAMPIR DI HIDE
        if(count((array)$data_rad))
        {
            echo('
                <table border="0" width="100%" class="grid" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <td colspan="3" align="center">
                                <div style="text-align: center;font-size:11pt;">
                                    <b>RONTGEN DIAGNOSTIK</b>
                                </div>                
                            </td>
                        </tr>
                        <tr>
                            <th width="3%">No.</th>
                            <th width="25%">Pemeriksaan</th>
                            <th>Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
            ');
            $i = 0;
            foreach($data_rad as $val)
            {
                echo('<tr>');
                echo('<td valign="top">'. ($i+1) .'</td>');
                echo('<td valign="top">'. $val['pemeriksaan'] .'</td>');
                echo('<td valign="top">'. $val['hasil'] .'</td>');
                echo('</tr>');
                $i++;
            }
            echo('</tbody></table><br>');
        }
     * 
     */
    ?>

<?php
//TOMBOL PRINT DI HIDE KARENA HARUS DI PRINT DI LAB JANGAN DI RUANGAN
/*if (!isset($caraPrint)){
$urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printHasil', array('pasienmasukpenunjang_id'=>$masukpenunjang->pasienmasukpenunjang_id, 'pendaftaran_id'=>$masukpenunjang->pendaftaran_id));
$urlPrintKartuGolonganDarah=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printKartuGolonganDarah', array('pasienmasukpenunjang_id'=>$masukpenunjang->pasienmasukpenunjang_id, 'pendaftaran_id'=>$masukpenunjang->pendaftaran_id));
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printKartuGolonganDarah(caraPrint)
{
    window.open("${urlPrintKartuGolonganDarah}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD); 
        //echo "<br>".CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        //echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')'));     
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Print Kartu Golongan Darah',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'printKartuGolonganDarah(\'PDF\')'));     
//        if(!isset($_GET['popup']))
//            echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index',array('modul_id'=>Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger'));
}
 * 
 */
?> 
<?php if($modHasilPeriksa->printhasillab == '1') {echo '</div>';}  ?>
