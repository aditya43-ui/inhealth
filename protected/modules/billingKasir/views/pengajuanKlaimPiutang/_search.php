
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'GET',
    'type' => 'horizontal',
    'id' => 'searchLaporan',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'
    ),
        )
);
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
<?php echo $form->errorSummary(array($modPengajuanKlaim, $modPengajuanKlaimDetail)); ?>
<fieldset>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Tgl. Pelayanan', 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $modPendaftaran->tgl_awal = $format->formatDateTimeForUser($modPendaftaran->tgl_awal);
                    $this->widget('MyDateTimePicker', array(
                        'name' => 'Filter[tgl_awal]',
                        'model' => $modPendaftaran,
                        'attribute' => 'tgl_awal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:140px;',
                        //                                    'onchange'=>'ajaxGetList()',
                        ),
                    ));
                    $modPendaftaran->tgl_awal = $format->formatDateTimeForDb($modPendaftaran->tgl_awal);
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Sampai Dengan', 'sampai dengan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $modPendaftaran->tgl_akhir = $format->formatDateTimeForUser($modPendaftaran->tgl_akhir);
                    $this->widget('MyDateTimePicker', array(
                        'name' => 'Filter[tgl_akhir]',
                        'model' => $modPendaftaran,
                        'attribute' => 'tgl_akhir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:140px;',
                        //                                    'onchange'=>'ajaxGetList()',
                        ),
                    ));
                    $modPendaftaran->tgl_akhir = $format->formatDateTimeForDb($modPendaftaran->tgl_akhir);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Jenis Penjamin <span class="required">*</span>', 'cara bayar', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeDropDownList($modPendaftaran, 'carabayar_id', CHtml::listData($modPendaftaran->getCaraBayarItems('piutang'), 'carabayar_id', 'carabayar_nama'), array('style' => 'width:200px;', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'ajax' => array('type' => 'POST',
                            'url' => $this->createUrl('GetPenjaminPasien', array('encode' => false, 'namaModel' => 'BKPendaftaranT')),
                            'update' => '#BKPendaftaranT_penjamin_id'  //selector to update
                        ),
                    ));
                    ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label('Penjamin <span class="required">*</span>', 'penjamin', array('class' => 'control-label')); ?>
                <div class="controls">
                <?php
                echo CHtml::activeDropDownList($modPendaftaran, 'penjamin_id', CHtml::listData($modPendaftaran->getPenjaminItems($modPendaftaran->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('style' => 'width:200px;', 'empty' => '-- Pilih --',
                    'onkeypress' => "return $(this).focusNextInputField(event)",));
                ?>
                </div>
            </div>

        </div>

    </div>
</fieldset>
<div class="form-actions">
<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onClick' => 'ajaxGetList();')); ?>
    <span>&nbsp;</span>
<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset', 'onClick' => 'onReset()')); ?>
</div>

<?php
$this->endWidget();
?>
