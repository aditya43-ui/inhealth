<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0)
    Yii::app()->user->setFlash('success', "Data Diklat berhasil disimpan!");
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="box" style="overflow-x:auto; max-width: 100%">
    <?php
    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        'id' => 'data-riwayat',
        'content' => array(
            'content-datariwayat' => array(
                'header' => '<b>Riwayat Diklat</b>',
                'isi' => $this->renderPartial('_riwayat', array(), true),
                'active' => false,
            ),
        ),
    ));
    ?>
</div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapegawai-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<?php echo $form->errorSummary($model); ?>
<div class="block-tabel" id="tableDiklatpegawai">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Diklat <b>Pegawai</b>
            </div>
        </div>
        <div class="panel-body" style="overflow-x: auto; max-width: 100%">
            <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <table class="table table-bordered table-striped table-condensed" style="padding-left: 0; padding-right: 0; width: 100%;" id="tableDiklat">
                <thead>
                    <tr>
                        <th rowspan="2" style="vertical-align: top;">No</th>
                        <th rowspan="2" style="vertical-align: top;">Jenis diklat <span class="required">*</span></th>
                        <th rowspan="2" style="vertical-align: top;">Diklat</th>
                        <th rowspan="2" width="16%" style="vertical-align: top;">Tanggal mulai diklat</th>
                        <th rowspan="2" width="15%" style="vertical-align: top;">Lama diklat</th>
                        <th rowspan="2" style="vertical-align: top;">Tempat</th>
                        <th colspan="3" style="text-align:center;">Keputusan</th>
                        <th rowspan="2" style="vertical-align: top;">Keterangan</th>
                        <th rowspan="2" style="vertical-align: top;">Tambah / Batal</th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th width="20%">Tanggal penetapan</th>
                        <th>Pimpinan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if (count((array)$detailPegawaidiklat) > 0) {
                        foreach ($detailPegawaidiklat as $i => $detail) :
                            $i++;
                    ?>
                            <tr>
                                <td>
                                    <?php echo CHtml::hiddenField('url', $this->createUrl('', array('idPegawai' => $detail->pegawai_id)), array('readonly' => TRUE)); ?>
                                    <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                                    <?php echo $form->hiddenField($detail, '[' . $i . ']pegawaidiklat_id'); ?>
                                    <?php echo $form->textField($detail, '[' . $i . ']no', array('readonly' => true, 'style' => 'width:20px;', 'value' => $i)) ?>
                                </td>
                                <td>
                                    <?php echo $form->dropDownList($detail, '[' . $i . ']jenisdiklat_id', CHtml::listData($modPegawaidiklat->getJenisdiklatItems(), 'jenisdiklat_id', 'jenisdiklat_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'style' => 'width:120px;')) ?>
                                </td>
                                <td style="padding-right: 0;">
                                    <?php echo $form->textField($detail, '[' . $i . ']pegawaidiklat_nama', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                                </td>
                                <td>
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $detail,
                                        'attribute' => '[' . $i . ']pegawaidiklat_tahun',
                                        'mode' => 'date',
                                        'options' => array(
                                            'showOn' => false,
                                            // 'maxDate' => 'd',
                                            'yearRange' => "-150:+0",
                                        ),
                                        'htmlOptions' => array(
                                            'placeholder' => '00/00/0000', 'class' => 'span3 dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                        ),
                                    )); ?>
                                </td>
                                <td>
                                    <?php echo $form->textField($detail, '[' . $i . ']pegawaidiklat_lamanya', array('class' => 'numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:10  0px;')); ?>
                                    <?php echo $form->dropDownList($detail, '[' . $i . ']pegawaidiklat_lamanyasatuan', array('tahun' => 'tahun', 'bulan' => 'bulan', 'hari' => 'hari'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:100px;')) ?>
                                </td>
                                <td>
                                    <?php echo $form->textField($detail, '[' . $i . ']pegawaidiklat_tempat', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                                </td>
                                <td>
                                    <?php echo $form->textField($detail, '[' . $i . ']nomorkeputusandiklat', array('class' => 'span2 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                </td>
                                <td>
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $detail,
                                        'attribute' => '[' . $i . ']tglditetapkandiklat',
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
                                    <?php echo $form->textField($detail, '[' . $i . ']pejabatygmemdiklat', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')) ?>
                                </td>
                                <td>
                                    <?php echo $form->textArea($detail, '[' . $i . ']pegawaidiklat_keterangan', array('onkeypress' => "(this)", 'rows' => '3', 'col' => '2', 'class' => 'span2')); ?>
                                </td>
                                <td style="width:50px;">
                                    <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>', '', array('title' => 'Tambah data', 'rel' => 'tooltip', 'onclick' => 'tambahPegawaidiklat(this);return false', 'id' => 'tambah', 'style' => 'cursor:pointer;')); ?>
                                    <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>', '#', array('title' => 'Hapus data', 'rel' => 'tooltip', 'id' => 'hapus', 'onclick' => 'hapusPegawaidiklat(this);return false', 'style' => 'cursor:pointer;display:none;')); ?>
                                </td>
                            </tr>
                    <?php
                        endforeach;
                    }
                    ?>
                    <?php
                    $no = $i + 1;
                    $x = 0;
                    ?>
                    <tr>
                        <td>
                            <?php echo CHtml::hiddenField('url', $this->createUrl('', array('idPegawai' => $modPegawaidiklat->pegawai_id)), array('readonly' => TRUE)); ?>
                            <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                            <?php echo $form->textField($modPegawaidiklat, '[' . $x . ']no', array('readonly' => true, 'style' => 'width:20px;', 'value' => $no)) ?>
                            <?php echo $form->hiddenField($modPegawaidiklat, '[' . $x . ']pegawaidiklat_id'); ?>
                        </td>
                        <td>
                            <?php echo $form->dropDownList($modPegawaidiklat, '[' . $x . ']jenisdiklat_id', CHtml::listData($modPegawaidiklat->getJenisdiklatItems(), 'jenisdiklat_id', 'jenisdiklat_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'style' => 'width:120px;')) ?>
                        </td>
                        <td style="padding-right: 0;">
                            <?php echo $form->textField($modPegawaidiklat, '[' . $x . ']pegawaidiklat_nama', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                        </td>
                        <td>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPegawaidiklat,
                                'attribute' => '[' . $x . ']pegawaidiklat_tahun',
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
                            <?php echo $form->textField($modPegawaidiklat, '[' . $x . ']pegawaidiklat_lamanya', array('class' => 'numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:30px;')); ?>
                            <?php echo $form->dropDownList($modPegawaidiklat, '[' . $x . ']pegawaidiklat_lamanyasatuan', array('tahun' => 'tahun', 'bulan' => 'bulan', 'hari' => 'hari'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:55px;')) ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPegawaidiklat, '[' . $x . ']pegawaidiklat_tempat', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPegawaidiklat, '[' . $x . ']nomorkeputusandiklat', array('class' => 'numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:20px')); ?>
                        </td>
                        <td>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPegawaidiklat,
                                'attribute' => '[' . $x . ']tglditetapkandiklat',
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
                            <?php echo $form->textField($modPegawaidiklat, '[' . $x . ']pejabatygmemdiklat', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')) ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($modPegawaidiklat, '[' . $x . ']pegawaidiklat_keterangan', array('onkeypress' => "(this)", 'rows' => '3', 'col' => '2', 'class' => 'span2')); ?>
                        </td>
                        <td style="width:50px;">
                            <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>', '', array('title' => 'Tambah data', 'rel' => 'tooltip', 'onclick' => 'tambahPegawaidiklat(this);return false', 'id' => 'tambah', 'style' => 'cursor:pointer;')); ?>
                            <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>', '#', array('title' => 'Hapus data', 'rel' => 'tooltip', 'id' => 'hapus', 'onclick' => 'hapusPegawaidiklat(this);return false', 'style' => 'cursor:pointer;display:none;')); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'submitButton', 'onKeypress' => 'return formSubmit(this,event)', 'name' => 'submitdiklat')
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
<!--================================== Akhir form diklat ========================================-->
<?php
$this->endWidget();
$urlGetPegawaidiklat = $this->createUrl('GetPegawaidiklat');
$pegawai_id = $_GET['pegawai_id'];
?>
<script type="text/javascript">
    var trPegawaidiklat = new String(<?php echo CJSON::encode($this->renderPartial('_rowPegawaidiklat', array('form' => $form, 'modPegawaidiklat' => $modPegawaidiklat,), true)); ?>);

    function tambahPegawaidiklat(obj) {
        $(obj).parents("td").children("#hapus").show();
        $(obj).hide();
        $(obj).parents("table").children("tbody").append(trPegawaidiklat.replace());
        renameInputpegawaidiklat();
    }

    function tambahPegawaidiklatdrinput(obj) {
        $("#hapus").show();
        $("#tambah").hide();
        $(obj).parents("table").children("tbody").append(trPegawaidiklat.replace());
        renameInputpegawaidiklat();
    }

    function hapusPegawaidiklat(obj) {
        $("#tambah").show();
        $(obj).hide();
        $(obj).parents("tr").remove();
    }

    function renameInputpegawaidiklat() {
        var row = 0;
        var obj_table = '#tableDiklat';
        $(obj_table).find("tbody > tr").each(function() {

            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                    if (old_name_arr[2] === 'no') {
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

    function Pegawaidiklatdata() {
        pegawai_id = <?php echo $pegawai_id ?>;
        if (pegawai_id == '') {
            myAlert('Anda belum memilih pegawai');
        } else {
            $.post("<?php echo $urlGetPegawaidiklat ?>", {
                    pegawai_id: pegawai_id,
                },
                function(data) {
                    $("#tableRiwayatPegawaidiklat").children("tbody").append(data.tr);
                }, "json");
        }
    }

    function ViewRiwayatPegawaidiklat() {

        if ($("#cekRiwayatPegawaidiklat").is(":checked")) {
            Pegawaidiklatdata();
            $("#tableRiwayatPegawaidiklat").slideDown(60);
        } else {
            $("#tableRiwayatPegawaidiklat").children("tbody").children("tr").remove();
            $("#tableRiwayatPegawaidiklat").slideUp(60);
        }
    }

    function hapus(obj) {
        myConfirm('Anda yakin akan menghapus item ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    url = $(obj).attr('href');
                    $(location).attr('href', url);
                }
            });

    }

    $(document).ready(function() {
        Pegawaidiklatdata();
    });
</script>