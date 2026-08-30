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
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
$format = new MyFormatter;
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judul_print, 'colspan'=>10));
?>

<table class="" width="100%">
    <tr>
        <td width="50%">
            <table class="" style="width:100%">
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
            <table class="" style="width:100%">
                <tr>
                     <td width="200px">Pegawai Yang Mengajuan</td>
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
<?php
if($model->pengajuanpetty_status == Params::STATUS_PETTY_CASH_DISETUJUI){
?>
<div class="row">
    <div class="col-sm-4" style="text-align:center;">
        <div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
                Pegawai Mengetahui,
        </div>
        <div class="control-group">
            ( <?php echo $model->atasan->NamaLengkap;?> )
        </div>
    </div>
    <div class="col-sm-4" style="text-align:center;">
    </div>
    <div class="col-sm-4" style="text-align:center;">
        <div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
                Pegawai Menyetujui,
        </div>
        <div class="control-group">
            ( <?php echo $model->direktur->NamaLengkap;?> )
        </div>
    </div>
</div>
<?php
}
?>

<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
