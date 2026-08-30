<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js'); ?>
<?php
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'id' => 'MOnitoring-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    )
);
?>
<?php echo $form->errorSummary(array($model)); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-monitor"></i> Monitoring <b>Sterilisasi</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Proses Inkubasi
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Tanggal', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_inkubasi',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    //						'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Jenis Sterilisasi', '', array('class' => 'control-label')); ?>
                        <div class='controls'>
                            <?php echo $form->DropDownList($model, 'jenissterilisasi_id', CHtml::listData(STJenissterilisasiM::model()->findAll(), 'jenissterilisasi_id', 'jenissterilisasi_nama'), array('class' => 'span3')); ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Nama Mesin', '', array('class' => 'control-label')); ?>
                        <div class='controls'>
                            <?php echo $form->DropDownList($model, 'jenissterilisasi_id', CHtml::listData(STBarangM::model()->findAllByAttributes(array('jenisbarang_id' => 44)), 'barang_id', 'barang_nama'), array('class' => 'span3')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Siklus', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'siklus', LookupM::getItems("siklus"), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Ind. Biologi
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php // echo CHtml::label('sterilisasi_id','sterilisasi_id',array('class'=>'control-label')); 
                        ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($model, 'sterilisasi_id', array('class' => 'span3')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('jenis ind Biologi', 'sterilisasi_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'jenisindbiologi', LookupM::getItems("jenisindbiologi"), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Tgl. Uji', 'sterilisasi_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglujikontrol',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    //						'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                            )); ?>
                        </div>
                    </div>
                    <?php echo $form->radioButtonListInlineRow($model, 'hasilujikontrol', array('Positive' => 'Positive', 'Negative' => 'Negative'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <div class="control-group">
                        <?php echo CHtml::label('No. Lubang Uji', 'sterilisasi_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'nolubanguji', array('class' => 'span3')); ?>
                        </div>
                    </div>
                    <?php echo $form->radioButtonListInlineRow($model, 'lubangujikontrol', array('Positive' => 'Positive', 'Negative' => 'Negative'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->radioButtonListInlineRow($model, 'ind_biologiuji', array('Positive' => 'Positive', 'Negative' => 'Negative'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->radioButtonListInlineRow($model, 'ind_biologikontrol', array('Positive' => 'Positive', 'Negative' => 'Negative'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <div class="control-group">
                        <?php echo CHtml::label('Operator', 'sterilisasi_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php // echo $form->dropDownList($model,'petugasmonitoring_id', CHtml::listData($model->getOperatorItems(),'pegawai_id','nama_pegawai') ,array('empty'=>'-- Pilih --')); 
                            ?>
                            <?php echo $form->dropDownList($model, 'petugasmonitoring_id', PegawairuanganV::model()->getDropPegawaiOperator(Yii::app()->user->getState('ruangan_id')), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('class' => 'btn btn-default', 'type' => 'button', 'onClick' => 'closeDialog();')
    );
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function loadDataPendaftaran() {
        var sterilisasi_id = $('#temp_dialogMonitoring').val();
        $('#STMonitoringsterilisasiT_sterilisasi_id').val(sterilisasi_id);


    }
    loadDataPendaftaran();

    function closeDialog() {
        window.parent.$('#temp_dialogMonitoring').dialog('close');
    }

    function generatePicker() {
        jQuery('input[name$="[tglujikontrol]"]').datepicker(
            jQuery.extend({
                    showMonthAfterYear: false
                },
                jQuery.datepicker.regional['id'], {

                    'minDate': 'd',
                    'timeText': 'Waktu',
                    'hourText': 'Jam',
                    'minuteText': 'Menit',
                    'secondText': 'Detik',
                    'showSecond': true,
                    'timeOnlyTitle': 'Pilih Waktu',
                    'timeFormat': 'hh:mm:ss',
                    'changeYear': true,
                    'changeMonth': true,
                    'showAnim': 'fold',
                    'dateFormat': 'dd M yy',
                    'yearRange': '-80y:+20y'
                }
            )
        ); //mask("99/99/9999 99:99:99")
        jQuery('input[name$="[tgl_inkubasi]"]').datepicker(
            jQuery.extend({
                    showMonthAfterYear: false
                },
                jQuery.datepicker.regional['id'], {

                    'minDate': 'd',
                    'timeText': 'Waktu',
                    'hourText': 'Jam',
                    'minuteText': 'Menit',
                    'secondText': 'Detik',
                    'showSecond': true,
                    'timeOnlyTitle': 'Pilih Waktu',
                    'timeFormat': 'hh:mm:ss',
                    'changeYear': true,
                    'changeMonth': true,
                    'showAnim': 'fold',
                    'dateFormat': 'dd M yy',
                    'yearRange': '-80y:+20y'
                }
            )
        ); //mask("99/99/9999 99:99:99")
    }
    $(document).ready(function() {

        setTimeout("generatePicker()", 1000);

    });
</script>