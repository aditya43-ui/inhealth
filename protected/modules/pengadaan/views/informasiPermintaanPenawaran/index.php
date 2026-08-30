<?php
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
        $('#permintaan-m-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('permintaan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Permintaan Penawaran</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Permintaan Penawaran</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Permintaan Penawaran</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scrollr">
						<div class="block-tabel">
							<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
								'id'=>'permintaan-m-grid',
								'dataProvider'=>$model->searchInformasi(),
								'template'=>"{summary}\n{items}\n{pager}",
								'itemsCssClass'=>'table table-bordered table-striped table-condensed',
								'columns'=>array(
									array(
										'name'=>'tglpenawaran',
										'type'=>'raw',
										'value'=>'MyFormatter::formatDateTimeForUser($data->tglpenawaran)',
									),
									'nosuratpenawaran',
									'supplier_nama',
									array(
										'header'=>'Pegawai Mengetahui',
										'type'=>'raw',
										'value'=>'(isset($data->pegawaimengetahui_id)? $data->PegawaimengetahuiLengkap : "-").
										(isset($data->tglmengetahui) ? "<br>".MyFormatter::formatDateTimeId($data->tglmengetahui) : 
										(!isset($data->pegawaimengetahui_id)? "" :
										(!isset($data->tglmenyetujui) ? "" : CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Mengetahui", array("permintaanpenawaran_id"=>$data->permintaanpenawaran_id,"frame"=>true)), array("target"=>"frameMengetahui","rel"=>"tooltip", "title"=>"Klik untuk approvement mengetahui", "onclick"=>"$(\'#dialogMengetahui\').dialog(\'open\');")))
										))',
									),
									array(
											'header'=>'Pegawai Menyetujui',
											'type'=>'raw',
											'value'=>'(isset($data->pegawaimenyetujui_id)? $data->PegawaimenyetujuiLengkap : "-").
													(isset($data->tglmenyetujui) ? 
													"<br>".MyFormatter::formatDateTimeId($data->tglmenyetujui) : 
														((isset($data->pegawaimenyetujui_id))&&(isset($data->pegawaimengetahui_id)) ? 
															(($data->statuspenawaran != "DITOLAK")?
																CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Menyetujui", array("permintaanpenawaran_id"=>$data->permintaanpenawaran_id,"frame"=>true)), array("target"=>"frameMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk approvement menyetujui", "onclick"=>"$(\'#dialogMenyetujui\').dialog(\'open\');")) : 
																"<a rel=\'tooltip\' title=\'Rencana ini sudah ditolak\'><icon class=\'icon-form-check\' style=\'opacity: 0.3\'></icon></a> "
															)
															:
																"<a rel=\'tooltip\' title=\'Tombol akan aktif jika data memiliki nama mengetahui dan menyetujui\'><icon class=\'icon-form-check\' style=\'opacity: 0.3\'></icon></a> "
														)
											)',
									),
									'statuspenawaran',
									array(
										'name'=>'ispenawaranmasuk',
										'type'=>'raw',
										'value'=>'($data->ispenawaranmasuk == TRUE)?"Masuk":"Keluar"',
									),
									array(
										'header'=>'Ubah Rencana',
										'type'=>'raw',
										'value'=>'(isset($data->tglmenyetujui))?
														"<a rel=\'tooltip\' title=\'Tidak dapat diubah karena sudah disetujui oleh pegawai menyetujui\'><icon class=\'icon-form-ubah\' style=\'opacity: 0.3\'></icon></a> "
													:
														(($data->statuspenawaran != "DITOLAK")?
															CHtml::link("<icon class=\'icon-form-ubah\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.$this->path_penawaran.'/index", array("permintaanpenawaran_id"=>$data->permintaanpenawaran_id,"ubah"=>true)), array("target"=>"BLANK","rel"=>"tooltip", "title"=>"Klik untuk mengubah data"))
														:
															"<a rel=\'tooltip\' title=\'Tidak dapat diubah karena sudah ditolak\'><icon class=\'icon-form-ubah\' style=\'opacity: 0.3\'></icon></a> "
														)
													',
                                'htmlOptions' => array('style' => 'text-align:center;'),
                            ),
                            array(
                                'header' => 'Permintaan Pembelian',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $cek = GFPermintaanPembelianT::model()->find('permintaanpenawaran_id = ' . $data->permintaanpenawaran_id);
                                    if ((isset($data->tglmenyetujui)) && (isset($data->tglmengetahui))) {
                                        if (!empty($cek)) {
                                            return CHtml::Link("<i class='icon-form-mintabeli'></i>", '', array('disabled' => true, 'style' => 'opacity: 0.3', "class" => "", "rel" => "tooltip", "title" => "Permintaan Penawaran Sudah " . $cek->statuspembelian));
                                        } else {
                                            return   CHtml::Link("<i class='icon-form-mintabeli'></i>", $this->createUrl($this->path_permintaan . $this->suffix . "/Index") . '&penawaran_id=' . $data->permintaanpenawaran_id, array("class" => "", "rel" => "tooltip", "title" => "Klik Mendaftarkan Ke Permintaan Pembelian"));
                                        }
                                    } else {
                                        return   CHtml::Link("<i class='icon-form-mintabeli'></i>", '', array('disabled' => true, 'style' => 'opacity: 0.3', "class" => "", "rel" => "tooltip", "title" => "Tombol akan aktif jika permintaan sudah disetujui dan diketahui"));
                                    }
                                },
                                'htmlOptions' => array('style' => 'text-align:center;'),
                            ),
                            array(
                                'header' => 'Rincian',
                                'type' => 'raw',
                                'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Rincian", array("permintaanpenawaran_id"=>$data->permintaanpenawaran_id)),
													 array("class"=>"", 
														   "target"=>"permintaan",
														   "onclick"=>"$(\"#dialogPermintaan\").dialog(\"open\");",
														   "rel"=>"tooltip",
														   "title"=>"Klik untuk melihat rincian permintaan penawaran",
													 ))',
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogPermintaan',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Rincian Permintaan Penawaran',
                        'autoOpen'=>false,
                        'minWidth'=>900,
                        'minHeight'=>100,
                        'resizable'=>false,
                         ),
                    ));
?>
<iframe src="" name="permintaan" width="100%" height="500">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>
<!--Dialog untuk mengetahui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMengetahui',
    'options' => array(
        'title' => 'Approvement Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('permintaan-m-grid', {
					data: $(this).serialize()
				}); }",
        ),
));
?>
<iframe name='frameMengetahui' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
<!-- Dialog untuk menyetujui -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogMenyetujui',
        'options' => array(
            'title' => 'Approvement Pegawai Menyetujui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'height' => 600,
            'resizable' => false,
			'close'=>"js:function(){ $.fn.yiiGridView.update('permintaan-m-grid', {
					data: $(this).serialize()
				}); }",
        ),
));
?>
<iframe name='frameMenyetujui' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>