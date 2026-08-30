<?php

/**
 * @author Deni Hamdani <denihamdani@piindoensia.co.id>
 * @website <piindonesia.co.id>
 * 
 * untuk menampilkan tindakan (via riwayat pasien).
 * 
 */

$row = $this->renderPartial($this->path_view.'_rowTindakan', array('idx' => 'i', 'modTindakan' => new AsesmenigdtindakT), true);
$row = str_replace("\n", '', $row);
$row = str_replace("\r", '', $row);

?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pemberian Tindakan
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-condensed table-striped" width="100%" id="tab_tindakan">
            <thead>
                <tr>
                    <th>Pukul</td>
                    <th>Tindakan</td>
                    <th>Nama</th>
                    <th style="width:50px; text-align: center;"><?php echo CHtml::link('<i class="icon-plus"></i>', '#', array(
                                                                    'onclick' => 'tambahTindakan(); return false;',
                                                                    'data-toggle' => 'tooltip',
                                                                    'title' => 'Tambah Terapi',
                                                                )); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $idx = 0;
                foreach ($modTindakan as $item) {
                    echo $this->renderPartial($this->path_view.'_rowTindakan', array('idx' => $idx++, 'modTindakan' => $item), true);
                } ?>
            </tbody>
        </table>
    </div>

    <?php // echo CHtml::encode($row); die; 
    ?>

    <script>
        var rowTindakan = '<?php echo $row; ?>';
        var rowTindakanIdx = 0;

        function tambahTindakan() {

            if (periksaInputTerakhirTindakan()) {
                myAlert('Lengkapi isian yang kosong pada baris tindakan sebelum Anda menambahkan data baru.');
                return false;
            }

            $("#tab_tindakan tbody").append(rowTindakan);
            renameInputTindakan();
            setDatePickerTindakan();
            setAutoCompleteTindakan();

        }

        function periksaInputTerakhirTindakan() {

            var barisKosong = false;

            var field = ['daftartindakan_id', 'tindakan_nama', 'tindakan_oleh', 'tindakan_oleh_nama'];

            $("#tab_tindakan tbody tr").each(function() {

                var row = $(this);
                var fieldKosong = false;
                $.each(field, function(idx, v) {
                    if ($(row).find("." + v).val().trim() == "") fieldKosong = true;
                });

                if (fieldKosong) barisKosong = true;
            });


            return barisKosong;
        }

        function renameInputTindakan() {
            var i = 0;
            var field = ['asesmenigdtindak_tgl', 'daftartindakan_id', 'tindakan_nama', 'tindakan_oleh', 'tindakan_oleh_nama'];

            $("#tab_tindakan tbody tr").each(function() {
                var row = $(this);
                row.data('row', i);
                $.each(field, function(idx, v) {
                    row.find("." + v).prop('name', 'det[' + i + '][' + v + ']');
                });
                i++;
            });
        }

        function setDatePickerTindakan() {
            var last = $("#tab_tindakan tbody tr:last-child");

            jQuery(last).find(".asesmenigdtindak_tgl").datetimepicker(
                    jQuery.extend({
                            showMonthAfterYear: false
                        },
                        jQuery.datepicker.regional['id'], {
                            'dateFormat': 'dd M yy',
                            'maxDate': 'd',
                            'timeText': 'Waktu',
                            'hourText': 'Jam',
                            'minuteText': 'Menit',
                            'secondText': 'Detik',
                            'showSecond': true,
                            'timeOnlyTitle': 'Pilih   Waktu',
                            'timeFormat': 'hh:mm:ss',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold'
                        }
                    )
                )
                .parents('.input-append')
                .find(".add-on").click(function() {
                    $(this).parents('.input-append').find('.asesmenigdtindak_tgl').focus();
                });

        }

        function setAutoCompleteInputTindakan(obj) {
            jQuery(obj).autocomplete({
                'showAnim': 'fold',
                'minLength': 2,
                'focus': function(event, ui) {
                    $(this).val(ui.item.label);
                    return false;
                },
                'select': function(event, ui) {
                    $(this).val(ui.item.label);
                    $(this).parents("tr").find(".daftartindakan_id").val(ui.item.value);
                    return false;
                },
                'source': function(request, response) {
                    $.ajax({
                        url: "<?php echo $this->createUrl('autocompleteTindakan'); ?>",
                        dataType: "json",
                        data: {
                            term: request.term,
                        },
                        success: function(data) {
                            response(data);
                        }
                    })
                }
            });
        }

        function setAutoCompleteInputTindakanPegawai(obj) {
            jQuery(obj).autocomplete({
                'showAnim': 'fold',
                'minLength': 2,
                'focus': function(event, ui) {
                    $(this).val(ui.item.label);
                    return false;
                },
                'select': function(event, ui) {
                    $(this).val(ui.item.label);
                    $(this).parents("tr").find(".tindakan_oleh").val(ui.item.value);
                    return false;
                },
                'source': function(request, response) {
                    $.ajax({
                        url: "<?php echo $this->createUrl('autocompleteTindakanPegawai'); ?>",
                        dataType: "json",
                        data: {
                            term: request.term,
                        },
                        success: function(data) {
                            response(data);
                        }
                    })
                }
            });
        }

        // lengkapi isian pertama sebelum Anda menambahkan data baru.
        function setAutoCompleteTindakan() {
            var last = $("#tab_tindakan tbody tr:last-child");

            setAutoCompleteInputTindakan(jQuery(last).find(".tindakan_nama"));
            setAutoCompleteInputTindakanPegawai(jQuery(last).find(".tindakan_oleh_nama"));
        }

        // ---------------- Pegawai Tindakan --------------------

        function setDialogPegawaiTindakan(obj) {
            rowTindakanIdx = $(obj).parents('tr').data('row');

            $("#dialogPegawaiTindakan").dialog("open");
        }

        function addPegawaiTindakan(data) {
            var row = $("#tab_tindakan tbody tr").eq(rowTindakanIdx);

            row.find(".tindakan_oleh").val(data.pegawai_id);
            row.find(".tindakan_oleh_nama").val(data.nama_pegawai);

            $("#dialogPegawaiTindakan").dialog("close");
        }

        // ----------------- Tindakan ---------------------------

        function setDialogTindakan(obj) {
            rowTindakanIdx = $(obj).parents('tr').data('row');

            $("#dialogTindakan").dialog("open");
        }

        function addTindakan(data) {
            var row = $("#tab_tindakan tbody tr").eq(rowTindakanIdx);

            row.find(".daftartindakan_id").val(data.daftartindakan_id);
            row.find(".tindakan_nama").val(data.daftartindakan_nama);

            $("#dialogTindakan").dialog("close");
        }

        $(document).ready(function() {
            $("#tab_tindakan tbody tr").each(function() {
                setAutoCompleteInputTindakan(jQuery(this).find(".tindakan_nama"));
                setAutoCompleteInputTindakanPegawai(jQuery(this).find(".tindakan_oleh_nama"));
            });
        });
    </script>
</div>