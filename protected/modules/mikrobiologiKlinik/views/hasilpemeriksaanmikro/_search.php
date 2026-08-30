<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'hasilpemeriksaanmikro-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
    <div class="control-group">
            <?php echo CHtml::label("Kelompok Mikroorganisme", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kelompok_mikroorganisme', array('placeholder' => 'Kelompok Mikroorganisme', 'class' => 'span3', 'maxlength' => 100)); ?>
            </div>
        </div>

        </div>
        <div class="col-sm-6">
     <div class="control-group">
            <?php echo CHtml::label("Hasil Pemeriksaan", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'hasilpemeriksaan', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 100)); ?>
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