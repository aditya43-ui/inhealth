<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
			'action'=>Yii::app()->createUrl($this->route),
            'id'=>'inforencanapen-form',
            'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'focus'=>'#'.CHtml::activeId($model,'noren_penerimaan'),
                    'method'=>'get',
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    ));
    Yii::app()->clientScript->registerScript('cariPasien', "
    $('#inforencanapen-form').submit(function(){
            $.fn.yiiGridView.update('inforencanggpen-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");?>
<div class="white-container">
<legend class="rim2">Informasi <b>Rencana Anggaran Penerimaan</b></legend>
<?php 
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Data berhasil disimpan!");
}

$this->widget('bootstrap.widgets.BootAlert'); 
?>
    <div class="block-tabel">
        <h6>Tabel <b>Rencana Anggaran Penerimaan</b></h6>
        <div class="table-condensed">
        <?php
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id'=>'inforencanggpen-grid',
                'dataProvider'=>$model->searchInformasiRencAnggPen(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
							array(
								'header'=>'No.',
								'value' => '($this->grid->dataProvider->pagination) ? 
										($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
										: ($row+1)',
								'type'=>'raw',
								'htmlOptions'=>array('style'=>'text-align:left; width:5px;'),
							),
							array(
								'name'=>'Nomor Penerimaan',
								'type'=>'raw',
								'value'=>'$data->noren_penerimaan',
							),
							array(
								'header'=>'Tahun Periode',
								'type'=>'raw',
								'name'=>'konfiganggaran_id',
								'value'=>'$data->konfiganggaran->deskripsiperiode',
							),
							array(
								'header'=>'Sumber Anggaran',
								'type'=>'raw',
								'name'=>'sumberanggaran_id',
								'value'=>'$data->sumberanggaran->sumberanggarannama',
							),
							array(
								'header'=>'Pegawai Mengetahui',
								'type'=>'raw',
								'value'=>'(isset($data->renpen_mengetahui_id)? $data->mengetahui->nama_pegawai : "-").
								(isset($data->renpen_tglmengetahui) ? "<br>".MyFormatter::formatDateTimeForUser($data->renpen_tglmengetahui) : 
								(!isset($data->renpen_mengetahui_id)? "" :
								(!isset($data->renpen_tglmenyetujui) ? "" : CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Mengetahui", array("renanggpenerimaan_id"=>$data->renanggpenerimaan_id,"frame"=>true)), array("target"=>"frameMengetahui","rel"=>"tooltip", "title"=>"Klik untuk mengetahui", "onclick"=>"$(\'#dialogMengetahui\').dialog(\'open\');")))
								))',
							),
							array(
								'header'=>'Pegawai Menyetujui',
								'type'=>'raw',
								'value'=>'(isset($data->renpen_menyetujui_id)? $data->menyetujui->nama_pegawai : "-").
								(isset($data->renpen_tglmenyetujui) ? "<br>".MyFormatter::formatDateTimeForUser($data->renpen_tglmenyetujui) : 
								(isset($data->renpen_menyetujui_id) ? CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Menyetujui", array("renanggpenerimaan_id"=>$data->renanggpenerimaan_id,"frame"=>true)), array("target"=>"frameMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk menyetujui", "onclick"=>"$(\'#dialogMenyetujui\').dialog(\'open\');")) : "")
								)',
							),
							array(
								'header'=>'Rincian',
								'type'=>'raw',
								'value'=>'CHtml::link("<icon class=\'icon-form-detail\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Rincian", array("renanggpenerimaan_id"=>$data->renanggpenerimaan_id,"frame"=>true)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"Klik untuk rincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))',
								'htmlOptions'=>array('style'=>'text-align: left;'),
							),
							array(
								'header'=>'Ubah',
								'type'=>'raw',
								'value'=>'(!isset($data->renpen_tglmengetahui) ? CHtml::link("<icon class=\'icon-form-ubah\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/UbahAnggaran", array("renanggpenerimaan_id"=>$data->renanggpenerimaan_id,"frame"=>true)), array("rel"=>"tooltip", "title"=>"Klik untuk ubah anggaran")) : "<span><icon class=\'icon-form-ubah\'></icon></span>")',
								'htmlOptions'=>array('style'=>'text-align: left;'),
							),
							array(
								'header'=>'Approval',
								'type'=>'raw',
								'value'=>'(!isset($data->renpen_tglmengetahui) ? "<span><icon class=\'icon-form-check\'></icon></span>" :
								(($data->IsApprove) ?  "Sudah diapprove " : CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Approval", array("renanggpenerimaan_id"=>$data->renanggpenerimaan_id,"frame"=>true)), array("rel"=>"tooltip", "title"=>"Klik untuk approval"))
								))',
								'htmlOptions'=>array('style'=>'text-align: left;'),
							),
                    ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            ));
        ?>
        </div>
    </div>
	<fieldset class="box">
        <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
        <div class="row">
			<div class="col-sm-4">
				<?php echo $form->textFieldRow($model,'noren_penerimaan',array('class'=>'span3 numberOnly','onkeypress'=>"return $(this).focusNextInputField(event)", 'placeholder'=>'No. pengeluaran')); ?>
            </div>
			<div class="col-sm-4">
				<div class="control-group">
				<?php echo $form->labelEx($model,'Periode Anggaran', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->dropDownList($model, 'konfiganggaran_id', CHtml::listData(AGKonfiganggaranK::model()->findAll(), 'konfiganggaran_id', 'deskripsiperiode'), array('empty'=>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'periodeAnggaran();')); ?>
						<?php echo CHtml::hiddenField('konfiganggaran_id','',array('class'=>'span2 integer','style'=>'width:90px;','readonly'=>true))?>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="control-group">
				<?php echo $form->labelEx($model,'Sumber Anggaran', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->dropDownList($model, 'sumberanggaran_id', CHtml::listData(AGSumberanggaranM::model()->findAllByAttributes(array(),array('order'=>'sumberanggarannama')), 'sumberanggaran_id', 'sumberanggarannama'), array('empty'=>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
					</div>
				</div>
			</div>
		</div>
    </fieldset>
      
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                    $this->createUrl($this->id.'/index'), 
                                    array('class' => 'btn btn-default',
                                        'onclick'=>'myConfirm("Apakah Anda ingin mengulang pencarian ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;')); ?>
        <?php  
        $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>	

    </div>	
	
<?php
$this->endWidget();
?>
</div>
<!--Dialog untuk mengetahui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogMengetahui',
        'options' => array(
            'title' => 'Detail Rencana Anggaran Pengeluaran',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'height' => 500,
            'resizable' => false,
			'close'=>"js:function(){ $.fn.yiiGridView.update('inforencanggpen-grid', {
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
            'title' => 'Detail Rencana Anggaran Pengeluaran',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'height' => 500,
            'resizable' => false,
			'close'=>"js:function(){ $.fn.yiiGridView.update('inforencanggpen-grid', {
					data: $(this).serialize()
				}); }",
        ),
));
?>
<iframe name='frameMenyetujui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!--Dialog untuk rincian-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogRincian',
        'options' => array(
            'title' => 'Detail Rencana Anggaran Penerimaan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'height' => 500,
            'resizable' => false,
        ),
));
?>
<iframe name='frameRincian' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<script type="text/javascript">
function periodeAnggaran(){
var konfig_id=$("#<?php echo CHtml::activeId($model,"konfiganggaran_id");?>").val();
$("#konfiganggaran_id").val(konfig_id);
}
</script>
