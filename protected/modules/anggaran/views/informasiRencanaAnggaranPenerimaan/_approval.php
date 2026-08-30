<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>


<div class="white-container">
    <legend class="rim2">Transaksi Approval Anggaran Penerimaan</legend>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'approval-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event); '), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
    )); ?>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Approval data anggaran penerimaan berhasil disimpan!");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->errorSummary($modDetail); ?>
    <fieldset class="box">
        <legend class="rim">Data Rencana Penerimaan</legend>
        <div class="row">
            <div class="col-sm-4">
                <?php echo $form->textFieldRow($model, 'tglrenanggaranpen', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                <?php echo $form->textFieldRow($model, 'noren_penerimaan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
            </div>
            <div class="col-sm-4">
                <div class="control-group">
                    <?php echo $form->hiddenField($model, 'digitnilai', array('readonly' => true)) ?>
                    <?php echo $form->labelEx($model, 'Periode Anggaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'deskripsiperiode', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($model, 'konfiganggaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'Sumber Anggaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'sumberanggarannama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($model, 'sumberanggaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'Total Penerimaan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'total_renanggaranpen', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>

                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel <b>Approval Anggaran Penerimaan</b></h6>
        <table class="items table table-striped table-condensed" id="table-rencanaanggaranpenerimaan">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Termin ke-</th>
                    <th>Tanggal Penerimaan</th>
                    <th>Nilai Anggaran <span id="digitlabel"></span></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $trApprove = $this->renderPartial('_rowApprovalkosong', array('format' => $format, 'modDetails' => $modDetails, 'modDetail' => $modDetail, 'digit_str' => $digit_str), true);
                echo $trApprove;
                ?>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align:right;">Total Rencana Anggaran Penerimaan</td>
                    <td><?php echo $form->textField($model, 'totalnilaipenerimaan', array('class' => 'span2 integer2', 'style' => 'width:90px;', 'readonly' => true)) ?></td>
                    <td><?php echo $form->hiddenField($model, 'jmlRow', array('class' => 'span2', 'style' => 'width:90px;', 'readonly' => true)) ?></td>
                </tr>
            </tfoot>
            </tbody>
        </table>
    </div>
    <div class="row box">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'Pegawai Mengetahui', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'pegawaimengetahui_nama', array('class' => 'span3', 'readonly' => true)); ?>
                    <?php echo $form->hiddenField($model, 'renpen_mengetahui_id', array('readonly' => true)); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'Pegawai Menyetujui', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'pegawaimenyetujui_nama', array('class' => 'span3', 'readonly' => true)); ?>
                    <?php echo $form->hiddenField($model, 'renpen_menyetujui_id', array('readonly' => true)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'verifikasiApprove();', 'onkeypress' => 'verifikasiApprove();')); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('index'),
            array('class' => 'btn btn-default', 'onclick' => 'if(!confirm("' . Yii::t('mds', 'Apakah Anda akan mengulang input data ?') . '")) return false;')
        ); ?>
        <?php
        echo (!isset($_GET['approverenanggpen_id']) ?
            CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true)) . "&nbsp&nbsp" :
            CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => false, 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp");
        $urlPrint = $this->createUrl('printApproval', array('approverenanggpen_id' => isset($_GET['approverenanggpen_id']) ? $_GET['approverenanggpen_id'] : null));
        $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}"+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
        <?php $content = $this->renderPartial('../tips/add1', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<div style='display:none;'>
    <?php
    $this->widget('MyDateTimePicker', array(
        'model' => $model,
        'attribute' => 'tglrenanggaranpen',
        'mode' => 'date',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
        ),
        'htmlOptions' => array(
            'readonly' => true,
            'onkeypress' => "return $(this).focusNextInputField(event)"
        ),
    ));
    ?>
</div>

<script type="text/javascript">
    function addRowApproval(obj) {
        var trApprove = new String(<?php echo CJSON::encode($this->renderPartial('_rowApprovalkosong', array('modDetail' => $modDetail, 'format' => $format, 'removeButton' => true), true)); ?>);

        $("#table-rencanaanggaranpenerimaan > tbody > tr:last .tambahRow").attr('style', 'display:none;');
        $("#table-rencanaanggaranpenerimaan > tbody > tr:last .integer2").maskMoney({
            "symbol": "",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": ".",
            "precision": 0
        });
        $(obj).parents('table').children('tbody').append(trApprove.replace());
        renameInput('#table-rencanaanggaranpenerimaan');
        $('#table-rencanaanggaranpenerimaan tbody').each(function() {
            jQuery('input[name$="[tglrenanggaranpen]"]').datepicker(
                jQuery.extend({
                        showMonthAfterYear: true
                    },
                    jQuery.datepicker.regional['id'], {
                        'dateFormat': 'dd M yy',
                        //								'maxDate':'d',
                        //								'timeText':'Waktu',
                        //								'hourText':'Jam',
                        //								'minuteText':'Menit',
                        //								'secondText':'Detik',
                        //								'showSecond':true,
                        //								'timeOnlyTitle':'Pilih Waktu',
                        //								'timeFormat':'hh:mm:ss',
                        'changeYear': true,
                        'changeMonth': true,
                        'showAnim': 'fold',
                        'yearRange': '-0y:+10y'
                    }
                )
            );
        });
    }

    function renameInput(obj_table) {
        var row = 0;
        $("#table-rencanaanggaranpenerimaan > tbody > tr:last .tambahRow").attr('style', 'display:true;');
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find("#no_urut").val(row + 1);
            $(this).find("#renanggaran_ke").val(row + 1);
            $(this).find('span[name*="[ii]"]').each(function() { //element <span>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });

    }

    function hapusApprove(obj, renanggaranpenerimaandet_id) {
        if (renanggaranpenerimaandet_id === 0) { //jika data baru ditambahkan, params rencanggaranpengdet_id = kosong
            myConfirm('Apakah Anda akan membatalkan rencana anggaran ini?', 'Perhatian!',
                function(r) {
                    if (r) {
                        $(obj).parents('tr').detach();
                        hitungTotalApprove();
                        renameInput('#table-rencanaanggaranpenerimaan');
                        $("#table-rencanaanggaranpenerimaan > tbody > tr:last .tambahRow").attr('style', 'display:true;');
                    }
                });
        } else {
            $("#table-rencanaanggaranpenerimaan").addClass("animation-loading");
            myConfirm('Apakah Anda akan menghapus rencana anggaran ini yang sudah ada di database?', 'Perhatian!',
                function(r) {
                    if (r) {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo $this->createUrl('HapusRencana'); ?>',
                            data: {
                                renanggaranpenerimaandet_id: renanggaranpenerimaandet_id
                            },
                            dataType: "json",
                            success: function(data) {
                                $(obj).parents('tr').detach();
                                hitungTotalApprove();
                                location.reload();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(errorThrown);
                            }
                        });
                    }
                    $("#table-rencanaanggaranpenerimaan").removeClass("animation-loading");
                });
        }
    }

    function hitungTotalApprove() {
        unformatNumberSemua();
        var total = 0;
        var jmlRencana = $('#table-rencanaanggaranpenerimaan tbody tr').length;
        $('#table-rencanaanggaranpenerimaan tbody tr').each(function() {
            var nilaianggaran = parseInt($(this).find('input[name$="[nilaipenerimaan]"]').val());
            if (nilaianggaran <= 0) {
                nilaianggaran = 0;
            }
            total += nilaianggaran;

        });
        $('#<?php echo CHtml::activeId($model, "totalnilaipenerimaan"); ?>').val(formatNumber(total));
        formatNumberSemua();
    }

    function verifikasiApprove() {
        if (requiredCheck($("approval-form"))) {
            var jml_row = $('#table-rencanaanggaranpenerimaan tbody tr').length;
            $('#<?php echo CHtml::activeId($model, "jmlRow"); ?>').val(jml_row);
            if (validasiDetail()) {
                if (jml_row == 0) {
                    myConfirm('Tidak ada data untuk diapprove ! <br> Silakan refresh halaman ini.', 'Perhatian!',
                        function(r) {
                            if (r) {
                                location.reload();
                            }
                        });
                } else {
                    $('#approval-form').submit();
                }
            } else {
                formatNumberSemua();
                return false;
            }

            $("#table-rencanaanggaranpengeluaran").addClass("animation-loading");
            $("form").find('.float').each(function() {
                $(this).val(formatFloat($(this).val()));
            });
            $("form").find('.integer2').each(function() {
                $(this).val(formatInteger($(this).val()));
            });
        }
        return false;
    }

    function validasiDetail() {
        if (validasiDetailTanggalAnggaran() && validasiDetailNilaiAnggaran()) {
            if (validasiDetailNilaiAnggaran()) {
                return true;
            } else {
                return false;
            }
        }
    }

    function validasiDetailTanggalAnggaran() {
        var detailTanggalanggaran = document.getElementsByClassName("tanggalanggaran");
        var jml = detailTanggalanggaran.length;
        var kosong = false;
        for (i = 0; i < jml; i++) {
            if (detailTanggalanggaran[i].value === '') {
                myAlert('Silakan lengkapi semua Tanggal Anggaran!');
                kosong = true;
                break;
            }
        }
        if (kosong)
            return false;
        else
            return true;
    }

    function validasiDetailNilaiAnggaran() {
        var detailNilaianggaran = document.getElementsByClassName("nilaianggaran");
        var jml = detailNilaianggaran.length;
        var kosong = false;
        for (i = 0; i < jml; i++) {
            if (detailNilaianggaran[i].value === '0') {
                myAlert('Silakan lengkapi semua Nilai Anggaran!');
                kosong = true;
                break;
            }
        }
        if (kosong)
            return false;
        else
            return true;
    }

    $(document).ready(function() {
        var digitnilai = $('#<?php echo CHtml::activeId($model, "digitnilai"); ?>').val();
        $('#digit').html(digitnilai);
        $('#digitlabel').html(digitnilai);
        hitungTotalApprove();
        $("#table-rencanaanggaranpenerimaan > tbody > tr:last .tambahRow").attr('style', 'display:true;');
    });
</script>