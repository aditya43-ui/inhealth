
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan));      

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'jadwaldokter_id',
		array(
                        'name'=>'jadwaldokter_id',
                        'value'=>'$data->jadwaldokter_id',
                        'filter'=>false,
                ),
//		array(
//                        'name'=>'instalasi_id',
//                        'filter'=>  CHtml::listData(RuanganM::model()->InstalasiItems, 'instalasi_id', 'instalasi_nama'),
//                        'value'=>'$data->instalasi->instalasi_nama',
//                ),
		array(
                        'name'=>'ruangan_id',
                        'filter'=>  CHtml::listData(PPPendaftaranT::model()->getRuanganItems(), 'ruangan_id', 'ruangan_nama'),
                        'value'=>'$data->ruangan->ruangan_nama',
                ),
		array(
                        'name'=>'pegawai_id',
                        'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
                        'value'=>'$data->pegawai->nama_pegawai',
                ),
		'jadwaldokter_hari',
                array(
                        'header'=>'Tanggal',
                        'name'=>'jadwaldokter_tgl',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->jadwaldokter_tgl)',
                        'filter'=>  CHtml::dropDownList('PPJadwaldokterM[bulan]', $model->bulan, Params::getBulan(), array('empty'=>'-- Pilih --')),
                    ),                    
		'jadwaldokter_buka',
 
        ),
    )); 
?>

<div class="">
</div><?php 
if($caraPrint!='PDF')
{ ?>
<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
<?php } ?>