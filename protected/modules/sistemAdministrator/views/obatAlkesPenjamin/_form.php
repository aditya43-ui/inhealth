<style>
    .float3, .float2, .integer2, .integer-decimal {
        text-align: right;
    }

</style>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'obatalkespenjamin-m-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return verifikasi(this);'),
	'focus' => '#',
		));
?>

<p class="help-block" style="color: black"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
	<div class="col-sm-6">
		<div class='control-group'>
			<?php echo $form->labelEx($model, 'carabayar_id', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'carabayar_id') ?>
				<?php echo $form->textField($model, 'carabayar_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Penjamin', 'penjamin_id', array('required' => true, 'class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'penjamin_id'); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model' => $model,
					'attribute' => 'penjamin_nama',
					'source' => 'js: function(request, response) {
                                    $.ajax({
					url: "' . $this->createUrl('AutocompletePenjamin') . '",
					dataType: "json",
					data: {
                                            term: request.term,
					},
					success: function (data) {
                                            response(data);
					}
                                    })
				}',
					'options' => array(
						'showAnim' => 'fold',
						'minLength' => 2,
						'focus' => 'js:function( event, ui ) {
					$(this).val( ui.item.value);
					return false;
					}',
						'select' => 'js:function( event, ui ) {
					$("#' . CHtml::activeId($model, 'penjamin_id') . '").val(ui.item.penjamin_id);
					$("#' . CHtml::activeId($model, 'carabayar_id') . '").val(ui.item.carabayar_id);
					$("#' . CHtml::activeId($model, 'carabayar_nama') . '").val(ui.item.carabayar_nama);
					return false;
					}',
					),
					'htmlOptions' => array(
						'placeholder' => 'Nama Penjamin',
						'onkeypress' => "return $(this).focusNextInputField(event)",
						'class'=>'span3'
					),
					'tombolDialog' => array('idDialog' => 'dialogPenjamin'),
				));
				?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model, 'jenisobatalkes_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php
				echo $form->dropDownList($model, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true order by jenisobatalkes_nama ASC'), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
				));
				?>
			</div>
		</div>
	</div>
	
	<div class="col-sm-6">
		<div class='control-group'>
			<?php echo $form->labelEx($model, 'persmargin', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($model, 'persmargin', array('class' => 'span3 integer-decimal valid-persen', 'onkeypress' => "return $(this).focusNextInputField(event);",'maxlength'=>6)); ?>
			</div>
		</div>
		<div class='control-group'>
			<?php echo $form->labelEx($model, 'persdiskon', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($model, 'persdiskon', array('class' => 'span3 integer-decimal valid-persen', 'onkeypress' => "return $(this).focusNextInputField(event);",'maxlength'=>6)); ?>
			</div>
		</div>
		<div class='control-group'>
			<?php echo $form->labelEx($model, 'biayaadministrasi', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($model, 'biayaadministrasi', array('class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
	</div>
</div>

<div class="form-actions">
	<?php
	echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
					Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
	?>
	<?php
	echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/Bank/admin'), array('class' => 'btn btn-danger',
		'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
	?>
	<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Obat Alkes Penjamin', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
	<?php
	$content = $this->renderPartial('akuntansi.views.tips.tipsaddedit3a', array(), true);
	$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
	?>
</div>

<?php $this->endWidget(); ?>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>
<?php
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogPenjamin',
	'options' => array(
		'title' => 'Daftar Penjamin',
		'autoOpen' => false,
		'modal' => true,
		'width' => 800,
		'height' => 400,
		'resizable' => false,
	),
));

$modPenjamin = new PenjaminpasienM('searchDialogPenjamin');
$modPenjamin->unsetAttributes();
//$account = "D";
if (isset($_GET['PenjaminpasienM'])) {
	$modPenjamin->attributes = $_GET['PenjaminpasienM'];
	$modPenjamin->carabayar_nama = $_GET['PenjaminpasienM']['carabayar_nama'];
	$modPenjamin->penjamin_nama = $_GET['PenjaminpasienM']['penjamin_nama'];
}
//$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'penjamin-m-grid',
	//'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider' => $modPenjamin->searchDialogPenjamin(),
	'filter' => $modPenjamin,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
				"id" => "selectPenjamin",
				"onClick" =>"
					$(\"#ObatalkespenjaminM_penjamin_id\").val(\"$data->penjamin_id\");
					$(\"#ObatalkespenjaminM_penjamin_nama\").val(\"$data->penjamin_nama\");
					$(\"#ObatalkespenjaminM_carabayar_id\").val(\"$data->carabayar_id\");
					$(\"#ObatalkespenjaminM_carabayar_nama\").val(\"$data->carabayar_nama\");
					$(\"#dialogPenjamin\").dialog(\"close\");
					return false;
			"))',
		),
		array(
			'header' => 'No.',
			'type' => 'raw',
			'value' => '$row+1',
			'filter' => false,
		),
		array(
			'header' => 'Jenis Penjamin',
			'name' => 'carabayar_nama',
			'value' => '$data->carabayar_nama',
			'filter' => CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true order by carabayar_nama asc'), 'carabayar_nama', 'carabayar_nama'),
		),
		array(
			'header' => 'Penjamin',
			'name' => 'penjamin_nama',
			'value' => '$data->penjamin_nama',
			'filter' => CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = true order by penjamin_nama asc'), 'penjamin_nama', 'penjamin_nama'),
		),

	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Rek Debit dialog =============================
?>
