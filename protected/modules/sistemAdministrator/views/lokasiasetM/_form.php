

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'salokasiaset-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#'.CHtml::activeId($model,'lokasiaset_kode'),
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>

            <?php Echo CHtml::hiddenField('tempKode', $model->lokasiaset_kode); ?>
            <?php echo $form->textFieldRow($model,'lokasiaset_kode',array('class'=>'span3 numbersOnly', 'onkeyup'=>'setKode(this);','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,)); ?>
            <div class="control-group">
                    <label class="control-label" for="instalasi">Instalasi Lokasi Aset</label>
                    <div class="controls">
                    <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            'model'=>$model,
                                            'attribute'=>'lokasiaset_namainstalasi',
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/getInstalasi').'",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                                             'options'=>array(
                                                   'showAnim'=>'fold',
                                                   'minLength' => 2,
                                                   'focus'=> 'js:function( event, ui ) {
                                                        $(this).val( ui.item.label);
                                                        return false;
                                                    }',
                                                   'select'=>'js:function( event, ui ) { 
                                                        $("#'.CHtml::activeId($model, 'lokasiaset_namainstalasi').'").val(ui.item.instalasi_nama);
                                                        return false;
                                                    }',
                                            ),
                                            'htmlOptions'=>array(
                                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
													'class'=>'angkahuruf-only',
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogInstalasi'),
                                        )); 
                        ?>
                    </div>
                </div>
            <div class="control-group">
                    <label class="control-label" for="ruangan">Ruangan Lokasi Aset</label>
                    <div class="controls">
                    <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            'model'=>$model,
                                            'attribute'=>'lokasiaset_namabagian',
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/getRuangan').'",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                                             'options'=>array(
                                                   'showAnim'=>'fold',
                                                   'minLength' => 2,
                                                   'focus'=> 'js:function( event, ui ) {
                                                        $(this).val( ui.item.label);
                                                        return false;
                                                    }',
                                                   'select'=>'js:function( event, ui ) { 
                                                        $("#'.CHtml::activeId($model, 'lokasiaset_namabagian').'").val(ui.item.ruangan_nama);
                                                        return false;
                                                    }',
                                            ),
                                            'htmlOptions'=>array(
                                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
													'class'=>'angkahuruf-only',
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogRuangan'),
                                        )); 
                        ?>
                    </div>
                </div>
            <?php //echo $form->textFieldRow($model,'lokasiaset_namainstalasi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php //echo $form->textFieldRow($model,'lokasiaset_namabagian',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'lokasiaset_namalokasi',array('class'=>'span3 angkahuruf-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<div class="control-group">
					<?php echo CHtml::activeLabel($model, 'garis_latitude', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model,'garis_latitude',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
						<?php echo CHtml::htmlButton('<i class="entypo-search"></i>',
								array(
			//						  'onclick'=>'$("#dialogLongitudeLatitude").dialog("open");return false;',
									  'class' => 'btn btn-danger',
									  'rel'=>"tooltip",
									  'id'=>'yw1',
									  'title'=>"Klik untuk mencari Longitude & Latitude",)); ?>
					</div>
				</div>
			<?php echo $form->textFieldRow($model,'garis_longitude',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>	
			<?php echo $form->checkBoxRow($model,'lokasiaset_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                       '', 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
            <?php //$this->widget('UserTips',array('type'=>'create'));?>
        <?php
echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Lokasi Aset', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-success',));
$content = $this->renderPartial($this->path_view.'tips.tipsCreate',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>

<?php 
Yii::app()->clientScript->registerScript('head','
    function setKode(obj){
        var value = $("#tempKode").val();
        var objValue = $(obj).val();
        if (objValue < value){
           $(obj).val(value);
        }
    }
',  CClientScript::POS_HEAD); ?>
<?php 

$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);?>

	<?php 
	$this->widget('ext.LocationPicker2.CoordinatePicker', array(
		'model' => $model,
		'latitudeAttribute' => 'garis_latitude',
		'longitudeAttribute' => 'garis_longitude',
		//optional settings
		'editZoom' => 12,
		'pickZoom' => 7,
		'defaultLatitude' => $garis_latitude,
		'defaultLongitude' => $garis_longitude,
	));
?>