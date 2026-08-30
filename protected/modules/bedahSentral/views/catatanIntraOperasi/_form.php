<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bedahanastesilokal-intraop-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>

<?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienadmisi_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienmasukpenunjang_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php // echo $form->textFieldRow($model,'rencanaoperasi_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);"));  
?>
<?php echo $form->errorSummary($model); ?>

<?php echo $this->renderPartial($this->path_view . "_riwayat", array('model' => $model), true); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Observasi Intra Operasi</b>
        </div>
    </div>
    <div class="panel-body">
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
                ));
                ?>
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

        <?php //echo $form->textFieldRow($model, 'status_anestesi', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); 
        ?>
        <?php //echo $form->textFieldRow($model, 'status_tindakanbedah', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); 
        ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'respirasi_nilai', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'respirasi_nilai', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label> x/Menit</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'td_systolic', array('class' => 'control-label', 'label' => 'Tekanan Darah')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'td_systolic', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label>/</label>
                <?php echo $form->textField($model, 'td_dyastolic', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'detaknadi', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'detaknadi', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label> x/Menit</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'suhubadan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'suhubadan', array('class' => 'span1 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label> &deg;C</label>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class='fas fa-tablets'></i> Obat yang Digunakan
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view . "_penggunaanObat", array(
            'form' => $form,
            'model' => $model,
        ), true); ?>
    </div>
</div>


<?php // echo $form->textFieldRow($model, 'create_time', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model, 'update_time', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model, 'create_loginpemakai_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model, 'update_loginpemakai_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
?>
<?php // echo $form->textFieldRow($model, 'create_ruangan', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);"));  
?>
<div class="clear"></div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'ulangiForm(); return false;'
        )
    ); ?>
    <?php // echo CHtml::link(Yii::t('mds', '{icon} Pengaturan BedahanastesilokalIntraopT', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Lihat Grafik Observasi Intra Operasi ', array('{icon}' => '<i class="icon-picture icon-white"></i>')), $this->createUrl('grafikIntra', array('pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id)), array('class' => 'btn btn-info')); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>

<script>
    function mulaiAnestesi() {
        var waktu = $("#BedahanastesilokalIntraopT_observasi_jam").val();
        var pasienmasukpenunjang_id = $("#BedahanastesilokalIntraopT_pasienmasukpenunjang_id").val();

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
        var waktu = $("#BedahanastesilokalIntraopT_observasi_jam").val();
        var pasienmasukpenunjang_id = $("#BedahanastesilokalIntraopT_pasienmasukpenunjang_id").val();

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
        var waktu = $("#BedahanastesilokalIntraopT_observasi_jam").val();
        var pasienmasukpenunjang_id = $("#BedahanastesilokalIntraopT_pasienmasukpenunjang_id").val();

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
        var waktu = $("#BedahanastesilokalIntraopT_observasi_jam").val();
        var pasienmasukpenunjang_id = $("#BedahanastesilokalIntraopT_pasienmasukpenunjang_id").val();

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

    function ulangiForm() {
        myConfirm("Anda yakin untuk mengulangi ini?", "Peringatan", function(r) {
            if (r) {
                window.location = "<?php echo $this->createUrl('create', array(
                                        'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id,
                                    )); ?>";
            }
        });
    }
</script>