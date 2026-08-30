<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'ppbuat-janji-poli-t-search',
        'type'=>'horizontal',
)); ?>
 <legend class="rim"><i class="entypo-search"></i> Pencarian berdasarkan : </legend>
<table>
    <tr>
        <td>
            <div class="control-group">
                    <?php echo $form->labelEx($model,'tglAwal', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tglAwal',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                        </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model,'tglAkhir', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tglAkhir',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                        </div>
                </div> 
            <?php echo $form->textFieldRow($model,'nama_pegawai'); ?>
            
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'numberOnly')); ?>
            <?php echo $form->textFieldRow($model,'nama_pasien'); ?>
            <?php echo $form->textFieldRow($model,'ruangan_nama'); ?>
            
        </td>
    </tr>
</table>

<div class="form-actions">
     <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	 <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('buatJanjiPoliT/index'), array('class'=>'btn btn-danger')); ?>
	 <?php if((!$model->isNewRecord) AND ((PPKonfigSystemK::model()->find()->printkartulsng==TRUE) OR (PPKonfigSystemK::model()->find()->printkartulsng==TRUE))) 
                        {  
                ?>
                            <script>
                                print(<?php echo $model->pendaftaran_id ?>);
                            </script>
                 <?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"print('$model->pendaftaran_id');return false",'disabled'=>FALSE  )); 
                       }else{
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','disabled'=>TRUE  )); 
                       } 
                ?>
				  
</div>

 <?php $this->endWidget(); ?>

<?php

$js = <<< JS
$('.numberOnly').keyup(function() {
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
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);
?>