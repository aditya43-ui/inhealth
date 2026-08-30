
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

echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>'6'));  

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
		'petunjuktransaksi_type',
		'petunjuktransaksi_nama',
		'petunjuktransaksi_deskripsi',
		array(
                            'header' => 'Gambar',
                            'htmlOptions' => array('style' => 'text-align:center; width: 20%'),
                            'value' => function($data) {
                                $img = "";
                                if (empty($data->petunjuktransaksi_image)) {
                                    $img = "";
                                } else {
                                    if (file_exists(Params::pathPetunjukTransaksiDirectory() . $data->petunjuktransaksi_image)) {
                                        $img = Params::urlPetunjukTransaksiDirectory() . $data->petunjuktransaksi_image;
                                    } else {
                                        $img = Params::urlPetunjukTransaksiDirectory() . "no_photo.jpeg";
                                    }
                                }
                                echo '<img src="' . $img . '" height="200" width="200">';
                            }
                        ),
		'petunjuktransaksi_urutan',
                array(
                    'header' => 'Aktif',
                    'value'=>'($data->petunjuktransaksi_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',

                ),
 
	),
)); 
?>