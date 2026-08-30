<?php
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }else if($caraPrint=='PRINT')
    {
?>
        <style>
            th {
                border: 1px solid;        
                background-color: transparent;
                padding: 5px;
            }
            .grid td{
                border: 1px solid;
                background-color: transparent;
                padding: 5px;
            }
            th{
                text-align: center;
                font-size: 14px;
            }
            table{
                width: 100%;
            }
        </style>
        <!--<div style="height:3cm;">&nbsp;</div>-->
<?php
    }else{
?>
        <style>
            th {
                border: 1px solid #000;
                background-color: transparent;
            }
            .grid td{
                border: 1px solid #000;
                border-collapse: collapse;
                padding: 5px;
            }
            .grid_td td{
                border-collapse: collapse;
                font-size: 11px;
            }   
            .grid_top td{
                border-top: 1px;
                border-left: 1px;
                border-style: solid;
            }
            .right{
                border-top: 1px;
                border-right: 1px;
                border-style: solid;
            }
            .grid_top_buttom td{
                border-top: 1px;
                border-bottom: 1px;
                border-left: 1px;
                border-style: solid;                
            }
            
            th{
                text-align: center;
                font-size: 14px;
            }
            table{
                /*font-family: tahoma;*/
                width: 100%;
            }
        </style>        
<?php
    }
?>
        <?php  //echo $this->renderPartial('application.views.headerReport.headerDefaultSurat');
       echo $this->renderPartial('application.views.headerReport.headerDefault'); ?>
<table width="100%" border="0" class="grid_td" cellpadding="0" cellspacing="0">
    <tr><?php $format=new MyFormatter();?>
        <td width="50%" style="border:none;"><center><?php echo Yii::app()->user->getState("kabupaten_nama").", ".$format->formatDateTimeId(date('Y-m-d')); ?></center></td>
        <td width="15%" style="border:none;">Penanggung jawab</td>
        <td width="35%" style="border:none;">: <?php echo $pemeriksa->gelardepan." ".$pemeriksa->nama_pegawai.", ".$pemeriksa->gelarbelakang->gelarbelakang_nama; ?></td>
    </tr>
    <tr> 
        <td style="border:none;"></td>
        <td style="border:none;">Izin</td>
        <td style="border:none;">: YM.01.05/8/455/IV.46/DKK/2008</td>
    </tr>
</table>
<br>
<table width="100%" border="0" class="grid_td" cellpadding="0" cellspacing="0">
    <tr class="grid_top">
        <td width="12%">No. Lab</td>
        <td width="45%">: <?php echo $masukpenunjang->no_masukpenunjang; ?></td>
        <td width="10%">Perujuk</td>
        <td class="right">: <?php echo $masukpenunjang->nama_perujuk; ?></td>
    </tr>
    <tr class="grid_top">
        <td>Nama Pasien</td>
        <td>: <?php echo $modHasilPeriksa->namadepan." ".$modHasilPeriksa->nama_pasien; ?></td>
        <td width="10%">Alamat</td>
        <td class="right">: <?php echo $masukpenunjang->alamatlengkapperujuk; ?></td>
    </tr>
    <tr class="grid_top">
        <td>Umur ; Jk</td>
        <td>: <?php echo substr($masukpenunjang->umur, 0,7)."; ".$modHasilPeriksa->jeniskelamin; ?></td>
        <td>No. Telp</td>
        <td class="right">: <?php echo $masukpenunjang->notelpperujuk; ?></td>
    </tr>
    <tr class="grid_top_buttom">
        <td>Alamat</td>
        <td>: <?php echo $modHasilPeriksa->alamat_pasien ?></td>
        <td>&nbsp;</td>
        <td class="right">&nbsp;</td>
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
<table border="0" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <div style="font-family:arial;font-size:10pt;text-align: center;">
                <b>
                    HASIL PEMERIKSAAN LABORATORIUM
                </b>
            </div>
        </td>
    </tr>
</table>
<br>
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
            '55'=>'LEMAK JANTUNG',
            '57'=>'IMUNO-SEROLOGI',
            '1'=>'Serologi',
            '69'=>'ANALISA SPERMA',
           // '70'=>'ANALISA BATU GINJAL',
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
                        'jenisperiksa'=>$kelompok['tittle']
                    )
                );
            }else{
                $this->renderPartial(
                    'template/__hasilPemeriksaan',
                    array(
                        'params'=>$kelompok['grid'],
                        'jenisperiksa'=>$kelompok['tittle']
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
//    JANGAN ADA RADIOLOGI DI LAB
//    if(count($data_rad))
//    {
//        echo('
//            <table border="0" width="100%" class="grid" cellpadding="0" cellspacing="0">
//                <thead>
//                    <tr>
//                        <td colspan="3" align="center">
//                            <div style="text-align: center;font-size:14pt;">
//                                <b>RONTGEN DIAGNOSTIK</b>
//                            </div>                
//                        </td>
//                    </tr>
//                    <tr>
//                        <th width="3%">No.</th>
//                        <th width="25%">Pemeriksaan</th>
//                        <th>Hasil</th>
//                    </tr>
//                </thead>
//                <tbody>
//        ');
//        $i = 0;
//        foreach($data_rad as $val)
//        {
//            echo('<tr>');
//            echo('<td valign="top">'. ($i+1) .'</td>');
//            echo('<td valign="top">'. $val['pemeriksaan'] .'</td>');
//            echo('<td valign="top">'. $val['hasil'] .'</td>');
//            echo('</tr>');
//            $i++;
//        }
//        echo('</tbody></table><br>');
//    }
?>

<br>
<table width="100%" border="0" class="grid_td" cellpadding="0" cellspacing="0">
    <tr>
        <td align="left" width="50%">Catatan</td>
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