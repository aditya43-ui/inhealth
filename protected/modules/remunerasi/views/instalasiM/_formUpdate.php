<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sainstalasi-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#SAInstalasiM_instalasi_nama',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>
        <table class="table">
            <tr>
                <td>
                    <?php echo $form->labelEx($model,'instalasi_image', array('class'=>'control-label','onkeypress'=>"return nextFocus(this,event,'SAProfilRumahSakitM_tgl_suratizin','SAProfilRumahSakitM_visi')")) ?>
                          <div class="controls">  
                            <?php echo Chtml::activeFileField($model,'instalasi_image',array('maxlength'=>254,'hint'=>'Isi Jika Akan Menambahkan Logo')); ?>
                          </div>                    <?php echo $form->textFieldRow($model,'instalasi_nama',array('class'=>'span2', 'onkeypress'=>"return nextFocus(this,event,'SAInstalasiM_instalasi_namalainnya','')", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($model,'instalasi_namalainnya',array('class'=>'span2', 'onkeypress'=>"return nextFocus(this,event,'SAInstalasiM_instalasi_singkatan','SAInstalasiM_instalasi_nama')", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($model,'instalasi_singkatan',array('class'=>'span2', 'onkeypress'=>"return nextFocus(this,event,'SAInstalasiM_instalasi_lokasi','SAInstalasiM_instalasi_namalainnya')", 'maxlength'=>2)); ?>
                    <?php echo $form->textFieldRow($model,'instalasi_lokasi',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'btn_simpan','SAInstalasiM_instalasi_singkatan')", 'maxlength'=>50)); ?>
                    <?php //echo $form->checkBoxRow($model,'instalasi_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->textAreaRow($modRiwayatRuanganR,'tentangpenetapan',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model,'instalasirujukaninternal',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'SAInstalasiM_instalasi_namalainnya','')", 'maxlength'=>50)); ?>
                    <?php echo $form->dropDownListRow($model,'instalasi_adakamar',array(''=>'-- Pilih --',1=>'Ya',0=>'Tidak'),array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'SAInstalasiM_instalasi_singkatan','SAInstalasiM_instalasi_nama')", 'maxlength'=>50)); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modRiwayatRuanganR,'tglpenetapanruangan', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modRiwayatRuanganR,
                                                    'attribute'=>'tglpenetapanruangan',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                                        'maxDate' => 'd',
                                                        'yearRange'=> "-60:+0",
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                            <?php echo $form->error($modRiwayatRuanganR, 'tglpenetapanruangan'); ?>
                        </div>
                    </div>   
                     <?php echo $form->textFieldRow($modRiwayatRuanganR,'nopenetapanruangan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                     <img src="<?php echo Params::urlInstalasiTumbsDirectory().'kecil_'.$model->instalasi_image ?> ">     

                </td>
            </tr>
        </table>
           
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'btn_simpan')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/instalasiM/admin'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	</div>

<?php $this->endWidget(); ?>
