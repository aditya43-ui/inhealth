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
        var tandagejala_daftar_id = $(obj).attr('tandagejala_daftar_id');

        if ($(obj).prop("checked") == true) {
            is_checked[tandagejala_daftar_id] = tandagejala_daftar_id;
        } else {
            is_checked[tandagejala_daftar_id] = 0;
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
        var jenistandagejala_id = $('#ASKelompoktandagejaladaftarM_jenistandagejala_id').val();
        if (jenistandagejala_id == '') {
            myAlert('Silakan pilih jenis tanda gejala terlebih dahulu', 'Perhatian!');
        } else {
            $("input:checkbox.pilih").each(function () {
                var tandagejala_daftar_id = $(this);
                tandagejala_daftar_id.prop("checked", false);
                tandagejala_daftar_id.removeAttr("disabled");
                $("#table-gejala > tbody > tr").find(".tandagejala_daftar_id").each(function () {
                    if (tandagejala_daftar_id.attr('tandagejala_daftar_id') == $(this).val()) {
                        tandagejala_daftar_id.prop("checked", true);
                        tandagejala_daftar_id.attr("disabled", true);
                    }
                });
            });

            $("#dialogTandaGejala").dialog("open");
        }
    }

    function tambahGejala(tandagejala_daftar_id) {
        var jenistandagejala_id = $('#ASKelompoktandagejaladaftarM_jenistandagejala_id').val();
        var ada = $('#ASKelompoktandagejaladaftarM_jenistandagejaladaftar_aktif');
        if (ada.is(" :checked")) {
            var status = 1;
        } else {
            var status = 0;
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getGejala'); ?>',
            data: {jenistandagejala_id: jenistandagejala_id, status: status, tandagejala_daftar_id: tandagejala_daftar_id},
            dataType: "json",
            success: function (data) {
                $('#table-gejala > tbody').append(data);
                $('#table-gejala').removeClass("animation-loading");
                renameInputRowBarang($("#table-gejala"));
                is_checked = {};
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function inputGejala() {
        var tandagejala_daftar_id = is_checked;

        if (isEmpty(tandagejala_daftar_id)) {
            myAlert('Gejala yang akan dikirimkan belum dipilih');
            return false;
        } else {
            $('#table-gejala').addClass("animation-loading");
            cekList(tandagejala_daftar_id);

        }
    }

    function cekList(id) {
        x = true;
        if (x == true) {
            tambahGejala(is_checked);
            $("#dialogTandaGejala").dialog("close");
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

    function loadData(jenistandagejala_id) {
        $("#table-gejala").addClass("animation-loading");
        $('#table-gejala > tbody').html("");
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetData'); ?>',
            data: {jenistandagejala_id: jenistandagejala_id}, //
            dataType: "json",
            success: function (data) {
                $('#table-gejala > tbody').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                renameInputRow($("#table-gejala"));
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-gejala").removeClass("animation-loading");
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

        $("#table-gejala tbody tr").each(function () {
            var tandagejala_id = $(this).find("input[name$='[tandagejala_id]']").val();
            if (tandagejala_id !== "") {
                $(this).find("td.rowbutton .icon-minus-sign").parent().hide();
            }
        });
    }

    function hapusLookup(obj) {
        var kelompoktandagejaladaftar_id = $(obj).parents("tr").find("input[name$='[kelompoktandagejaladaftar_id]']").val();
        if (kelompoktandagejaladaftar_id !== "") {
            myConfirm("Apakah Anda yakin akan menghapus data ini dari database?", "Perhatian!",
                    function (r) {
                        if (r) {
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo $this->createUrl('Delete'); ?>&id=' + kelompoktandagejaladaftar_id,
                                data: {id: kelompoktandagejaladaftar_id}, //
                                dataType: "json",
                                success: function (data) {
                                    if (data.sukses == 1) {
                                        $(obj).parents('tr').detach();
                                        renameInputRow($("#table-gejala"));
                                    }
                                    myAlert(data.pesan);
                                    var rowCount = $("#table-gejala").find('tbody tr').length;
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
            renameInputRow($("#table-gejala"));
        }
    }

    function tambahLookup() {
        row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowGejala', array('model' => $modDet), true)); ?>'
        $('#table-gejala').append(row);
        renameInputRow($("#table-gejala"));
        $("#table-gejala tr:last .integer").maskMoney(
                {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
        );
    }

    function cek(obj) {
        if ($(obj).is(':checked')) {
            $(obj).parents("tr").find("input[name$='[jenistandagejaladaftar_aktif]']").val(1);
        } else {
            $(obj).parents("tr").find("input[name$='[jenistandagejaladaftar_aktif]']").val(0);
        }
    }

    function refreshTable() {
        var jenistandagejala_id = $('#ASKelompoktandagejaladaftarM_jenistandagejala_id').val();

        if (jenistandagejala_id !== '') {
            $('#table-gejala').addClass('animation-loading');

            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('getData'); ?>',
                data: {jenistandagejala_id: jenistandagejala_id},
                dataType: "json",
                success: function (data) {
                    $("#table-gejala > tbody").find('tr').detach();
                    $("#table-gejala > tbody").append(data.form);
                    $('#table-gejala').removeClass('animation-loading');
                    renameInputRow($("#table-gejala"));
                    getExtAutoComplete();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    $(document).ready(function () {
<?php if (!empty($model->kelompoktandagejaladaftar_id)) { ?>
            loadData('<?php echo $model->jenistandagejala_id; ?>');
<?php } ?>

<?php if (!empty($model->diagnosakep_id)) { ?>
            refreshTable();
<?php } ?>
    })

</script>