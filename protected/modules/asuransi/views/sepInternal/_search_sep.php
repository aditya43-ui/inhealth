<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'assep-t-search',
    'type' => 'horizontal',
)); ?>

<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <?php echo CHtml::label('Tanggal Rujukan Internal', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM, YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>

        <?php echo $form->textFieldRow($model, 'nosep_utama', array('placeholder' => 'No Sep', 'class' => 'span4', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'nosurat_rujukaninternal', array('placeholder' => 'No. Rujukan Internal', 'class' => 'span4', 'maxlength' => 50)); ?>
    
        <div class="control-group">
            <?php echo CHtml::label($form->checkBox($model, 'is_sep', array('value'=>1)).' Tanggal SEP', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM, YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal_utama)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir_utama)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('F d, Y', strtotime($model->tgl_awal_utama)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir_utama)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal_utama', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir_utama', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="span6">
        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No Pendaftaran', 'class' => 'span4', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No Rekam Medik', 'class' => 'span4', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'maxlength' => 100)); ?>
    </div>

</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
    ); ?>
</div>

<?php $this->endWidget(); ?>