<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'penerimaanlinen-info-search',
    'type' => 'horizontal',
));
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label(CHtml::activeRadioButton($model, 'pengajuan') . " <label for='InformasiambilpencucianlinenumumV_pengajuan'>Tgl Pengajuan</label>", 'tanggal_lahir', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal_pengajuan)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir_pengajuan)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d F Y', strtotime($model->tgl_awal_pengajuan)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir_pengajuan)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal_pengajuan', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir_pengajuan', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label(CHtml::activeRadioButton($model, 'pengambilan') . " <label for='InformasiambilpencucianlinenumumV_pengambilan'>Tgl Pengambilan</label>", 'tanggal_lahir', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal_pengambilan)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir_pengambilan)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d F Y', strtotime($model->tgl_awal_pengambilan)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir_pengambilan)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal_pengambilan', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir_pengambilan', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('No Pengajuan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nopenerimaan', array('placeholder' => 'No. Pengajuan', 'class' => 'span4', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('No Pengambilan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nopengambilan', array('placeholder' => 'No Pengambilan', 'class' => 'span4', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Mengajukan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'namapengirim', array('placeholder' => 'Nama Mengajukann', 'class' => 'span4', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Pengambil', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'namapengambil', array('placeholder' => 'Nama Pengambil', 'class' => 'span4', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
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
        $this->createUrl($this->id . '/index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips.informasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>