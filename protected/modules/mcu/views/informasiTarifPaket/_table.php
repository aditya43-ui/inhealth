<?php
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftarTindakan-grid',
	'dataProvider'=>$modTarifTindakanRuanganV->searchInformasi(),        
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
        'tipepaket_nama',
        'kelaspelayanan_nama',
        'carabayar_nama',
        'penjamin_nama',
        array(
            'name'=>'tarifpaket',
            'header'=>'Tarif Paket<br>(Rp)',
            'value'=>'MyFormatter::formatNumberForPrint($data->tarifpaket)',
            'htmlOptions'=>array(
                'style'=>'text-align: right',
            )
        ),
        array(
            'name'=>'paketsubsidiasuransi',
            'header'=>'Tanggungan Asuransi Paket<br>(Rp)',
            'value'=>'MyFormatter::formatNumberForPrint($data->paketsubsidiasuransi)',
            'htmlOptions'=>array(
                'style'=>'text-align: right',
            )
        ),
        array(
            'name'=>'paketiurbiaya',
            'header'=>'Iur Biaya<br>(Rp)',
            'value'=>'MyFormatter::formatNumberForPrint($data->paketiurbiaya)',
            'htmlOptions'=>array(
                'style'=>'text-align: right',
            )
        ),
        array(
			'header'=>'Paket Pelayanan',
			'type'=>'raw',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
			'value'=>'CHtml::link("<i class=\'icon-form-lihat\'></i> ",Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/detailsTarif",array("tipepaket_id"=>$data->tipepaket_id)) ,array("title"=>"Lihat Detail Tarif Paket","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsTarif\").dialog(\"open\");", "rel"=>"tooltip"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
		),        
	),
	'afterAjaxUpdate'=>'function(id, data){
		jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
	}',
));
