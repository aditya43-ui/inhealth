<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakelurahan-m-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#propinsi',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
)); ?>
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
<?php echo $form->errorSummary($model); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Provinsi','propinsi',array('class'=>"control-label")) ?>
                <div class="controls">
                    <?php echo CHtml::dropDownList('propinsi', $model->getPropinsiItemsKec($model->kecamatan_id), CHtml::listData($model->PropinsiItems, 'propinsi_id', 'propinsi_nama'),array('empty'=>'-- Pilih --',
                                                                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                                'ajax'=>array(
                                                                                'type'=>'POST',
                                                                                'url'=>Yii::app()->createUrl('ActionDynamic/GetKabupaten',array('encode'=>false,'namaModel'=>'','attr'=>'propinsi')),
                                                                                'update'=>'#kabupaten',))); 
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Kabupaten','kabupaten',array('class'=>"control-label")) ?>
                <div class="controls">
                    <?php echo CHtml::dropDownList('kabupaten', $model->getKabupatenItemsKec($model->kecamatan_id), CHtml::listData($model->KabupatenItems, 'kabupaten_id', 'kabupaten_nama'),array('empty'=>'-- Pilih --',
                                                                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                                'ajax'=>array(
                                                                                'type'=>'POST',
                                                                                'url'=>Yii::app()->createUrl('ActionDynamic/GetKecamatan',array('encode'=>false,'namaModel'=>'','attr'=>'kabupaten')),
                                                                                'update'=>'#RDKelurahanM_kecamatan_id',))); 
                    ?>
                </div>
            </div>
            
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
                                                            'title'=>'Klik untuk mencari Longitude & Latitude',)); ?>
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
       
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'kecamatan_id',CHtml::listData($model->KecamatanItems, 'kecamatan_id', 'kecamatan_nama'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'kelurahan_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
			<?php echo $form->textFieldRow($model,'kelurahan_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
            <?php echo $form->textFieldRow($model,'kode_pos',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>15,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>

    </tr>
    <tr>
        <td>
            <?php //echo $form->checkBoxRow($model,'kelurahan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			<div class="control-group">
				<?php echo CHtml::label("",'kelurahan_aktif', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->checkBox($model,'kelurahan_aktif',array()); ?> <label>Aktif</label>
				</div>
			</div>
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        Yii::app()->createUrl($this->module->id.'/kelurahanM/admin'), 
        array('class' => 'btn btn-default',
           'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelurahan', array('{icon}'=>'<i class="entypo-folder"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); ?>
    <?php
        $content = $this->renderPartial('../tips/tipsaddedit5',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SAKelurahanM_kelurahan_namalainnya').value = nama.value.toUpperCase();
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