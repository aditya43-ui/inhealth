<style>
    .watermark
    {
       background-image: url(/images/watermark_print.png);
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
</style>
<?php if($modHasilPeriksa->printhasillab == '1') {echo '<div class="watermark">';}  ?>
<?php  //echo $this->renderPartial('application.views.headerReport.headerDefaultSurat');
       echo $this->renderPartial('application.views.headerReport.headerDefault'); ?>
<table style="width:100%;font-family: arial;font-size: 10pt;">
    <tr ><?php $format=new MyFormatter(); $tgl = explode(" ",$modHasilPeriksa->update_time); $tgl_periksa = $format->formatDateTimeForDb($tgl[0]." ".$tgl[1]." ".$tgl[2]);?>
        <td width="50%" style="border:none;"><center><?php echo Yii::app()->user->getState("kabupaten_nama").", ".$format->formatDateTimeId(date($tgl_periksa)); ?>
    
    
    
    </center></td>
        <td width="15%" style="border:none;">Penanggung jawab</td>
        <td width="35%" style="border:none;">: <?php echo (isset($pemeriksa->gelardepan)?$pemeriksa->gelardepan." " : "").$pemeriksa->nama_pegawai.(isset($pemeriksa->gelarbelakang_id) ? $pemeriksa->gelarbelakang->gelarbelakang_nama.", " : null); ?></td>
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
        <td width="10%">No. Lab</td>
        <td width="40%">: <?php echo $masukpenunjang->no_masukpenunjang; ?></td>
        <td width="50%" colspan="2"><b>Data Perujukan</b></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>: <?php echo $modHasilPeriksa->namadepan." ".$modHasilPeriksa->nama_pasien; ?></td>
        <td width="10%">Perujuk</td>
        <td>: <?php
        if (isset($masukpenunjang->nama_perujuk)){ 
            echo $masukpenunjang->nama_perujuk;
        }else if (isset($masukpenunjang->nama_dokterasal)){
            echo $masukpenunjang->nama_dokterasal;
        }else{
            echo $perujuk->gelardepan."".$perujuk->nama_pegawai;
        } 
        ?>
    </td>
    </tr>
    <tr>
        <td>Umur ; Jk</td>
        <td>: <?php echo substr($masukpenunjang->umur, 0,7)."; ".$modHasilPeriksa->jeniskelamin; ?></td>
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
                <div style="font-family:arial;font-size:16pt;">
                    <b>
                        <center>
                            <h3>HASIL PEMERIKSAAN LABORATORIUM</h3>
                        </center>
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
        if(Yii::app()->user->getState('ruangan_id')==Params::RUANGAN_ID_LAB_KLINIK)  
        {  
            foreach($data as $jenisperiksa => $kelompok)
            {
                if(array_key_exists($jenisperiksa, $menu))
                {
                    $this->renderPartial(
                        'template/__hasilPemeriksaan_' . $jenisperiksa,
                        array(
                            'params'=>$kelompok['grid'],
                            'jenisperiksa'=>$kelompok['tittle'],
                        )
                    );
                }else{
                    $this->renderPartial(
                        'template/__hasilPemeriksaan',
                        array(
                            'params'=>$kelompok['grid'],
                            'jenisperiksa'=>$kelompok['tittle'],
                        )
                    );                    
                }

            }
        }else{
            echo'
            <table border="0" width="100%" class="grid" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th>Jenis/Detail Pemeriksaan</th>
                        <th>Makroskopis</th>
                        <th>Mikroskopis</th>
                        <th>Saran</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($data as $key => $datalab) {
                echo'
                    <tr>
                        <td>'.$datalab->pemeriksaanlab->pemeriksaanlab_nama.'</td>
                        <td>'.$datalab->makroskopis.'</td>
                        <td>'.$datalab->mikroskopis.'</td>
                        <td>'.$datalab->saranpa.'</td>
                        <td>'.$datalab->catatanpa.'</td>
                    </tr>';
                    }
                echo'
                </tbody>
            </table>
            <br>';
        }
        ?>
    </div>

    <?php
    //TIDAK BOLEH ADA PEMERIKSAAN RAD DI PRINT HASIL LAB
//        if(count($data_rad))
//        {
//            echo('
//                <table border="0" width="100%" class="grid" cellpadding="0" cellspacing="0">
//                    <thead>
//                        <tr>
//                            <td colspan="3" align="center">
//                                <div style="text-align: center;font-size:14pt;">
//                                    <b>RONTGEN DIAGNOSTIK</b>
//                                </div>                
//                            </td>
//                        </tr>
//                        <tr>
//                            <th width="3%">No.</th>
//                            <th width="25%">Pemeriksaan</th>
//                            <th>Hasil</th>
//                        </tr>
//                    </thead>
//                    <tbody>
//            ');
//            $i = 0;
//            foreach($data_rad as $val)
//            {
//                echo('<tr>');
//                echo('<td valign="top">'. ($i+1) .'</td>');
//                echo('<td valign="top">'. $val['pemeriksaan'] .'</td>');
//                echo('<td valign="top">'. $val['hasil'] .'</td>');
//                echo('</tr>');
//                $i++;
//            }
//            echo('</tbody></table><br>');
//        }
    ?>

<?php
if (!isset($caraPrint)){
//$urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printHasil', array('pasienmasukpenunjang_id'=>$masukpenunjang->pasienmasukpenunjang_id, 'pendaftaran_id'=>$masukpenunjang->pendaftaran_id));
$urlPrint=  Yii::app()->createAbsoluteUrl('/laboratoriumPA/pencatatanHasilPemeriksaan/print', array('pasienmasukpenunjang_id'=>$masukpenunjang->pasienmasukpenunjang_id));
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
        //echo "abc";
        //echo "<br>".CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        //echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp";     
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";     
        if ($goldarah > 0){
            echo CHtml::htmlButton(Yii::t('mds','{icon} Print Kartu Golongan Darah',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'printKartuGolonganDarah(\'PDF\')'))."&nbsp&nbsp";
        }
        if(!isset($_GET['popup']))
            echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('index',array('modul_id'=>Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger'));
}
?> 
<?php if($modHasilPeriksa->printhasillab == '1') {echo '</div>';}  ?>
