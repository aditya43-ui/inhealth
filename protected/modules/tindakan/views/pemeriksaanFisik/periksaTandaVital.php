<?php
$this->widget('bootstrap.widgets.BootAlert'); 
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pemeriksaanfisik-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<?php echo $form->hiddenField($modPemeriksaanFisik, 'pendaftaran_id'); ?>
<?php echo $form->hiddenField($modPemeriksaanFisik, 'pasien_id'); ?>
<?php echo $form->hiddenField($modPasien, 'jeniskelamin'); ?>
<div class="row">
    <div class="col-sm-12">

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pemeriksaan</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo CHtml::label('Instalasi / Ruangan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('instalasi',$modPendaftaran->instalasi->instalasi_nama, array('class'=>'span2','readonly'=>true)) ?>
                        <?php echo CHtml::textField('ruangan',$modPendaftaran->ruangan->ruangan_nama, array('class'=>'span2','readonly'=>true)) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'tglperiksafisik', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $this->widget('MyDateTimePicker', array(
                            'model' => $modPemeriksaanFisik,
                            'attribute' => 'tglperiksafisik',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'span3 dtPicker3 realtime',
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php
                    echo $form->label($modPemeriksaanFisik, 'pegawai_id', array('class' => 'control-label', 'label' =>'Dokter <span class="required">*</span>')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modPemeriksaanFisik, 'pegawai_id', CHtml::listData($modPemeriksaanFisik->getDokterItems($modPendaftaran->ruangan_id), 'pegawai_id', 'NamaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php
                    echo $form->label($modPemeriksaanFisik, 'perawat', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modPemeriksaanFisik, 'paramedis_nama', CHtml::listData($modPemeriksaanFisik->ParamedisItems, 'pegawai.nama_pegawai', 'pegawai.nama_pegawai'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>
                
                <?= $this->renderPartial($this->path_view . "_keluhanAnamnesa", array('model' => $modAnamnesa, 'form' => $form), true); ?>
                    
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Tanda Vital
                </div>
            </div>
            <div class="panel-body">
                <?php
                    echo $this->renderPartial($this->path_view . "pemeriksaan/_tandaVital", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);
                ?>
            </div>
        </div>
    </div>
</div>
<?php
    $btnsukses = (!empty($_GET['sukses'])? true: false);
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled' => $btnsukses));
?>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    
function returnValue(obj){
    var value = $(obj).val();
    var attrID = $(obj).attr('id');
    var td = $('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'tekanandarah') ?>').val();
    var splitTD = td.split(' / ');
    
    if (attrID == '<?php echo CHtml::activeId($modPemeriksaanFisik, 'td_diastolic') ?>'){
        splitTD[0] = splitTD[0].replace(/_/gi, "0");
        $('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'tekanandarah') ?>').val(splitTD[0]+' / '+value);
    }
    else if (attrID == '<?php echo CHtml::activeId($modPemeriksaanFisik, 'td_systolic') ?>'){
        splitTD[1] = splitTD[1].replace(/_/gi, "0");
        $('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'tekanandarah') ?>').val(value+' / '+splitTD[1]);
    }
}


function getText(){
    var dias = parseFloat($('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'td_diastolic') ?>').val());
    var sys = parseFloat($('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'td_systolic') ?>').val());
    var arteri = ((sys+(2*dias))/3);
    
    if (jQuery.isNumeric(dias)){
        if (jQuery.isNumeric(sys)){
            $.post('<?php echo Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/GetTextTekananDarah') ?>', {diastolic:dias, systolic:sys}, function(data){
                if (data.text == null){
                    $('#tekananDarah').val('Tekanan Darah Tidak Ditemukan');
                } else {
                    $('#tekananDarah').val(data.text);
                }
            },'json');
            $('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'meanarteripressure') ?>').val(arteri.toFixed(2));
        }
    }
}


function getfromDevice(){
    $.post('<?php echo $this->createUrl('getfromDevice'); ?>',{},function(dataz){
        $('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'detaknadi') ?>').val(dataz.detaknadi);
        $('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'tekanandarah') ?>').val(dataz.tekanandarah);
        $('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'td_systolic') ?>').val(dataz.sys);
        $('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'td_diastolic') ?>').val(dataz.dias);
            getText();
    }, 'json');
}

function gantiJumlah(obj){
    var value = parseFloat($(obj).val());
    var teman = $(obj).parent('.groupUkurans').find('input[type="text"]');
    var valueTeman = parseFloat(teman.val());
    var hasil;

    hasil = valueTeman*value;
    teman.val(hasil);
}


function gantiHidden(){
    var defaultBB = parseFloat(0.001);
    var defaultTB = parseFloat(100);
    var valueBB = parseFloat($('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'beratbadan_kg') ?>').val());
    var valueTB = parseFloat($('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'tinggibadan_cm') ?>').val());

    if ($('#gram').val() != defaultBB){
        $('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB*defaultBB);
    }
    else{
        $('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB);
    }
    
    if ($('#meter').val() != defaultTB){
        $('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB*defaultTB);
    }
    else{
        $('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB);
    }
}            
            
function getBeratBadanIdeal(){
    var beratBadan = parseFloat($('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'beratbadan_kg') ?>').val());
    var tinggiBadan = parseFloat($('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
    var jenisKelamin = $('#<?php echo CHtml::activeId($modPasien, 'jenis_kelamin') ?>').val();
    var hasil;
    if (jenisKelamin == "<?php echo Params::JENIS_KELAMIN_PEREMPUAN ?>"){
        hasil = (tinggiBadan - 100) - ((15/100)*(tinggiBadan-100));
        if (hasil < 0){
            hasil = 0;
        }
        $('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'bb_ideal') ?>').val(hasil);
    }
    else{
        hasil = (tinggiBadan - 100) - ((10/100)*(tinggiBadan-100));
        if (hasil < 0){
            hasil = 0;
        }
        $('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'bb_ideal') ?>').val(hasil);
    }
}

function getBMI(){
    var beratBadan = parseFloat($('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'beratbadan_kg') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
    var tinggiBadan = parseFloat($('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'tinggibadan_cm') ?>').parent('.groupUkurans').find('input[type="hidden"]').val());
    var hasil;
    
    hasil = (beratBadan/((tinggiBadan*tinggiBadan)/10000));
    if (jQuery.isNumeric(hasil)){
        $.post('<?php echo Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/getBMIText'); ?>', {bmi:hasil}, function(data){
            $('#imt').val(data.text);
            $('#imtValue').val(Math.floor(hasil));
        },'json');
    }
}

$(document).ready(function(){
    $('.groupUkurans').find('input').keyup(function(){
        gantiHidden();
        getBeratBadanIdeal();
        getBMI();
    });
});
</script>
