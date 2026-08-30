<?php
$this->breadcrumbs = array(
    'Diagnosa',
);

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpasien-morbiditas-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemeriksaan Diagnosa
        </div>
    </div>
    <div class="panel-body">
        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary($modMorbiditas[0]); ?>

        <table style="width: 100%; border: none;">
            <tr>
                <div class="col-sm-6">
                    <?php echo $form->dropDownListRow($modMorbiditas[0], '[0]pegawai_id', CHtml::listData($modMorbiditas[0]->DokterItems, 'pegawai_id', 'NamaLengkap'), array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->dropDownListRow($modMorbiditas[0],'[0]kasusdiagnosa',LookupM::getItems('kasusdiagnosa'),array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); 
                    ?>
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
            </tr>
        </table>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <label for="berdasarKasusPenyakit" class="checkbox">
                        <?php echo CHtml::checkBox('berdasarKasusPenyakit', false, array('onclick' => 'daftarDiagnosa(this)')); ?> Berdasarkan <b>Kasus Penyakit</b>
                    </label>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_tblPilihDiagnosa', array('modDiagnosa' => $modDiagnosa, 'modKasuspenyakitDiagnosa' => $modKasuspenyakitDiagnosa, 'modPendaftaran' => $modPendaftaran)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Diagnosa Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table id="tblDiagnosaPasien" class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Tanggal Diagnosa</th>
                            <th>Kelompok Diagnosa</th>
                            <th>Klasifikasi Diagnosa</th>
                            <th>Kode</th>
                            <th>Nama Diagnosa</th>
                            <!--<th>Nama Lain</th>-->
                            <th>Kata Kunci</th>
                            <th>Diagnosa Tindakan</th>
                            <th>Sebab Diagnosa</th>
                            <th>Batal / Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($listMorbiditas)) {
                            $this->renderPartial('_listDiagnosa', array('modMorbiditas' => $listMorbiditas));
                        }

                        if ($newInput && !$successSave) {
                            $this->renderPartial('_cekValidDiagnosa', array('modMorbiditas' => $modMorbiditas));
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php $content = $this->renderPartial('../tips/tips', array(), true);
    if ($printaktif) {
        echo CHtml::link(Yii::t('mds', '{icon} Print Diagnosa', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printDiagnosa();return false")) . '&nbsp;';
    } else {
        echo CHtml::link(Yii::t('mds', '{icon} Print Diagnosa', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true)) . '&nbsp;';
    }
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content)); ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function inputDiagnosa(obj, idDiagnosa) {
        var idDiagnosa = idDiagnosa;
        var idKelDiagnosa = $(obj).parent().parent().find('select[name^="kelompokDiagnosa_"]').val();
        var tglDiagnosa = $('#RIPasienMorbiditasT_0_tglmorbiditas').val();
        if (!cekInputDiagnosa(idDiagnosa)) {
            $(obj).parent().parent().css("background-color", "yellow");
            jQuery.ajax({
                'url': '<?php echo Yii::app()->createUrl('rawatInap/diagnosaTRI/LoadFormDiagnosis') ?>',
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
                        renameInput('Morbiditas', 'diagnosaTindakan');
                        renameInput('Morbiditas', 'sebabDiagnosa');
                        renameInput('Morbiditas', 'infeksiNosokomial');
                    }

                },
                'cache': false
            });
        } else {
            myConfirm("Apakah Anda Akan Membatalkan Diagnosa No. " + idDiagnosa + "?", "Perhatian!", function(r) {
                if (r) {
                    $('#tblDiagnosaPasien').find('input[class$="idDiagnosa"]').each(function() {
                        if (this.value == idDiagnosa)
                            remove(this, idDiagnosa);
                    });
                }
            });
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
        if ($(obj).is(':checked')) {
            $('#tblDiagnosa').attr('style', 'display:none;');
            $('#tblKasuspenyakitDiagnosa').attr('style', 'display:block;');
        } else {
            $('#tblDiagnosa').attr('style', 'display:block;');
            $('#tblKasuspenyakitDiagnosa').attr('style', 'display:none;');
        }

        //    $('#tblDiagnosaPasien tbody tr').detach();
    }

    function remove(obj, idDiagnosa) {

        var idDiagnosa = idDiagnosa;
        var idKelDiagnosa = $('#tblDiagnosa').find('select[name^="kelompokDiagnosa_' + idDiagnosa + '"]').parent().parent();

        idKelDiagnosa.removeAttr('style');

        $(obj).parents('tr').detach();
        return false;

    }

    function deleteDiagnosa(obj, idDiagnosa) {
        myConfirm("Apakah Anda yakin akan menghapus diagnosa dari database?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxDeleteDiagnosa') ?>', {
                    idDiagnosa: idDiagnosa
                }, function(data) {
                    if (data.success) {
                        $(obj).parent().parent().remove();
                        myAlert('Data berhasil dihapus.');
                    } else {
                        myAlert('Data Gagal dihapus');
                    }
                }, 'json');
            }
        });
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