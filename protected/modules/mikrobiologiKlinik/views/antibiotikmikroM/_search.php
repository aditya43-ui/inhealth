<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'antibiotik-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
    <div class="control-group">
            <?php echo CHtml::label("Antibiotik Nama", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'antibiotikmikro_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'maxlength' => 100)); ?>
            </div>
        </div>

        </div>
        <div class="col-sm-6">
     <div class="control-group">
            <?php echo CHtml::label("Jenis Antibiotik ", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'antibiotikmikro_jenis', array('placeholder' => 'Jenis Nama', 'class' => 'span3', 'maxlength' => 100)); ?>
            </div>
        </div>


        </div>
        
    </div>
   
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
    ); ?>
</div>

<?php $this->endWidget(); ?>