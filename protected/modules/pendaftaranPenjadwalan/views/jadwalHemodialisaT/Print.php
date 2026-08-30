
<?php 
//if($caraPrint=='EXCEL')
//{
//    header('Content-Type: application/vnd.ms-excel');
//    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
//    header('Cache-Control: max-age=0');     
//}
if(@$caraPrint=='PRINT'){
	echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      
}
$this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
	'id'=>'sajenis-kelas-m-grid',
    'enableSorting'=>false,
	'dataProvider'=>$model->searchPrintJadwalHD($totalData),
    'template'=>"{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'mergeColumns'=>array('jadwalhemodialisa_hari', 'jadwalhemodialisa_tgl_ke', 'shift_id'),
	'columns'=>array(
				array(
                       'header'=>'Hari',
						'name'=>'jadwalhemodialisa_hari',
                       'type'=>'raw',
                       'value'=>'$data->jadwalhemodialisa_hari',
                    ),    
				array(
                       'header'=>'Tanggal',
						'name'=>'jadwalhemodialisa_tgl_ke',
                       'type'=>'raw',
                       'value'=>'MyFormatter::formatDateTimeForUser($data->jadwalhemodialisa_tgl_ke)',
                    ),
				array(
                       'header'=>'Shift',
						'name'=>'shift_id',
                       'type'=>'raw',
                       'value'=>'$data->shift->shift_nama',
                    ),
                 array(
                       'header'=>'Ruangan',
						'name'=>'ruangan_id',
                       'type'=>'raw',
                       'value'=>'$data->getNamaRuangan()',
                    ),
				 array(
                       'header'=>'No R.M',
                       'type'=>'raw',
                       'value'=>'$data->pasienrl->no_rekam_medik',
                    ),
				array(
                       'header'=>'Nama Pasien',
                       'type'=>'raw',
                       'value'=>'$data->pasienrl->nama_pasien',
                    ),
				array(
                       'header'=>'Jenis Kelamin',
                       'type'=>'raw',
                       'value'=>'$data->pasienrl->jeniskelamin',
                    ),

        ),
    )); 
?>