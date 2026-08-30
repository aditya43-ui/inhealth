<?php
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftarTindakan-grid',
	'dataProvider'=>$modTarifTindakanRuanganV->searchInformasi(),        
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
		'jenistarif_nama',
		'kelompoktindakan_nama',
        'komponenunit_nama',
		'kategoritindakan_nama',
        'kelaspelayanan_nama',
		'daftartindakan_nama',		
		array(
			'header'=>'Tarif Total',
			'value'=>'$this->grid->getOwner()->renderPartial(\'rawatJalan.views.informasiTarif._tarifTotal\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id,\'daftartindakan_id\'=>$data->daftartindakan_id, \'jenistarif_id\'=>$data->jenistarif_id),true)',
				'htmlOptions'=>array('style'=>'text-align: right'),
        ),
        array(
			'name'=>'persencyto_tind',
            'htmlOptions'=>array('style'=>'text-align: right'),
		), array(
			'name'=>'persendiskon_tind',
            'htmlOptions'=>array('style'=>'text-align: right'),
        ),
		//'persencyto_tind',
		array(
			'header'=>'Komponen Tarif',
			'type'=>'raw',
			'value'=>'CHtml::link("<i class=\'icon-form-komtarif\'></i> ",Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/detailsTarif",array("kelaspelayanan_id"=>$data->kelaspelayanan_id,"daftartindakan_id"=>$data->daftartindakan_id, "kategoritindakan_id"=>$data->kategoritindakan_id, "jenistarif_id"=>$data->jenistarif_id)) ,array("title"=>"Klik untuk Melihat Detail Tarif","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsTarif\").dialog(\"open\");", "rel"=>"tooltip"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
		),               
	),
	'afterAjaxUpdate'=>'function(id, data){
		jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
		$("table").find("input[type=text]").each(function(){
			cekForm(this);
		})
		$("table").find("select").each(function(){
			cekForm(this);
		})
	}',
));
?>