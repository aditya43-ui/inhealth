
<?php 
$caraPrint = null;
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
    $template = "{items}";
}
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');   
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));
$format = new MyFormatter;
?>

<table style="width: 100%; border: none;">
    <tr><td colspan="2" style="text-align: center; font-weight: bold; text-decoration: underline;">BUKTI PEMBAYARAN JASA DOKTER</td></tr>
    <tr><td>Nama Dokter</td><td>: <?php echo empty($model->rujukandari_id) ? $model->pegawai->NamaLengkap : $model->rujukandari->namaperujuk; ?></td></tr>
    <tr><td>Periode</td><td>: <?php echo $format->formatDateTimeId($model->periodejasa)." s.d ".$format->formatDateTimeId($model->sampaidgn); ?></td></tr>
</table>
<?php
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$modDetail->searchPrint(),
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
                    'header'=>'No.',
                    'value'=>'$row+1',
                ),
                array(
                    'header'=>'No. Pendaftaran/<br>No. RM',
                    'type'=>'raw',
                    'value'=>'$data->pendaftaran->no_pendaftaran ."/<br>". $data->pasien->no_rekam_medik',
                ),
                array(
                    'header'=>'No. Penunjang',
                    'type'=>'raw',
                    'value'=>'empty($data->pasienmasukpenunjang_id) ? "<p style=\"margin: 0; text-align: center;\">-</p>" : $data->pasienmasukpenunjang->no_masukpenunjang ."<br>". $data->pasien->no_rekam_medik',
                ),
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->pasien->nama_pasien',
                ),
                array(
                    'header'=>'Alamat Pasien',
                    'type'=>'raw',
                    'value'=>'$data->pasien->alamat_pasien',
                ),
                array(
                    'header'=>'Jenis Penjamin / Penjamin',
                    'type'=>'raw',
                    'value'=>'$data->pendaftaran->carabayar->carabayar_nama ."/<br>". $data->pendaftaran->penjamin->penjamin_nama',
                ),
                array(
                    'header'=>'Jumlah Tarif',
                    'type'=>'raw',
                    'value'=>'"<div style=\"text-align:right;\">".number_format($data->jumahtarif)."</div>"',
                ),
                array(
                    'header'=>'Jumlah Jasa',
                    'type'=>'raw',
                    'value'=>'"<div style=\"text-align:right;\">".number_format($data->jumlahjasa)."</div>"',
                ),
                array(
                    'header'=>'Jumlah Bayar',
                    'type'=>'raw',
                    'value'=>'"<div style=\"text-align:right;\">".number_format($data->jumlahbayar)."</div>"',
                ),
                array(
                    'header'=>'Sisa Jasa',
                    'type'=>'raw',
                    'value'=>'"<div style=\"text-align:right;\">".number_format($data->sisajasa)."</div>"',
                ),
        ),
    )); 
?>

<?php if(isset($_GET['caraPrint'])){?>
    
    <table width="100%" style="font-weight: bold">
        <tr>
            <td style="font-weight: normal; text-align: center;"><?php echo ProfilrumahsakitM::model()->findByPk(Yii::app()->user->getState('profilrs_id'))->kabupaten->kabupaten_nama?>, <?php echo $format->formatDateTimeId(date('Y-m-d'))?></td>
        </tr>
        <tr>
            <td></td>
            <td>Total Tarif</td>
            <td>: <?php echo number_format($model->totaltarif)?></td>
        </tr>
        <tr>
            <td></td>
            <td>Total Jasa</td>
            <td>: <?php echo number_format($model->totaljasa)?></td>
        </tr>
        <tr>
            <td></td>
            <td>Total Bayar Jasa</td>
            <td>: <?php echo number_format($model->totalbayarjasa)?></td>
        </tr>
        <tr>
            <td></td>
            <td>Total Sisa Jasa</td>
            <td>: <?php echo number_format($model->totalsisajasa)?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;text-align: center;"><?php echo empty($model->rujukandari_id) ? $model->pegawai->NamaLengkap : $model->rujukandari->namaperujuk; ?></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <?php }?>
<?php  
if(isset($frame)){
    echo CHtml::link(
        Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 
        "#", 
        array(
            'class'=>'btn btn-info',
            'onclick'=>"printDetail('PRINT'); return false",
        )
    ); ?>
    <script>
    function printDetail(caraPrint) 
    {
        window.open('<?php echo $this->createUrl('Print', array('id'=>$model->pembayaranjasa_id)); ?>'+'&caraPrint=' + caraPrint,'printwin','left=100,top=100,width=980,height=400,scrollbars=1');
    }
    </script>
<?php } ?>