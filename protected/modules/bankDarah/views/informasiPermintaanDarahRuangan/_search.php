<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'permintaandarah-r-search',
    'type' => 'horizontal',
));
$format = new MyFormatter();
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Tanggal Permintaan', array('class' => 'control-label')) ?>
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
            <?php echo $form->labelEx($model, 'No Permintaan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'no_permintaandarah', array('placeholder' => 'Nomor Formulir', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'No. Rekam Medik', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'no_rekam_medik', array('class' => 'custom-only span3', 'placeholder' => 'Nomor Rekam Medik')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Nama Pasien', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_pasien', array('class' => 'custom-only span3', 'placeholder' => 'Nama Pasien')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Ruangan Asal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'ruanganpemesan_id', CHtml::listData(RuanganM::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Jenis Penjamin', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll(), 'carabayar_id', 'carabayar_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Penjamin', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'penjamin_id', CHtml::listData(PenjaminpasienM::model()->findAll(), 'penjamin_id', 'penjamin_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')) ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/index'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $tips = array(
        '0' => 'tanggal',
        '1' => 'cari',
        '2' => 'ulang'
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>