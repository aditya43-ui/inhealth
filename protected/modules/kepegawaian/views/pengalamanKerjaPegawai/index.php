<style>
    .panel-success .panel-heading,
    .accordion-group .accordion-toggle {
        background-color: #6cccb9 !important;
        border-color: #6cccb9 !important;
    }

    div.box {
        margin-bottom: 10px;
    }
</style>

<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0)
    Yii::app()->user->setFlash('success', "Data Pengalaman Kerja berhasil disimpan!");
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'data-riwayat',
    'content' => array(
        'content-datariwayat' => array(
            'header' => '<b>Riwayat Pengalaman Kerja</b>',
            'isi' => $this->renderPartial('_riwayat', array(), true),
            'active' => false,
        ),
    ),
));
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapegawai-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>
<?php echo $form->errorSummary($model); ?>
<div class="block-tabel" id="tablePengalamankerja">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="fas fa-briefcase"></i> Pengalaman <b>Kerja</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <table class="table table-bordered table-striped table-condensed" style="padding-left: 0; padding-right: 0;" id="tablePengalamanKerja">
                <thead>
                    <tr>
                        <th>No. urut</th>
                        <th>Nama perusahaan <span class="required">*</span></th>
                        <th>Bidang usaha</th>
                        <th>Jabatan</th>
                        <th>Tanggal masuk <span class="required">*</span></th>
                        <th>Tanggal keluar <span class="required">*</span></th>
                        <th>Lama kerja</th>
                        <th>Alasan berhenti</th>
                        <th>Keterangan</th>
                        <th>Tambah / Batal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if (count((array)$detailPengalamankerja) > 0) {
                        foreach ($detailPengalamankerja as $i => $detail) :
                            $i++;
                    ?>
                            <tr>
                                <td>
                                    <?php echo CHtml::hiddenField('url', $this->createUrl('', array('idPegawai' => $model->pegawai_id)), array('readonly' => TRUE)); ?>
                                    <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                                    <?php echo $form->textField($detail, '[' . $i . ']pengalamankerja_nourut', array('style' => 'width:20px;', 'value' => $i)) ?>
                                    <?php echo $form->hiddenField($detail, '[' . $i . ']pengalamankerja_id'); ?>
                                </td>
                                <td>
                                    <?php echo $form->textField($detail, '[' . $i . ']namaperusahaan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                                </td>
                                <td>
                                    <?php echo $form->textField($detail, '[' . $i . ']bidangperusahaan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                                </td>
                                <td>
                                    <?php echo $form->textField($detail, '[' . $i . ']jabatanterahkir', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                                </td>
                                <td>
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $detail,
                                        'attribute' => '[' . $i . ']tglmasuk',
                                        'mode' => 'date',
                                        'options' => array(
                                            'showOn' => false,
                                            // 'maxDate' => 'd',
                                            'onkeyup' => "js:function(){setLamaKerja(this);}",
                                            'onSelect' => 'js:function(){setLamaKerja(this);}',
                                            'yearRange' => "-150:+0",
                                        ),
                                        'htmlOptions' => array(
                                            'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'setLamaKerja(this);'
                                        ),
                                    )); ?>
                                </td>
                                <td>
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $detail,
                                        'attribute' => '[' . $i . ']tglkeluar',
                                        'mode' => 'date',
                                        'options' => array(
                                            'showOn' => false,
                                            'onkeyup' => "js:function(){setLamaKerja(this);}",
                                            'onSelect' => 'js:function(){setLamaKerja(this);}',
                                            // 'maxDate' => 'd',
                                            'yearRange' => "-150:+0",
                                        ),
                                        'htmlOptions' => array(
                                            'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'setLamaKerja(this);'
                                        ),
                                    )); ?>
                                </td>
                                <td>
                                    <?php echo $form->textField($detail, '[' . $i . ']lama_tahun', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:20px',)) . ' thn'; ?>
                                    <?php echo $form->textField($detail, '[' . $i . ']lama_bulan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:20px',)) . ' bln'; ?>
                                </td>
                                <td>
                                    <?php echo $form->textArea($detail, '[' . $i . ']alasanberhenti', array('onkeypress' => "(this)", 'style' => 'width:50px;')); ?>
                                </td>
                                <td>
                                    <?php echo $form->textArea($detail, '[' . $i . ']keterangan', array('onkeypress' => "(this)", 'style' => 'width:50px;', 'class' => 'keterangan')); ?>
                                </td>
                                <td style="width:50px;">
                                    <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>', '', array('title' => 'Tambah data', 'rel' => 'tooltip', 'onclick' => 'tambahPengalamankerja(this);return false', 'id' => 'tambah', 'style' => 'cursor:pointer;')); ?>
                                    <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>', '#', array('title' => 'Hapus data', 'rel' => 'tooltip', 'id' => 'hapus', 'onclick' => 'hapusPengalamankerja(this);return false', 'style' => 'cursor:pointer;display:none;')); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php } ?>
                    <?php
                    $no = $i + 1;
                    $x = 0;
                    ?>
                    <tr>
                        <td>
                            <?php echo CHtml::hiddenField('url', $this->createUrl('', array('idPegawai' => $model->pegawai_id)), array('readonly' => TRUE)); ?>
                            <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                            <?php echo $form->textField($modPengalamankerja, '[' . $x . ']pengalamankerja_nourut', array('value' => $no, 'style' => 'width:20px;')) ?>
                            <?php echo $form->hiddenField($modPengalamankerja, '[' . $x . ']pengalamankerja_id'); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPengalamankerja, '[' . $x . ']namaperusahaan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPengalamankerja, '[' . $x . ']bidangperusahaan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPengalamankerja, '[' . $x . ']jabatanterahkir', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                        </td>
                        <td>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPengalamankerja,
                                'attribute' => '[' . $x . ']tglmasuk',
                                'mode' => 'date',
                                'options' => array(
                                    'showOn' => false,
                                    'onkeyup' => "js:function(){setLamaKerja(this);}",
                                    'onSelect' => 'js:function(){setLamaKerja(this);}',
                                    // 'maxDate' => 'd',
                                    'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'setLamaKerja(this);'
                                ),
                            )); ?>
                        </td>
                        <td>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPengalamankerja,
                                'attribute' => '[' . $x . ']tglkeluar',
                                'mode' => 'date',
                                'options' => array(
                                    'showOn' => false,
                                    'onkeyup' => "js:function(){setLamaKerja(this);}",
                                    'onSelect' => 'js:function(){setLamaKerja(this);}',
                                    // 'maxDate' => 'd',
                                    'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'setLamaKerja(this);'
                                ),
                            )); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPengalamankerja, '[' . $x . ']lama_tahun', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:20px',)) . ' thn'; ?>
                            <?php echo $form->textField($modPengalamankerja, '[' . $x . ']lama_bulan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:20px',)) . ' bln'; ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($modPengalamankerja, '[' . $x . ']alasanberhenti', array('onkeypress' => "(this)", 'style' => 'width:50px;')); ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($modPengalamankerja, '[' . $x . ']keterangan', array('onkeypress' => "(this)", 'style' => 'width:50px;', 'class' => 'keterangan')); ?>
                        </td>
                        <td style="width:50px;">
                            <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>', '', array('title' => 'Tambah data', 'rel' => 'tooltip', 'onclick' => 'tambahPengalamankerja(this);return false', 'id' => 'tambah', 'style' => 'cursor:pointer;')); ?>
                            <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>', '#', array('title' => 'Hapus data', 'rel' => 'tooltip', 'id' => 'hapus', 'onclick' => 'hapusPengalamankerja(this);return false', 'style' => 'cursor:pointer;display:none;')); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'submitButton', 'onKeypress' => 'return formSubmit(this,event)', 'name' => 'submitPengalamankerja')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        '#',
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
</div>
<?php
$this->endWidget();
$urlGetPengalamankerja = $this->createUrl('GetPengalamankerja');
$pegawai_id = $_GET['pegawai_id'];
?>
<script type="text/javascript">
    var trPengalamankerja = new String(<?php echo CJSON::encode($this->renderPartial('_rowPengalamankerja', array('form' => $form, 'modPengalamankerja' => $modPengalamankerja,), true)); ?>);

    function tambahPengalamankerja(obj) {
        $(obj).parents("td").children("#hapus").show();
        $(obj).hide();
        $(obj).parents("table").children("tbody").append(trPengalamankerja.replace());
        renameInputpengalamankerja(obj);
    }

    function hapusPengalamankerja(obj) {
        $("#tambah").show();
        $(obj).hide();
        $(obj).parents("tr").remove();
    }

    function renameInputpengalamankerja() {
        var row = 0;
        var obj_table = '#tablePengalamanKerja';
        $(obj_table).find("tbody > tr").each(function() {

            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                    if (old_name_arr[2] === 'pengalamankerja_nourut') {
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
                'onkeyup': function() {
                    setLamaKerja(this);
                },
                'onSelect': function() {
                    setLamaKerja(this);
                },
                'yearRange': '-80y:+20y'
            }));
        $('#' + id_span).on('click', function() {
            $('#' + id).datepicker('show');
        });
        $(".datemask").mask("99/99/9999");
    }

    function Pengalamankerjadata() {
        pegawai_id = <?php echo $pegawai_id ?>;;
        if (pegawai_id == '') {
            myAlert('Anda belum memilih pegawai');
        } else {
            $.post("<?php echo $urlGetPengalamankerja ?>", {
                    pegawai_id: pegawai_id,
                },
                function(data) {
                    $("#tableRiwayatPengalamankerja").children("tbody").append(data.tr);
                }, "json");
        }
    }

    function ViewRiwayatPengalamankerja() {

        if ($("#cekRiwayatPengalamankerja").is(":checked")) {
            Pengalamankerjadata();
            $("#tableRiwayatPengalamankerja").slideDown(60);
        } else {
            $("#tableRiwayatPengalamankerja").children("tbody").children("tr").remove();
            $("#tableRiwayatPengalamankerja").slideUp(60);
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

    function setLamaKerja(obj) {
        var tgl_awal = $(obj).parents('tr').find('input[name*="[tglmasuk]"]').val();
        var tgl_akhir = $(obj).parents('tr').find('input[name*="[tglkeluar]"]').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetLamaKerja'); ?>',
            data: {
                tgl_awal: tgl_awal,
                tgl_akhir: tgl_akhir
            },
            dataType: "json",
            success: function(data) {
                $(obj).parents('tr').find('input[name*="[lama_tahun]"]').val(data.thn);
                $(obj).parents('tr').find('input[name*="[lama_bulan]"]').val(data.bln);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    $(document).ready(function() {
        Pengalamankerjadata();
    });
</script>