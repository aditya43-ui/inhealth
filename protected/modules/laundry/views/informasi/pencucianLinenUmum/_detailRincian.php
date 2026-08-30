<?php 
$kosong = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>'Pencucian Linen Umum', 'colspan'=>10));      

?>
<style>
    table.grid th, table.grid td, table.no-grid th, table.no-grid td {
        font-size: 9pt;
    } 
</style>
<table class="w100 prinout no-grid ">
    <tr>
        <td width="20%">Tgl Pencucian</td>
        <td width="3%">:</td>
        <td><?= MyFormatter::formatDateTimeForUser($model->tglpencucian,'long') ?></td>
        <td width="10%"></td>
        <td width="15%">Keterangan</td>
        <td width="3%">:</td>
        <td><?= $model->keterangan ?></td>
    </tr>
    <tr>
        <td >No Pencucian</td>
        <td width="3%">:</td>
        <td><?= $model->nopencucian ?></td>
        <td width="10%"></td>
        <td>Pegawai</td>
        <td width="3%">:</td>
        <td><?= !empty($model->pegawaimengetahui)?$model->pegawaimengetahui->namaLengkap:null ?></td>
    </tr>
    <tr>        
        <td >Mesin Pencucian</td>
        <td width="3%">:</td>
        <td><?= !empty($model->mesinpencucian)?$model->mesinpencucian->mesinpencucian_nama:'' ?></td>
        <td width="10%"></td>
        <td></td>
        <td width="3%"></td>
        <td></td>
    </tr>
</table>

<h3 align="center">Data Linen</h3>
<table class="w100 prinout grid ">
    <tr>
        <th><b>No</b></th>
        <th><b>Nama Linen</b></th>
        <th><b>Jumlah</b></th>
        <th><b>Satuan</b></th>
        <th><b>Keterangan</b></th>
    </tr>   
    <?php
        if (!empty($modDetail)){
            foreach($modDetail as $key =>$det){
    ?>
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $det->namalinen ?></td>
                    <td><?= $det->jumlah ?></td>
                    <td><?= $det->satuan ?></td>
                    <td><?= $det->keterangan ?></td>
                </tr>
    <?php
            }
        }else{
            echo '<tr><td colspan="5">Data tidak ditemukan</tr>';
        }
    ?>
</table>

<h3 align="center">Data Bahan Desenfeksi</h3>
<table class="w100 prinout grid ">
    <tr>
        <th><b>No</b></th>
        <th><b>Nama Bahan</b></th>
        <th><b>Jumlah Bahan</b></th>
        <th><b>Satuan</b></th>
    </tr>   
    <?php
        if (!empty($modBahan)){
            foreach($modBahan as $key =>$det){
    ?>
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $det->bahanperawatan->bahanperawatan_nama ?></td>
                    <td><?= $det->jmlpemakaian ?></td>
                    <td>Liter</td>
                </tr>
    <?php            
            }
        }else{
            echo '<tr><td colspan="4">Data tidak ditemukan</tr>';            
        }
    ?>
</table>

<table class="w100 prinout no-grid ">
    <tr>
        <td style="text-align: center;">Mengajukan</td>
        <td style="text-align: center;">Mengetahui</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td style="text-align: center;">(<?= $kosong ?>)</td>
        <td style="text-align: center;">(<?= !empty($model->pegawaimengetahui)?$model->pegawaimengetahui->namaLengkap:$kosong ?>)</td>
    </tr>
    <tr>
        <td style="text-align:center;">
            <?php
                if (empty($caraPrint)){
                    echo '<link rel="stylesheet" type="text/css" href="'.Yii::app()->request->baseUrl.'/css/global-prinout.css"> ';
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp";
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp";
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) ;        
                    
            ?>
                    <script>
                        const print = (caraPrint) => {
                            window.open("<?= $this->createUrl('detail',['id'=>$model->pencucianlinenumum_id]) ?>&caraPrint="+caraPrint,"",'location=_new, width=900px');
                        }
                    </script>
            <?php
                }
            ?>
        </td>
        <td></td>
    </tr>
</table>