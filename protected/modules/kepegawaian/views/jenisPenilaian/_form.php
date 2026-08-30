<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kpjenispenilaian-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php // echo $form->textFieldRow($model,'jabatan_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php echo $form->textFieldRow($model, 'jenispenilaian_nama', array('placeholder' => 'Jenis Penilaian', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'jenispenilaian_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <div class="control-group">
            <?php echo CHtml::label('Bobot Penilaian (%)', 'bobot_penilaian', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'bobot_penilaian', array('placeholder' => 'Bobot Penilaian', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", "onkeyup" => "cekPesentasiBobotNilai(this.value)")); ?>
            </div>
        </div>
        <?php // echo $form->textFieldRow($model,'bobot_penilaian',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", "onkeyup"=>"cekPesentasiBobotNilai(this.value)")); 
        ?>
    </div>

    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'jenispenilaian_sifat', LookupM::getItems('sifatjenispenilaian'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 25, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'jenispenilaian_urutan', array('placeholder' => '00', 'class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'style' => 'text-align:right;')); ?>
        <?php echo $form->dropDownListRow($model, 'tingkatpenilaian', LookupM::getItems('tingkatpenilaian'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 20, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jenispenilaian_aktif'); ?>
                <label for="KPJenispenilaianM_jenispenilaian_aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php // echo $form->checkBoxRow($model,'jenispenilaian_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Penilaian', array('{icon}' => '<i class="' . MyIcon::getIcons('pengaturan') . '"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('kepegawaian.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('KPJenispenilaianM_jenispenilaian_namalain').value = nama.value.toUpperCase();
    }

    function cekPesentasiBobotNilai(value) {
        console.log(value);
        var bobot_penilaian = $("#<?php echo CHtml::activeId($model, "bobot_penilaian"); ?>").val();
        if (bobot_penilaian != "") {
            $("#<?php echo CHtml::activeId($model, "bobot_penilaian"); ?>").parents(".control-group").removeClass("error");
            $("#<?php echo CHtml::activeId($model, "bobot_penilaian"); ?>").removeClass("error");
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('checkPersentasiBobotNilai'); ?>',
                data: {
                    bobot_penilaian: bobot_penilaian
                },
                dataType: "json",
                success: function(data) {
                    if (data != null) {
                        if (data.status == 'error') {
                            $("#<?php echo CHtml::activeId($model, "bobot_penilaian"); ?>").parents(".control-group").addClass("error");
                            $("#<?php echo CHtml::activeId($model, "bobot_penilaian"); ?>").addClass("error");
                            myAlert('Bobot Penilaian sekarang ' + data.nilai + '% Tidak boleh lebih dari 100%.');
                        }
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }
</script>