<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'search',
    'type'=>'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Supplier','', array('class'=>'control-label')) ?>
           <div class="controls">
               <?php 
                   echo $form->textField($model,'supplier_nama',array('class'=>'span3'));
               ?>
           </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'submit')); 
    ?>                
</div>
<?php $this->endWidget(); ?>
