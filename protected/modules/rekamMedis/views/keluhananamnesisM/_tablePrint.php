<?php

$table = 'ext.bootstrap.widgets.BootGridView';                        
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
        'template'=>"{items}",
        'itemsCssClass'=>'table border',
	'columns'=>array(
		////'keluhananamnesis_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->keluhananamnesis_id',
                ),
		'keluhananamnesis_nama',
 
        ),
    )); 
?>

