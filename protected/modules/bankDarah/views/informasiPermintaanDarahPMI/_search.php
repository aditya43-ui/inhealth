<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'permintaanpmi-r-search',
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
                <?php echo $form->textField($model, 'no_permintaan', array('placeholder' => 'Nomor Permintaan', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Petugas', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_pegawai', array('placeholder' => 'Nama Petugas', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("Status", 'permintaandarah_status', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'status', array('Belum' => 'Belum Diterima', 'Sudah' => 'Sudah Diterima'), array('class' => 'span4', 'empty' => '-- Pilih --')) ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl('index') . '";}); return false;'
        )
    );
    ?>
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