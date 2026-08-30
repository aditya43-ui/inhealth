<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'kppengangkatantphl-t-form',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nomorindukpegawai'),
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. TMT", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nomorindukpegawai', array('class' => 'span3', 'maxlength' => 20)); ?>
        <?php
        // $format = new MyFormatter();
        // $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
        // $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
        ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nama_pegawai', array('class' => 'span3', 'maxlength' => 10)); ?>
        <?php echo $form->textFieldRow($model, 'pengangkatantphl_nosk', array('class' => 'span3', 'maxlength' => 50)); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('PengangkatantphlT/Informasi'), array('class' => 'btn btn-danger')); ?>
    <?php
    $content = $this->renderPartial('../tips/informasi_pengangkatanTphl', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>