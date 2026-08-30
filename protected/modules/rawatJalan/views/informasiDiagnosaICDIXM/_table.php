<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'sadiagnosa-icdixm-grid',
	'dataProvider' => $model->search(),
	//'filter'=>$model,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-bordered table-striped table-condensed',
	'columns' => array(
		////'diagnosaicdix_id',
		array(
			'name' => 'diagnosaicdix_id',
			'value' => '$data->diagnosaicdix_id',
			'filter' => false,
		),
		'diagnosaicdix_nourut',
		'diagnosaicdix_kode',
		'diagnosaicdix_nama',
		'diagnosaicdix_namalainnya',
		'diagnosatindakan_katakunci',
		/*
		'diagnosaicdix_aktif',
		*/
		//		array(
		//                        'header'=>Yii::t('zii','View'),
		//			'class'=>'bootstrap.widgets.BootButtonColumn',
		//                        'template'=>'{view}',
		//		),
		//		array(
		//                        'header'=>Yii::t('zii','Update'),
		//			'class'=>'bootstrap.widgets.BootButtonColumn',
		//                        'template'=>'{update}',
		//                        'buttons'=>array(
		//                            'update' => array (
		//                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
		//                                        ),
		//                         ),
		//		),
		//		array(
		//                        'header'=>Yii::t('zii','Delete'),
		//			'class'=>'bootstrap.widgets.BootButtonColumn',
		//                        'template'=>'{remove} {delete}',
		//                        'buttons'=>array(
		//                                        'remove' => array (
		//                                                'label'=>"<i class='icon-form-silang'></i>",
		//                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
		//                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->diagnosaicdix_id"))',
		//                                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
		//                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
		//                                        ),
		//                                        'delete'=> array(
		//                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
		//                                        ),
		//                        )
		//),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
