<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Penyerahan <b>Hasil Pemeriksaan Radiologi</b>
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
                $this->renderPartial('template/_ringkasDataPasien2', array('modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modPasien' => $modPasien));
                echo $form->errorSummary(array($modHasilRad));
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
                            <?php $modHasilRad->tglpengambilanhasil = $format->formatDateTimeId(date('Y-m-d H:i:s')); ?>
                            <?php echo $form->labelEx($modHasilRad, 'tglpengambilanhasil', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget(
                                    'MyDateTimePicker',
                                    array(
                                        'model' => $modHasilRad,
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
                                <?php echo $form->textFieldRow($modHasilRad, 'namapenerimahasil', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                            <div class="inline" id="sendiri">
                                &nbsp;<?php echo $form->checkBox($modHasilRad, 'is_sendiri', array('readonly' => false, 'onclick' => 'setEnableForm()')); ?><span style="font-size: 8pt">Pilih jika diri sendiri</span>
                            </div>
                        </div>

                        <div class="control-group">
                            <?php echo CHtml::label("Identitas Pengambil Hasil", '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modHasilRad, 'jenisidentitas', LookupM::getItemsUrutan('jenisidentitas'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1', 'style' => 'float:left; width:80px'));
                                ?>
                                <?php echo $form->textField($modHasilRad, 'no_identitas', array('class' => 'span2 ', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>

                        <?php echo $form->textFieldRow($modHasilRad, 'notelppenerimahasil', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textAreaRow($modHasilRad, 'alamat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textAreaRow($modHasilRad, 'ketpenyerahan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($modHasilRad, 'namaygmenyerahkan', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

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
        if (document.getElementById("HasilpemeriksaanradT_is_sendiri").checked) {
            $('#HasilpemeriksaanradT_namapenerimahasil').val($("#ROPasienMasukPenunjangV_nama_pasien").val());
            $('#HasilpemeriksaanradT_notelppenerimahasil').val($("#ROPasienM_no_mobile_pasien").val());
            $('#HasilpemeriksaanradT_jenisidentitas').val($("#ROPasienM_jenisidentitas").val());
            $('#HasilpemeriksaanradT_no_identitas').val($("#ROPasienM_no_identitas_pasien").val());
            $('#HasilpemeriksaanradT_alamat').val($("#ROPasienM_alamat_pasien").val());
        } else {
            $('#HasilpemeriksaanradT_namapenerimahasil').val('');
            $('#HasilpemeriksaanradT_notelppenerimahasil').val('');
            $('#HasilpemeriksaanradT_jenisidentitas').val('');
            $('#HasilpemeriksaanradT_no_identitas').val('');
            $('#HasilpemeriksaanradT_alamat').val('');
        }
    }
</script>