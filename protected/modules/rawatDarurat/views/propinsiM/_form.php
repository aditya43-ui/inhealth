<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sapropinsi-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus'=>'#SAPropinsiM_propinsi_nama',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
)); ?>
<div class="row">
	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
	<?php echo $form->errorSummary($model); ?>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'propinsi_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>25)); ?>
		<?php echo $form->textFieldRow($model,'propinsi_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>25)); ?>		
	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($model,'latitude', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($model,'latitude',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
				<?php echo CHtml::htmlButton('<i class="entypo-map"></i>',
					array(
						'class'=>'btn btn-primary btn-location',
						'rel'=>'tooltip',
						'id'=>'yw1',
						'onclick' =>'changeSize()',
						'title'=>'Klik untuk mencari Longitude & Latitude',
					)); 
				?>
			</div>
		</div>
		<?php echo $form->textFieldRow($model,'longitude',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>               		
						<!--Extension location-picker latitude & longitude-->
		<?php 
					 //  if (isset($model->latitude)){
					  // $modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getstate('propinsi_id'));
					  // $model->latitude = $modPropinsi->latitude;
					  // $model->latitude = $modPropinsi->longitude;
					 //  }

		$this->widget('ext.LocationPicker2.CoordinatePicker', array(
			   'model' => $model,
			   'latitudeAttribute' => 'latitude',
			   'longitudeAttribute' => 'longitude',
			   //optional settings
			   'editZoom' => 12,
			   'pickZoom' => 7,
			   'defaultLatitude' => $model->latitude,
			   'defaultLongitude' => $model->longitude,
		));
		?>	
	</div>
</div>

<?php //echo $form->checkBoxRow($model,'propinsi_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
<div class="form-actions">
	<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
		Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
		array('class' => 'btn btn-danger', 'type'=>'submit', 'id'=>'btn_simpan','onKeypress'=>'return formSubmit(this,event)')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
		Yii::app()->createUrl($this->module->id.'/propinsiM/admin'), 
		array('class' => 'btn btn-default',
		'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Provinsi', array('{icon}'=>'<i class="entypo-folder"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('tab'=>'frame','modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); ?>
	<?php
		$content = $this->renderPartial('../tips/tipsaddedit5',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
	?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SAPropinsiM_propinsi_namalainnya').value = nama.value.toUpperCase();
    }
    
     function registerJSlocation(id,modelName,i)
     {
        $('#'+id).on('click', function(){ 
                $('#'+id).coordinate_picker({'lat_selector':'#'+modelName+'_'+i+'_latitude','long_selector':'#'+modelName+'_'+i+'_longitude','default_lat':'-7.091932','default_long':'107.672491','edit_zoom':12,'pick_zoom':7})                                
            });
                
    }
        
    function changeSize()
    {            
        window.parent.document.getElementById('frame').style= 'overflow-y:scroll;height:600px;';            
    }
    
    
</script>