<!-- <div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Penyerahan <b>Hasil Pemeriksaan MCU</b>
        </div>
    </div>
    <div class="panel-body"> -->
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
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', '<b>Berhasil </b> Data berhasil disimpan');
        }
        $this->widget('bootstrap.widgets.BootAlert');
        $this->renderPartial('_ringkasDataPasien', array('modPasienMcu' => $modPasienMcu, 'modHasilMcu' => $modHasilMcu, 'modPasien' => $modPasien));
        echo $form->errorSummary(array($modHasilMcu));
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
                    <?php $modHasilMcu->tglpengambilanhasil = $format->formatDateTimeId(date('Y-m-d H:i:s')); ?>
                    <?php echo $form->labelEx($modHasilMcu, 'tglpengambilanhasil', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget(
                            'MyDateTimePicker',
                            array(
                                'model' => $modHasilMcu,
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
                <?php echo $form->textFieldRow($modHasilMcu, 'namapenerimahasil', array('placeholder' => 'Nama Pengambil Hasil', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                <div class="control-group">
                    <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modHasilMcu, 'is_sendiri', array('readonly' => false, 'onclick' => 'setEnableForm()')); ?><span style="font-size: 8pt">Pilih jika diri sendiri</span>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label("Identitas Pengambil Hasil", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modHasilMcu, 'jenisidentitas', LookupM::getItemsUrutan('jenisidentitas'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1', 'style' => 'float:left; width:80px'));
                        ?>
                        <?php echo $form->textField($modHasilMcu, 'no_identitas', array('placeholder' => '00', 'class' => 'span2 ', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>

                <?php echo $form->textFieldRow($modHasilMcu, 'notelppenerimahasil', array('placeholder' => 'No. Telp Pengambil Hasil', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textAreaRow($modHasilMcu, 'alamat', array('placeholder' => 'Alamat', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modHasilMcu, 'ketpenyerahan', array('placeholder' => 'Keterangan Pengambilan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modHasilMcu, 'namaygmenyerahkan', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

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
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array(
            'title' => 'Simpan',
            'class' => 'btn btn-danger', 'type' => 'submit',
            'id' => 'btn_simpan', $disable => $disable
        )
    );
    ?>
    <?php
    // echo CHtml::link(
    //     Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    //     $this->createUrl('index'),
    //     array('title' => 'Ulang', 'class' => 'btn btn-default')
    // );
    ?>
</div>

<?php $this->endWidget(); ?>
<!-- </div>
</div> -->

<script type="text/javascript">
    function setEnableForm() {
        if (document.getElementById("KesimpulanmcuT_is_sendiri").checked) {
            $('#KesimpulanmcuT_namapenerimahasil').val($("#MCInfokunjunganmcuV_nama_pasien").val());
            $('#KesimpulanmcuT_notelppenerimahasil').val($("#PasienM_no_mobile_pasien").val());
            $('#KesimpulanmcuT_jenisidentitas').val($("#PasienM_jenisidentitas").val());
            $('#KesimpulanmcuT_no_identitas').val($("#PasienM_no_identitas_pasien").val());
            $('#KesimpulanmcuT_alamat').val($("#PasienM_alamat_pasien").val());
        } else {
            $('#KesimpulanmcuT_namapenerimahasil').val('');
            $('#KesimpulanmcuT_notelppenerimahasil').val('');
            $('#KesimpulanmcuT_jenisidentitas').val('');
            $('#KesimpulanmcuT_no_identitas').val('');
            $('#KesimpulanmcuT_alamat').val('');
        }
    }
</script>