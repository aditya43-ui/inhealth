<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'loginpemakai-k-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

            <?php 
                        echo $form->errorSummary($model); 
                        echo $form->textFieldRow($model,'nama_pemakai',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LoginpemakaiK_old_password','LoginpemakaiK_new_password_repeat')", 'maxlength'=>200)); 
            ?>
            <div class="control-group">
                <?php echo $form->labelEx($model,'old_password',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->passwordField($model,'old_password',array('value'=>'','class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LoginpemakaiK_new_password','LoginpemakaiK_nama_pemakai')", 'maxlength'=>200)); ?><?php echo CHtml::link('<i class="icon-info-sign icon-white"></i>', '#', array('class'=>'btn btn-primary', 'data-title'=>Yii::t('mds','Tips'), 'data-content'=>Yii::t('mds','fill this field in case to change the password'), 'rel'=>'popover')); ?>
                    <?php echo $form->error($model,'old_password'); ?>
                </div>
            </div>
        
            <?php  
                        echo $form->passwordFieldRow($model,'new_password',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LoginpemakaiK_new_password_repeat','LoginpemakaiK_old_password')", 'maxlength'=>200));
                        echo $form->passwordFieldRow($model,'new_password_repeat',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LoginpemakaiK_loginpemakai_aktif','LoginpemakaiK_new_password')", 'maxlength'=>50));
            ?>
            <div class="control-group">
                <?php echo $form->labelex($model,'ruangan',array('class'=>'control-label required')) ?>
                <div class="controls">
                    <?php 
                             $arrRuangan = array();
                             foreach($modRuanganPemakai as $ruanganPemakai){
                                $arrRuangan[] = $ruanganPemakai['ruangan_id'];
                            }

                            $this->widget('application.extensions.emultiselect.EMultiSelect',
                                  array('sortable'=>true, 'searchable'=>true)
                            );
                            echo CHtml::dropDownList(
                                'ruangan_id[]',
                                $arrRuangan,
                                CHtml::listData(RuanganM::model()->findAll(array('order'=>'ruangan_nama')), 'ruangan_id', 'ruangan_nama'),
                                array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                            );
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelex($model,'modul',array('class'=>'control-label required')) ?>
                <div class="controls">
                    <?php 
                             $arrModul = array();
                             foreach($modModulPemakai as $modulPemakai){
                                $arrModul[] = $modulPemakai['modul_id'];
                            }

                            $this->widget('application.extensions.emultiselect.EMultiSelect',
                                  array('sortable'=>true, 'searchable'=>true)
                            );
                            echo CHtml::dropDownList(
                                'modul_id[]',
                                $arrModul,
                                CHtml::listData(ModulK::model()->findAll(array('order'=>'modul_nama')), 'modul_id', 'modul_nama'),
                                array('multiple'=>'multiple','key'=>'modul_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                            );
                    ?>
                    <?php echo $form->error($model,'modul') ?>
                </div>
                <?php echo $form->checkBoxRow($model,'loginpemakai_aktif', array('onkeypress'=>"return nextFocus(this,event,'submitButton','LoginpemakaiK_new_password_repeat')")); ?>
            </div>
            <div class="form-actions">
                                    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                         Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                         array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'submitButton')); ?>
                                    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                                                        Yii::app()->createUrl($this->module->id.'/'.loginpemakaiK.'/admin'), 
                                                                        array('class'=>'btn btn-danger',
                                                                         'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
            </div>

<?php $this->endWidget(); ?>
<?php
$js = <<< JSCRIPT
   kosongkanPassword();
       
   function kosongkanPassword(){
        $('#LoginpemakaiK_new_password').val('');
        $('#LoginpemakaiK_old_password').val('');
        $('#LoginpemakaiK_new_password_repeat').val('');
   }

JSCRIPT;
Yii::app()->clientScript->registerScript('kosongkanPassword', $js, CClientScript::POS_READY);
?>