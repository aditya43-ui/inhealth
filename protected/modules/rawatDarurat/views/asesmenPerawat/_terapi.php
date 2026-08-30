<?php

/**
 * @author Deni Hamdani <denihamdani@piindoensia.co.id>
 * @website <piindonesia.co.id>
 * 
 * untuk menampilkan riwayat terapi untuk panel pemberian obat (via riwayat pasien).
 * 
 */

$row = $this->renderPartial($this->path_view.'_rowTerapi', array('idx' => 'i', 'terapi' => new AsesmenigdterapiT), true);
$row = str_replace("\n", '', $row);
$row = str_replace("\r", '', $row);
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class='fas fa-tablets'></i> Pemberian Obat / Infus
        </div>
    </div>
    <div class="panel-body table-responsive">

        <table class="table table-bordered table-condensed table-striped" width="100%" id="tab_terapi">
            <thead>
                <tr>
                    <th>Pukul</th>
                    <th>Nama Obat / Infus</th>
                    <th>Dosis</th>
                    <th>Rute</th>
                    <th>Diperiksa Oleh</th>
                    <th>Diberikan Oleh</th>
                    <th style="width:50px; text-align: center;"><?php echo CHtml::link('<i class="icon-plus"></i>', '#', array(
                                                                    'onclick' => 'tambahTerapi(); return false;',
                                                                    'data-toggle' => 'tooltip',
                                                                    'title' => 'Tambah Terapi',
                                                                )); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $idx = 0;
                foreach ($terapi as $item) {
                    echo $this->renderPartial($this->path_view.'_rowTerapi', array('idx' => $idx++, 'terapi' => $item), true);
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        var rowTerapi = '<?php echo $row; ?>';
        var rowTerapiIdx = 0;

        function tambahTerapi() {

            if (periksaInputTerakhirTerapi()) {
                myAlert('Lengkapi isian yang kosong pada baris terapi sebelum Anda menambahkan data baru.');
                return false;
            }

            $("#tab_terapi tbody").append(rowTerapi);

            renameInputTerapi();
            setAutoCompleteTerapi();
            setDatePickerTerapi();
        }

        function periksaInputTerakhirTerapi() {

            var barisKosong = false;

            var field = ['obatalkes_nama',
                'terapi_diperiksa', 'terapi_diperiksa_nama',
                'terapi_diberikan', 'terapi_diberikan_nama'
            ];

            $("#tab_terapi tbody tr").each(function() {

                var row = $(this);
                var fieldKosong = false;
                $.each(field, function(idx, v) {
                    if ($(row).find("." + v).val().trim() == "") fieldKosong = true;
                });

                if (fieldKosong) barisKosong = true;
            });

            return barisKosong;
        }

        function renameInputTerapi() {
            var i = 0;
            var field = ['asesmenigdterapi_tgl', 'obatalkes_id', 'obatalkes_nama',
                'terapi_dosis', 'terapi_rute', 'terapi_diperiksa', 'terapi_diperiksa_nama',
                'terapi_diberikan', 'terapi_diberikan_nama'
            ];

            $("#tab_terapi tbody tr").each(function() {
                var row = $(this);
                row.data("row", i);
                $.each(field, function(idx, v) {
                    row.find("." + v).prop('name', 'terapi[' + i + '][' + v + ']');
                });
                i++;
            });
        }


        function setDatePickerTerapi() {
            var last = $("#tab_terapi tbody tr:last-child");

            jQuery(last).find(".asesmenigdterapi_tgl").datetimepicker(
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
                    $(this).parents('.input-append').find('.asesmenigdterapi_tgl').focus();
                });

        }

        function setAutoCompleteInputTerapiPemberi(obj) {
            $(obj).autocomplete({
                'showAnim': 'fold',
                'minLength': 2,
                'focus': function(event, ui) {
                    $(this).val(ui.item.label);
                    return false;
                },
                'select': function(event, ui) {
                    $(this).val(ui.item.label);
                    $(this).parents("tr").find(".terapi_diberikan").val(ui.item.value);
                    return false;
                },
                'source': function(request, response) {
                    $.ajax({
                        url: "<?php echo $this->createUrl('autocompleteTerapiPemberi'); ?>",
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

        function setAutoCompleteInputTerapiPeriksa(obj) {
            $(obj).autocomplete({
                'showAnim': 'fold',
                'minLength': 2,
                'focus': function(event, ui) {
                    $(this).val(ui.item.label);
                    return false;
                },
                'select': function(event, ui) {
                    $(this).val(ui.item.label);
                    $(this).parents("tr").find(".terapi_diperiksa").val(ui.item.value);
                    return false;
                },
                'source': function(request, response) {
                    $.ajax({
                        url: "<?php echo $this->createUrl('autocompleteTerapiPeriksa'); ?>",
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

        function setAutoCompleteInputTerapi(obj) {
            $(obj).autocomplete({
                'showAnim': 'fold',
                'minLength': 2,
                'focus': function(event, ui) {
                    $(this).val(ui.item.label);
                    return false;
                },
                'select': function(event, ui) {
                    $(this).val(ui.item.label);
                    $(this).parents("tr").find(".obatalkes_id").val(ui.item.value);
                    return false;
                },
                'source': function(request, response) {
                    $.ajax({
                        url: "<?php echo $this->createUrl('autocompleteTerapi'); ?>",
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

        function setAutoCompleteTerapi() {
            var last = $("#tab_terapi tbody tr:last-child");

            setAutoCompleteInputTerapi(jQuery(last).find(".obatalkes_nama"));
            setAutoCompleteInputTerapiPeriksa(jQuery(last).find(".terapi_diperiksa_nama"));
            setAutoCompleteInputTerapiPemberi(jQuery(last).find(".terapi_diberikan_nama"));
        }

        // ------------ Obat Alkes ----------------------

        function setDialogTerapi(obj) {
            rowTerapiIdx = $(obj).parents('tr').data('row');

            $("#dialogTerapi").dialog("open");
        }

        function addObatTerapi(data) {
            var row = $("#tab_terapi tbody tr").eq(rowTerapiIdx);

            row.find(".obatalkes_id").val(data.obatalkes_id);
            row.find(".obatalkes_nama").val(data.obatalkes_nama);

            $("#dialogTerapi").dialog("close");
        }


        // ------------- Pemeriksa ( Dokter ) ----------------------

        function setDialogPeriksaTerapi(obj) {
            rowTerapiIdx = $(obj).parents('tr').data('row');

            $("#dialogDokterTerapi").dialog("open");
        }

        function addDokterTerapi(data) {
            var row = $("#tab_terapi tbody tr").eq(rowTerapiIdx);

            row.find(".terapi_diperiksa").val(data.pegawai_id);
            row.find(".terapi_diperiksa_nama").val(data.nama_pegawai);

            $("#dialogDokterTerapi").dialog("close");
        }

        // ------------- Pemberi ( Perawat ) -------------------------

        function setDialogPemberiTerapi(obj) {
            rowTerapiIdx = $(obj).parents('tr').data('row');

            $("#dialogPemberiTerapi").dialog("open");
        }

        function addPemberiTerapi(data) {
            var row = $("#tab_terapi tbody tr").eq(rowTerapiIdx);

            row.find(".terapi_diberikan").val(data.pegawai_id);
            row.find(".terapi_diberikan_nama").val(data.nama_pegawai);

            $("#dialogPemberiTerapi").dialog("close");
        }

        $(document).ready(function() {
            $("#tab_terapi tbody tr").each(function() {
                setAutoCompleteInputTerapi(jQuery(this).find(".obatalkes_nama"));
                setAutoCompleteInputTerapiPeriksa(jQuery(this).find(".terapi_diperiksa_nama"));
                setAutoCompleteInputTerapiPemberi(jQuery(this).find(".terapi_diberikan_nama"));
            });
        });
    </script>
</div>