<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0)
    Yii::app()->user->setFlash('success', "Data Perjalanan Dinas berhasil disimpan!");
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'data-riwayat',
    'content' => array(
        'content-datariwayat' => array(
            'header' => '<b>Riwayat Perjalanan Dinas</b>',
            'isi' => $this->renderPartial('_riwayat', array(), true),
            'active' => false,
        ),
    ),
));
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kpperjalanandinas-r-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<?php echo $form->errorSummary($modPerjalananDinas); ?>

<div class="block-tabel" id="formOrganisasi">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Perjalanan Dinas <b>Pegawai</b>
            </div>
        </div>
        <div class="panel-body">
            <div style="max-width:100%; ">
                <table class="table table-bordered table-striped table-condensed" id="tablePerjalananDinas" style="padding-left: 0; padding-right: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tujuan Dinas</th>
                            <th>Tugas Dinas <span class="required">*</span></th>
                            <th>Keterangan</th>
                            <th>Alamat Tujuan</th>
                            <th>Provinsi</th>
                            <th>Kota</th>
                            <th>Tanggal Mulai <span class="required">*</span></th>
                            <th>Tanggal Akhir</th>
                            <th>Negara Tujuan</th>
                            <th>Tambah / Batal</th>
                        </tr>
                    </thead>

                    <?php
                    $i = 0;
                    ?>
                    <tbody>
                        <?php
                        if (count((array)$details) > 0) {
                            foreach ($details as $i => $detail) :
                                $i++;
                        ?>

                                <tr>

                                    <?php echo $form->hiddenField($detail, '[' . $i . ']perjalanandinas_id', array('class' => 'span1 pegawai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    <td style="padding-right: 0;">
                                        <?php echo $form->textField($detail, '[' . $i . ']nourutperj', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'value' => $i, 'readonly' => true, 'style' => 'width:20px;')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($detail, '[' . $i . ']tujuandinas', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textArea($detail, '[' . $i . ']tugasdinas', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rows' => '3', 'col' => '2')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textArea($detail, '[' . $i . ']descdinas', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);",  'rows' => '3', 'col' => '2')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textArea($detail, '[' . $i . ']alamattujuan', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);",  'rows' => '3', 'col' => '2')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->dropDownList($detail, '[' . $i . ']propinsi_nama', CHtml::listData(PropinsiM::model()->findAll(), 'propinsi_nama', 'propinsi_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->dropDownList($detail, '[' . $i . ']kotakabupaten_nama', CHtml::listData(KabupatenM::model()->findAll(), 'kabupaten_nama', 'kabupaten_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                                    </td>
                                    <td>
                                        <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $detail,
                                            'attribute' => '[' . $i . ']tglmulaidinas',
                                            'mode' => 'date',
                                            'options' => array(
                                                'showOn' => false,
                                                // 'maxDate' => 'd',
                                                'yearRange' => "-150:+0",
                                            ),
                                            'htmlOptions' => array(
                                                'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                            ),
                                        )); ?>
                                    </td>
                                    <td>
                                        <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $detail,
                                            'attribute' => '[' . $i . ']sampaidengan',
                                            'mode' => 'date',
                                            'options' => array(
                                                'showOn' => false,
                                                // 'maxDate' => 'd',
                                                'yearRange' => "-150:+0",
                                            ),
                                            'htmlOptions' => array(
                                                'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                            ),
                                        )); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($detail, '[' . $i . ']negaratujuan', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                                    </td>
                                    <td>
                                        <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>', '#', array('style' => 'display:none;', 'title' => 'Hapus data', 'rel' => 'tooltip', 'id' => 'hapus', 'onclick' => 'hapusOrganisasi(this);return false', 'style' => 'cursor:pointer;')); ?>
                                    </td>
                                    <?php echo $form->hiddenField($detail, '[' . $i . ']create_time', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php echo $form->hiddenField($detail, '[' . $i . ']update_time', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php echo $form->hiddenField($detail, '[' . $i . ']create_loginpemakai_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php echo $form->hiddenField($detail, '[' . $i . ']update_loginpemakai_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php echo $form->hiddenField($detail, '[' . $i . ']create_ruangan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                </tr>
                        <?php endforeach;
                        }
                        $no = $i + 1;
                        $x = 0; ?>
                        <tr>

                            <td style="padding-right: 0;">
                                <?php echo $form->textField($modPerjalananDinas, '[' . $x . ']nourutperj', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'value' => $no, 'readonly' => true, 'style' => 'width:20px;')); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($modPerjalananDinas, '[' . $x . ']tujuandinas', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                            </td>
                            <td>
                                <?php echo $form->textArea($modPerjalananDinas, '[' . $x . ']tugasdinas', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rows' => '3', 'col' => '2')); ?>
                            </td>
                            <td>
                                <?php echo $form->textArea($modPerjalananDinas, '[' . $x . ']descdinas', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);",  'rows' => '3', 'col' => '2')); ?>
                            </td>
                            <td>
                                <?php echo $form->textArea($modPerjalananDinas, '[' . $x . ']alamattujuan', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);",  'rows' => '3', 'col' => '2')); ?>
                            </td>
                            <td>
                                <?php echo $form->dropDownList($modPerjalananDinas, '[' . $x . ']propinsi_nama', CHtml::listData(PropinsiM::model()->findAll(array('order' => 'propinsi_nama')), 'propinsi_nama', 'propinsi_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'onchange' => 'getKabupaten(this)')); ?>
                            </td>
                            <td>
                                <?php echo $form->dropDownList($modPerjalananDinas, '[' . $x . ']kotakabupaten_nama', CHtml::listData(KabupatenM::model()->findAll(array('order' => 'kabupaten_nama')), 'kabupaten_nama', 'kabupaten_nama'), array('class' => 'span3 kabupaten', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                            </td>
                            <td>
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPerjalananDinas,
                                    'attribute' => '[' . $x . ']tglmulaidinas',
                                    'mode' => 'date',
                                    'options' => array(
                                        'showOn' => false,
                                        // 'maxDate' => 'd',
                                        'yearRange' => "-150:+0",
                                    ),
                                    'htmlOptions' => array(
                                        'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>
                            </td>
                            <td>
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPerjalananDinas,
                                    'attribute' => '[' . $x . ']sampaidengan',
                                    'mode' => 'date',
                                    'options' => array(
                                        'showOn' => false,
                                        // 'maxDate' => 'd',
                                        'yearRange' => "-150:+0",
                                    ),
                                    'htmlOptions' => array(
                                        'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($modPerjalananDinas, '[' . $x . ']negaratujuan', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                            </td>
                            <td>
                                <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>', '', array('title' => 'Tambah data', 'rel' => 'tooltip', 'onclick' => 'tambahOrganisasi(this);return false', 'id' => 'tambah', 'style' => 'cursor:pointer;')); ?>
                                <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>', '#', array('style' => 'display:none;', 'title' => 'Hapus data', 'rel' => 'tooltip', 'id' => 'hapus', 'onclick' => 'hapusOrganisasi(this);return false', 'style' => 'cursor:pointer;')); ?>
                            </td>
                            <?php echo $form->hiddenField($modPerjalananDinas, '[' . $x . ']create_time', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($modPerjalananDinas, '[' . $x . ']update_time', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($modPerjalananDinas, '[' . $x . ']create_loginpemakai_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($modPerjalananDinas, '[' . $x . ']update_loginpemakai_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($modPerjalananDinas, '[' . $x . ']create_ruangan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            $modPerjalananDinas->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            '#',
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php
$urlGetPerjalananDinas = $this->createUrl('GetPerjalananDinas');
$pegawai_id = $_GET['pegawai_id'];
?>

<script type="text/javascript">
    var trPendidikanpegawai = new String(<?php echo CJSON::encode($this->renderPartial('_rowPerjalanan', array('form' => $form, 'model' => $modPerjalananDinas,), true)); ?>);

    function tambahOrganisasi(obj) {
        $("#hapus").show();
        $(obj).hide();
        $(obj).parents("table").children("tbody").append(trPendidikanpegawai.replace());
        renameInput();
    }

    function hapusOrganisasi(obj) {
        $("#tambah").show();
        $(obj).hide();
        $(obj).parents("tr").remove();
        renameInput();
    }

    function renameInput() {
        var row = 0;
        var obj_table = '#tablePerjalananDinas';
        $(obj_table).find("tbody > tr").each(function() {

            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                    if (old_name_arr[2] === 'nourutperj') {
                        $(this).attr('name', old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]").val(row + 1);
                    }
                }
            });
            $(this).find('span').each(function() {
                var old_name = $(this).parent('.input-append').find('input').attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                var id_span = '';
                if (old_name_arr.length == 3) {
                    id_span = old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_date";
                    id = old_name_arr[0] + "_" + row + "_" + old_name_arr[2];
                    $(this).attr("id", id_span);
                    registerDateJs(id, id_span);
                }
            });
            row++;
        });
    }

    function registerDateJs(id, id_span) {
        $('#' + id).datepicker(jQuery.extend({
                showMonthAfterYear: false
            },
            jQuery.datepicker.regional['id'], {
                'timeOnlyTitle': 'Pilih Waktu',
                'changeYear': true,
                'changeMonth': true,
                'showAnim': 'fold',
                'yearRange': '-80y:+20y'
            }));
        $('#' + id_span).on('click', function() {
            $('#' + id).datepicker('show');
        });
        $(".datemask").mask("99/99/9999");
    }

    function Pengorganisasidata() {
        pegawai_id = <?php echo $pegawai_id ?>;
        if (pegawai_id == '') {
            myAlert('Anda belum memilih pegawai');
            return false;
        } else {
            $.post("<?php echo $urlGetPerjalananDinas ?>", {
                    pegawai_id: pegawai_id,
                },
                function(data) {
                    $("#tableRiwayatJabatan").children("tbody").html(data.tr);
                }, "json");
        }
    }

    function ViewRiwayatJabatan() {

        if ($("#cekRiwayatpegawai").is(":checked")) {
            Pengorganisasidata();
            $("#tableRiwayatJabatan").slideDown(60);
        } else {
            $("#tableRiwayatJabatan").children("tbody").children("tr").remove();
            $("#tableRiwayatJabatan").slideUp(60);
        }
    }

    $('#cekRiwayatpegawai').change(function() {
        $('#divRiwayatpendidikanpegawai').slideToggle(500);
    });

    function hapus(obj) {
        myConfirm('Anda yakin akan menghapus item ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    url = $(obj).attr('href');
                    $(location).attr('href', url);
                }
            });

    }

    function getKabupaten(obj) {
        $.post("<?php echo Yii::app()->createUrl('actionDynamic/getKabupatendrNamaPropinsi', array('attr' => 'propinsi_nama')); ?>", {
            propinsi_nama: $(obj).val(),
        }, function(data) {
            $(obj).parents('tr').find('.kabupaten').html(data);
        });
    }

    $(document).ready(function() {
        Pengorganisasidata();
    });
</script>