<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Penyerahan <b>Hasil Pemeriksaan Laboratorium</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'hasil-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'type' => 'horizontal',
            'focus' => '#',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Pasien</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->widget('bootstrap.widgets.BootAlert');
                $this->renderPartial('template/_ringkasDataPasien2', array('modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modHasilLab' => $modHasilLab, 'modPasien' => $modPasien));
                echo $form->errorSummary(array($modHasilLab));
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Penyerahan Hasil
                </div>
            </div>
            <div class="panel-body">
                <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php $modHasilLab->tglpengambilanhasil = $format->formatDateTimeId(date('Y-m-d H:i:s')); ?>
                            <?php echo $form->labelEx($modHasilLab, 'tglpengambilanhasil', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget(
                                    'MyDateTimePicker',
                                    array(
                                        'model' => $modHasilLab,
                                        'attribute' => 'tglpengambilanhasil',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            //                                        'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array(
                                            'class' => 'dtPicker3 span3',
                                            'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    )
                                );
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <?php echo $form->textFieldRow($modHasilLab, 'namapenerimahasil', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                            <div class="inline" id="sendiri">
                                &nbsp;<?php echo $form->checkBox($modHasilLab, 'is_sendiri', array('readonly' => false, 'onclick' => 'setEnableForm()')); ?><span style="font-size: 8pt">Pilih jika diri sendiri</span>
                            </div>
                        </div>

                        <div class="control-group">
                            <?php echo CHtml::label("Identitas Pengambil Hasil", '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modHasilLab, 'jenisidentitas', LookupM::getItemsUrutan('jenisidentitas'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1', 'style' => 'float:left; width:80px'));
                                ?>
                                <?php echo $form->textField($modHasilLab, 'no_identitas', array('class' => 'span2 ', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>

                        <?php echo $form->textFieldRow($modHasilLab, 'notelppenerimahasil', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textAreaRow($modHasilLab, 'alamat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textAreaRow($modHasilLab, 'ketpenyerahan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($modHasilLab, 'namaygmenyerahkan', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class='form-actions'>
            <?php
            $disable = '';
            if (isset($_GET['sukses'])) {
                $disable = 'disabled';
            }
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
                'class' => 'btn btn-danger', 'type' => 'submit',
                'id' => 'btn_simpan', $disable => $disable
            ));
            ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index'), array('class' => 'btn btn-danger')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
<script type="text/javascript">
    function setEnableForm() {
        if (document.getElementById("LBHasilPemeriksaanLabT_is_sendiri").checked) {
            $('#LBHasilPemeriksaanLabT_namapenerimahasil').val($("#LBPasienMasukPenunjangV_nama_pasien").val());
            $('#LBHasilPemeriksaanLabT_notelppenerimahasil').val($("#LBPasienM_no_mobile_pasien").val());
            $('#LBHasilPemeriksaanLabT_jenisidentitas').val($("#LBPasienM_jenisidentitas").val());
            $('#LBHasilPemeriksaanLabT_no_identitas').val($("#LBPasienM_no_identitas_pasien").val());
            $('#LBHasilPemeriksaanLabT_alamat').val($("#LBPasienM_alamat_pasien").val());
        } else {
            $('#LBHasilPemeriksaanLabT_namapenerimahasil').val('');
            $('#LBHasilPemeriksaanLabT_notelppenerimahasil').val('');
            $('#LBHasilPemeriksaanLabT_jenisidentitas').val('');
            $('#LBHasilPemeriksaanLabT_no_identitas').val('');
            $('#LBHasilPemeriksaanLabT_alamat').val('');

        }
    }
</script>