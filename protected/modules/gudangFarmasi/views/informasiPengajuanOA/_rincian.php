<style>
    
    body {
        color: black;
    }
    
    .border th, .border td{
        border:1px solid #000;
        padding:2px;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array()); ?>
<h4 style="font-weight: bold; color: black">
    <p style="margin: 0; text-align: center;"><?php echo $judulLaporan; ?></p>
</h4>
    <br>
<table style="width: 100%; border: none;">
    <tr>
        <td width="50%">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="200px">No. Pengajuan</td>
                    <td>
                        : <?php echo $model->nopengajuanhargaoa; ?> 
                    </td>
                </tr>
                <tr>
                    <td>Tgl. Permintaan</td>
                    <td>
                        : <?php echo MyFormatter::formatDateTimeForUser($model->tglpengajuanhargaoa); ?> 
                    </td>
                </tr>
            </table>
        </td>
        <td width="50%">
            <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="200px">Keterangan Pengajuan</td>
                    <td>
                        : <?php echo $model->ketpengajuan; ?> 
                    </td>
                </tr>
                <tr>
                    <td>Pegawai yang Mengajukan</td>
                    <td>
                        :  <?php echo $model->pegawai->namaLengkap; ?> 
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<table width="100%" style='margin-left:auto; margin-right:auto;' class ="border">
    <thead class="border">
        <tr>
            <th rowspan="2" style="text-align: center">No.</th>
            <th rowspan="2" style="text-align: center">Jenis</th>
            <th rowspan="2" style="text-align: center">Nama Obat</th>
            <th rowspan="2" style="text-align: center">Satuan</th>
            <th colspan="6" style="text-align: center">Lama</th>
            <th colspan="6" style="text-align: center">Baru</th>
            <th rowspan="2" style="text-align: center">Alasan Perubahan</th>
        </tr>
        <tr>
            <th style="text-align: center">Harga Netto</th>
            <th style="text-align: center">Keringanan</th>
            <th style="text-align: center">PPN</th>
            <th style="text-align: center">HPP</th>
            <th style="text-align: center">Margin (%)</th>
            <th style="text-align: center">Harga Jual</th>

            <th style="text-align: center">Harga Netto</th>
            <th style="text-align: center">Keringanan</th>
            <th style="text-align: center">PPN</th>
            <th style="text-align: center">HPP</th>
            <th style="text-align: center">Margin (%)</th>
            <th style="text-align: center">Harga Jual</th>
        </tr>
    </thead>
        <?php 
        foreach ($modDetails as $i=>$modObat){ 
                $satuanobat = "";
                 if (!empty($modObat->satuanbesar_id)) {
                    $besar = SatuanbesarM::model()->findByPk($modObat->satuanbesar_id);
                    $satuanobat = $besar->satuanbesar_nama;
                } else if (!empty($modObat->satuankecil_id)) {
                    $kecil = SatuankecilM::model()->findByPk($modObat->satuankecil_id);
                    $satuanobat = $kecil->satuankecil_nama;
                }
        ?>
             <tr class="border">
                <td><?php echo ($i+1)."."; ?></td>
                <td><?php echo (isset($modObat->obatalkes->jenisobatalkes)? $modObat->obatalkes->jenisobatalkes->jenisobatalkes_nama :"-"); ?></td>
                <td><?php echo $modObat->obatalkes->obatalkes_nama; ?></td>
                <td><?php echo "1 ".$satuanobat; ?></td>
                <td><?php echo "Rp ".MyFormatter::formatNumberForPrint($modObat->harganettolama); ?></td>
                <td><?php echo "Rp ".MyFormatter::formatNumberForPrint($modObat->diskonlama); ?></td>
                <td><?php echo "Rp ".MyFormatter::formatNumberForPrint($modObat->ppnlama); ?></td>
                <td><?php echo "Rp ".MyFormatter::formatNumberForPrint($modObat->hpplama); ?></td>
                <td><?php echo MyFormatter::formatNumberForPrint($modObat->marginlama)."%"; ?></td>
                <td><?php echo "Rp ".MyFormatter::formatNumberForPrint($modObat->hargajuallama); ?></td>
                <td><?php echo "Rp ".MyFormatter::formatNumberForPrint($modObat->harganettobaru); ?></td>
                <td><?php echo "Rp ".MyFormatter::formatNumberForPrint($modObat->diskonbaru); ?></td>
                <td><?php echo "Rp ".MyFormatter::formatNumberForPrint($modObat->ppnbaru); ?></td>
                <td><?php echo "Rp ".MyFormatter::formatNumberForPrint($modObat->hppbaru); ?></td>
                <td><?php echo MyFormatter::formatNumberForPrint($modObat->marginbaru)."%"; ?></td>
                <td><?php echo "Rp ".MyFormatter::formatNumberForPrint($modObat->hargajualbaru); ?></td>
                <td><?php echo $modObat->alasanperubahan; ?></td>
            </tr>
        <?php } ?>
</table>
<br><br>
<?php if(!empty($model->tglmengetahui)){ ?>
<div class="row">
    <div class="col-sm-6" style="text-align:center;">
        <div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
            Mengetahui,<br> Manager Keuangan
        </div>
        <div class="control-group">
            ( <?php echo $model->pegawaimengetahui->NamaLengkap; ?> )
        </div>
    </div>
    <div class="col-sm-6" style="text-align:center;">
        <div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
            Menyetujui,<br> Direktur
        </div>
        <div class="control-group">
            ( <?php echo $model->pegawaimengetahui->NamaLengkap;?> )
        </div>
    </div>
</div>
<br><br>
<?php } ?>
<?php
if(!isset($_GET['caraPrint'])){
    $urlPrint= $this->createUrl('rincian',array('pengajuanhargaoa_id'=>$model->pengajuanhargaoa_id));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>

<?php
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
}
?>