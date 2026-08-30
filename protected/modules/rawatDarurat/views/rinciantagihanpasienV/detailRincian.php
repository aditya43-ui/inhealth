<?
$pathTemplate = "application.modules.laboratorium.views.daftarPasien.template.";
?>
<style>
    .watermark {
        background-image: url(http://localhost/ehospitaljk/images/watermark_print.png);
        background-position: center 350px;
        background-size: 300px;
        /* CSS3 only, but not really necessary if you make a large enough image */
        position: absolute;
        background-repeat: no-repeat;
        width: 100%;
        margin: 0;
        z-index: 1000;
    }
</style>
<?php // if (isset($caraPrint)){ 
?>
<style>
    th {
        border: 1px solid;
        background-color: transparent;
    }

    .grid td {
        border: 1px solid;
        background-color: transparent;
    }

    th {
        text-align: center;
        font-size: 11pt;
    }

    table {
        width: 100%;
    }

    body {
        font-size: 11pt;
    }
</style>
<?php if ($modHasilPeriksa->printhasillab == '1') {
    echo '<div class="watermark">';
}  ?>
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
<table width="100%" style='margin-left:auto; margin-right:auto;font-size: 12px;'>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
        <td width="40%"></td>
        <td>Tgl. Pendaftaran</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->tgl_pendaftaran; ?></td>
    </tr>
    <tr>
        <td>Jeni Kelamin</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->pasien->jeniskelamin; ?></td>
        <td></td>
        <td>No. Pendafaran</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->umur; ?></td>
        <td></td>
        <td>Kelas Pelayanan</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
    </tr>
    <tr>
        <td>Jenis Penjamin</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->carabayar->carabayar_nama; ?></td>
        <td></td>
        <td>Diagnosa</td>
        <td>:</td>
        <td><?php
            if (!empty($modPendaftaran->diagnosa) && count((array)$modPendaftaran->diagnosa) > 0) { ?>
                <ul>
                    <?php foreach ($modPendaftaran->diagnosa as $row) {
                        echo '<li>' . $row->diagnosa->diagnosa_nama . '</li>';
                    } ?>
                </ul>
            <?php } else {
                echo ' - ';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->pasien->nama_pasien ?></td>
        <td></td>
        <td>Tgl. Pendaftaran</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->tgl_pendaftaran ?></td>
    </tr>
    <tr>
        <td>Penjamin</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
        <td></td>
        <td>Jenis Kasus Penyakit</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama; ?></td>
    </tr>
</table>
<!--<table width="100%" style='margin-left:auto; margin-right:auto;'>
     <tr>        
        <td>
            <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); 
                                            ?>:</label>
            <?php //echo CHtml::encode($modPendaftaran->pasien->nama_pasien); 
            ?>
            <br>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); 
                                                ?>:</label>
                <?php //echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); 
                ?>
            <br>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); 
                                                ?>:</label>
                <?php //echo CHtml::encode($modPendaftaran->umur); 
                ?>
            <br>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->getAttributeLabel('carabayar_id')); 
                                                ?>:</label>
                <?php //echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); 
                ?>
            <br>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->getAttributeLabel('penjamin_id')); 
                                                ?>:</label>
                <?php //echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); 
                ?>
        </td>
        <td width="30%">
        </td>
        <td>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->getAttributeLabel('tgl_pendaftaran')); 
                                                ?>:</label>
            <?php //echo CHtml::encode($modPendaftaran->tgl_pendaftaran); 
            ?>
            <br>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); 
                                                ?>:</label>
                <?php //echo CHtml::encode($modPendaftaran->no_pendaftaran); 
                ?>
            <br>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->getAttributeLabel('kelaspelayanan')); 
                                                ?>:</label>
            <?php //echo CHtml::encode($modPendaftaran->kelaspelayanan->kelaspelayanan_nama); 
            ?>
            <br>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->getAttributeLabel('diagnosa')); 
                                                ?>:</label>
                    <?php //if (count((array)$modPendaftaran->diagnosa) > 0 ){ 
                    ?>
                    <ul>
                            <?php ///foreach ($modPendaftaran->diagnosa as $row){
                            //echo '<li>'.$row->diagnosa->diagnosa_nama.'</li>';
                            //  } 
                            ?>
                    </ul>
                    <?php //} else { echo ' - '; }
                    ?>
                   <br>
                <label class='control-label'><?php //echo CHtml::encode($modPendaftaran->getAttributeLabel('jeniskasuspenyakit_id')); 
                                                ?>:</label>
            <?php //echo CHtml::encode($modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama); 
            ?>
        </td>
        </tr>
    </table>-->
<table class='table table-striped table-bordered table-condensed'>
    <thead>
        <tr>
            <th>
                Keterangan
            </th>
            <th>
                Kategori (Dokter)<br>Tindakan
            </th>
            <th>
                Tarif Satuan
            </th>
            <th>
                Jumlah
            </th>
            <th>
                Tarif Cyto
            </th>
            <th>
                Keringanan
            </th>
            <th>
                Sub Total
            </th>
            <th>
                Status Bayar
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $ruangan = array();
        $total = 0;
        $subsidiAsuransi = 0;
        $subsidiPemerintah = 0;
        $subsidiRumahSakit = 0;
        $iurBiaya = 0;
        foreach ($modRincian as $i => $row) {
            $rowspan = count(RDRinciantagihanpasienV::model()->findAll('ruangan_id = ' . $row->ruangan_id . ' and pendaftaran_id = ' . $row->pendaftaran_id));
            if (!in_array($row->ruangan_id, $ruangan)) {
                $ruangan[] = $row->ruangan_id;
                $ruanganTd = '<td rowspan="' . $rowspan . '" style="vertical-align:middle;text-align:center;">' . $row->ruangan_nama . '</td>';
            } else {
                $ruanganTd = '';
            }
            $subtot = $row->tarifcyto_tindakan + ($row->tarif_satuan * $row->qty_tindakan);
            echo '<tr>
                    ' . $ruanganTd . '
                    <td>' . $row->kategoritindakan_nama . ' (' . $row->nama_pegawai . ')<br>' . $row->daftartindakan_nama . '
                    </td>
                    <td style="text-align:right;">' . number_format($row->tarif_satuan, 0, ',', '.') . '
                    </td>
                    <td>' . $row->qty_tindakan . '
                    </td>
                    <td style="text-align:right;">' . number_format($row->tarifcyto_tindakan, 0, ',', '.') . '
                    </td>
                    <td>' . $row->discount_tindakan . '
                    </td>
                    <td style="text-align:right;">' . number_format($subtot, 0, ',', '.') . '
                    </td>
                    <td>' . ((empty($row->tindakansudahbayar_id)) ? "BELUM LUNAS" : "LUNAS") . '
                    </td>
                   </tr>';
            $total += $subtot;
            $subsidiAsuransi += $row->subsidiasuransi_tindakan;
            $subsidiPemerintah += $row->subsidipemerintah_tindakan;
            $subsidiRumahSakit += $row->subsisidirumahsakit_tindakan;
            $iurBiaya += $row->iurbiaya_tindakan;
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">
                <div class='pull-right'>Total Tagihan</div>
            </td>
            <td style="text-align:right;"><?php echo number_format($total, 0, ',', '.'); ?></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6">
                <div class='pull-right'>Tanggungan Asuransi</div>
            </td>
            <td style="text-align:right;"><?php echo number_format($subsidiAsuransi, 0, ',', '.'); ?></td>
            <td></td>
        </tr>
        <!--<tr>
            <td colspan="6"><div class='pull-right'>Tanggungan Pemerintah</div></td>
            <td style="text-align:right;"><?php echo number_format($subsidiPemerintah, 0, ',', '.'); ?></td>
            <td></td>
        </tr>-->
        <tr>
            <td colspan="6">
                <div class='pull-right'>Tanggungan Rumah Sakit</div>
            </td>
            <td style="text-align:right;"><?php echo number_format($subsidiRumahSakit, 0, ',', '.'); ?></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6">
                <div class='pull-right'>Iur Biaya</div>
            </td>
            <td style="text-align:right;"><?php echo number_format($iurBiaya, 0, ',', '.'); ?></td>
            <td></td>
        </tr>
    </tfoot>
</table>
<div style="clear:both;border:none;">
    <?php
    //            $menu = array(
    //                '4'=>'URIN LENGKAP',
    //                '64'=>'TEST KEHAMILAN',
    //                '65'=>'URIN KHUSUS',
    //                '6'=>'FEACES LENGKAP',
    //                '66'=>'FEACES KHUSUS',
    //                '24'=>'Hematologi',
    //                '53'=>'KARBOHIDRAT',
    //                '55'=>'KARBOHIDRAT',
    //                '57'=>'IMUNO-SEROLOGI',
    //                '1'=>'Serologi',
    //                '69'=>'ANALISA SPERMA',
    ////                '70'=>'ANALISA BATU GINJAL',
    //                '51'=>'HUMADRUG',
    //                '52'=>'LAIN - LAIN',
    //                '5'=>'Mikrobiologi',
    //            );
    //            foreach($data as $jenisperiksa => $kelompok)
    //            {
    //                if(array_key_exists($jenisperiksa, $menu))
    //                {
    //                    $this->renderPartial(
    //                        $pathTemplate.'__hasilPemeriksaan_' . $jenisperiksa,
    //                        array(
    //                            'params'=>$kelompok['grid'],
    //                            'jenisperiksa'=>$kelompok['tittle'],
    //                        )
    //                    );
    //                }else{
    //                    $this->renderPartial(
    //                        $pathTemplate.'__hasilPemeriksaan',
    //                        array(
    //                            'params'=>$kelompok['grid'],
    //                            'jenisperiksa'=>$kelompok['tittle'],
    //                        )
    //                    );                    
    //                }
    //
    //            }
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
<?php // if($modHasilPeriksa->printhasillab == '1') {echo '</div>';}  
?>