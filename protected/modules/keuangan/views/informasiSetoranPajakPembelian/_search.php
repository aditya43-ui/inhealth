<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'setoranpajakpembelian-info-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Kas Keluar", '', array('class' => 'control-label')) ?>
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
            <?php echo CHtml::label(CHtml::activeCheckBox($model, 'ceklis') . "<label for='KUInformasisetoranpajakpembelianV_ceklis'>Tanggal Penyetoran</label>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tglnyetor_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tglnyetor_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tglnyetor_awal)) ?> - <?php echo date('d M Y', strtotime($model->tglnyetor_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tglnyetor_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tglnyetor_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nokaskeluar', array('placeholder' => 'No. Kas Keluar', 'class' => 'span4')); ?>
        <?php echo $form->textFieldRow($model, 'no_setorpajakpembelian', array('placeholder' => 'No. Penyetoran', 'class' => 'span4')); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Pajak', ' ', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'pajak_id', CHtml::listData(PajakM::model()->findAll('pajak_aktif = true AND ispajakpegawai = FALSE ORDER BY pajak_nama ASC'), 'pajak_id', 'pajak_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Status Penyetoran', ' ', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'status_penyetoran', array('1' => 'BELUM LUNAS', '2' => 'LUNAS'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Status Pembatalan', ' ', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'status_pembatalan', array('1' => 'TIDAK DIBATALKAN', '2' => 'SUDAH DIBATALKAN'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Petugas Penyetor', ' ', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'petugaspenyetor_id', CHtml::listData(PegawairuanganV::model()->findAll('pegawai_aktif = true AND ruangan_id = ' . Yii::app()->user->getState('ruangan_id') . ' ORDER BY nama_pegawai ASC'), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/barangM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php
    $tips = array(
        '0' => 'tanggal',
        '1' => 'detail',
        '2' => 'batal',
        '3' => 'cari',
        '4' => 'ulang2'
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>