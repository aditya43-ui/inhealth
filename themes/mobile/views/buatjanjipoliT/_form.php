
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ppbuat-janji-poli-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
        ));
?>
<?php echo $form->errorSummary(array($modPasien,$modPPBuatJanjiPoli)); ?>
<fieldset>
<?php echo $this->renderPartial('_formPasien', array('form'=>$form, 'modPasien'=>$modPasien, 'modPPBuatJanjiPoli'=>$modPPBuatJanjiPoli)); ?>
</fieldset>

<fieldset>
    <legend class="rim"> Buat Janji &nbsp;</legend>
    <table>
        <tr>
            <td>
                <?php
                echo $form->dropDownListRow($modPPBuatJanjiPoli, 'ruangan_id', CHtml::listData($modPPBuatJanjiPoli->getRuanganItems(), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --',
                    'onchange' => "listDokterRuangan(this.value);",
                    'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?>    
                <?php echo $form->dropDownListRow($modPPBuatJanjiPoli, 'pegawai_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modPPBuatJanjiPoli, 'tgljadwal', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPPBuatJanjiPoli,
                                'attribute' => 'tgljadwal',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'minDate' => 'd',
                                    'onkeypress' => "js:function(){getUmur(this);}",
                                    'onSelect' => 'js:function(){hariBaru(this);}',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                        ?>
                        <?php echo $form->error($modPPBuatJanjiPoli, 'tgljadwal'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modPPBuatJanjiPoli, 'harijadwal', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => TRUE)); ?>
            </td>
        </tr>
    </table>
</fieldset>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($modPPBuatJanjiPoli->isNewRecord ? Yii::t('mds', '{icon} Kirim', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('admin'), array('class'=>'btn btn-danger')); ?>
</div>

<?php $this->endWidget(); ?>
<?php
    $urlGetTglLahir = Yii::app()->createUrl('ActionAjax/GetTglLahir');
    $urlGetUmur = Yii::app()->createUrl('ActionAjax/GetUmur');
    $urlGetDaerah = Yii::app()->createUrl('ActionAjax/getListDaerahPasien');
    $idTagUmur = CHtml::activeId($modPasien, 'umur');
    $urlListDokterRuangan = Yii::app()->createUrl('actionDynamic/listDokterRuangan');
    $urlGetHari = Yii::app()->createUrl('ActionAjax/GetHari');
    $urlPrintKartuJanjiPoli = Yii::app()->createUrl('print/lembarJanjiPoli', array('idBuatJanjiPoli' => ''));

    $cekKartuPasien = PPKonfigSystemK::model()->find()->printkartulsng;
    if (!empty($cekKartuPasien)) { //Jika Kunjungan Pasien diisi TRUE
        $statusKartuPasien = $cekKartuPasien;
    } else { //JIka Print Kunjungan Diset FALSE
        $statusKartuPasien = 0;
    }
//
$js = <<< JS

function print(idBuatJanjiPoli)
{

        if(${statusKartuPasien}==1){ //JIka di Konfig Systen diset TRUE untuk Print kunjungan
             window.open('${urlPrintKartuJanjiPoli}'+idBuatJanjiPoli,'printwin','left=100,top=100,width=400,height=400');
        }             
}

function hariBaru()
    {
        var tanggal = $('#PPBuatJanjiPoliT_tgljadwal').val();
            $.post("${urlGetHari}",{tanggal: tanggal},
            function(data){

               $('#PPBuatJanjiPoliT_harijadwal').val(data.hari); 

       },"json");
       
    
    }

function listDokterRuangan(idRuangan)
{
    $.post("${urlListDokterRuangan}", { idRuangan: idRuangan },
        function(data){
            $('#PPBuatJanjiPoliT_pegawai_id').html(data.listDokter);
    }, "json");
}

function loadUmur(tglLahir)
{
    $.post("${urlGetUmur}",{tglLahir: tglLahir},
        function(data){
           $("#${idTagUmur}").val(data.umur);
    },"json");
}

function setJenisKelaminPasien(jenisKelamin)
{
    $('input[name="PPPasienM[jeniskelamin]"]').each(function(){
            if(this.value == jenisKelamin)
                $(this).attr('checked',true);
        }
    );
}

function loadDaerahPasien(idProp,idKab,idKec,idKel)
{
    $.post("${urlGetDaerah}", { idProp: idProp, idKab: idKab, idKec: idKec, idKel: idKel },
        function(data){
            $('#PPPasienM_propinsi_id').html(data.listPropinsi);
            $('#PPPasienM_kabupaten_id').html(data.listKabupaten);
            $('#PPPasienM_kecamatan_id').html(data.listKecamatan);
            $('#PPPasienM_kelurahan_id').html(data.listKelurahan);
    }, "json");
}
JS;
Yii::app()->clientScript->registerScript('fungsipasien', $js, CClientScript::POS_BEGIN);
$js = <<< JS
$('#isPasienLama').click(function(){
    if ($(this).is(':checked'))
      {
         $('#no_rekam_medik').removeAttr('disabled');
         $('#buttonSearch').removeAttr('disabled');
      }
    else
      {
        $('#no_rekam_medik').attr('disabled','true');
        $('#no_rekam_medik').val('');
        $('#buttonSearch').attr('disabled','true');
        $('#PPPasienM_kabupaten_id').html('<option value=\'\'>--Pilih--</option>');
        $('#PPPasienM_kecamatan_id').html('<option value=\'\'>--Pilih--</option>');
        $('#PPPasienM_kelurahan_id').html('<option value=\'\'>--Pilih--</option>');
//        $('#isPasienLama').attr('checked',true);
         
       }

       
      
});
JS;
Yii::app()->clientScript->registerScript('fungsipasien', $js, CClientScript::POS_READY);
?>
