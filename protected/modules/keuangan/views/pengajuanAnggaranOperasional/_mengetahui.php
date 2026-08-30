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
<?php
$judulLaporan = "Pengajuan Anggaran Operasional";
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
$format = new MyFormatter;
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>6));
if(isset($_GET['sukses'])){
	Yii::app()->user->setFlash('success',"Status Mengetahui berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>

<table style="width:100%">
    <tr>
        <td width="50%">
            <table style="width:100%">
                <tr>
                    <td width="120px">Tgl. Pengajuan</td>
                    <td width="10px">:</td>
                    <td>
                        <?php echo MyFormatter::formatDateTimeForUser($model->pengajuanpetty_tgl); ?>
                    </td>
                </tr>
                <tr>
                    <td width="120px">No. Pengajuan</td>
                    <td width="10px">:</td>
                    <td>
                        <?php echo $model->pengajuanpetty_no; ?>
                    </td>
                </tr>
                <tr>
                    <td width="120px">Kategori</td>
                    <td width="10px">:</td>
                    <td>
                        <?php echo ucwords(strtolower($model->pengajuanpetty_kategori)); ?>
                    </td>
                </tr>
                <tr>
                    <td width="120px">Alasan Pengajuan</td>
                    <td width="10px">:</td>
                    <td>
                        <?php echo $model->pengajuanpetty_untuk; ?>
                    </td>
                </tr>
            </table>
        </td>
        <td width="50%">
            <table style="width:100%">
                <tr>
                     <td width="170px">Pegawai Yang Mengajuan</td>
                    <td width="10px">:</td>
                    <td>
                        <?php echo (isset($model->pegawai)? $model->pegawai->namaLengkap: ""); ?>
                    </td>
                </tr>
                <tr>
                     <td width="120px">NIP</td>
                    <td width="10px">:</td>
                    <td>
                        <?php echo (isset($model->pegawai)? $model->pegawai->nomorindukpegawai: ""); ?>
                    </td>
                </tr>
                <tr>
                     <td width="120px">Unit Kerja</td>
                    <td width="10px">:</td>
                    <td>
                        <?php echo (isset($model->pegawai)? (isset($model->pegawai->unitkerja)? $model->pegawai->unitkerja->namaunitkerja: ""): ""); ?>
                    </td>
                </tr>
                <tr>
                     <td width="120px">Jabatan</td>
                    <td width="10px">:</td>
                    <td>
                        <?php echo (isset($model->pegawai)? (isset($model->pegawai->jabatan)? $model->pegawai->jabatan->jabatan_nama: ""): ""); ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br><br>

<table width="100%" style='margin-left:auto; margin-right:auto;' class ="border">
    <thead class="border">
        <tr>
            <td style="text-align:center; width: 10px">No</td>
            <td style="text-align:center;">Nama Pengajuan Anggaran</td>
            <td style="text-align:center; width: 100px">Jumlah</td>
            <td style="text-align:center; width: 150px">Harga Satuan</td>
            <td style="text-align:center; width: 150px">Subtotal</td>
            <td style="text-align:center;">Keterangan</td>
        </tr>
    </thead>
    <tbody>
            <?php
                    $i = 1;
                if(count((array)$modDet) > 0){
                    foreach ($modDet as $dt){
            ?>
                    <tr class="border">
                            <td><?php echo $i; ?></td>
                            <td><?php echo $dt->pengajuanpettydet_item; ?></td>
                            <td><?php echo $dt->pengajuanpettydet_qty; ?></td>
                            <td style="text-align:right;">Rp <?php echo number_format($dt->pengajuanpettydet_hargasatuan,0,"","."); ?></td>
                            <td style="text-align:right;">Rp <?php echo number_format($dt->pengajuanpettydet_subtotal,0,"","."); ?></td>
                            <td><?php echo $dt->pengajuanpettydet_keterangan; ?></td>
                    </tr>
            <?php

                    $i++;
                    }
                }
            ?>
    </tbody>
    <tfoot>
            <th colspan="4" style="text-align: right;">Total</th>
            <th  style="text-align:right;">

                    Rp <?php echo number_format($model->pengajuanpetty_total,0,"","."); ?>

            </th>
            <th>&nbsp;</th>
    </tfoot>
</table>
<div class="row">
    <div class="col-sm-4" style="text-align:center;">
        <?php
            if(isset($_GET['sukses'])){
                    echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
                    echo "Pegawai Mengetahui, ";
            }else{
                    echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
                    echo CHtml::link(Yii::t('mds',' Mengetahui'),
                    $this->createUrl($this->id.'/index'),
                    array('class' => 'btn btn-danger',
                            'onclick'=>'myConfirm("Apakah Anda yakin?","Perhatian!",
                            function(r) {if(r) window.location = "'.$this->createUrl('Mengetahui',array('pengajuanpetty_id'=>$model->pengajuanpetty_id,'approve'=>true)).'";} ); return false;'));
            }
        ?>
    </div>
    <div class="control-group">
            ( <?php echo $model->atasan->NamaLengkap;?> )
    </div>
    </div>
    <div class="col-sm-4" style="text-align:center;">
    </div>
    <div class="col-sm-4" style="text-align:center;">
    </div>
</div>
