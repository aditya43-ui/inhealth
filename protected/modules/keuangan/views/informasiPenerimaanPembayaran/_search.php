<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'penerimaanpembayaran-info-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Kas Masuk", '', array('class' => 'control-label')) ?>
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
            <?php echo CHtml::label(CHtml::activeCheckBox($model, 'ceklis') . " <label for='KUInformasipenerimaanpembayaranpiutangV_ceklis'>Tgl. Pembayaran</label>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tglbayar_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tglbayar_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tglbayar_awal)) ?> - <?php echo date('d M Y', strtotime($model->tglbayar_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tglbayar_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tglbayar_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nobuktibayar', array('placeholder' => 'No. Kas Masuk', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'nopembayaran', array('placeholder' => 'No. Pembayaran Piutang', 'class' => 'span3')); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Pembayaran', ' ', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jnspembayar_id', CHtml::listData(JnspembayarM::model()->findAll('jnspembayar_aktif = true'), 'jnspembayar_id', 'jnspembayar_nama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Bank', ' ', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'bank_id', CHtml::listData(BankM::model()->findAll('bank_aktif = true and ispenerimaan = true'), 'bank_id', 'namabank'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Status Pembayaran', ' ', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'status_pembayaran', array('1' => 'BELUM LUNAS', '2' => 'LUNAS'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Status Pembatalan', ' ', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'status_pembatalan', array('1' => 'TIDAK DIBATALKAN', '2' => 'SUDAH DIBATALKAN'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Petugas Penyetor', ' ', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'pegawai_id', CHtml::listData(PegawairuanganV::model()->findAll('pegawai_aktif = true AND ruangan_id = ' . Yii::app()->user->getState('ruangan_id') . ' ORDER BY nama_pegawai ASC'), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
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