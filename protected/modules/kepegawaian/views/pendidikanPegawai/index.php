<style>
    .panel-success .panel-heading,
    .accordion-group .accordion-toggle {
        background-color: #6cccb9 !important;
        border-color: #6cccb9 !important;
    }

    div.box {
        margin-bottom: 10px;
    }

    .num {
        text-align: right;
    }
</style>

<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0)
    Yii::app()->user->setFlash('success', "Data Pendidikan berhasil disimpan!");

$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'data-riwayat',
    'content' => array(
        'content-datariwayat' => array(
            'header' => '<b>Riwayat Pendidikan</b>',
            'isi' => $this->renderPartial('_riwayat', array(), true),
            'active' => false,
        ),
    ),
));
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapegawai-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>
<?php echo $form->errorSummary($model); ?>
<!--================================== Form pendidikan =====================================-->
<div class="block-tabel" id="tablePendidikanpegawai">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="fas fa-user-graduate"></i> Pendidikan <b>Pegawai</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <div class="control-group">
                <?php echo CHtml::label('Jenis Pendidikan <span class="required"> * </span>', '', array('class' => 'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'jenispendidikan', LookupM::getItems('jenispendidikan'), array('empty' => '-- Pilih --', 'class' => 'required')); ?>
                </div>
            </div>
            <table class="table table-bordered table-striped table-condensed" style="padding-left: 0; padding-right: 0;" id="tablePendidikanPegawai">
                <thead>
                    <tr>
                        <th rowspan="2">No. urut</th>
                        <th rowspan="2">Pendidikan <span class="required">*</span></th>
                        <th rowspan="2">Nama Sekolah / Universitas</th>
                        <th rowspan="2">Alamat Sekolah / Universitas</th>
                        <th rowspan="2">Tanggal masuk</th>
                        <th rowspan="2">Lama pendidikan</th>
                        <th colspan="3" style="text-align:center;">Kolom ijazah</th>
                        <th rowspan="2">Nilai lulus / grade lulus</th>
                        <th rowspan="2">Keterangan</th>
                        <th rowspan="2">Tambah / Batal</th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Tanda tangan</th>
                    </tr>
                </thead>
                <?php
                $nourut_pend = 1;
                $i = 0;
                ?>
                <tbody>
                    <tr>
                        <td>
                            <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pegawai_id' => $model->pegawai_id)), array('readonly' => TRUE)); ?>
                            <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                            <?php echo $form->textField($modPendidikanpegawai, '[' . $i . ']nourut_pend', array('onkeypress' => "return $(this).focusNextInputField(event)", 'value' => '1', 'style' => 'width:30px;')) ?>
                        </td>
                        <td>
                            <?php echo $form->dropDownList($modPendidikanpegawai, '[' . $i . ']pendidikan_id', CHtml::listData($modPendidikanpegawai->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'style' => 'width:60px;')) ?>
                        </td>
                        <td style="padding-right: 0;">
                            <?php echo $form->textField($modPendidikanpegawai, '[' . $i . ']namasek_univ', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($modPendidikanpegawai, '[' . $i . ']almtsek_univ', array('rows' => 2, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </td>
                        <td>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPendidikanpegawai,
                                'attribute' => '[' . $i . ']tglmasuk',
                                'mode' => 'date',
                                'options' => array(
                                    'showOn' => false,
                                    // 'maxDate' => 'd',
                                    'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPendidikanpegawai, '[' . $i . ']lamapendidikan_bln', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 num')); ?>
                            <?php echo $form->dropDownList($modPendidikanpegawai, '[' . $i . ']satuan', array('tahun' => 'tahun', 'bulan' => 'bulan'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:55px;')) ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPendidikanpegawai, '[' . $i . ']no_ijazah_sert', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                        </td>
                        <td>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPendidikanpegawai,
                                'attribute' => '[' . $i . ']tgl_ijazah_sert',
                                'mode' => 'date',
                                'options' => array(
                                    'showOn' => false,
                                    // 'maxDate' => 'd',
                                    'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPendidikanpegawai, '[' . $i . ']ttd_ijazah_sert', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPendidikanpegawai, '[' . $i . ']nilailulus', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:20px;')); ?>
                            <?php echo ' / '; ?>
                            <?php echo $form->textField($modPendidikanpegawai, '[' . $i . ']gradelulus', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:20px;')); ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($modPendidikanpegawai, '[' . $i . ']keteranganpend', array('rows' => 2, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </td>
                        <td>
                            <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>', '', array('title' => 'Tambah data', 'rel' => 'tooltip', 'onclick' => 'tambahPendidikanpegawai(this);return false', 'id' => 'tambah', 'style' => 'cursor:pointer;')); ?>
                            <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>', '#', array('title' => 'Hapus data', 'rel' => 'tooltip', 'id' => 'hapus', 'onclick' => 'hapusPendidikanpegawai(this);return false', 'style' => 'cursor:pointer;display:none;')); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeypress' => 'return formSubmit(this,event)', 'name' => 'submitpendidikan', 'onclick' => ''));
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), '#', array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        ));
        ?>
    </div>
</div>
<script type="text/javascript">
    var trPendidikanpegawai = new String(<?php echo CJSON::encode($this->renderPartial('_rowPendidikanpegawai', array('form' => $form, 'modPendidikanpegawai' => $modPendidikanpegawai,), true)); ?>);

    function tambahPendidikanpegawai(obj) {
        $("#hapus").show();
        $(obj).hide();
        $(obj).parents("table").children("tbody").append(trPendidikanpegawai.replace());
        renameInputpendidikanpegawai();
        $(obj).parents("table").find("tr:last-child .num").maskMoney({
            "thousands": "",
            "decimal": "",
            "precision": "",
            "allowZero": true,
            "allowNegative": false
        });
    }

    function tambahPendidikanpegawaidrinput(obj) {
        $("#hapus").show();
        $("#tambah").hide();
        $(obj).parents("table").children("tbody").append(trPendidikanpegawai.replace());
        renameInputpendidikanpegawai();
    }

    function hapusPendidikanpegawai(obj) {
        $("#tambah").show();
        $(obj).hide();
        $(obj).parents("tr").remove();
        renameInputpendidikanpegawai();
        addDatePicker
    }

    function renameInputpendidikanpegawai() {
        var row = 0;
        var obj_table = '#tablePendidikanPegawai';
        $(obj_table).find("tbody > tr").each(function() {

            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                    if (old_name_arr[2] === 'nourut_pend') {
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

    function renameInputpendidikanpegawai1() {
        nourut = 1;
        $(".keterangan").each(function() {
            $(this).parents('tr').find('[name*="KPPendidikanpegawaiR"]').each(function() {
                var input = $(this).attr('name');
                var data = input.split('KPPendidikanpegawaiR[]');
                var id = input.split('KPPendidikanpegawaiR[][');
                if (typeof data[1] === 'undefined') {} else {
                    $(this).attr('name', 'KPPendidikanpegawaiR[' + nourut + ']' + data[1]);
                    if (data[1] === '[nourut_pend]') {
                        $(this).attr('name', 'KPPendidikanpegawaiR[' + nourut + ']' + data[1]).val(nourut + 1);
                    }
                };
            });
            nourut++;
        });
    }

    function Pendidikanpegawaidata() {
        pegawai_id = <?php echo $_GET['pegawai_id']; ?>;
        if (pegawai_id == '') {
            myAlert('Anda belum memilih pegawai');
        } else {
            $.post("<?php echo $this->createUrl('GetPendidikanpegawai'); ?>", {
                    pegawai_id: pegawai_id,
                },
                function(data) {
                    $("#tableRiwayatpendidikanpegawai").children("tbody").append(data.tr);
                }, "json");
        }
    }

    function ViewRiwayatPendidikanpegawai() {
        if ($("#cekRiwayatPendidikanpegawai").is(":checked")) {
            Pendidikanpegawaidata();
            $("#tableRiwayatpendidikanpegawai").slideDown(60);
        } else {
            $("#tableRiwayatpendidikanpegawai").children("tbody").children("tr").remove();
            $("#tableRiwayatpendidikanpegawai").slideUp(60);
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

    function cekRequiredTable() {
        myAlert("Silahlkgdfgdfg");
        return false;
    }

    $(document).ready(function() {
        Pendidikanpegawaidata();
        $("#tablePendidikanPegawai tbody").find("tr .num").maskMoney({
            "thousands": "",
            "decimal": "",
            "precision": "",
            "allowZero": true,
            "allowNegative": false
        });
        $("input[class='required']").each(function() {
            if ($(this).val() == "") {
                myAlert("Silakan isi yang bertanda * !");
            }
            return false;
        });
    });
</script>
<?php $this->endWidget(); ?>