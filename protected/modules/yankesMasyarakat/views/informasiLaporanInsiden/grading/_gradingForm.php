<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gradinginsidenrs-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <?php echo CHtml::label('Tanggal Grading ', 'tgl_gradingunit', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tgl_gradingunit = date("Y-m-d H:i:s");
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_gradingunit',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'changeYear' => false,
                    ),
                    'htmlOptions' => array('class' => 'dtPicker2 span3', 'onkeyup' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Peluang', 'peluang_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'peluang_id', PeluangM::model()->getListPeluang(), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span3',
                    'ajax' => array('type' => 'POST',
                        'url' => $this->createUrl('/actionDynamic/GetKonsekuensi', array('encode' => false, 'namaModel' => get_class($model))),
                        'success' => 'function(data){$("#' . CHtml::activeId($model, "konsekuensi_id") . '").html(data); }',
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Konsekuensi', 'konsekuensi_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'konsekuensi_id', KonsekuensiM::model()->getListNamaKonsekuensi(), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span3',
                    'ajax' => array('type' => 'POST',
                        'url' => $this->createUrl('/actionDynamic/GetTingkatRisiko', array('encode' => false, 'namaModel' => get_class($model))),
                        'success' => 'function(data){$("#' . CHtml::activeId($model, "tingkatrisiko_id") . '").html(data); setTindakan(); }',
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Skor Risiko', 'skor_risiko', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'skor_risiko', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tingkat Risiko', 'tingkatrisiko_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'tingkatrisiko_id', Chtml::listData(TingkatrisikoM::model()->findAllByAttributes(array('tingkatrisiko_aktif' => true)), 'tingkatrisiko_id', 'tingkatrisiko_nama'), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span3', 'onchange' => 'setTindakan();',
                    'readonly'=>true,
                    'ajax' => array('type' => 'POST',
                        'url' => $this->createUrl('/actionDynamic/GetWarnaRisiko', array('encode' => false, 'namaModel' => get_class($model))),
                        'success' => 'function(data){$("#' . CHtml::activeId($model, "gradingrisiko") . '").html(data); }',
                    ),
                ));
                
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Grading Risiko Kejadian', 'gradingrisiko', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'gradingrisiko', CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type' => 'tingkatwarna_risiko')), 'lookup_value', 'lookup_name'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly'=>true, 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group" id="tindakanini">
            <?php echo CHtml::label('Tindakan', 'tindakan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'tindakan', array('class' => 'span3', 'rows' => 5, 'readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tindak Lanjut', 'tindaklanjut', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'tindaklanjut', array('class' => 'span3', 'rows' => 4, 'readonly'=>false)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Grader', 'grader1', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $cekInsiden = InsidenrsT::model()->findByPk($_GET['insidenrs_id']);
                $cekPegawai = PegawaiM::model()->findByPk($cekInsiden->mengetahui_id);

                if (!empty($cekInsiden->mengetahui_id)) {
                    $model->grader1 = $cekPegawai->pegawai_id;
                    $model->grader1_nama = $cekPegawai->namaLengkap;
                } else {
                    $model->grader1 = '';
                    $model->grader1_nama = '';
                }
                echo $form->hiddenField($model, 'grader1', array('class' => 'span3', 'readonly' => true));
                echo $form->textField($model, 'grader1_nama', array('class' => 'span3', 'readonly' => true));
                ?>
            </div>
        </div>
    </div>
</div>

<div class="form-action">
    <?php
    $cek = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $model->insidenrs_id));
    if ($cekInsiden->mengetahui_id == Yii::app()->user->getState('pegawai_id') && empty($cek->tglverifikasi_unit)) {
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    } else {
        if (empty($cek->tglverifikasi_unit)) {
            echo CHtml::link(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), '#', array('class' => 'btn btn-primary', 'onclick' => 'myAlert("Maaf, Anda Tidak bisa melakukan Grading, Grading hanya bisa dilakukan oleh kepala bagian");return false;'));
        }
    }
    ?>
</div>
<?php $this->endWidget(); ?>
<script>
    /**
     * Set tindakan
     * @param {type} obj
     * @returns {Boolean}
     */
    function setTindakan(obj) {
        var tingkatrisiko_id = $('#GradinginsidenrsT_tingkatrisiko_id').val();
        var peluang = $("#GradinginsidenrsT_peluang_id").val();
        var konsekuensi = $("#GradinginsidenrsT_konsekuensi_id").val();
        var GradinginsidenrsT_gradingrisiko
            $("#GradinginsidenrsT_tingkatrisiko_id").val()
        
        if (tingkatrisiko_id != ''){
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('setTindakan'); ?>',
                data: {
                    nilai: $(obj).val(),
                    tingkatrisiko_id: tingkatrisiko_id,
                    peluang:peluang,
                    konsekuensi:konsekuensi
                }, //
                dataType: "json",
                success: function (data) {
                    //$('#tindakanini').html(data.form);
                    if (data.ok != 1) {
                        toastr.warning(data.msg);
                        $("#GradinginsidenrsT_tindakan").val("");
                        return false;
                    }
                    $("#GradinginsidenrsT_skor_risiko").val(data.skor);
                    setVal(data.data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }
    
    /**
     * Set data tindakan dan regrading
     * @param {type} data
     * @returns {undefined}     
     */
    function setVal(data){
         $("#GradinginsidenrsT_tindakan").val(data.tingkatrisiko_tindakan);
         $("#GradinginsidenrsT_gradingrisiko").val(data.tingkatrisiko_warna);
    }
    setTindakan();
    
    $(document).ready(function(){
        if ('<?= !empty($cek->tglverifikasi_unit) ?>') {
            $("#gradinginsidenrs-t-form select").attr("disabled", true);
            $("#gradinginsidenrs-t-form input").attr("disabled", true);
            $("#gradinginsidenrs-t-form textarea").attr("disabled", true);
        } 
    }); 
</script>

<?php if (isset($_GET['sukses'])) { ?>
    <script>
        parent.location.reload();
    </script>
<?php } ?>