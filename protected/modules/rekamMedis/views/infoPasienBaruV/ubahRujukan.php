<div class="white-container">
    <legend class="rim2">Ubah <b>Data Rujukan</b></legend>
    <?php

    $arrMenu = array();
                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' RKRujukanT #'.$modRujukan->rujukan_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'rmrujukan-t-form',
        'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
            'focus'=>'#',
            'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
    )); 
    $this->widget('bootstrap.widgets.BootAlert');

    ?>

    <?php echo $this->renderPartial('_formRujukan', array('modRujukan'=>$modRujukan, 'form'=>$form)); ?>
    <div class="form-actions">
                            <?php echo CHtml::htmlButton($modRujukan->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                         Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                    array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/infoPasienBaruV/admin'), 
                            array('class' => 'btn btn-default',
                                  'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>