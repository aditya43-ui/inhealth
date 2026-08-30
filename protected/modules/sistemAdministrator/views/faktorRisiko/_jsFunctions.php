<script type="text/javascript">
    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).attr('row-rincian', row);
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

    }

    function hapusLookup(obj) {
        var faktorrisikodet_id = $(obj).parents("tr").find("input[name$='[faktorrisikodet_id]']").val();
        if (faktorrisikodet_id !== "") {
            myConfirm("Apakah Anda yakin akan menghapus data ini?", "Perhatian!",
                    function (r) {
                        if (r) {
                            $(obj).parents('tr').detach();
                            renameInputRow($("#table-lookup"));
                        }
                    });
        } else {
            $(obj).parents('tr').detach();
            renameInputRow($("#table-lookup"));
        }
    }

    function tambahLookup() {
        row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowLookup', array('model' => $model), true)); ?>'
        $('#table-lookup').append(row);
        renameInputRow($("#table-lookup"));
        genExt();
        $("#table-lookup tr:last .integer").maskMoney(
                {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
        );
    }

    function genExt() {
        $('.faktorrisikodet_indikator').autocomplete({
            'showAnim': 'fold',
            'minLength': 3,
            'focus': function (event, ui)
            {
                $(this).val(ui.item.label);
                return false;
            },
            'select': function (event, ui)
            {
                setFaktorRisiko(ui.item, this);
                return false;
            },
            'source': function (request, response)
            {
                $.ajax({
                    url: "<?php echo $this->createUrl('AutoCompleteFaktorRisiko'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term,
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            }
        });
    }

    function setFaktorRisiko(data, obj) {
        if (typeof $(obj).parents("tr").attr("row-rincian") === 'undefined') {
            var no = $("#norow").val();
        } else {
            var no = $(obj).parents("tr").attr("row-rincian");
        }

        $('#table-lookup > tbody > tr[row-rincian="' + no + '"]').find('.faktorrisiko_daftar_id').val(data.faktorrisiko_daftar_id);
        $('#table-lookup > tbody > tr[row-rincian="' + no + '"]').find('.faktorrisikodet_indikator').val(data.faktorrisiko_daftar_nama);

    }


    function setFaktorRisikodialog(id, nama, obj) {
        if (typeof $(obj).parents("tr").attr("row-rincian") === 'undefined') {
            var no = $("#norow").val();
        } else {
            var no = $(obj).parents("tr").attr("row-rincian");
        }

        $('#table-lookup > tbody > tr[row-rincian="' + no + '"]').find('.faktorrisiko_daftar_id').val(id);
        $('#table-lookup > tbody > tr[row-rincian="' + no + '"]').find('.faktorrisikodet_indikator').val(nama);

    }

    function cek(obj) {
        if ($(obj).is(':checked')) {
            $(obj).parents("tr").find("input[name$='[faktorrisikodet_aktif]']").val(1);
        } else {
            $(obj).parents("tr").find("input[name$='[faktorrisikodet_aktif]']").val(0);
        }
    }

    function setCeklisDiagnosa() {
        $("input:checkbox.pilih").each(function () {
            var nomor = $(this);
            nomor.prop("checked", false);
            nomor.removeAttr("disabled");
            $("#table-lookup > tbody > tr").find(".kelompokfaktorrisikodaftar_id").each(function () {
                if (nomor.attr('kelompokfaktorrisikodaftar_id') == $(this).val()) {
                    nomor.prop("checked", true);
                    nomor.attr("disabled", true);
                }
            });
        });
    }

    function refreshTable() {
        var diagnosakep_id = $("#<?php echo CHtml::activeId($model, 'diagnosakep_id') ?>").val();
        var faktorrisiko_nama = $("#<?php echo CHtml::activeId($model, 'faktorrisiko_nama') ?>").val();

        if (diagnosakep_id !== '' && faktorrisiko_nama !== '') {
            $('#table-lookup').addClass('animation-loading');

            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('getLookup'); ?>',
                data: {diagnosakep_id: diagnosakep_id, faktorrisiko_id: faktorrisiko_nama},
                dataType: "json",
                success: function (data) {
                    $("#table-lookup > tbody").find('tr').detach();
                    $("#table-lookup > tbody").append(data.form);
                    $('#table-lookup').removeClass('animation-loading');
                    renameInputRow($("#table-lookup"));
                    getExtAutoComplete();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function setDialog(obj) {
        if (typeof $(obj).parents("tr").attr("row-rincian") === 'undefined') {
            var no = $("#norow").val();
        } else {
            var no = $(obj).parents("tr").attr("row-rincian");
        }
        var row = $("#norow").val(no);
        $("#dialogDaftarRisiko").dialog("open");
    }
    
    function setJenisFaktor(){
        var jenis = $("#SAFaktorrisikoM_faktorrisiko_nama").val();
        
        $.fn.yiiGridView.update('kelompokresiko-m-grid', {
            data: {
                "SAKelompokfaktorrisikodaftarM[jenisfaktorrisiko_id]": jenis,
            }
        });
    }
    
    var is_checked = {};
    function setKelompok(obj) {
        var kelompokfaktorrisikodaftar_id = $(obj).attr('kelompokfaktorrisikodaftar_id');

        if ($(obj).prop("checked") == true) {
            is_checked[kelompokfaktorrisikodaftar_id] = kelompokfaktorrisikodaftar_id;
        } else {
            is_checked[kelompokfaktorrisikodaftar_id] = 0;
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
    
    function cekJenis(){
        if($("#SAFaktorrisikoM_faktorrisiko_nama").val()==""){
            alert("Pilih Jenis Faktor terlebih dahulu!"); 
            return false;
        }else{          
            setCeklisDiagnosa();
            $("#dialogKelompok").dialog("open");
        }
    }
    
    function inputKelompok(from='') {
        var kelompokfaktorrisikodaftar_id = is_checked;
        //console.log(from);
        if (isEmpty(kelompokfaktorrisikodaftar_id)) {
            myAlert('Risiko belum dipilih');
            return false;
        } else {
            $('#table-lookup').addClass("animation-loading");
            cekList(kelompokfaktorrisikodaftar_id, from);

        }
    }
    
    function isEmpty(obj) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }
    
    function cekList(id, from='') {
        //console.log(from);
        x = true;
        if (x == true) {
            tambahKelompok(is_checked, from);
            $("#dialogKelompok").dialog("close");
            return x;
        }
        return false;
    }
    
    function tambahKelompok(kelompokfaktorrisikodaftar_id, from='') {        
        //console.log(from);
        $.ajax({
            type    : 'POST',
            url     : '<?php echo $this->createUrl('setResiko'); ?>',
            data    : {id: kelompokfaktorrisikodaftar_id, from:from},
            dataType: "json",
            success : function (data) {
                //console.log(data);
                $('#table-lookup > tbody').append(data);
                $('#table-lookup').removeClass("animation-loading");
                renameInputRowResiko($("#table-lookup"));
                is_checked = {};
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    function renameInputRowResiko(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).attr('row-rincian', row);
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0]+ "_" +old_name_arr[1] + "_" + row + "_" + old_name_arr[3]);
                    $(this).attr("name", old_name_arr[0] +"[detail]" + "[" + row + "][" + old_name_arr[3] + "]");
                }
            });
            row++;
        });
    }
    

    $(document).ready(function () {
        
        <?php if (!empty($model->diagnosakep_id) && $model->jenisfaktorrisiko_id) { ?>
            var data    = <?= json_encode($kelompok)?>;
            $('#table-lookup').addClass("animation-loading");
            data.forEach(myLoop);
            
            from        = 'update';
            inputKelompok(from);
            //console.log(from);
        <?php } ?>

        <?php if (!empty($model->faktorrisiko_id)) { ?>
            refreshTable();
        <?php } ?>
    });
    
    function myLoop(value, index, array) {
        var id = value;
        $("#check_"+id).prop("checked", true).change();        
    }


</script>