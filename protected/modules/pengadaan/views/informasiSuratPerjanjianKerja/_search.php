<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'informasi-spk-search',
    'type' => 'horizontal',
        ));
?>
<div class="col-sm-6">
    <div class="control-group">	
        <?php echo CHtml::label("Tanggal Kontrak", 'tglsuratperjanjian', array('class' => 'control-label ')) ?>
        <div class="controls">
            <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tanggal_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tanggal_akhir)) ?>">
                <i class="entypo-calendar"></i>
                <span ><?php echo date('F d, Y', strtotime($model->tanggal_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tanggal_akhir)) ?></span>
                <?php echo $form->hiddenField($model, 'tanggal_awal', array('class' => 'start')) ?>
                <?php echo $form->hiddenField($model, 'tanggal_akhir', array('class' => 'end')) ?>
            </div>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Nomor Kontrak', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'nomor_dokumen', array('placeholder' => 'Ketik Nomor Kontrak', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Nomor Transaksi', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'nosuratperjanjiankerja', array('placeholder' => 'Ketik Nomor Transaksi', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>    
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Nama Pekerjaan', 'namapekerjaan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'namapekerjaan', array('placeholder' => 'Ketik Nama Pekerjaan', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
            <?php echo CHtml::label('Penyedia', 'supplier_nama', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'supplier_nama', array('placeholder' => 'Ketik Nama Penyedia', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<br><br>
<div class="clear"></div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')) . "&nbsp"; ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('InformasiSuratPerjanjianKerja/index'), array('class' => 'btn btn-danger')) . "&nbsp"; ?>

    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp"; ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp"; ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp"; ?>
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