<?php
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftarTindakan-grid',
	'dataProvider'=>$modTarifTindakanRuanganV->searchInformasiMcu(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
		'kelompoktindakan_nama',
		'kategoritindakan_nama',
		'daftartindakan_nama',
		'kelaspelayanan_nama',
		array(
			'name'=>'tarifTotal',
			'value'=>'$this->grid->getOwner()->renderPartial(\'rawatJalan.views.informasiTarif._tarifTotal\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id,\'daftartindakan_id\'=>$data->daftartindakan_id),true)',
		),
		'persencyto_tind',
		'persendiskon_tind',
		array(
			'name'=>'Komponen Tarif',
			'type'=>'raw',
			'value'=>'CHtml::link("<i class=\'icon-form-komtarif\'></i> ",Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/detailsTarif",array("kelaspelayanan_id"=>$data->kelaspelayanan_id,"daftartindakan_id"=>$data->daftartindakan_id, "kategoritindakan_id"=>$data->kategoritindakan_id)) ,array("title"=>"Klik untuk Melihat Detail Tarif","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsTarif\").dialog(\"open\");", "rel"=>"tooltip"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
		),                
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
?>