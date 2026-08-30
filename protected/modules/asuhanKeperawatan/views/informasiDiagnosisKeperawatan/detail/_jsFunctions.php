<script type="text/javascript">
//  Tanda Gejala
    var is_checked = {};

    function isEmpty(obj) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }

    function setTandaGejalanya(obj) {
        var tandagejala = $(obj).attr('tandagejaladet_id');
        
        if ($(obj).prop("checked") == true) {
            is_checked[tandagejala] = tandagejala;
        } else {
            is_checked[tandagejala] = 0;
        }
    }

    function setSemuaTandagejala(obj) {
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

    function inputTandaGejala() {
        var tandadangejala = is_checked;
        if (isEmpty(tandadangejala)) {
            myAlert('Tanda dan Gejala belum dipilih');
            return false;
        } else {
//            $('#table-tandagejala').addClass("animation-loading");
            cekListGejala(tandadangejala);
        }
    }

    function setCeklisGejala() {
        $("input:checkbox.pilih").each(function () {
            var nomor = $(this);
            nomor.prop("checked", false);
            nomor.removeAttr("disabled");
            $("#table-tandagejala > tbody > tr").find(".tandagejala").each(function () {
                if (nomor.attr('tandagejaladet_id') == $(this).val()) {
                    nomor.prop("checked", true);
                    nomor.attr("disabled", true);
                }
            });
        });
    }

    function cekListGejala(id) {
        x = true;

        if (x == true) {
            tambahGejala(is_checked);
            $("#dialogTandaGejala").dialog("close");
            return x;
        }
        return false;
    }

    function tambahGejala(tandagejaladet_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getTandaGejalanya'); ?>',
            data: {tandagejaladet_id: tandagejaladet_id},
            dataType: "json",
            success: function (data) {
                parent = $(dialog).attr("parent-dialog");
                obj = $("#" + parent);
                
                $(obj).parents('tr').find('.tandagejaladetail').each(function () {
                    $(this).find('#table-tandagejala > tbody > tr').remove(); 
                    $(this).find('#table-tandagejala > tbody').append(data.tabel);
                    $(this).find('#table-tandagejala').removeClass("animation-loading");
                });
                $(obj).parents('tr').find('.diagnosisaskep_id').val(data.diagnosa_id);
                $(obj).parents('tr').find('.diagnosakep_nama').val(data.diagnosa_nama);
                $(obj).parents('tr').find('.faktorrisiko_indikator').attr('readonly','readonly');
                $(obj).parents('tr').find('.faktorrisikonya').hide();
                setDiagnosaRow(obj, data.diagnosa_id);
                renameInputRows();
//                is_checked = {};
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

//  Faktor Risiko
    var is_checked2 = {};

    function setFaktorRisikonya(obj) {
        var faktorrisiko = $(obj).attr('faktorrisikodet_id');
        
        if ($(obj).prop("checked") == true) {
            is_checked2[faktorrisiko] = faktorrisiko;
        } else {
            is_checked2[faktorrisiko] = 0;
        }
    }

    function setSemuaFaktorrisiko(obj) {
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

    function inputFaktorRisiko() {
        var faktordanrisiko = is_checked2;
        if (isEmpty(faktordanrisiko)) {
            myAlert('Faktor Risiko belum dipilih');
            return false;
        } else {
//            $('#table-faktorrisiko').addClass("animation-loading");
            cekListRisiko(faktordanrisiko);
        }
    }

    function setCeklisRisiko() {
        $("input:checkbox.pilih").each(function () {
            var nomor = $(this);
            nomor.prop("checked", false);
            nomor.removeAttr("disabled");
            $("#table-faktorrisiko > tbody > tr").find(".faktorrisiko").each(function () {
                if (nomor.attr('faktorrisikodet_id') == $(this).val()) {
                    nomor.prop("checked", true);
                    nomor.attr("disabled", true);
                }
            });
        });
    }

    function cekListRisiko(id) {
        x = true;

        if (x == true) {
            tambahRisiko(is_checked2);
            $("#dialogFaktorRisiko").dialog("close");
            return x;
        }
        return false;
    }

    function tambahRisiko(faktorrisikodet_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getFaktorRisikonya'); ?>',
            data: {faktorrisikodet_id: faktorrisikodet_id},
            dataType: "json",
            success: function (data) {
                parent = $(dialog).attr("parent-dialog");
                obj = $("#" + parent);
                
                $(obj).parents('tr').find('.risikodetail').each(function () {
                    $(this).find('#table-faktorrisiko > tbody > tr').remove(); 
                    $(this).find('#table-faktorrisiko > tbody').append(data.tabel);
                    $(this).find('#table-faktorrisiko').removeClass("animation-loading");
                });
                $(obj).parents('tr').find('.diagnosisaskep_id').val(data.diagnosa_id);
                $(obj).parents('tr').find('.diagnosakep_nama').val(data.diagnosa_nama);
                $(obj).parents('tr').find('.tandagejala_indikator').attr('readonly','readonly');
                $(obj).parents('tr').find('.tandagejalanya').hide();
                setDiagnosaRow(obj, data.diagnosa_id);
                renameInputRows();
//                is_checked2 = {};
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

//  Diagnosa Keperawatan
    


    function cekPengkajianId(pengkajianaskep_id) {
        if (pengkajianaskep_id !== undefined) {
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('cekPengkajianId'); ?>',
                data: {pengkajianaskep_id: pengkajianaskep_id},
                dataType: "json",
                success: function (data) {

                    if (data != null) {
                        myAlert("Pengkajian sudah dipilih!");
                        return false;
                    } else {

                        loadPasien(pengkajianaskep_id);
                        return true;
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function cekPengkajian(obj) {
        var pengkajianaskep_id = $("#<?php echo CHtml::activeId($modPengkajian, 'pengkajianaskep_id') ?>").val();
        var iskeperawatan = $("#iskeperawatan").val();
        if (pengkajianaskep_id == '') {
            myAlert("Silakan Pilih Pengkajian!");
        } else {
            if (iskeperawatan == 1) {
                window.open("<?php echo Yii::app()->controller->createUrl("/asuhanKeperawatan/DiagnosisKeperawatan/DetailPengkajianKeb"); ?>/&pengkajianaskep_id=" + pengkajianaskep_id, "", 'location=_new, width=900px, scrollbars=1');
            }
            if (iskeperawatan == 0) {
                window.open("<?php echo Yii::app()->controller->createUrl("/asuhanKeperawatan/DiagnosisKeperawatan/DetailPengkajian"); ?>/&pengkajianaskep_id=" + pengkajianaskep_id, "", 'location=_new, width=900px, scrollbars=1');
            }
        }
        return false;
    }

    function loadPasien(pengkajianaskep_id)
    {
        var iskeperawatan = $('#iskeperawatan').val();
        if (pengkajianaskep_id !== undefined) {
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('loadPasien'); ?>',
                data: {pengkajianaskep_id: pengkajianaskep_id, iskeperawatan: iskeperawatan},
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if (data !== '') {
                        console.log("fsfsfs:" + data);
                        $("#<?php echo CHtml::activeId($modPengkajian, 'pengkajianaskep_id') ?>").val(data.data.pengkajianaskep_id);
                        if (data.iskeperawatan == 1) {
                            $("#<?php echo CHtml::activeId($modPengkajian, 'no_pengkajian') ?>").val(data.data.no_pengkajian);
                        } else {
                            $("#<?php echo CHtml::activeId($modPengkajian, 'no_pengkajian_keb') ?>").val(data.data.no_pengkajian);
                        }
                        $("#<?php echo CHtml::activeId($modPengkajian, 'pengkajianaskep_tgl') ?>").val(data.data.pengkajianaskep_tgl);
                        $("#<?php echo CHtml::activeId($modPengkajian, 'pegawai_id') ?>").val(data.data.pegawai_id);
                        $("#<?php echo CHtml::activeId($modPengkajian, 'nama_pegawai') ?>").val(data.data.nama_pegawai);

                        $('#<?php echo CHtml::activeId($modPasien, 'no_pendaftaran') ?>').val(data.data.no_pendaftaran);
                        $('#<?php echo CHtml::activeId($modPasien, 'nama_pasien') ?>').val(data.data.nama_pasien);
                        $('#<?php echo CHtml::activeId($modPasien, 'ruangan_nama') ?>').val(data.data.ruangan_nama);
                        $('#<?php echo CHtml::activeId($modPasien, 'tgl_pendaftaran') ?>').val(data.data.tgl_pendaftaran);
                        $('#<?php echo CHtml::activeId($modPasien, 'umur') ?>').val(data.data.umur);
                        $('#<?php echo CHtml::activeId($modPasien, 'kelaspelayanan_nama') ?>').val(data.data.kelaspelayanan_nama);
                        $('#<?php echo CHtml::activeId($modPasien, 'no_rekam_medik') ?>').val(data.data.no_rekam_medik);
                        $('#<?php echo CHtml::activeId($modPasien, 'diagnosa_nama') ?>').val(data.diagnosa);
                        $('#<?php echo CHtml::activeId($modPasien, 'no_kamarbed') ?>').val(((data.data.kamarruangan_nokamar !== null) ? data.data.kamarruangan_nokamar : '-') + ' / ' + ((data.data.kamarruangan_nobed !== null) ? data.data.kamarruangan_nobed : '-'));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }
   

    function deleteTindakan(obj, idTindakanpelayanan)
    {
        myConfirm("Apakah Anda yakin akan menghapus tindakan?", "Perhatian!", function (r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxDeleteTindakanPelayanan') ?>', {idTindakanpelayanan: idTindakanpelayanan}, function (data) {
                    if (data.success)
                    {
                        $(obj).parent().parent().detach();
                        myAlert('Data berhasil dihapus.');
                    } else {
                        myAlert('Data Gagal dihapus');
                    }
                }, 'json');
            }
        });
    }

    function renameListTindakan(modelName, attributeName)
    {
        var trLength = $('#table-diagnosis tr').length;
        var i = -1;
        $('#table-diagnosis tr').each(function () {
            if ($(this).has('input[name$="[diagnosisaskep_id]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('textarea[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('textarea[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
        });
    }

    function renameInput(modelName, attributeName)
    {
        var trLength = $('#table-diagnosis tr').length;
        var i = -1;
        $('#table-diagnosis tr').each(function () {
            if ($(this).has('input[name$="[diagnosisaskep_id]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('input[name$="[' + attributeName + '][]"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + '][]"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('textarea[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('textarea[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('input[id="row"]').attr('value', i);
            $(this).find('input[id="row"]').val(i);
//        jQuery('input[name$="[daftartindakanNama]"]').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
        });
    }
    
    function renameInputRows()
    {
        var trLength = $('#table-diagnosis tr').length;
        var i = -1;
        var j = -1;
        $('#table-diagnosis tr').each(function () {
            if ($(this).has('input[name$="[diagnosisaskep_id]"]').length) {
                i++;
                j++;
            }
            
            var row = 0;
            $(this).find("#table-faktorrisiko > tbody > tr").each(function () {
                $(this).find('.faktorrisikodet_idnya').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");

                    if (old_name_arr.length == 3) {
                        $(this).attr("id", old_name_arr[0] + "_" + i + "_" + old_name_arr[2]);
                        $(this).attr("name", old_name_arr[0] + "[" + i + "][" + old_name_arr[2] + "]");
                    }
                    if (old_name_arr.length == 4) {

                        $(this).attr("id", old_name_arr[0] + "_" + i + "_" + old_name_arr[2] + "_" + row);
                        $(this).attr("name", old_name_arr[0] + "[" + i + "][" + old_name_arr[2] + "][" + row + "]");
                    }
                });
                row++;
            });
            
            var row2 = 0;
            $(this).find("#table-tandagejala > tbody > tr").each(function () {
                $(this).find('.tandagejaladet_idnya').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");

                    if (old_name_arr.length == 3) {
                        $(this).attr("id", old_name_arr[0] + "_" + j + "_" + old_name_arr[2]);
                        $(this).attr("name", old_name_arr[0] + "[" + j + "][" + old_name_arr[2] + "]");
                    }
                    if (old_name_arr.length == 4) {

                        $(this).attr("id", old_name_arr[0] + "_" + j + "_" + old_name_arr[2] + "_" + row2);
                        $(this).attr("name", old_name_arr[0] + "[" + j + "][" + old_name_arr[2] + "][" + row2 + "]");
                    }
                });
                row2++;
            });
        });
    }

    function renameInputTandaGejala(obj_table)
    {
        var row = 0;
        $(obj_table).find("tbody > .diagnosisaskepdet").each(function () {

            var row2 = 0;
            $(this).find('input[name$="[tandagejala_id]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input[name$="[tandagejala_id][]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
                if (old_name_arr.length == 4) {

                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
                }
                row2++;
            });
            row++;
        });
    }

    function renameInputDiagDetail(obj_table)
    {
        var row = 0;
        console.log();
        $(obj_table).find("tbody > .diagnosisaskepdet").each(function () {
            var row2 = 0;
            $(this).find('input[name$="[alternatifdx_id]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input[name$="[alternatifdx_id][]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
                if (old_name_arr.length == 4) {

                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
                }
                row2++;
            });
            row++;
        });
    }

    function renameInputTandaGejalaSimpan(obj_table, modPilih)
    {
        var row = 0;
        $(obj_table).find("tbody > .diagnosisaskepdet").each(function () {

            var row2 = 0;
            $(this).find('input[name$="[tandagejala_id]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input[name$="[tandagejala_id][]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
                if (old_name_arr.length == 4) {

                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
                }
                for (i = 0; i < modPilih[row].length; i++) {
                    var tg_id = modPilih[row][i].tandagejala_id;
                    if (tg_id !== 'undefined') {
                        if ($(this).val() == tg_id) {
                            $(this).attr("checked", "checked");
                        }
                    }
                }
                row2++;
            });
            row++;
        });
    }

    function renameInputDiagDetailSimpan(obj_table, modPilih)
    {
        var row = 0;
        $(obj_table).find("tbody > .diagnosisaskepdet").each(function () {

            var row2 = 0;
            $(this).find('input[name$="[alternatifdx_id]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input[name$="[alternatifdx_id][]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
                if (old_name_arr.length == 4) {

                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
                }
                for (i = 0; i < modPilih[row].length; i++) {
                    var tg_id = modPilih[row][i].alternatifdx_id;
                    if (tg_id !== 'undefined') {
                        if ($(this).val() == tg_id) {
                            $(this).attr("checked", "checked");
                        }
                    }
                }
                row2++;
            });
            row++;
        });
    }

    function renameInputIntervensi(obj_table)
    {
        var row = 0;
        $(obj_table).find("tbody > .diagnosisaskepdet").each(function () {
            var row2 = 0;
            $(this).find('input[name$="[intervensidet_id]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input[name$="[intervensidet_id][]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
                if (old_name_arr.length == 4) {

                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
                }
                row2++;
            });
            row++;
        });
    }

    function renameInputIntervensiSimpan(obj_table, modPilih)
    {
        var row = 0;
        $(obj_table).find("tbody > .diagnosisaskepdet").each(function () {
            var row2 = 0;
            $(this).find('input[name$="[intervensidet_id]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input[name$="[intervensidet_id][]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
                if (old_name_arr.length == 4) {

                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
                }

                for (i = 0; i < modPilih[row].length; i++) {
                    var tg_id = modPilih[row][i].intervensidet_id;
                    if (tg_id !== 'undefined') {
                        if ($(this).val() == tg_id) {
                            $(this).attr("checked", "checked");
                        }
                    }
                }

                row2++;
            });
            row++;
        });
    }

    function renameInputRow(obj_table) {

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
            id = $(obj_table).find('tr:first-child input[name*="[datapenunjang_id]"]').val();
//			if (id != "") {
//				$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
//			}
        }
        //====end button visibility

    }

    function renameInputRowKriteriaSimpan(obj_table, modPilih) {
        var row = 0;
        $(obj_table).find("tbody > .diagnosisaskepdet").each(function () {
            var row2 = 0;
            $(this).find('.kriteria').find("tbody > tr").each(function () {
                $(this).find('span').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
                    }
                });
                $(this).find('input[name$="[diagnosisaskep_ir]"]').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                        $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
                    }

                });
                $(this).find('input[name$="[diagnosisaskep_er]"]').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                        $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
                    }

                });
                $(this).find('input[name$="[kriteriahasildet_id]"]').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                        $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
                    }

                    for (i = 0; i < modPilih[row].length; i++) {
                        var tg_id = modPilih[row][i].kriteriahasildet_id;
                        var ir = modPilih[row][i].diagnosisaskep_ir;
                        var er = modPilih[row][i].diagnosisaskep_er;
                        if (tg_id !== 'undefined') {
                            if ($(this).val() == tg_id) {
                                $(this).attr("checked", "checked");
                                $(this).parents('tr').find('input[name$="[' + row + '][diagnosisaskep_ir][' + row2 + ']"]').val(ir);
                                $(this).parents('tr').find('input[name$="[' + row + '][diagnosisaskep_er][' + row2 + ']"]').val(er);
                            }
                        }

                    }

                });
                row2++;
            });
            row++;
        });
        //====button visibility
        //init
        $(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().hide();
        $(obj_table).find('tr td.rowbutton .icon-minus-sign').parent().hide();
        //set
        $(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().hide();
        $(obj_table).find('tr:last-child td.rowbutton .icon-plus-sign').parent().hide();
        var rowCount = $(obj_table).find('tbody tr').length;
        if (rowCount == 1) {
            $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
            $(obj_table).find('tr:first-child td.rowbutton .icon-plus-sign').parent().hide();
            id = $(obj_table).find('tr:first-child input[name*="[diagnosisaskepdet_id]"]').val();
            if (id != "") {
                $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
            }
        }
        //====end button visibility

    }

    function renameInputRowKriteria(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > .diagnosisaskepdet").each(function () {
            var row2 = 0;
            $(this).find('.kriteria').find("tbody > tr").each(function () {
                $(this).find('span').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
                    }
                });
                $(this).find('input,select,textarea').each(function () { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
                        $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
                    }
                });
                row2++;
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
        var rowCount = $(obj_table).find('tbody > tr').length;
        if (rowCount == 1) {
            $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
            $(obj_table).find('tr:first-child td.rowbutton .icon-plus-sign').parent().show();
            id = $(obj_table).find('tr:first-child input[name*="[diagnosisaskep_id]"]').val();
            if (id != "") {
                $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
            }
        }
        //====end button visibility

    }

    function loadDetail(diagnosisaskep_id) {
        $("#table-diagnosis").addClass("animation-loading");
        $('#table-diagnosis > tbody').html("");
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetPenunjang'); ?>',
            data: {diagnosisaskep_id: diagnosisaskep_id}, //
            dataType: "json",
            success: function (data) {
                $('#table-diagnosis > tbody').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-diagnosis").removeClass("animation-loading");
                renameInputRow($("#diagnosis-penunjang"));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    function setDialog(obj) {
        parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogTandaGejala";
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }
    function setDialog2(obj) {
        parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogFaktorRisiko";
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }
    function setDialog3(obj) {
        parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogDiagnosa";
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }

    function setDiagnosaAuto(diagnosakep_id) {

        var diagnosakep_id = diagnosakep_id;
        dialog = "#dialogDiagnosa";
        /*
         if(idDlg != null)
         {
         dialog = idDlg;
         }
         */
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        check = true;
        $('#table-diagnosis').find("tbody > .diagnosisaskepdet").each(function () {
            var val = $(this).find('input[name$="[diagnosisaskep_id]"]').val(); //element <input>
            console.log(val);
            console.log(diagnosakep_id);
            if (val == diagnosakep_id) {
                check = false;
                myAlert('Diagnosa sudah dipilih!');
                return false;
            }
        });
        if (check) {
            $.get('<?php echo Yii::app()->createUrl('asuhanKeperawatan/DiagnosisKeperawatan/getDiagnosa'); ?>', {diagnosakep_id: diagnosakep_id}, function (data) {
                $(obj).val(data[0].diagnosakep_id);
                $(obj).val(data[0].diagnosakep_nama);
                setDiagnosa(obj, data[0]);
            }, "json");
            $(dialog).dialog("close");
        }
    }

    function setDiagnosa(obj, item)
    {
        $(obj).parents('tr').find('input[name$="[diagnosisaskep_id]"]').val(item.diagnosakep_id);
        $(obj).parents('tr').find('input[name$="[diagnosakep_nama]"]').val(item.diagnosakep_nama);
        setDiagnosaRow(obj, item.diagnosakep_id);
    }

    function setDiagnosaRow(obj, diagnosakep_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetDiagnosaRow'); ?>',
            data: {diagnosakep_id: diagnosakep_id}, //
            dataType: "json",
            success: function (data) {
                console.log($(obj).parents('tr').find('.diagdetail'));
                $(obj).parents('tr').find('.diagdetail').html("");
                $(obj).parents('tr').find('.diagdetail').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-diagnosis").removeClass("animation-loading");
                renameInputDiagDetail('#table-diagnosis');
                renameInputRow('#table-diagnosis');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setTandaGejala(obj, tandagejaladet_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetTandaGejalanya'); ?>',
            data: {tandagejaladet_id: tandagejaladet_id}, //
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.tandagejala').html("");
                $(obj).parents('tr').find('.tandagejala').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-diagnosis").removeClass("animation-loading");
                renameInputTandaGejala('#table-diagnosis');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setTujuan(obj, diagnosisaskep_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetTujuan'); ?>',
            data: {diagnosisaskep_id: diagnosisaskep_id}, //
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.tujuan').html("");
                $(obj).parents('tr').find('.tujuan').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-diagnosis").removeClass("animation-loading");
                renameInput('ASDiagnosisaskepdetT', 'diagnosisaskepdet_hari');
                renameInput('ASDiagnosisaskepdetT', 'diagnosisaskepdet_estimasiwaktu');
                renameInput('ASDiagnosisaskepdetT', 'tujuan_id');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setKriteriaHasil(obj, diagnosisaskep_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetKriteriaHasil'); ?>',
            data: {diagnosisaskep_id: diagnosisaskep_id}, //
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.kriteriahasil').html("");
                $(obj).parents('tr').find('.kriteriahasil').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $("#table-diagnosis").removeClass("animation-loading");
                renameInput('ASDiagnosisaskepdetT', 'kriteriahasil_id');
                renameInput('ASDiagnosisaskepdetT', 'kriteriahasil_nama');
                renameInputRowKriteria('#table-diagnosis');
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setIntervensi(obj, diagnosisaskep_id) {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetIntervensi'); ?>',
            data: {diagnosisaskep_id: diagnosisaskep_id}, //
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.intervensi').html("");
                $(obj).parents('tr').find('.intervensi').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-diagnosis").removeClass("animation-loading");
                renameInputIntervensi('#table-diagnosis');
                renameInput('ASDiagnosisaskepdetT', 'intervensi_id');
                renameInput('ASDiagnosisaskepdetT', 'intervensi_nama');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function isKolaborasi() {
        var obj = $('#table-diagnosis > tbody > tr').find('input[name$="[iskolaborasi]"]');
        if ($(obj).is(':checked')) {
            $(obj).val(1);
        } else {
            $(obj).val(0);
        }
    }

    function isKeperawatan() {
        var obj = $("#iskeperawatan");
        if ($(obj).is(':checked')) {
            $(obj).val(1);
            $(".keperawatan").hide();
            $(".kebidanan").show();
        } else {
            $(obj).val(0);
            $(".keperawatan").show();
            $(".kebidanan").hide();
        }
    }

    function cekListKebidanan(obj) {
        if ($(obj).is(':checked')) {
            $(obj).val(1);
            $(".keperawatan").hide();
            $(".kebidanan").show();
        } else {
            $(obj).val(0);
            $(".keperawatan").show();
            $(".kebidanan").hide();
        }
    }

    function cekListKolaborasi(obj) {
        if ($(obj).is(':checked')) {
            $(obj).val(1);
//			$(obj).parents('tr').find('textarea[name$="[diagnosisaskepdet_ketkolaborasi]"]').removeAttr('readonly');
        } else {
            $(obj).val(0);
//			$(obj).parents('tr').find('textarea[name$="[diagnosisaskepdet_ketkolaborasi]"]').attr('readonly', true);
        }
    }

    
    $(document).ready(function () {
        isKeperawatan();
        isKolaborasi();
        renameInputRow('#table-diagnosis');
<?php if (!empty($model->diagnosisaskep_id)) { ?>
            var iskeperawatan = <?php echo json_encode($modPengkajian->iskeperawatan); ?>;
            if (iskeperawatan == true) {
                $('#iskeperawatan').attr("unchecked", "unchecked");
                $('#iskeperawatan').attr("disabled", "disabled");
                $('#iskeperawatan').val(0);
                $(".keperawatan").show();
                $(".kebidanan").hide();
            }
            if (iskeperawatan == false) {
                $('#iskeperawatan').attr("checked", "checked");
                $('#iskeperawatan').attr("disabled", "disabled");
                $('#iskeperawatan').val(1);
                $(".keperawatan").hide();
                $(".kebidanan").show();
            }
<?php } ?>

        cekDisabled($('#pembayaran-form'));
        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', '.ui-dialog-content', function () {
            cekDisabled('form');
        });
    });
</script>