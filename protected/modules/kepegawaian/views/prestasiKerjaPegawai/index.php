<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0)
    Yii::app()->user->setFlash('success', "Data Prestasi Kerja berhasil disimpan!");
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kpprestasikerja-r-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>

<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'data-riwayat',
    'content' => array(
        'content-datariwayat' => array(
            'header' => '<b>Riwayat Prestasi Kerja</b>',
            'isi' => $this->renderPartial('_riwayat', array(), true),
            'active' => false,
        ),
    ),
));
?>

<?php echo $form->errorSummary($modPrestasiKerja); ?>
<div class="block-tabel" id="formOrganisasi">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Prestasi Kerja <b>Pegawai</b>
            </div>
        </div>
        <div class="panel-body" style="overflow-x: auto; max-width: 100%;">
            <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <table class="table table-bordered table-striped table-condensed" id="tablePrestasiKerja" style="padding-left: 0; padding-right: 0;">
                <thead>
                    <tr>

                        <th rowspan="2">No. Urut <span class="required">*</span></th>
                        <th rowspan="2">Tanggal Perolehan <span class="required">*</span></th>
                        <th rowspan="2">Instansi Pemberi</th>
                        <th rowspan="2">Penjabat Pemberi</th>
                        <th rowspan="2">Nama Penghargaan</th>
                        <th rowspan="2">Keterangan</th>
                        <th rowspan="2">Tambah / Batal</th>
                    </tr>
                </thead>
                <?php
                $nourut_pend = 1;
                $i = 0;
                ?>
                <tbody>
                    <?php
                    if (count((array)$details) > 0) {
                        foreach ($details as $i => $detail) :
                            $i++;
                    ?>

                            <tr>
                                <?php echo $form->hiddenField($detail, '[' . $i . ']prestasikerja_id', array('class' => 'span1 pegawai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->hiddenField($detail, '[' . $i . ']pegawai_id', array('class' => 'span1 pegawai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php //echo $form->hiddenField($detail,'['.$x.']nama_pegawai',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                                ?>
                                <td>
                                    <?php echo $form->textField($detail, '[' . $i . ']nourutprestasi', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                </td>
                                <td style="padding-right: 0;">

                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $detail,
                                        'attribute' => '[' . $i . ']tglprestasidiperoleh',
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
                                    <?php echo $form->textField($detail, '[' . $i . ']instansipemberi', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                </td>
                                <td>
                                    <?php echo $form->textField($detail, '[' . $i . ']pejabatpemberi', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                </td>
                                <td>
                                    <?php echo $form->textField($detail, '[' . $i . ']namapenghargaan', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                </td>
                                <td>
                                    <?php echo $form->textField($detail, '[' . $i . ']keteranganprestasi', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>', '', array('title' => 'Tambah data', 'rel' => 'tooltip', 'onclick' => 'tambahOrganisasi(this);return false', 'id' => 'tambah', 'style' => 'cursor:pointer;')); ?>
                                    <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>', '#', array('style' => 'display:none;', 'title' => 'Hapus data', 'rel' => 'tooltip', 'id' => 'hapus', 'onclick' => 'hapusOrganisasi(this);return false', 'style' => 'cursor:pointer;')); ?>
                                </td>
                                <?php echo $form->hiddenField($detail, '[' . $i . ']create_time', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->hiddenField($detail, '[' . $i . ']update_time', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->hiddenField($detail, '[' . $i . ']create_loginpemakai_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->hiddenField($detail, '[' . $i . ']update_loginpemakai_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->hiddenField($detail, '[' . $i . ']create_ruangan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </tr>
                        <?php endforeach;
                    } else {
                        $x = 0; ?>

                        <tr>
                            <?php //echo $form->hiddenField($modPrestasiKerja,'['.$x.']nama_pegawai',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                            ?>
                            <td>
                                <?php echo $form->textField($modPrestasiKerja, '[' . $x . ']nourutprestasi', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </td>
                            <td style="padding-right: 0;">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPrestasiKerja,
                                    'attribute' => '[' . $x . ']tglprestasidiperoleh',
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
                                <?php echo $form->textField($modPrestasiKerja, '[' . $x . ']instansipemberi', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($modPrestasiKerja, '[' . $x . ']pejabatpemberi', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($modPrestasiKerja, '[' . $x . ']namapenghargaan', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($modPrestasiKerja, '[' . $x . ']keteranganprestasi', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </td>
                            <td>
                                <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>', '', array('title' => 'Tambah data', 'rel' => 'tooltip', 'onclick' => 'tambahOrganisasi(this);return false', 'id' => 'tambah', 'style' => 'cursor:pointer;')); ?>
                                <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>', '#', array('style' => 'display:none;', 'title' => 'Hapus data', 'rel' => 'tooltip', 'id' => 'hapus', 'onclick' => 'hapusOrganisasi(this);return false', 'style' => 'cursor:pointer;')); ?>
                            </td>
                            <?php echo $form->hiddenField($modPrestasiKerja, '[' . $x . ']create_time', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($modPrestasiKerja, '[' . $x . ']update_time', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($modPrestasiKerja, '[' . $x . ']create_loginpemakai_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($modPrestasiKerja, '[' . $x . ']update_loginpemakai_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($modPrestasiKerja, '[' . $x . ']create_ruangan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            $modPrestasiKerja->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
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
$urlGetPrestasikerja = $this->createUrl('GetPrestasiKerja');
$pegawai_id = $_GET['pegawai_id'];
?>

<script type="text/javascript">
    var trPendidikanpegawai = new String(<?php echo CJSON::encode($this->renderPartial('_rowPrestasi', array('form' => $form, 'model' => $modPrestasiKerja,), true)); ?>);

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
        var obj_table = '#tablePrestasiKerja';
        $(obj_table).find("tbody > tr").each(function() {

            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                    if (old_name_arr[2] === 'nourutprestasi') {
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
            $.post("<?php echo $urlGetPrestasikerja ?>", {
                    pegawai_id: pegawai_id,
                },
                function(data) {
                    $("#tableRiwayatJabatan").children("tbody").append(data.tr);
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

    $(document).ready(function() {
        Pengorganisasidata();
    });
</script>