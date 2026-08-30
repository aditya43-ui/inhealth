<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'kpinfohukumanpoinpeg-v-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nama_pegawai'),
)); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Penilaian", 'tglpresensi', array('class' => 'control-label')) ?>
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
        <?php echo $form->textFieldRow($model, 'nama_pegawai', array('placeholder' => 'Nama Pegawai', 'class' => 'span4', 'maxlength' => 30)); ?>
        <?php echo $form->dropDownListRow($model, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE ORDER BY jabatan_nama ASC "), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 30)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll(" unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC "), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 30)); ?>
        <?php echo $form->dropDownListRow($model, 'kategoripegawai', LookupM::getItems('kategoripegawai'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 30)); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('PresensiT/InformasiPresensi'),
        array('title' => 'Ulang', 'class' => 'btn btn-default')
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/informasi_presensi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>