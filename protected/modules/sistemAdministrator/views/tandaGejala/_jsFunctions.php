<script type="text/javascript">
    var is_checked = {};

    function isEmpty(obj) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }

    function setKelompok(obj) {
        var kelompoktandagejaladaftar_id = $(obj).attr('kelompoktandagejaladaftar_id');

        if ($(obj).prop("checked") == true) {
            is_checked[kelompoktandagejaladaftar_id] = kelompoktandagejaladaftar_id;
        } else {
            is_checked[kelompoktandagejaladaftar_id] = 0;
        }
    }

    function setSemuaKelompok(obj) {
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

    function setCeklisKelompok() {
        var diagnosakep_id = $('#SATandagejalaM_diagnosakep_id').val();
        if(diagnosakep_id == ''){
            myAlert('Silakan pilih diagnosa terlebih dahulu', 'Perhatian!');
        }else{
            $("input:checkbox.pilih").each(function () {
                var kelompoktandagejaladaftar_id = $(this);
                kelompoktandagejaladaftar_id.prop("checked", false);
                kelompoktandagejaladaftar_id.removeAttr("disabled");
                $("#table-kelompok > tbody > tr").find(".kelompoktandagejaladaftar_id").each(function () {
                    if (kelompoktandagejaladaftar_id.attr('kelompoktandagejaladaftar_id') == $(this).val()) {
                        kelompoktandagejaladaftar_id.prop("checked", true);
                        kelompoktandagejaladaftar_id.attr("disabled", true);
                    }
                });
            });
            
            $("#dialogKelompokTandaGejala").dialog("open");
        }
    }

    function cekSudahAda(kelompoktandagejaladaftar_id, obj) {
        var x = true;
        console.log(kelompoktandagejaladaftar_id);
        $('.kelompoktandagejaladaftar_id').each(function () {
            if ($(this).val() == kelompoktandagejaladaftar_id) {
                x = false;
                $('#table-kelompok').removeClass("animation-loading");
            } else {

            }
        });

        if (x == false) {
            toastr.error('Tanda Gejala telah ada di list. Silakan pilih yang lain.', "Perhatian!");
            $(obj).val('');
        } else {
            tambahKelompok(kelompoktandagejaladaftar_id);
            $(obj).val('');
        }
    }

    function tambahKelompok(kelompoktandagejaladaftar_id) {
        var diagnosakep_id = $('#SATandagejalaM_diagnosakep_id').val();
        var ada = $('#SATandagejalaM_tandagejala_aktif');
        if (ada.is(" :checked")) {
            var status = 1;
        } else {
            var status = 0;
        }
        
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getKelompok'); ?>',
            data: {diagnosakep_id:diagnosakep_id, status:status, kelompoktandagejaladaftar_id: kelompoktandagejaladaftar_id},
            dataType: "json",
            success: function (data) {
                $('#table-kelompok > tbody').append(data);
                $('#table-kelompok').removeClass("animation-loading");
                renameInputRowBarang($("#table-kelompok"));
                is_checked = {};
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function inputKelompok() {
        var kelompoktandagejaladaftar_id = is_checked;

        if (isEmpty(kelompoktandagejaladaftar_id)) {
            myAlert('Kelompok yang akan dikirimkan belum dipilih');
            return false;
        } else {
            $('#table-kelompok').addClass("animation-loading");
            cekList(kelompoktandagejaladaftar_id);

        }
    }

    function cekList(id) {
        x = true;
        if (x == true) {
            tambahKelompok(is_checked);
            $("#dialogKelompokTandaGejala").dialog("close");
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
    
    function setKelompokTandaGejala(){
        var jenis = $("#SATandagejalaM_jenistandagejala").val();
        
        $.fn.yiiGridView.update('kelompoktandagejaladaftar-m-grid', {
            data: {
                "KelompoktandagejaladaftarM[jenistandagejala_id]": jenis,
            }
        });
    }
    
    function setRow(obj) {
        var no = $(obj).parents("tr").attr('no-row');
        $("#norow").val(no);
    }

    function setDaftar(data, obj) {
        if (typeof $(obj).parents("tr").attr('no-row') === 'undefined') {
            var no = $("#norow").val();
        } else {
            var no = $(obj).parents("tr").attr('no-row');
        }

        $("#table-kelompok").find('tbody > tr[no-row="' + no + '"]').find('.tandagejala_indikator').val(data.tandagejala_daftar_nama);
        $("#table-kelompok").find('tbody > tr[no-row="' + no + '"]').find('.tandagejala_daftar_id').val(data.tandagejala_daftar_id);

        $("#dialogDaftarTanda").dialog("close");
    }

    function clearDaftarHasil(obj) {
        $(obj).parents("tr").find('.tandagejala_daftar_id').val('');
    }

    function getExtAutoComplete() {

        $("#table-kelompok").find('.tandagejala_indikator').autocomplete(
                {
                    'showAnim': 'fold',
                    'minLength': 3,
                    'focus': function (event, ui)
                    {
                        $(this).val(ui.item.label);
                        return false;
                    },
                    'select': function (event, ui)
                    {
                        setDaftar(ui.item, this);
                        return false;
                    },
                    'source': function (request, response)
                    {
                        $.ajax({
                            url: "<?php echo $this->createUrl('/ActionAutoComplete/GetDaftarTandaGejala'); ?>",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    }
                }
        );


    }

    function setLookup(tandagejala_id) {
        $("#table-kelompok").addClass("animation-loading");
        $('#table-kelompok > tbody').html("");
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetLookup'); ?>',
            data: {tandagejala_id: tandagejala_id}, //
            dataType: "json",
            success: function (data) {
                $('#table-kelompok > tbody').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                renameInputRow($("#table-kelompok"));
                getExtAutoComplete();
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-kelompok").removeClass("animation-loading");
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

        $("#table-kelompok tbody tr").each(function () {
            var tandagejala_id = $(this).find("input[name$='[tandagejala_id]']").val();
            if (tandagejala_id !== "") {
                $(this).find("td.rowbutton .icon-minus-sign").parent().hide();
            }
        });
    }

    function hapusLookup(obj) {
        var tandagejala_id = $(obj).parents("tr").find("input[name$='[tandagejala_id]']").val();
        if (tandagejala_id !== "") {
            myConfirm("Apakah anda yakin akan menghapus data ini dari database?", "Perhatian!",
                    function (r) {
                        if (r) {
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo $this->createUrl('Delete'); ?>&id=' + tandagejala_id,
                                data: {id: tandagejala_id}, //
                                dataType: "json",
                                success: function (data) {
                                    if (data.sukses == 1) {
                                        $(obj).parents('tr').detach();
                                        renameInputRow($("#table-kelompok"));
                                        getExtAutoComplete();
                                    }
                                    myAlert(data.pesan);
                                    var rowCount = $("#table-kelompok").find('tbody tr').length;
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
            renameInputRow($("#table-kelompok"));
        }
    }

    function tambahLookup() {
        row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowKelompok', array('model' => $modDet), true)); ?>'
        $('#table-kelompok').append(row);
        renameInputRow($("#table-kelompok"));
        getExtAutoComplete();
        $("#table-kelompok tr:last .integer").maskMoney(
                {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
        );
    }

    function cek(obj) {
        if ($(obj).is(':checked')) {
            $(obj).parents("tr").find("input[name$='[tandagejala_aktif]']").val(1);
        } else {
            $(obj).parents("tr").find("input[name$='[tandagejala_aktif]']").val(0);
        }
    }

    function refreshTable() {
        var tandagejala_id = '<?php echo !empty($_GET['tandagejala_id']) ? $_GET['tandagejala_id'] : null; ?>';
        var diagnosakep_id = $('#SATandagejalaM_diagnosakep_id').val();
        var jenistandagejala = $('#SATandagejalaM_jenistandagejala').val();

        if (diagnosakep_id !== '' && jenistandagejala !== '') {
            $('#table-kelompok').addClass('animation-loading');

            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('getLookup'); ?>',
                data: {diagnosakep_id: diagnosakep_id, jenistandagejala: jenistandagejala},
                dataType: "json",
                success: function (data) {
                    $("#table-kelompok > tbody").find('tr').detach();
                    $("#table-kelompok > tbody").append(data.form);
                    $('#table-kelompok').removeClass('animation-loading');
                    renameInputRow($("#table-kelompok"));
                    getExtAutoComplete();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }


    $(document).ready(function () {
<?php if (!empty($model->tandagejala_id)) { ?>
        refreshTable();
        var jenis = $("#SATandagejalaM_jenistandagejala").val();
        setTimeout(function(){
            $.fn.yiiGridView.update('kelompoktandagejaladaftar-m-grid', {
                data: {
                    "KelompoktandagejaladaftarM[jenistandagejala_id]": jenis,
                }
            });
        },500);
<?php } ?>
    })


</script>