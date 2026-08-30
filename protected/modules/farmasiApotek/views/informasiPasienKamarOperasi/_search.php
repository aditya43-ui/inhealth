<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'formPencarian',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#FAResepturT_noresep',
        'method' => 'get',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    ));
?>
<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Tanggal", '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modPasienMasukPenunjang->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modPasienMasukPenunjang->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d F Y', strtotime($modPasienMasukPenunjang->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modPasienMasukPenunjang->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($modPasienMasukPenunjang, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($modPasienMasukPenunjang, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <?php echo Chtml::label("Nomor SEP", 'nosep', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPasienMasukPenunjang, 'nosep', array('class' => 'span4', 'placeholder' => 'Nomor SEP')); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4 numberOnly', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 numberOnly', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numberOnly', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')); ?>
    <?php
    $content = $this->renderPartial('../tips/informasiPasienResep', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>