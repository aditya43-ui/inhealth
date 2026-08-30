<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'assep-t-search',
    'type' => 'horizontal',
)); ?>

<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <?php echo CHtml::label('Tanggal SEP/Approve', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'no_kartu_bpjs', array('class' => 'span3', 'maxlength' => 50)); ?>
    </div>
    <div class="span6">

        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span3', 'maxlength' => 100)); ?>
        <?php // echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3','maxlength'=>100)); 
        ?>
        <?php // echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3','maxlength'=>100)); 
        ?>
    </div>

</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'reset')); ?>
</div>

<?php $this->endWidget(); ?>