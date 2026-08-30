
<?php
$myicon = new MyIcon();
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'prescriptionhd-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
//        'focus'=>'#namaObatNonRacik',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        ));
?>

<?php if (empty($_GET['frame'])) : ?>
    <?php
    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        'id' => 'list-rujukankeluar',
        'content' => array(
            'content-detailpasien' => array(
                'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan Riwayat Hemodialisis Pasien')) . '<b> Riwayat Prescription Dokter</b>',
                'isi' => $this->renderPartial($this->path_view . '_listHD', array(
                    'model' => $model,
                    'loadRiwayat' => $loadRiwayat,
                    'modPendaftaran' => $modPendaftaran,
                    'modPasien' => $modPasien
                        ), true),
                'active' => true,
            ),
        ),
    ));
    ?>
<?php endif; ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Prescription Dokter</div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Reseptur',
        );

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <div class="col-md-6">
            <div class="control-group ">
                <?php echo CHtml::label('Waktu prescription', 'tanggal', array('class' => 'control-label required')) ?>
                <div class="controls">
                    <?php
//                           (isset($model->waktu_prescription)) ? $model->waktu_prescription : date('d-m-Y');
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'waktu_prescription',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                            'yearRange' => "-60:+0",
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Prescription Dokter</label>
                <div class="controls">
                    <?= $form->radioButton($model, 'prescription_dokter', array('value' => 'akut', 'uncheckValue' => null)) ?><label>Akut</label> &nbsp;
                    <?= $form->radioButton($model, 'prescription_dokter', array('value' => 'kronis', 'uncheckValue' => null)) ?><label>Kronis</label> &nbsp;
                    <?= $form->radioButton($model, 'prescription_dokter', array('value' => 'pirrt', 'uncheckValue' => null)) ?><label>PIRRT</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Time</label>
                <div class="controls"><?= $form->textField($model, 'durasi_time', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 integer')); ?>
                    <?= $form->dropDownList($model, 'time_satuan', CHtml::listData(LookupM::model()->findAll("lookup_type='satuanlamanyeri' AND lookup_aktif=TRUE"), 'lookup_name', 'lookup_name'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'empty' => '--Pilih--')); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Blood Flow</label>
                <div class="controls"><?= $form->textField($model, 'blood_flow', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?><label>mL/menit</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Dialysate Flow</label>
                <div class="controls"><?= $form->textField($model, 'dialysate_flow', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float',)); ?><label>mL/menit</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Dialysate</label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'dialysate_bicarbonat', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkDialysate("bicarbonat")')) ?> <label>Bicarbonat</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">&nbsp;</label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'dialysate_lainnya', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkDialysate("lainnya")')) ?> <label>Lainnya</label>
                    <?php echo $form->textField($model, 'dialysate_lainnya_keterangan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Dialyser</label>
                <div class="controls"><?= $form->textField($model, 'diayser', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?></div>
            </div>
            <div class="control-group">
                <label class="control-label">Dialyser Temperature</label>
                <div class="controls"><?= $form->textField($model, 'dialyser_temperature', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?><label>&#8451;</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Ultra Filtration Goal</label>
                <div class="controls"><?= $form->textField($model, 'uf_goal', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?></div>
            </div>
            <div class="control-group">
                <label class="control-label">Akses Vaskuler</label>
                <div class="controls">
                    <?php if (count($aksesvaskular) > 0) : ?>
                        <?php foreach ($aksesvaskular as $av) : ?>
                            <?= CHtml::textField('aksesvaskular[]', $av->nama_akses_vaskular.(!empty($av->hd_kateter)?' - '.$av->hd_kateter:''), array('readonly' => true, 'style' => 'margin-bottom: 10px;')) ?><br>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <?= $form->textField($model, 'akses_vaskular', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'disabled' => true)); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Catatan Lain</label>
                <div class="controls"><?= $form->textArea($model, 'catatan_lain', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '', 'style' => 'width:285px; height: 100px')); ?></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="control-group">
                <label class="control-label">DPJP</label>
                <div class="controls">
                    <?= $form->HiddenField($model, 'dpjp_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                    <?= $form->textField($model, 'dpjp_nama', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Heparinisasi</label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'heparinisasi_standar', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkHeparinisasi("standar")')) ?> <label>Standar</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">&nbsp;</label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'heparinisasi_minimal', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkHeparinisasi("minimal")')) ?> <label>Minimal</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">&nbsp;</label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'heparinisasi_tanpaheparin', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkHeparinisasi("tanpaheparin")')) ?> <label>Tanpa Heparin</label>
                    <?php echo $form->textField($model, 'heparinisasi_tanpaheparin_penyebab', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">&nbsp;</label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'heparinisasi_lmwh', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkHeparinisasi("lmwh")')) ?> <label>LMWH</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">&nbsp;</label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'heparinisasi_lainnya', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkHeparinisasi("lainnya")')) ?> <label>lainnya</label>
                    <?php echo $form->textField($model, 'heparinisasi_lainnya_penyebab', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Selisih BB</label>
                <div class="controls"><?= $form->textField($model, 'selisih_berat_badan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?> <label>Kg</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Infus</label>
                <div class="controls"><?= $form->textField($model, 'infus', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 float')); ?> <label>mL</label>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php echo $form->checkBox($model, 'transfusi_darah', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column')) ?> <label>Transfusi Darah</label>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php echo $form->checkBox($model, 'penggunaan_elektropetin', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column')) ?> <label>Penggunaan Elektropetin</label>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php echo $form->checkBox($model, 'penggunaan_zatbesi', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column')) ?> <label>Penggunaan Zat Besi</label>
                </div>
            </div>
        </div>
        </fieldset>
        <!--</div>-->
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="form-actions">

            <?php
            if (isset($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => 'btn btn-danger', 'id' => 'btn_submit', 'disabled' => true)) . "&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']), array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']) . '";}); return false;'
                )) . "&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-success',
                    'onclick' => "print(" . $modPendaftaran->pendaftaran_id . ",'');return false")) . "&nbsp;";
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'id' => 'btn_submit', 'onclick' => 'cekInsert();', 'onKeypress' => 'cekInsert();', 'disabled' => (isset($_GET['sukses'])) ? true : false)) . "&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']), array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']) . '";}); return false;'
                )) . "&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-success', 'type' => 'button', 'disabled' => 'disabled')) . "&nbsp";
            }
            ?>

        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>
    $(document).ready(function () {
        if ($("#HDPrescriptionHdT_dialysate_lainnya").is(":checked")) {
            document.getElementById("HDPrescriptionHdT_dialysate_lainnya_keterangan").readOnly = false;
        }
        if ($("#HDPrescriptionHdT_heparinisasi_tanpaheparin").is(":checked")) {
            document.getElementById("HDPrescriptionHdT_heparinisasi_tanpaheparin_penyebab").readOnly = false;
        }
        if ($("#HDPrescriptionHdT_heparinisasi_lainnya").is(":checked")) {
            document.getElementById("HDPrescriptionHdT_heparinisasi_lainnya_penyebab").readOnly = false;
        }

<?php if (isset($_GET['mode'])) { ?>
            $("#prescriptionhd-t-form").find('input,select,textarea, button').each(function () {
                $(this).attr('disabled', true);
            });
<?php } ?>
    })

    function cekInsert() {
        $(".integer").each(function () {
            $(this).val(parseInt(unformatNumber($(this).val())));
        });
        $(".float").each(function () {
            $(this).val(parseFloat(unformatNumber($(this).val())));
        });

        $('#prescriptionhd-t-form').submit();
    }

    function checkHeparinisasi(param) {
        if (param == 'tanpaheparin') {
            if ($("#HDPrescriptionHdT_heparinisasi_tanpaheparin").is(":checked")) {
                document.getElementById("HDPrescriptionHdT_heparinisasi_tanpaheparin_penyebab").readOnly = false;
            } else {
                document.getElementById("HDPrescriptionHdT_heparinisasi_tanpaheparin_penyebab").readOnly = true;
                document.getElementById("HDPrescriptionHdT_heparinisasi_tanpaheparin_penyebab").value = '';
            }
        } else if (param == 'lainnya') {
            if ($("#HDPrescriptionHdT_heparinisasi_lainnya").is(":checked")) {
                document.getElementById("HDPrescriptionHdT_heparinisasi_lainnya_penyebab").readOnly = false;
            } else {
                document.getElementById("HDPrescriptionHdT_heparinisasi_lainnya_penyebab").readOnly = true;
                document.getElementById("HDPrescriptionHdT_heparinisasi_lainnya_penyebab").value = '';
            }
        }

    }

    function checkDialysate(param) {
        if (param == 'lainnya') {
            if ($("#HDPrescriptionHdT_dialysate_lainnya").is(":checked")) {
                document.getElementById("HDPrescriptionHdT_dialysate_lainnya_keterangan").readOnly = false;
            } else {
                document.getElementById("HDPrescriptionHdT_dialysate_lainnya_keterangan").readOnly = true;
                document.getElementById("HDPrescriptionHdT_dialysate_lainnya_keterangan").value = '';
            }
        }
    }
    function print(pendaftaran_id, prescriptionid)
    {
        window.open('<?php echo $this->createUrl('printPrescription'); ?>&prescriptionid=' + prescriptionid + '&id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=640,height=640');
    }



</script>

