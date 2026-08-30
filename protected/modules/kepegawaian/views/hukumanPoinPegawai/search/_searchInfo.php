<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'kpinfohukumanpoinpeg-v-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nama_pegawai'),
)); ?>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Tgl. Presensi", 'tglpresensi', array('class' => 'control-label')) ?>
        <div class="controls">
            <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                <i class="entypo-calendar"></i>
                <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
            </div>
        </div>
    </div>
    <?php echo $form->textFieldRow($model, 'nama_pegawai', array('class' => 'span3', 'maxlength' => 30)); ?>
</div>
<div class="clear"></div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('PresensiT/InformasiPresensi'), array('class' => 'btn btn-danger')); ?>
    <?php
    $content = $this->renderPartial('../tips/informasi_presensi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>