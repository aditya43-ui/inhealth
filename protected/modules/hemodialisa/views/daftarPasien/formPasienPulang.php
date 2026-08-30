<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>

    </div>
</div>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pasienpulang-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tindak Lanjut</div>
    </div>
    <div class="panel-body">
        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary(array($modelPulang, $modRujukanKeluar)); ?>
        <div class="col-sm-6">
            <?php //echo $form->textFieldRow($modelPulang,'pasienadmisi_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
            ?>
            <div class="control-group">
                <?php //echo $form->labelEx($modelPulang,'tglpasienpulang', array('class'=>'control-label')) 
                ?>
                <?php echo CHtml::label('Tgl. Pasien Keluar', 'tglpasienpulang', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modelPulang,
                        'attribute' => 'tglpasienpulang',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2-5'),
                    )); ?>
                    <?php echo $form->error($modelPulang, 'tglpasienpulang'); ?>
                </div>
            </div>

            <?php echo $form->hiddenfield($modelPulang, 'pendaftaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
            <?php echo $form->hiddenfield($modelPulang, 'pasien_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
            <div class="control-group">
                <?php echo $form->labelEx($modelPulang, 'carakeluar_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $modelPulang,
                        'carakeluar_id',
                        CHtml::listData($modelPulang->getCarakeluarItems(), 'carakeluar_id', 'carakeluar_nama'),
                        array(
                            'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onclick' => 'cekCaraKeluar(this);',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('SetDropDownKondisiKeluar', array('encode' => false, 'model_nama' => get_class($modelPulang))),
                                'update' => "#" . CHtml::activeId($modelPulang, 'kondisikeluar_id'),
                            ),
                        )
                    ); ?>
                    <?php echo $form->error($modelPulang, 'carakeluar_id'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Kondisi Pulang <span class="required">*</span>', 'kondisikeluar_id', array('class' => 'control-label')) ?>
                <?php //echo $form->labelEx($modelPulang,'kondisikeluar_id', array('class'=>'control-label')) 
                ?>
                <div class="controls">
                    <?php echo $form->dropDownList(
                        $modelPulang,
                        'kondisikeluar_id',
                        CHtml::listData($modelPulang->getKondisikeluarItems($modelPulang->carakeluar_id), 'kondisikeluar_id', 'kondisikeluar_nama'),
                        array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onclick' => 'cekKondisiKeluar(this);')
                    ); ?>
                    <?php echo $form->error($modelPulang, 'kondisikeluar_id'); ?>
                </div>
            </div>
            <?php //echo $form->textFieldRow($modelPulang,'ruanganakhir_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
            ?>
            <?php echo $form->textFieldRow($modelPulang, 'penerimapasien', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

            <?php if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) { ?>
                <?php echo $form->textFieldRow($modMasukKamar, 'tglmasukkamar', array('readonly' => true)) ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modMasukKamar, 'lamadirawat_kamar', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modMasukKamar, 'lamadirawat_kamar', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Hari
                        <?php echo $form->hiddenField($modelPulang, 'lamarawat', array('class' => 'span1', 'value' => $modMasukKamar->lamadirawat_kamar, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modelPulang, 'hariperawatan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelPulang, 'hariperawatan', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Hari
                    </div>
                </div>
            <?php } else { ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modelPulang, 'lamarawat', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelPulang, 'lamarawat', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Jam
                    </div>
                </div>
                <?php echo $form->error($modelPulang, 'lamarawat'); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modelPulang, 'hariperawatan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelPulang, 'hariperawatan', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Hari
                    </div>
                </div>

            <?php } ?>
            <?php //echo $form->textFieldRow($modelPulang,'satuanlamarawat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
            ?>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-success box-meninggal">
                <div class="panel-heading">
                    <div class="panel-title">
                        <?php echo CHtml::checkBox('isDead', $modelPulang->isDead, array('onkeypress' => "return $(this).focusNextInputField(event)")) ?>
                        Pasien Meninggal
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group">
                        <?php echo $form->labelEx($modelPulang, 'tgl_meninggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modelPulang,
                                'attribute' => 'tgl_meninggal',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2-5', 'readonly' => true),
                            )); ?>

                        </div>
                    </div>
                </div>
            </div>
            Keterangan<br>
            <?php echo $form->textArea($modelPulang, 'keterangankeluar', array('rows' => 3, 'cols' => 50, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

        </div>
    </div>
</div>

<?php echo $this->renderPartial('_formRujukanKeluar', array('form' => $form, 'modelPulang' => $modelPulang, 'modRujukanKeluar' => $modRujukanKeluar)); ?>


<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $modelPulang->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')),
        array('class' => 'btn btn-default', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
</div>

<?php $this->endWidget(); ?>

<script>
    function cekCaraKeluar(obj) {
        if (obj.value == "<?php echo Params::CARAKELUAR_ID_DIRUJUK ?>") {
            $('#pakeRujukan').attr('checked', true);
            $('#divRujukan input').removeAttr('disabled');
            $('#divRujukan select').removeAttr('disabled');
            $('#divRujukan textarea').removeAttr('disabled');
            $('#divRujukan').show(500);
        } else {
            $('#pakeRujukan').removeAttr('checked');
            $('#divRujukan input').attr('disabled', 'true');
            $('#divRujukan select').attr('disabled', 'true');
            $('#divRujukan textarea').attr('disabled', 'true');
            $('#divRujukan').hide(500);
        }
    }

    function cekKondisiKeluar(obj) {
        if (obj.value == "<?php echo Params::KONDISIKELUAR_ID_MENINGGAL_1 ?>" || obj.value == "<?php echo Params::KONDISIKELUAR_ID_MENINGGAL_2 ?>") {
            $('#isDead').attr('checked', true);
            $('#HDPasienPulangT_tgl_meninggal').removeAttr('disabled');
        } else {
            $('#isDead').removeAttr('checked');
            $('#HDPasienPulangT_tgl_meninggal').attr('disabled', 'true');
        }
    }

    function konfirmasi() {
        myConfirm("<?php echo Yii::t('mds', 'Do You want to cancel?') ?>", "Perhatian!", function(r) {
            if (r) {
                window.location.href = window.location;
            } else {
                $('#HDPasienPulangT_carakeluar_id').focus();
                return false;
            }
        });
    }
    $(document).ready(function() {
        // Notifikasi Pasien
        <?php
        if (isset($smspasien)) {
            if ($smspasien == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                    isinotifikasi: 'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16 
                simpanNotifikasi(params);
        <?php
            }
        }
        ?>
    })
</script>
<?php if ($tersimpan == true) { ?>
    <script>
        parent.location.reload();
    </script>
<?php } ?>