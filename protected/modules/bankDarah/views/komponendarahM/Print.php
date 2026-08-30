
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

if($caraPrint!="PDF"){
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
}
$this->widget($table,array(
	'id'=>'komponendarah-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchKomponenDarah(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                    array(
                        'header'=>'No.',
                        'value' => '$row+1',
                    ),
//                    'komponendarah_id',
                    'namakomponendrh',
                    'singkatan_komp',
                    'jeniskantongdarah.nama_jenis',
                    array(
                      'header'=>'Nominal Tarif',
                      'value'=>function($data){
                            $tarif = TariftindakanperdatotalV::model()->findByAttributes(array('daftartindakan_id'=>$data->daftartindakan->daftartindakan_id));
                            echo 'Rp '.MyFormatter::formatNumberForPrint($tarif->harga_tariftindakan);

                      },
                    ),       
                    array(
                          'name'=>'komponendarah_aktif',
                          'value'=>'(($data->komponendarah_aktif == 1) ? "Ya" : "Tidak")',
                          'filter'=>CHtml::activeDropDownList($model, 'komponendarah_aktif', array(1=>'Ya', 0=>'Tidak'), array('empty'=>'-- Pilih --',)),
                          'htmlOptions'=>array('style'=>'text-align:left;'),
                    ),
	),
)); 
?>