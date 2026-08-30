<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'assep-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    //	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'),
    'focus' => '#',
));
?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "SEP berhasil disimpan !");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row-fluid" id="content-bpjs">
    <div class="span6">

        <?php echo $form->hiddenField($modAsuransiPasien, 'nokartuasuransi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'no_rekam_medik', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($modAsuransiPasien, 'nopeserta', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($modAsuransiPasien, 'tglcetakkartuasuransi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($modAsuransiPasien, 'kelastanggunganasuransi_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($modAsuransiPasien, 'jenispeserta_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'namaasuransi_cob', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'no_asuransi_cob', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'hakkelas_kode', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'nama_diagnosaawal', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

        <?php
        if (in_array($modPendaftaran->pasienadmisi_id, $model->InstalasiPelayananRJ()) && empty($modPendaftaran->pasienadmisi_id)) {
            $display = 'block';
            $required = "required";
        } else if ($modPendaftaran->instalasi_id == Params::INSTALASI_ID_RD && empty($modPendaftaran->pasienadmisi_id)) {
            $display = 'none';
            $required = "";
        } else {
            if ($model->jnspelayanan == 1) {
                $display = 'block';
                $required = "required";
            } else {
                $display = 'none';
                $required = "";
            }
        }
        ?>

        <div id="rujukanBpjs" style="display:<?= $display ?>">
            <div class="control-group ">
                <?php echo CHtml::label("Jenis/Asal Rujukan", 'no_rujukan', array('class' => 'control-label')) ?>
                <div class="controls form-inline">
                    <?php
                    echo $form->radioButtonList($model, 'jenispeserta_id', array("1" => "PCare&nbsp;&nbsp;", "2" => "Rumah Sakit"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("No.Rujukan Faskes <span class='required'>*</span>", 'no_rujukan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modRujukanBpjs, 'no_rujukan', array('placeholder' => 'No. Rujukan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo CHtml::link("<i class='icon-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk mengecek rujukan", "onclick" => "getRujukanNoRujukan($('#" . CHtml::activeId($modRujukanBpjs, "no_rujukan") . "').val());return true;")); ?>
                    <?php echo $form->error($modRujukanBpjs, 'no_rujukan'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label <?= $required ?>">
                    Tanggal Rujukan
                    <span class="required">*</span>
                </label>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modRujukanBpjs,
                        'attribute' => 'tanggal_rujukan',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'showOn' => false,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('class' => 'dtPicker2 span3', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                    ));
                    ?>
                    <?php echo $form->error($modRujukanBpjs, 'tanggal_rujukan'); ?>
                </div>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("No. Kartu BPJS <span class='required'>*</span> ", 'nopeserta', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nopeserta', array('readonly' => true, 'placeholder' => 'Ketik No. Peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->error($model, 'nopeserta'); ?>
                <?php echo $form->hiddenField($model, 'asuransipasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
            </div>
        </div>


        <div class="control-group ">
            <label class="control-label">
                No. SEP
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'nosep', array('placeholder' => 'No. SEP Otomatis', 'class' => 'span3', 'readonly' => false, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->error($model, 'nosep'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglsep', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'tglsep', array('readonly' => true, 'placeholder' => 'Ketik No. Peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modAsuransiPasien, 'namapemilikasuransi', array('placeholder' => 'Nama Lengkap Pemilik Asuransi', 'class' => 'span3', 'readonly' => empty($modAsuransiPasien->namapemilikasuransi) ? false : true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <div class="control-group ">
            <?php echo CHtml::label("Kode PPK Pelayanan", 'ppkpelayanan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'ppkpelayanan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label("Nama PPK Pelayanan", 'ppkpelayanan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'ppkpelayanan_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'maxlength' => 50)); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'jnspelayanan', array('2' => 'Rawat Jalan', '1' => 'Rawat Inap'), array('empty' => '--Pilih--', 'class' => 'span3', 'disabled' => true)); ?>
        <div class="control-group ">
            <?php echo CHtml::label("Kelas Rawat <span class='required'>*</span>", 'kelastanggungan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'klsrawat', array('1' => 'Kelas I', '2' => 'Kelas II', '3' => 'Kelas III'), array(
                    'empty' => '-Pilih-', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)",
                ));
                ?>
            </div>
        </div>

        <?php echo $form->hiddenField($model, 'klsrawat', array()); ?>

        <div class="control-group">
            <?php echo CHtml::label("Kode PPK Rujukan <span class='required'>*</span>", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'ppkrujukan',
                    'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('AutocompleteItemSEP') . '",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                        item: "ppk",
                                    },
                                    success: function (data) {
                                        response(data);
                                    }
                                })
                            }',
                    'options' => array(
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.kode);
                                    return false;
                                }',
                        'select' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.kode);
                                    $("#' . CHtml::activeId($model, 'ppkrujukan_nama') . '").val(ui.item.nama);
                                    return false;
                                }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Kode PPK', 'rel' => 'tooltip', 'title' => 'Ketik kode ppk untuk mencari data ppk', 'class' => 'span3 required',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama PPK Rujukan <span class='required'>*</span>", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'ppkrujukan_nama',
                    'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('AutocompleteItemSEP') . '",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                        item: "ppk",
                                    },
                                    success: function (data) {
                                        response(data);
                                    }
                                })
                            }',
                    'options' => array(
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.nama);
                                    return false;
                                }',
                        'select' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.nama);
                                    $("#' . CHtml::activeId($model, 'ppkrujukan') . '").val(ui.item.kode);
                                    return false;
                                }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Nama PPK', 'rel' => 'tooltip', 'title' => 'Ketik nama ppk untuk mencari data ppk', 'class' => 'span3 required',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="span6">

        <div class="control-group">
            <?php echo CHtml::label("Poli Tujuan <span class='required'>*</span> ", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'politujuan', array('readonly' => true, 'placeholder' => 'Poli Tujuan', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Diagnosa Awal <span class='required'>*</span>", 'no_rujukan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'diagnosaawal',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('AutocompleteItemSEP') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                    item: "diagnosa",
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
                    'options' => array(
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val(ui.item.kode);
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.kode);
                                $("#' . CHtml::activeId($model, 'nama_diagnosaawal') . '").val(ui.item.nama);
                                return false;
                            }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Nama Diagnosa', 'rel' => 'tooltip', 'title' => 'Ketik diagnosa untuk mencari data diagnosa', 'class' => 'span3 required',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
                <?php echo $form->hiddenField($model, 'nama_diagnosaawal', array('placeholder' => 'Diagnosa Awal', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <?php
        if (in_array($modPendaftaran->pasienadmisi_id, $model->InstalasiPelayananRJ()) && empty($modPendaftaran->pasienadmisi_id)) {
            $display = 'block';
        } else if ($modPendaftaran->instalasi_id == Params::INSTALASI_ID_RD && empty($modPendaftaran->pasienadmisi_id)) {
            $display = 'none';
        } else {
            if ($model->jnspelayanan == 1) {
                $display = 'none';
            } else {
                $display = 'block';
            }
        }
        ?>
        <div class="panel panel-success" id="skdp" style="display: <?php echo $display; ?>">
            <div class="control-group">
                <?php echo CHtml::label("Nomor Surat Kontrol <span class='required'>*</span>", 'Nomor Surat Kontrol', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'no_surat', array('placeholder' => 'Nomor Surat Kontrol', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Dokter DPJP ", 'nama_dpjp', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nama_dpjp', array('placeholder' => 'Dokter DPJP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => 'Isi jika pasien dengan surat kontrol', 'onblur' => "if($(this).val()=='') $('#" . CHtml::activeId($model, 'kode_dpjp') . "').val('')")); ?>
                    <?php echo CHtml::link("<i class='icon-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk cari DPJP", "onclick" => "$('#dialogDpjp').dialog('open');return true;")); ?>
                    <?php echo $form->hiddenField($model, 'kode_dpjp', array('placeholder' => 'Dokter DPJP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </div>
        <div class="control-group form-inline">
            <?php echo CHtml::label("Poli Eksekutif", 'Eksekutif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->radioButtonList($model, 'is_polieksekutif', array("1" => "YA&nbsp;&nbsp;", "0" => "TIDAK"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <div class="control-group form-inline">
            <?php echo CHtml::label("COB", 'COB', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'is_cob', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                echo $form->textField($model, 'status_nosep', array('class' => 'span1', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <div class="control-group form-inline">
            <?php echo CHtml::label("Katarak", 'Katarak', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->radioButtonList($model, 'katarak', array("1" => "YA&nbsp;&nbsp;", "0" => "TIDAK"), array('onkeyup' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'form-suplesi',
            'content' => array(
                'content-suplesi' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => 'cekSuplesi(this)', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk Kecelakaan Lalu Lintas')) . '<b><span class="judulasuransi">Kecelakaan Lalu Lintas',
                    'isi' => $this->renderPartial($this->path_view . '_formSuplesi', array(
                        'form' => $form,
                        'model' => $model,
                    ), true),
                    'active' => $model->lakalantas,
                ),
            ),
            'htmlOptions' => array(),
        ));
        ?>
        <div class="control-group">
            <?php echo CHtml::label("No. Telepon Peserta <span class='required'>*</span>", 'no_telpon_peserta', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'no_telpon_peserta', array('placeholder' => 'Telepon peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("User Pembuat SEP", 'pembuat_sep', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pembuat_sep', array('readonly' => true, 'placeholder' => 'Pembuat SEP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($model, 'catatansep', array('placeholder' => '', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

    </div>
</div>
<div class="form-actions">
    <?php
    $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
    $disabledSave = isset($_GET['id']) ? true : (($sukses == 1) ? true : false);
    ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disabledSave, 'onclick' => 'cekInput(this,14);return false;')); ?>

</div>
<?php $this->endWidget(); ?>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs)); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPoli',
    'options' => array(
        'title' => 'Referensi Poli BPJS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial($this->path_view . '_pencarianPoli');
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDiagnosaBpjs',
    'options' => array(
        'title' => 'Referensi Diagnosa BPJS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial($this->path_view . '_pencarianDiagnosa');
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPpk',
    'options' => array(
        'title' => 'Referensi PPK Rujukan/Faskes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial($this->path_view . '_pencarianPpk');
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSuplesi',
    'options' => array(
        'title' => 'Pencarian Suplesi Jasa Raharja',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial($this->path_view . '_pencarianSuplesi');
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDpjp',
    'options' => array(
        'title' => 'Pencarian Dokter DPJP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial($this->path_view . '_pencarianDpjp');
$this->endWidget();
?>

<script>
    $(document).ready(function() {
        cekSuplesi($('input:radio[name="ARSepT[suplesi_jasaraharja]"]:checked'));
    });
</script>