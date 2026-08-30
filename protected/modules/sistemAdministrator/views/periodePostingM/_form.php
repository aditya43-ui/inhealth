<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'saperiodeposting-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php //echo $form->dropDownListRow($model, 'konfiganggaran_id', CHtml::listData(KonfiganggaranK::model()->findAll(array('condition'=>'isclosing_anggaran = false','order'=>'deskripsiperiode ASC')), 'konfiganggaran_id', 'deskripsiperiode'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); 
        ?>
        <?php echo $form->dropDownListRow($model, 'rekperiode_id', CHtml::listData(RekperiodM::model()->findAll(array('condition' => 'isclosing = false', 'order' => 'deskripsi ASC')), 'rekperiod_id', 'deskripsi'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'periodeposting_nama', array('placeholder' => 'Nama Periode', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php
        if (!empty($model->periodeposting_id)) {
        ?>
            <div class="control-group">
                <?php echo CHtml::label("", 'periodeposting_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'periodeposting_aktif', array()); ?>
                    <label for="SAPeriodepostingM_periodeposting_aktif">Aktif</label>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglperiodeposting_awal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglperiodeposting_awal',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'dateFormat' => Params::DATE_FORMAT,
                        'yearRange' => "-150:+0",
                        'onSelect' => "js:function() {
							cekTanggal();
							return false;
						}",
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'dtPicker2 span2', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglperiodeposting_akhir', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglperiodeposting_akhir',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'dateFormat' => Params::DATE_FORMAT,
                        'yearRange' => "-150:+0",
                        'onSelect' => "js:function() {
							cekTanggal();
							return false;
						}",
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'dtPicker2 span2', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($model, 'deskripsiperiodeposting', array('placeholder' => 'Deskripsi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Periode Posting', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>

    <?php
    $content = $this->renderPartial($this->path_tips . 'tipsaddedit4b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<script>
    function cekTanggal() {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('cekTanggal'); ?>',
            data: $("#saperiodeposting-m-form").serialize(),
            dataType: "json",
            success: function(data) {
                if (data.pesan !== "") {
                    myAlert(data.pesan);
                    $("#<?php echo CHtml::activeId($model, 'tglperiodeposting_akhir') ?>").val("");
                    $("#<?php echo CHtml::activeId($model, 'tglperiodeposting_awal') ?>").val("");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                myAlert(data.pesan);
            }
        });
    }
</script>