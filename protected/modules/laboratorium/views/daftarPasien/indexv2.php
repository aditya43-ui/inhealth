<style>
    .selected-diagnosa td {
        background-color: yellow !important;
    }
</style>
<?php
//$this->breadcrumbs=array(
//    'Diagnosa',
//);
//
//$this->widget('bootstrap.widgets.BootAlert');
//
//
?>

<!--<legend class="rim2">Diagnosis</legend>-->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpasien-morbiditas-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($modMorbiditas[0]); ?>
    <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
    <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($modMorbiditas[0], '[0]pegawai_id', CHtml::listData($modMorbiditas[0]->getDokterItems(), 'pegawai_id', 'NamaLengkap'), array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->labelEx($modMorbiditas[0], '[0]tglmorbiditas', array('class' => 'control-label')) ?>
        <?php $modMorbiditas[0]->tglmorbiditas = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modMorbiditas[0]->tglmorbiditas, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
        <div class="controls">
            <?php $this->widget('MyDateTimePicker', array(
                'model' => $modMorbiditas[0],
                'attribute' => '[0]tglmorbiditas',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Diagnosa
            <b><?php echo CHtml::radioButton('berdasarKasusPenyakit', true, array('onclick' => 'daftarDiagnosa(this)', 'class' => 'kp_t')); ?></b>
        </div>
    </div>
    <div class="panel-body">
        <div class="block-tabel">
            <div class="control-group">
                <div class="pull-left" style="padding-left:30px;">
                </div>
            </div>
            <?php $this->renderPartial($this->path_view . '_tblPilihDiagnosa', array('modDiagnosa' => $modDiagnosa, 'modKasuspenyakitDiagnosa' => $modKasuspenyakitDiagnosa)); ?>
        </div>
    </div>
</div>
<div class="panel panel-shadow panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Diagnosa Pasien</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <div class="block-tabel">
            <table id="tblDiagnosaPasien" class="table table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Tgl. Diagnosa</th>
                        <th>Kelompok Diagnosa</th>
                        <th>Klasifikasi Diagnosa</th>
                        <th>Kode</th>
                        <th>Nama Diagnosa</th>
                        <th>Nama Lain</th>
                        <th>Kata Kunci</th>
                        <!--<th>Diagnosa Tindakan</th>-->
                        <!--<th>Sebab Diagnosa</th>-->
                        <th>Batal / Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($listMorbiditas)) {
                        $this->renderPartial($this->path_view . '_listDiagnosa', array('modMorbiditas' => $listMorbiditas));
                    }

                    if ($newInput && $successSave) {
                        $this->renderPartial($this->path_view . '_cekValidDiagnosa', array('modMorbiditas' => $modMorbiditas));
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    // echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
    // array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); 
    ?>

    <?php

    echo CHtml::link(Yii::t('mds', '{icon} Print Diagnosa', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printDiagnosa();return false", 'disabled' => FALSE)) . '&nbsp;';

    $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $('#tblDiagnosa').addClass('hide');
    $('#tblKasuspenyakitDiagnosa').removeClass('hide');

    function inputDiagnosa(obj, idDiagnosa) {
        var idDiagnosa = idDiagnosa;
        var idKelDiagnosa = $(obj).parent().parent().find('select[name^="kelompokDiagnosa_"]').val();

        var IdPendaftaran = '<?php echo $modPendaftaran->pendaftaran_id; ?>';

        var tglDiagnosa = $('#LBPasienmorbiditasT_0_tglmorbiditas').val();
        //LBPasienmorbiditasT_0_tglmorbiditas
        //RJPasienMorbiditasT_0_tglmorbiditas
        if (!cekInputDiagnosa(idDiagnosa)) {

            //console.log($(obj).parents('tr').;
            jQuery.ajax({
                'url': '<?php echo Yii::app()->createUrl('rawatJalan/pemeriksaanPasien/loadFormDiagnosis') ?>',
                'data': {
                    tglDiagnosa: tglDiagnosa,
                    idDiagnosa: idDiagnosa,
                    idKelDiagnosa: idKelDiagnosa
                },
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    if (data.status == 'fail') {
                        myAlert(data.pesan);
                    } else {
                        $('#tblDiagnosaPasien tbody').append(data.form);
                        renameInput('Morbiditas', 'diagnosa');
                        renameInput('Morbiditas', 'kelompokDiagnosa');
                        // renameInput('Morbiditas','diagnosaTindakan');
                        // renameInput('Morbiditas','sebabDiagnosa');
                        renameInput('Morbiditas', 'infeksiNosokomial');

                        if ($('#berdasarKasusPenyakit').is(':checked')) {
                            var kelompokDiagnosa = $('#tblKasuspenyakitDiagnosa #kelompokDiagnosa_' + idDiagnosa).val();
                        } else {
                            var kelompokDiagnosa = $('#tblDiagnosa #kelompokDiagnosa_' + idDiagnosa).val();
                        }
                        jQuery.ajax({
                            'url': '<?php echo $this->createUrl('SaveDiagnosis') ?>',
                            'data': {
                                IdPendaftaran: IdPendaftaran,
                                tglDiagnosa: tglDiagnosa,
                                idDiagnosa: idDiagnosa,
                                kelompokDiagnosa: idKelDiagnosa
                            },
                            'type': 'post',
                            'dataType': 'json',
                            'success': function(data) {
                                console.log("BERHASIL DISIMPAN...!");
                                $(obj).parent().parent().addClass('selected-diagnosa');
                            },
                            'cache': false
                        });
                    }
                },
                'cache': false
            });
        } else {
            if (confirm('Apakah Anda Akan Membatalkan Diagnosa No. ' + idDiagnosa + ' ?')) {
                $('#tblDiagnosaPasien').find('input[class$="idDiagnosa"]').each(function() {
                    if (this.value == idDiagnosa) {
                        remove(this, idDiagnosa);

                        jQuery.ajax({
                            'url': '<?php echo Yii::app()->createUrl('rawatJalan/pemeriksaanPasien/HapusDiagnosis') ?>',
                            'data': {
                                IdPendaftaran: IdPendaftaran,
                                idDiagnosa: idDiagnosa
                            },
                            'type': 'post',
                            'dataType': 'json',
                            'success': function(data) {
                                console.log("BERHASIL DIHAPUS...!");
                            },
                            'cache': false
                        });
                    }
                });
            }
        }
    }

    function cekInputDiagnosa(idDiagnosa) {
        var sudahAda = false;
        $('#tblDiagnosaPasien').find('input[class$="idDiagnosa"]').each(function() {
            if (this.value == idDiagnosa)
                sudahAda = true;
        });
        return sudahAda;
    }

    function daftarDiagnosa(obj) {
        if (!$(".kp_t").is(":checked")) {
            $('#tblDiagnosa').addClass('hide');
            $('#tblKasuspenyakitDiagnosa').removeClass('hide');
        } else {
            $('#tblDiagnosa').removeClass('hide');
            $('#tblKasuspenyakitDiagnosa').addClass('hide');
        }

        //    $('#tblDiagnosaPasien tbody tr').detach();
    }

    function addDiagnosaTindakan(obj, idDiagnosa) {
        $('#dialogDiagnosaTindakan #tr').val(idDiagnosa);
        $('#dialogDiagnosaTindakan').dialog('open');
        $('#dialogDiagnosaTindakan').find("input[name$='[diagnosaicdix_id]']").each(function() {
            $(this).removeAttr('checked');
        });
    }

    function addSebabDiagnosa(obj) {
        $('#dialogSebabDiagnosa').dialog('open');
    }

    function setDiagnosaTindakan(obj, idDiagnosaTind, namaDiagnosaTind) {
        var idTr = $('#dialogDiagnosaTindakan #tr').val();
        $('#tr_' + idTr).find('input[name$="[diagnosaTindakan]"]').val(idDiagnosaTind);
        $('#tr_' + idTr + ' #diagnosaTindakanNama').html(namaDiagnosaTind);
        $('#dialogDiagnosaTindakan').dialog('close');
    }

    function remove(obj, idDiagnosa) {

        // myAlert(idDiagnosa);
        var idDiagnosa = idDiagnosa;
        var idKelDiagnosa = $('#tblDiagnosa').find('select[name^="kelompokDiagnosa_' + idDiagnosa + '"]').parent().parent();
        idKelDiagnosa.removeAttr('style');

        $(obj).parents('tr').detach();
        return false;

    }

    function cekHapus(obj, idDiagnosa) {
        var idDiagnosa = idDiagnosa;
        var idKelDiagnosa = $('#tblDiagnosa').find('select[name^="kelompokDiagnosa_' + idDiagnosa + '"]').parent().parent();
        idKelDiagnosa.removeAttr('style');

        $(obj).parents('tr').detach();
        var IdPendaftaran = '<?php echo $modPendaftaran->pendaftaran_id; ?>';

        jQuery.ajax({
            'url': '<?php echo Yii::app()->createUrl('rawatJalan/pemeriksaanPasien/HapusDiagnosis') ?>',
            'data': {
                IdPendaftaran: IdPendaftaran,
                idDiagnosa: idDiagnosa
            },
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                console.log("BERHASIL DIHAPUS...!");
            },
            'cache': false
        });

        return false;

    }

    function deleteDiagnosa(obj, idDiagnosa) {
        myConfirm("Apakah Anda yakin akan menghapus diagnosa dari database?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxDeleteDiagnosa') ?>', {
                    idDiagnosa: idDiagnosa
                }, function(data) {
                    if (data.success) {
                        $(obj).parent().parent().detach();
                        myAlert('Data berhasil dihapus.');
                    } else {
                        myAlert('Data Gagal dihapus');
                    }
                }, 'json');
            }
        });
    }

    function renameInput(modelName, attributeName) {
        var trLength = $('#tblDiagnosaPasien tr').length;
        var i = -1;
        $('#tblDiagnosaPasien tr').each(function() {
            if ($(this).has('input[name$="[diagnosa]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
        });
    }

    function printDiagnosa() {
        window.open('<?php echo $this->createUrl('printDiagnosa', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=793,height=1122');
    }
</script>

<?php
//========= Dialog buat diagnosa tindakan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDiagnosaTindakan',
    'options' => array(
        'title' => 'Diagnosa Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 400,
        'resizable' => false,
    ),
));
echo CHtml::hiddenField("tr", '', array('readonly' => true, 'class' => 'span1'));
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rjdiagnosatindakan-m-grid',
    'dataProvider' => $modDiagnosaicdixM->search(),
    'filter' => $modDiagnosaicdixM,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        'diagnosaicdix_nourut',
        'diagnosaicdix_kode',
        'diagnosaicdix_nama',
        'diagnosaicdix_namalainnya',
        'diagnosatindakan_katakunci',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "setDiagnosaTindakan(this,$data->diagnosaicdix_id,\'$data->diagnosaicdix_nama\');return false;"))',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end diagnosa tindakan =============================
?>

<?php
//========= Dialog buat sebab diagnosa  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSebabDiagnosa',
    'options' => array(
        'title' => 'Sebab Diagnosa',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 400,
        'resizable' => false,
    ),
));

echo $form->radioButtonListRow($modMorbiditas[0], 'sebabdiagnosa_id', CHtml::listData($modSebabDiagnosa, 'sebabdiagnosa_id', 'sebabdiagnosa_nama'));

$this->endWidget();
//========= end sebab diagnosa =============================
?>
<?php
$js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"

function palidasiForm(obj)
{
    var berubah = $('#berubah').val();
    if(berubah=='Ya'){
        myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
            if(r){
                $('#url').val(obj);
                $('#btn_simpan').click();
            }
        });
    }      
}

daftarDiagnosa(null);
        
JS;
Yii::app()->clientScript->registerScript('js', $js, CClientScript::POS_READY);
?>