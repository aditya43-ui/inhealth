<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

<?php

$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
	'id'=>'ubahcarabayar-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
        'htmlOptions'=>array(
            'onKeyPress'=>'return disableKeyPress(event)'
        ),
    )
);

?>

<!-- <p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p> -->
    <?php echo $form->errorSummary($model); ?>
    <?php echo CHtml::hiddenField('pendaftaran_id','',array('readonly'=>true)); ?>
    <?php //echo $form->textFieldRow($model,'pendaftaran_id',array()); ?>
    <div class="control-group">
        <?php echo CHtml::label('No. Pendaftaran ', 'noPendaftaran', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::textField('noPendaftaran','noPendaftaran',array('readonly'=>true)); ?>
        </div>
    </div>
    <?php
        echo $form->dropDownListRow(
            $model,'carabayar_id',CHtml::listData(CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true)), 'carabayar_id', 'carabayar_nama'),
            array(
                'onchange'=>"listPenjamin(this.value);onClickAsuransi(this);"
            )
        );
    ?>
    <?php echo $form->dropDownListRow($model,'penjamin_id',array()); ?>
    <?php echo $form->textAreaRow($model,'alasanperubahan',array()); ?>

    <div id="divAsuransi" class="<?php echo ($model->pakeAsuransi) ? '':'hide' ?>" >
        <?php echo $form->textFieldRow($modPendaftaran,'no_asuransi', array('disabled'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. Asuransi')); ?>
        <?php echo $form->textFieldRow($modPendaftaran,'namapemilik_asuransi', array('disabled'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Nama Pemilik Asuransi')); ?>
        <?php echo $form->textFieldRow($modPendaftaran,'nopokokperusahaan', array('disabled'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. Pokok Perusahaan')); ?>
        <?php echo $form->textFieldRow($modPendaftaran,'namaperusahaan', array('disabled'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Nama Perusahaan'));?>
        <?php echo $form->dropDownListRow($modPendaftaran,'kelastanggungan_id', CHtml::listData($modPendaftaran->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:120px;')); ?>
        <div class="control-group">
            <div class="controls">
                 <?php echo $form->checkBox($modPendaftaran,'status_konfirmasi', array('onkeypress'=>"return $(this).focusNextInputField(event)",'checked'=>false)); ?>Status Konfirmasi
                <?php echo $form->error($modPendaftaran, 'tgl_konfirmasi'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($modPendaftaran,'tgl_konfirmasi', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php   
                        $this->widget(
                            'MyDateTimePicker',array(
                                'model'=>$modPendaftaran,
                                'attribute'=>'tgl_konfirmasi',
                                'mode'=>'datetime',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                            )
                        );
                ?>
                <?php echo $form->error($modPendaftaran, 'tgl_konfirmasi'); ?>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php
            echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')
            );
        ?>
    </div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    
function onClickAsuransi()
{
    var data = {
            8:'ada',
            5:'ada',
            1:'ada',
            7:'ada',
            15:'ada'
    };
    var cara_bayar = $("#UbahcarabayarR_carabayar_id").val();
    if(data[cara_bayar] != undefined)
    {
        $('#divAsuransi').hide();
        $('#divAsuransi input').attr('disabled','true');
        $('#divAsuransi select').attr('disabled','true');
        $('#divAsuransi input').attr('value','');
        $('#divAsuransi select').attr('value','');
    }else{
        $('#divAsuransi input').removeAttr('disabled');
        $('#divAsuransi select').removeAttr('disabled');
        $('#divAsuransi').show();
    }
}

function loadPendaftaranId()
{   
    jQuery('#PendaftaranT_tgl_konfirmasi').datetimepicker(
        jQuery.extend(
            {showMonthAfterYear:false},
            jQuery.datepicker.regional['id'],
            {
                'maxDate':'d',
                'dateFormat':'dd M yy',
                'timeText':'Waktu',
                'hourText':'Jam',
                'minuteText':'Menit',
                'secondText':'Detik',
                'showSecond':true,
                'timeOnlyTitle':'Pilih Waktu',
                'timeFormat':'hh:mm:ss',
                'changeYear':true,
                'changeMonth':true,
                'showAnim':'fold',
                'yearRange':'-80y:+20y'
            }
        )
    );
    var pendaftaran_id = $('#tempPendaftaranId').val();
    var noPendaftaran = $('#tempNoPendaftaran').val();
    var idCaraBayar = $('#tempCaraBayarId').val();
    $('#carabayardialog div.divForFormUbahCaraBayar #pendaftaran_id').val(pendaftaran_id);
    $('#carabayardialog div.divForFormUbahCaraBayar #noPendaftaran').val(noPendaftaran);
    
    $.post("<?php echo Yii::app()->createUrl('ActionAjax/getListCaraBayar')?>", { idCaraBayar: idCaraBayar },
        function(data){
            $('#carabayardialog div.divForFormUbahCaraBayar #UbahcarabayarR_carabayar_id').html(data.listCaraBayar);
            $('#carabayardialog div.divForFormUbahCaraBayar #UbahcarabayarR_penjamin_id').html(data.listPenjamin);
            onClickAsuransi()
            
            $.post("<?php echo Yii::app()->createUrl('ActionAjax/getDataPendaftaranRI')?>", { pendaftaran_id:pendaftaran_id },
                function(data)
                {
                    $('#carabayardialog').find('input[name$="[no_asuransi]"]').val(data.no_asuransi);
                    $('#carabayardialog').find('input[name$="[namapemilik_asuransi]"]').val(data.namapemilik_asuransi);
                    $('#carabayardialog').find('input[name$="[nopokokperusahaan]"]').val(data.nopokokperusahaan);
                    $('#carabayardialog').find('input[name$="[namaperusahaan]"]').val(data.namaperusahaan);
                    $('#carabayardialog').find('input[name$="[kelastanggungan_id]"]').val(data.kelastanggungan_id);
                    $('#carabayardialog').find('input[name$="[status_konfirmasi]"]').val(data.status_konfirmasi);
                    $('#carabayardialog').find('input[name$="[tgl_konfirmasi]"]').val(data.tgl_konfirmasi);
                    $('#carabayardialog').find('select[name$="[penjamin_id]"]').val(data.penjamin_id);
                },
            "json");
            
            
    }, "json");
}

loadPendaftaranId();

function listPenjamin(idCaraBayar)
{
    $.post("<?php echo Yii::app()->createUrl('ActionAjax/getListPenjamin')?>", { idCaraBayar: idCaraBayar },
        function(data){
            $('#carabayardialog div.divForFormUbahCaraBayar #UbahcarabayarR_penjamin_id').html(data.listPenjamin);
    }, "json");
}
</script>