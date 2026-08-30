<?php
	$modModul = new ModulK();
						if(isset($_GET['ModulK'])){
							$modModul->attributes = $_REQUEST['ModulK'];
						}
	$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'pencarian-modul-grid',
	'dataProvider'=>$modModul->searchModul(),
   	'filter'=>$modModul,
    'template'=>"{items}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			    array(
			        'value' => 'CHtml::link($data->modul_namalainnya, Yii::app()->createUrl("$data->url_modul",array("modul_id"=>$data->modul_id)))',
     				'type'  => 'raw',
     				'headerHtmlOptions' => array('style' => 'display:none'),
			        'filter'=> CHtml::activeTextField($modModul, 'modul_namalainnya',array('placeholder'=>'Cari Nama Modul')),
			    ),
	        ),
	));
	?>