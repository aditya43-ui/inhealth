<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'tglpinjampeg'),
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">
                <?php echo $form->checkBox($model, 'ceklistglpinjam'); ?>
                Pinjam Pegawai
            </label>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">
                <?php echo $form->checkBox($model, 'ceklis'); ?>
                Jatuh Tempo
            </label>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal_jatuhtempo)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir_jatuhtempo)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal_jatuhtempo)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir_jatuhtempo)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal_jatuhtempo', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir_jatuhtempo', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nopinjam', array('placeholder' => 'Nomor Pinjaman', 'class' => 'span3 angkahuruf-only')); ?>
        <div class="control-group">
            <?php echo Chtml::label("NIP", 'nomorindukpegawai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nomorindukpegawai', array('placeholder' => 'NIP', 'class' => 'span3 numbers-only', 'maxlength' => 18)); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nama_pegawai', array('placeholder' => 'Nama Pegawai', 'class' => 'span3 hurufs-only')); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('/kepegawaian/informasiPinjamanPegawai'),
        array('title' => 'Ulang', 'class' => 'btn btn-default')
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/informasi_penggajianKaryawan', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>