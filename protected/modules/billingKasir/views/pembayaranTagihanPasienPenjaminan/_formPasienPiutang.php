<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>


<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'piutang-t-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),//DIMATIKAN KARENA PAKAI VERIFIKASI FORM >> , 'onsubmit'=>'return requiredCheck(this);'
        'focus'=>'#instalasi_id',
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>


<strong>Penanggung Jawab</strong>

<?php echo $form->hiddenField($model, 'pembayaranpelayanan_id'); ?>
<div class="control-group">
    <?php echo $form->labelEx($model, 'nama_penanggungjawab', array('class'=>'control-label', 'label'=>'Nama'))?>
    <div class="controls">
        <?php echo $form->textField($model, 'nama_penanggungjawab', array(
            'class'=>'span3',
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            'readonly'=>false,
        )); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'alamatktp_penanggungjawab', array('class'=>'control-label', 'label'=>'Alamat Sesuai KTP'))?>
    <div class="controls">
        <?php echo $form->textArea($model, 'alamatktp_penanggungjawab', array(
            'cols'=>4,
            'class'=>'span4',
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            'readonly'=>false,
        )); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'umur_penanggungjawab', array('class'=>'control-label', 'label'=>'Umur'))?>
    <div class="controls">
        <?php echo $form->textField($model, 'umur_penanggungjawab', array(
            'class'=>'span1 numbers-only',
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            'readonly'=>false,
        )); ?><label>Tahun</label>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'pekerjaan_penanggungjawab', array('class'=>'control-label', 'label'=>'Pekerjaan'))?>
    <div class="controls">
        <?php echo $form->textField($model, 'pekerjaan_penanggungjawab', array(
            'class'=>'span3',
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            'readonly'=>false,
        )); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'notelp_penanggungjawab', array('class'=>'control-label', 'label'=>'No. Telp'))?>
    <div class="controls">
        <?php echo $form->textField($model, 'notelp_penanggungjawab', array(
            'class'=>'span3 numbers-only',
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            'readonly'=>false,
        )); ?>
    </div>
</div>

<strong>Identitas Pasien</strong>

<div class="control-group">
    <?php echo $form->labelEx($pasien, 'nama_pasien', array('class'=>'control-label', 'label'=>'Nama Pasien'))?>
    <div class="controls">
        <?php echo CHtml::activeTextField($pasien, 'nama_pasien', array(
            'class'=>'span3 input_readonly',
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            'readonly'=>true,

            //'style'=>'font-weight: bold;', 
        )); ?>
    </div>
</div>

<div class="control-group">
    <?php echo $form->labelEx($pasien, 'alamat_pasien', array('class'=>'control-label', 'label' => 'Alamat Pasien'))?>
    <div class="controls">
        <?php echo CHtml::activeTextArea($pasien, 'alamat_pasien', array(
            'class'=>'span4 input_readonly',
            'rows'=>4,
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            'readonly'=>true,

            //'style'=>'font-weight: bold;', 
        )); ?>
    </div>
</div>

<div class="control-group">
    <?php echo $form->labelEx($pendaftaran, 'no_pendaftaran', array('class'=>'control-label', 'label'=>'No. RM/No. Pendaftaran'))?>
    <div class="controls">
        <?php echo CHtml::activeTextField($pasien, 'no_rekam_medik', array(
            'class'=>'span2 input_readonly',
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            'readonly'=>true,

            //'style'=>'font-weight: bold;', 
        )); ?>
        <?php echo CHtml::activeTextField($pendaftaran, 'no_pendaftaran', array(
            'class'=>'span2 input_readonly',
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            'readonly'=>true,

            //'style'=>'font-weight: bold;', 
        )); ?>
    </div>
</div>


<div class="control-group">
    <?php echo $form->labelEx($model,'tglmrs_krs', array('class'=>'control-label', 'label' => 'Tgl. MRS / Tgl. KRS')) ?>
    <div class="controls">
        <?php   
                $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'tglmrs_krs',
                        'mode'=>'datetime',
                        'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                //'maxDate' => 'd',
                        ),
                        'htmlOptions'=>array('class'=>'dtPicker2-5 span3', 
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'readonly' => true
                        ),
        )); ?>
    </div>
</div>

<div class="control-group">
    <?php echo $form->labelEx($model, 'tempat_layanan', array('class'=>'control-label'))?>
    <div class="controls">
        <?php echo CHtml::textField('tempat_layanan', $pendaftaran->pasienadmisi->ruangan->ruangan_nama ?? $pendaftaran->ruangan->ruangan_nama ?? "-", array(
            'class'=>'span3 input_readonly',
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            'readonly'=>true,

            //'style'=>'font-weight: bold;', 
        )); ?>
    </div>
</div>
<div class="control-group ">
    <?php echo $form->labelEx($model,'tanggal_akad', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php   
                $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'tanggal_akad',
                        'mode'=>'datetime',
                        'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                //'maxDate' => 'd',
                        ),
                        'htmlOptions'=>array('class'=>'dtPicker2-5 span3', 
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'readonly' => true
                        ),
        )); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'jangka_waktu', array('class'=>'control-label'))?>
    <div class="controls">
        <?php echo $form->textField($model,'jangka_waktu',array(
            'class'=>'span2',
            'onkeyup'=>"return $(this).focusNextInputField(event);",

            //'style'=>'font-weight: bold;', 
        )); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'catatan', array('class'=>'control-label'))?>
    <div class="controls">
        <?php echo $form->textArea($model,'catatan',array(
            'class'=>'span4',
            'rows'=>4,
            'onkeyup'=>"return $(this).focusNextInputField(event);",

            //'style'=>'font-weight: bold;', 
        )); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'jumlah_total', array('class'=>'control-label'))?>
    <div class="controls">
        <?php echo $form->textField($model,'jumlah_total',array(
            'class'=>'span2 integer2 input_readonly',
            'readonly'=>true, 
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            //'style'=>'font-weight: bold;', 
        )); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'jumlah_bayarhutang', array('class'=>'control-label', 'label'=>'Jumlah Bayar'))?>
    <div class="controls">
        <?php echo $form->textField($model,'jumlah_bayarhutang',array(
            'class'=>'span2 integer2', 
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            'onblur'=>'hitungPiutangMandiri()',
            //'style'=>'font-weight: bold;', 
        )); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'jumlah_sisahutang', array('class'=>'control-label required', 'label'=>'Jumlah Sisa'))?>
    <div class="controls">
        <?php echo $form->textField($model,'jumlah_sisahutang',array(
            'class'=>'span2 integer2 input_readonly',
            'readonly'=>true, 
            'onkeyup'=>"return $(this).focusNextInputField(event);",
            //'style'=>'font-weight: bold;', 
        )); ?>
    </div>
</div>
<div class="form-action">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); //formSubmit(this,event) ?>
</div>

<?php $this->endWidget(); ?>

<script>
    
    function hitungPiutangMandiri() {
        var piutang = parseFloat(unformatNumber($("#BKPembayaranpelayananT_jumlah_total").val()));
        var bayar = parseFloat(unformatNumber($("#BKPembayaranpelayananT_jumlah_bayarhutang").val()));
        var sisa = 0;

        if (bayar > piutang) {
            bayar = piutang;
        }
        sisa = piutang - bayar;

        $("#BKPembayaranpelayananT_jumlah_total").val(formatNumber(piutang));
        $("#BKPembayaranpelayananT_jumlah_bayarhutang").val(formatNumber(bayar));
        $("#BKPembayaranpelayananT_jumlah_sisahutang").val(formatNumber(sisa));

    }

    $(document).ready(function() {
        hitungPiutangMandiri();
    });


</script>