<?php
$itemCssClass='table table-striped table-bordered table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)){
$data = $model->searchPrint();
$template = "{items}";
$sort = false;
if ($caraPrint == "EXCEL"){
$table = 'ext.bootstrap.widgets.BootExcelGridView';
}if ($caraPrint == "PDF"){
$itemCssClass='table border';
}
} else{
$data = $model->searchPrint();
$template = "{summary}\n{items}\n{pager}";
}

$this->widget($table,array(
'id'=>'sajenis-kelas-m-grid',
'enableSorting'=>false,
'dataProvider'=>$data,
'template'=>$template,
'enableSorting'=>$sort,
'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
		////'barang_id',
		 array(
                    'header' => 'No.',
                    'value' => '$row+1',
                    ),

//		 array(
//                        'name'=>'subsubkelompok_id',
//                        'filter'=> CHtml::activeDropDownList($model, 'subsubkelompok_id',CHtml::listData($model->SubSubKelompokItems, 'subsubkelompok_id', 'subsubkelompok_nama'),array('empty'=>'-- Pilih --')),
//                        'value'=>function($data) {
//                            $sub = SubsubkelompokM::model()->findByPk($data->subsubkelompok_id);
//                            return isset($sub->subsubkelompok_nama)?$sub->subsubkelompok_nama:null;
//                        }
//                    ),
		array(
			'name'=>'barang_type',
			'value'=>'$data->barang_type',
			'filter'=>CHtml::activeTextField($model, 'barang_type'),
		),
		'barang_kode',
		'barang_nama',
		'barang_namalainnya',
		 array(
			'header' => 'Status',
			'value'=>'($data->barang_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
			'htmlOptions'=>array('style'=>'text-align:center;'),
		),
		
 
        ),
    ));
                    
                    
 ?>