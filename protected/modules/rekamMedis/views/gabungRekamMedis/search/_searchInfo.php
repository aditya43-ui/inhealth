<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'kpinfohukumanpoinpeg-v-search',
    'type' => 'horizontal',
    //    'focus'=>'#'.CHtml::activeId($model,'nama_pegawai'),
)); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Tanggal Gabung", 'tglpresensi', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'no_rekam_medik_lama', array('placeholder' => 'No. Rekam Medik Lama', 'class' => 'span4 numbers-only', 'maxlength' => 8)); ?>
        <?php echo $form->textFieldRow($model, 'nama_pasien_lama', array('placeholder' => 'Nama Pasien Lama', 'class' => 'span4', 'maxlength' => 50)); ?>
    </div>

    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'no_rekam_medik_baru', array('placeholder' => 'No. Rekam Medik Baru', 'class' => 'span4 numbers-only', 'maxlength' => 8)); ?>
        <?php echo $form->textFieldRow($model, 'nama_pasien_baru', array('placeholder' => 'Nama Pasien Baru', 'class' => 'span4', 'maxlength' => 50)); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $tips = array(
        '0' => 'cari',
        '1' => 'ulang',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>