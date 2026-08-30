
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'kprealisasikenpangkat-r-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

    <?php echo $form->errorSummary($modRealisasi); ?>
<table>
    <tr>
        <td>
            <?php echo $form->hiddenField($modRealisasi,'kenaikanpangkat_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::label('Tgl. SK', ' ', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modRealisasi,
                            'attribute' => 'realisasikenpangkat_tglsk',
                            'mode' => 'datetime',
//                                         'maxdate'=>'d',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
            <?php echo $form->textFieldRow($modRealisasi,'realisasikenpangkat_nosk',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?> 
             <?php echo CHtml::label('Masa Kerja', ' ', array('class' => 'control-label')) ?>
                    <div class="controls">  
            <?php echo $form->textField($modRealisasi,'realisasikenpangkat_masakerjath',array('class'=>'span1', 'placeholder'=>$modRealisasi->getAttributeLabel('realisasikenpangkat_masakerjath'))); ?>
            <?php echo $form->textField($modRealisasi,'realisasiken_masakerjabln',array('class'=>'span1', 'placeholder'=>$modRealisasi->getAttributeLabel('realisasiken_masakerjabln'))); ?>
                        <div>
        </td>
        <td>
            
            <?php echo $form->textFieldRow($modRealisasi,'realisasiken_gajipokok',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->dropDownListRow($modRealisasi,'realisasiken_pejabatygberwenang',CHtml::listData(PegawaiM::model()->findAll(), 'nama_pegawai', 'nama_pegawai'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <?php //echo $form->textFieldRow($modRealisasi,'realisasiken_pejabatygberwenang',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<td></tr></table>
<!--<div class="form-actions">-->
        <?php 
//             echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
//             Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
//             array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)'));
        ?>
        <?php 
//            echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
//            Yii::app()->createUrl($this->module->id.'/'.realisasikenpangkatR.'/admin'), 
//            array('class' => 'btn btn-default',
//                  'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
        ?>
<!--</div>-->

<?php $this->endWidget(); ?>