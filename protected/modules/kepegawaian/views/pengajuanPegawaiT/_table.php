<?php
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$action = $this->getAction()->getId();
$currentUrl = Yii::app()->createUrl($module . '/' . $controller . '/' . $action);
?>

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'kpinfopengajuanpegawai-v-grid',
	'dataProvider'=>$model->searchInformasi(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(		
		array(
			'header'=>'Tanggal Pengajuan',
			'name'=>'tglpengajuan',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglpengajuan)',
		),
		array(
			'header'=>'No. Pengajuan',
			'name'=>'nopengajuan',
			'value'=>'$data->nopengajuan',
		),
		array(
			'header'=>'Yang Mengajukan',
			'name'=>'mengajukan_id',
			'value'=>'(!empty($data->id_pegmengajukan)?$data->namaLengkapMengajukan:"")',
		),
                array(
			'header'=>'Mengetahui',
                        'type'=>'raw',
			'name'=>'mengetahui_id',
			'value'=>'(!empty($data->id_pegmengetahui)?$data->namaLengkapMengetahui:"").
                        (isset($data->tgl_mengetahui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tgl_mengetahui) : 
                        (!isset($data->id_pegmengetahui)? "" :
                        (!isset($data->tgl_menyetujui) ? "" : CHtml::link("<icon class=\'icon-form-kontrakkarya\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ApproveMengetahui", array("pengajuanpegawai_id"=>$data->pengajuanpegawai_t_id,"frame"=>true)), array("target"=>"frameMengetahui","rel"=>"tooltip", "title"=>"Klik untuk Approve Mengetahui", "onclick"=>"$(\'#dialogMengetahui\').dialog(\'open\');")))
                        ))',
		),
                array(
			'header'=>'Menyetujui',
                         'type'=>'raw',
			'name'=>'mengetahui_id',
			'value'=>'(!empty($data->id_pegmenyetujui)?$data->namaLengkapMenyetujui:"").
                        (isset($data->tgl_menyetujui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tgl_menyetujui) : 
                        (isset($data->id_pegmenyetujui) ? CHtml::link("<icon class=\'icon-form-kontrakkarya\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ApproveMenyetujui", array("pengajuanpegawai_id"=>$data->pengajuanpegawai_t_id,"frame"=>true)), array("target"=>"frameMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk Approve Menyetujui", "onclick"=>"$(\'#dialogMenyetujui\').dialog(\'open\');")) : "")
                        )',
		),
                array(
                        'header' => 'Jml Orang',
                        'name' => 'jmlorang',
                        'value' => '$data->jmlorang',
                        'htmlOptions' => array('style'=>'text-align:right;')
                ),
                array(
                        'header' => 'Untuk Keperluan',  
                        'name' => 'untukkeperluan',
                        'value' => '$data->untukkeperluan'
                ),
                array(
                        'header' => 'Keterangan',  
                        'name' => 'keterangan',
                        'value' => '$data->keterangan'
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<!--Dialog untuk mengetahui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogMengetahui',
        'options' => array(
            'title' => 'Approvement Pegawai Mengetahui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'height' => 500,
            'resizable' => true,
			'close'=>"js:function(){ $.fn.yiiGridView.update('kpinfopengajuanpegawai-v-grid', {
					data: $(this).serialize()
				}); }",
        ),
));
?>
<iframe name='frameMengetahui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!--Dialog untuk menyetujui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogMenyetujui',
        'options' => array(
            'title' => 'Approvement Pegawai Menyetujui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'height' => 500,
            'resizable' => true,
			'close'=>"js:function(){ $.fn.yiiGridView.update('kpinfopengajuanpegawai-v-grid', {
					data: $(this).serialize()
				}); }",
        ),
));
?>
<iframe name='frameMenyetujui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>