
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pasienpulang-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

<?php 
   // echo $this->renderPartial('_formDataPasienPulang',array('form'=>$form,'modRD'=>$modRD)) 
?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary(array($modelPulang,$modRujukanKeluar)); ?>
        <table>
            <tr>
                <td width="50%">
                    <?php //echo $form->textFieldRow($modelPulang,'pasienadmisi_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modelPulang,'tglpasienpulang', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modelPulang,
                                                    'attribute'=>'tglpasienpulang',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                            )); ?>
                            <?php echo $form->error($modelPulang, 'tglpasienpulang'); ?> 
                        </div>
                    </div>

                    <?php echo $form->hiddenfield($modelPulang,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                    <?php echo $form->hiddenfield($modelPulang,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                    <?php //RND-3003echo $form->dropDownListRow($modelPulang,'carakeluar', LookupM::getItems('carakeluar'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'onchange'=>'carakeluar(this.value)')); ?>
                    <?php //RND-3003echo $form->dropDownListRow($modelPulang,'kondisipulang', LookupM::getItems('kondisipulang'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'onchange'=>'pasienmeninggal(this.value)')); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modelPulang,'carakeluar_id', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modelPulang,'carakeluar_id', CHtml::listData($modelPulang->getCarakeluarItems(), 'carakeluar_id', 'carakeluar_nama'), 
                                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'onclick'=>'carakeluar(this.value);',
                                                'ajax'=>array('type'=>'POST',
                                                            'url'=>$this->createUrl('SetDropDownKondisiKeluar',array('encode'=>false,'model_nama'=>get_class($modelPulang))),
                                                            'update'=>"#".CHtml::activeId($modelPulang, 'kondisikeluar_id'),
                                                ),));?>                            
                            <?php echo $form->error($modelPulang, 'carakeluar_id'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Kondisi Pulang <span class="required">*</span>', 'PIPasienPulangT_kondisikeluar_id', array('class'=>'control-label'))?>
                        <?php //echo $form->labelEx($modelPulang,'kondisikeluar_id', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modelPulang,'kondisikeluar_id', CHtml::listData($modelPulang->getKondisikeluarItems($modelPulang->carakeluar_id), 'kondisikeluar_id', 'kondisikeluar_nama'), 
                                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'pasienmeninggal(this.value);'));?>
                            <?php echo $form->error($modelPulang, 'kondisikeluar_id'); ?>
                        </div>
                    </div>    
                    <?php //echo $form->textFieldRow($modelPulang,'ruanganakhir_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modelPulang,'penerimapasien',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    
                                    </td>
                <td width="50%">
                   <fieldset class="">
                        <legend>
                            <?php echo CHtml::checkBox('isDead', $modelPulang->isDead, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
                            Pasien Meninggal
                        </legend>
                        <div class="control-group">
                                <?php echo $form->labelEx($modelPulang,'tgl_meninggal', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php   
                                            $this->widget('MyDateTimePicker',array(
                                                            'model'=>$modelPulang,
                                                            'attribute'=>'tgl_meninggal',
                                                            'mode'=>'datetime',
                                                            'options'=> array(
                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                            ),
                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','disabled'=>true),
                                    )); ?>

                                </div>
                            </div>
                    </fieldset> 
                </td>
            </tr>
        </table>
         
        <?php 
            if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_PI)
            {
                echo $this->renderPartial('_formUpdateMasukKamar',array('form'=>$form,'modMasukKamar'=>$modMasukKamar));
            }
        ?>
        
        <?php echo $this->renderPartial('_formRujukanKeluarRD',array('form'=>$form,'modelPulang'=>$modelPulang,'modRujukanKeluar'=>$modRujukanKeluar)) ?>

       
		
	<div class="form-actions">
                 <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                       Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                                        array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                 <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-cancel"></i>')),
                                                                        array('class' => 'btn btn-default','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)')); ?>
	</div>

<?php $this->endWidget(); ?>
