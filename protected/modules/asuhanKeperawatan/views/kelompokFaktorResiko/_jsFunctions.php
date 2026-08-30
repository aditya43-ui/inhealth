<script type="text/javascript">
    var is_checked = {};

    function isEmpty(obj) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }

    function setGejala(obj) {
        var faktorrisiko_daftar_id = $(obj).attr('faktorrisiko_daftar_id');

        if ($(obj).prop("checked") == true) {
            is_checked[faktorrisiko_daftar_id] = faktorrisiko_daftar_id;
        } else {
            is_checked[faktorrisiko_daftar_id] = 0;
        }
    }

    function setSemuaGejala(obj) {
        if ($(obj).prop("checked") == true) {
            $("input:checkbox.pilih").each(function () {
                $(this).prop("checked", true).change();
            });
        } else {
            $("input:checkbox.pilih").each(function () {
                $(this).prop("checked", false).change();
            });
        }

    }

    function setCeklisGejala() {
        var jenisfaktorrisiko_id = $('#ASKelompokFaktorResikoM_jenisfaktorrisiko_id').val();
        if (jenisfaktorrisiko_id == '') {
            myAlert('Silakan pilih jenis faktor risiko terlebih dahulu', 'Perhatian!');
        } else {
            $("input:checkbox.pilih").each(function () {
                var faktorrisiko_daftar_id = $(this);
                faktorrisiko_daftar_id.prop("checked", false);
                faktorrisiko_daftar_id.removeAttr("disabled");
                $("#table-risiko > tbody > tr").find(".faktorrisiko_daftar_id").each(function () {
                    if (faktorrisiko_daftar_id.attr('faktorrisiko_daftar_id') == $(this).val()) {
                        faktorrisiko_daftar_id.prop("checked", true);
                        faktorrisiko_daftar_id.attr("disabled", true);
                    }
                });
            });

            $("#dialogDaftarFaktorRisiko").dialog("open");
        }
    }

    function tambahGejala(faktorrisiko_daftar_id) {
        var jenisfaktorrisiko_id = $('#ASKelompokFaktorResikoM_jenisfaktorrisiko_id').val();
        var ada = $('#ASKelompokFaktorResikoM_kelompokfaktorrisikodaftar_aktif');
        if (ada.is(" :checked")) {
            var status = 1;
        } else {
            var status = 0;
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getGejala'); ?>',
            data: {jenisfaktorrisiko_id: jenisfaktorrisiko_id, status: status, faktorrisiko_daftar_id: faktorrisiko_daftar_id},
            dataType: "json",
            success: function (data) {
                $('#table-risiko > tbody').append(data);
                $('#table-risiko').removeClass("animation-loading");
                renameInputRowBarang($("#table-risiko"));
                is_checked = {};
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function inputGejala() {
        var faktorrisiko_daftar_id = is_checked;
        if (isEmpty(faktorrisiko_daftar_id)) {
            myAlert('Faktor Risiko yang akan dikirimkan belum dipilih');
            return false;
        } else {
            $('#table-risiko').addClass("animation-loading");
            cekList(faktorrisiko_daftar_id);
        }
    }

    function cekList(id) {
        x = true;
        if (x == true) {
            tambahGejala(is_checked);
            $("#dialogDaftarFaktorRisiko").dialog("close");
            return x;
        }
        return false;
    }

    function renameInputRowBarang(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function () { //element <input>
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

    function loadData(jenisfaktorrisiko_id) {
        $("#table-risiko").addClass("animation-loading");
        $('#table-risiko > tbody').html("");
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetData'); ?>',
            data: {jenisfaktorrisiko_id: jenisfaktorrisiko_id}, //
            dataType: "json",
            success: function (data) {
                $('#table-risiko > tbody').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                renameInputRow($("#table-risiko"));
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-risiko").removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }

    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).attr('no-row', row);
            $(this).find('span').each(function () { //element <input>
                if (typeof $(this).attr("name") !== 'undefined') {
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                    }
                }
            });
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });

        //====button visibility
        //init
        $(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().show();
        $(obj_table).find('tr td.rowbutton .icon-minus-sign').parent().show();
        //set
        $(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().hide();
        $(obj_table).find('tr:last-child td.rowbutton .icon-plus-sign').parent().show();
        var rowCount = $(obj_table).find('tbody tr').length;
        if (rowCount == 1) {
            $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
            $(obj_table).find('tr:first-child td.rowbutton .icon-plus-sign').parent().show();
            id = $(obj_table).find('tr:first-child input[name*="[lookup_id]"]').val();
            if (id != "") {
                $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
            }
        }
        //====end button visibility

        $("#table-risiko tbody tr").each(function () {
            var tandagejala_id = $(this).find("input[name$='[tandagejala_id]']").val();
            if (tandagejala_id !== "") {
                $(this).find("td.rowbutton .icon-minus-sign").parent().hide();
            }
        });
    }

    function hapusLookup(obj) {
        var kelompokfaktorrisikodaftar_id = $(obj).parents("tr").find("input[name$='[kelompokfaktorrisikodaftar_id]']").val();
        if (kelompokfaktorrisikodaftar_id !== "") {
            myConfirm("Apakah Anda yakin akan menghapus data ini dari database?", "Perhatian!",
                    function (r) {
                        if (r) {
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo $this->createUrl('Delete'); ?>&id=' + kelompokfaktorrisikodaftar_id,
                                data: {id: kelompokfaktorrisikodaftar_id}, //
                                dataType: "json",
                                success: function (data) {
                                    if (data.sukses == 1) {
                                        $(obj).parents('tr').detach();
                                        renameInputRow($("#table-risiko"));
                                    }
                                    myAlert(data.pesan);
                                    var rowCount = $("#table-risiko").find('tbody tr').length;
                                    if (rowCount == 0) {
                                        tambahLookup();
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(errorThrown);
                                }
                            });
                        }
                    });
        } else {
            $(obj).parents('tr').detach();
            renameInputRow($("#table-risiko"));
        }
    }

    function tambahLookup() {
        row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowFaktorRisiko', array('model' => $modDet), true)); ?>'
        $('#table-risiko').append(row);
        renameInputRow($("#table-risiko"));
        $("#table-risiko tr:last .integer").maskMoney(
                {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
        );
    }

    function cek(obj) {
        if ($(obj).is(':checked')) {
            $(obj).parents("tr").find("input[name$='[kelompokfaktorrisikodaftar_aktif]']").val(1);
        } else {
            $(obj).parents("tr").find("input[name$='[kelompokfaktorrisikodaftar_aktif]']").val(0);
        }
    }

    function refreshTable() {
        var jenisfaktorrisiko_id = $('#ASKelompokFaktorResikoM_jenisfaktorrisiko_id').val();
console.log(jenisfaktorrisiko_id);
        if (jenisfaktorrisiko_id !== '') {
            $('#table-risiko').addClass('animation-loading');

            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('getData'); ?>',
                data: {jenisfaktorrisiko_id: jenisfaktorrisiko_id},
                dataType: "json",
                success: function (data) {
                    $("#table-risiko > tbody").find('tr').detach();
                    $("#table-risiko > tbody").append(data.form);
                    $('#table-risiko').removeClass('animation-loading');
                    renameInputRow($("#table-risiko"));
                    getExtAutoComplete();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    $(document).ready(function () {
<?php if (!empty($model->kelompokfaktorrisikodaftar_id)) { ?>
            loadData('<?php echo $model->jenisfaktorrisiko_id; ?>');
<?php } ?>

<?php if (!empty($model->diagnosakep_id)) { ?>
            refreshTable();
<?php } ?>
    })

</script>