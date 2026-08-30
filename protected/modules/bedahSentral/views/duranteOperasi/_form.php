<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<style>
    .numbers-only {
        text-align: right;
    }
</style>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'anastesiduranteoperasi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienadmisi_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienmasukpenunjang_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<?php echo $this->renderPartial($this->path_view . "_riwayat", array('model' => $model), true); ?>

<div class="col-sm-6">
    <?php echo $form->textFieldRow($model, 'pemeriksaanke', array('class' => 'span1 numbers-only', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'observasi_jam', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'observasi_jam',
                'mode' => 'time',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span2', 'onclick' => "return $(this).focusNextInputField(event)"),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Status Anestesi/Sedasi</label>
        <div class="controls">
            <?php echo CHtml::htmlButton('Mulai<br>(Intubasi)', array('id' => 'btn_mulai_anestesi', 'class' => 'btn btn-sm btn-success', 'disabled' => !empty($status->statusanestesi), 'onclick' => 'mulaiAnestesi();')); ?>
            <?php echo CHtml::htmlButton('Sedang<br>Anestesi/Sedasi', array('id' => 'btn_sedang_anestesi', 'class' => 'btn btn-sm btn-warning', 'disabled' => $status->statusanestesi != Params::STATUSDURANTEANESTESI_SEDANG_ANESTESI)); ?>
            <?php echo CHtml::htmlButton('Akhir Anestesi<br>(Eksturbasi)', array('id' => 'btn_akhir_anestesi', 'class' => 'btn btn-sm btn-danger', 'disabled' => $status->statusanestesi != Params::STATUSDURANTEANESTESI_SEDANG_ANESTESI, 'onclick' => 'selesaiAnestesi();')); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Status Tindakan/Bedah</label>
        <div class="controls">
            <?php echo CHtml::htmlButton('Mulai Tindakan', array('class' => 'btn btn-sm btn-success', 'id' => 'btn_mulai_tindakan', 'disabled' => !empty($status->status_tindakanbedah), 'onclick' => 'mulaiTindakan();')); ?>
            <?php echo CHtml::htmlButton('Sedang Berlangsung Tindakan', array('class' => 'btn btn-sm btn-warning', 'id' => 'btn_sedang_tindakan', 'disabled' => $status->status_tindakanbedah != Params::STATUSDURANTEANESTESI_SEDANG_TINDAKAN)); ?>
            <?php echo CHtml::htmlButton('Akhir Tindakan', array('class' => 'btn btn-sm btn-danger', 'id' => 'btn_akhir_tindakan', 'disabled' => $status->status_tindakanbedah != Params::STATUSDURANTEANESTESI_SEDANG_TINDAKAN, 'onclick' => 'selesaiTindakan();')); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model, 'spo2_nilai', array('class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model, 'endtidalco2_nilai', array('class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <div class="control-group">
        <label class="control-label">Inhalasi</label>
        <div class="controls">
            <?php
            echo '<div class="checkbox cb_main">'
                . $form->checkBox($model, 'isisofluran', array('class' => 'cb_ceklis', 'uncheckValue' => null, 'value' => 1)) . '<div style="width:100px; float:left;">' . $form->label($model, 'isisofluran') . '</div>'
                . $form->textField($model, 'isofluran_nilai', array('class' => 'span2 float2 cb_input'))
                . '</div>';
            echo '<div class="checkbox cb_main">'
                . $form->checkBox($model, 'issevofluran', array('class' => 'cb_ceklis', 'uncheckValue' => null, 'value' => 1)) . '<div style="width:100px; float:left;">' . $form->label($model, 'issevofluran') . '</div>'
                . $form->textField($model, 'sevofluran_nilai', array('class' => 'span2 float2 cb_input'))
                . '</div>';
            echo '<div class="checkbox cb_main">'
                . $form->checkBox($model, 'isdesfluran', array('class' => 'cb_ceklis', 'uncheckValue' => null, 'value' => 1)) . '<div style="width:100px; float:left;">' . $form->label($model, 'isdesfluran') . '</div>'
                . $form->textField($model, 'desfluran_nilai', array('class' => 'span2 float2 cb_input'))
                . '</div>';
            ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model, 'n2o_nilai', array('class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model, 'air_nilai', array('class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model, 'o2_nilai', array('class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->labelEx($model, 'pernapasan_nilai', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'pernapasan_nilai', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <label> x/Menit</label>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'suhutubuh', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'suhutubuh', array('class' => 'span1 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <label> &deg;C</label>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'td_sistolik', array('class' => 'control-label', 'label' => 'Tekanan Darah')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'td_sistolik', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <label>/</label>
            <?php echo $form->textField($model, 'td_diastolik', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'detaknadi', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'detaknadi', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <label> x/Menit</label>
        </div>
    </div>
    <?php echo $form->dropDownListRow($model, 'kesadaranpasien', LookupM::getItems('kesadaranpasien'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    <?php echo $form->textFieldRow($model, 'urine_jumlah', array('class' => 'span2 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textAreaRow($model, 'catatan', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
</div>

<div class="clear"></div>
<div class="col-sm-6">
    <?php echo $this->renderPartial($this->path_view . "_medikasi", array(
        'model' => $model,
    ), true); ?>
</div>
<div class="col-sm-6">
    <?php echo $this->renderPartial($this->path_view . "_intramuskular", array(
        'model' => $model,
    ), true); ?>

</div>

<div class="clear"></div>


<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'ulangiForm(); return false;'
        )
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Lihat Grafik Observasi Durante Operasi', array('{icon}' => '<i class="icon-picture icon-white"></i>')), $this->createUrl('grafikDurante', array('pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id)), array('class' => 'btn btn-info')); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>
</div>
<?php $this->endWidget(); ?>


<script>
    function mulaiAnestesi() {
        var waktu = $("#AnastesiduranteoperasiT_observasi_jam").val();
        var pasienmasukpenunjang_id = $("#AnastesiduranteoperasiT_pasienmasukpenunjang_id").val();

        if (waktu == null || waktu.trim() == "") {
            myAlert("Waktu Observasi Harus Diisi");
            return false;
        }

        myConfirm("Anda yakin untuk mengubah status Anestesi?", "Peringatan", function(r) {
            if (!r) {
                return false;
            }

            $.post('<?php echo $this->createUrl('mulaiAnestesi'); ?>', {
                waktu: waktu,
                pasienmasukpenunjang_id: pasienmasukpenunjang_id
            }, function(data) {
                if (data.ok) {
                    $("#btn_mulai_anestesi").attr("disabled", true);
                    $("#btn_sedang_anestesi, #btn_akhir_anestesi").attr("disabled", false);
                    myAlert(data.msg);
                }
            }, 'json');
        });
    }

    function selesaiAnestesi() {
        var waktu = $("#AnastesiduranteoperasiT_observasi_jam").val();
        var pasienmasukpenunjang_id = $("#AnastesiduranteoperasiT_pasienmasukpenunjang_id").val();

        if (waktu == null || waktu.trim() == "") {
            myAlert("Waktu Observasi Harus Diisi");
            return false;
        }

        myConfirm("Anda yakin untuk mengubah status Anestesi?", "Peringatan", function(r) {
            if (!r) {
                return false;
            }

            $.post('<?php echo $this->createUrl('selesaiAnestesi'); ?>', {
                waktu: waktu,
                pasienmasukpenunjang_id: pasienmasukpenunjang_id
            }, function(data) {
                if (data.ok) {
                    $ //("#btn_mulai_anestesi").attr("disabled", true);
                    $("#btn_sedang_anestesi, #btn_akhir_anestesi").attr("disabled", true);
                    myAlert(data.msg);
                }
            }, 'json');
        });
    }

    function mulaiTindakan() {
        var waktu = $("#AnastesiduranteoperasiT_observasi_jam").val();
        var pasienmasukpenunjang_id = $("#AnastesiduranteoperasiT_pasienmasukpenunjang_id").val();

        if (waktu == null || waktu.trim() == "") {
            myAlert("Waktu Observasi Harus Diisi");
            return false;
        }

        myConfirm("Anda yakin untuk mengubah status Tindakan/Bedah?", "Peringatan", function(r) {
            if (!r) {
                return false;
            }

            $.post('<?php echo $this->createUrl('mulaiTindakan'); ?>', {
                waktu: waktu,
                pasienmasukpenunjang_id: pasienmasukpenunjang_id
            }, function(data) {
                if (data.ok) {
                    $("#btn_mulai_tindakan").attr("disabled", true);
                    $("#btn_sedang_tindakan, #btn_akhir_tindakan").attr("disabled", false);
                    myAlert(data.msg);
                }
            }, 'json');
        });
    }

    function selesaiTindakan() {
        var waktu = $("#AnastesiduranteoperasiT_observasi_jam").val();
        var pasienmasukpenunjang_id = $("#AnastesiduranteoperasiT_pasienmasukpenunjang_id").val();

        if (waktu == null || waktu.trim() == "") {
            myAlert("Waktu Observasi Harus Diisi");
            return false;
        }

        myConfirm("Anda yakin untuk mengubah status Tindakan?", "Peringatan", function(r) {
            if (!r) {
                return false;
            }

            $.post('<?php echo $this->createUrl('selesaiTindakan'); ?>', {
                waktu: waktu,
                pasienmasukpenunjang_id: pasienmasukpenunjang_id
            }, function(data) {
                if (data.ok) {
                    $ //("#btn_mulai_anestesi").attr("disabled", true);
                    $("#btn_sedang_tindakan, #btn_akhir_tindakan").attr("disabled", true);
                    myAlert(data.msg);
                }
            }, 'json');
        });
    }

    function ceklisDisabled() {
        $(".cb_main").each(function() {

            console.log($(this));

            var ok = $(this).find(".cb_ceklis").is(":checked");

            if (ok) {
                $(this).find(".cb_input").prop("disabled", false);
            } else {
                $(this).find(".cb_input").val("").prop("disabled", true);
            }
        });
    }

    function ulangiForm() {
        myConfirm("Anda yakin untuk mengulangi ini?", "Peringatan", function(r) {
            if (r) {
                window.location = "<?php echo $this->createUrl('index', array(
                                        'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id,
                                    )); ?>";
            }
        });
    }

    $(document).ready(function() {
        $(".cb_main .cb_ceklis").on("click", ceklisDisabled);
        ceklisDisabled();
    });
</script>