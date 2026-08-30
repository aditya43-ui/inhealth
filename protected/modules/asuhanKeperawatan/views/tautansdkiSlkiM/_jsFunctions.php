<script type="text/javascript">
    function setLookup(diagnosakep_id) {
        $("#table-lookup").addClass("animation-loading");
        $('#table-lookup > tbody').html("");
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetLookup'); ?>',
            data: {diagnosakep_id: diagnosakep_id}, //
            dataType: "json",
            success: function (data) {
                $('#table-lookup > tbody').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                renameInputRow($("#table-lookup"));
                $(".integer").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#table-lookup").removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }

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

        $("#table-lookup tbody tr").each(function () {
            var tautansdki_slki_id = $(this).find("input[name$='[tautansdki_slki_id]']").val();
            if (tautansdki_slki_id !== "") {
                $(this).find("td.rowbutton .icon-minus-sign").parent().hide();
            }
        });
    }

    function hapusLookup(obj) {
        var tautansdki_slki_id = $(obj).parents("tr").find("input[name$='[tautansdki_slki_id]']").val();
        if (tautansdki_slki_id !== "") {
            myConfirm("Apakah Anda yakin akan menghapus data ini dari database?", "Perhatian!",
                    function (r) {
                        if (r) {
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo $this->createUrl('Delete'); ?>&id=' + tautansdki_slki_id,
                                data: {id: tautansdki_slki_id}, //
                                dataType: "json",
                                success: function (data) {
                                    if (data.sukses == 1) {
                                        $(obj).parents('tr').detach();
                                        renameInputRow($("#table-lookup"));
                                    }
                                    myAlert(data.pesan);
                                    var rowCount = $("#table-lookup").find('tbody tr').length;
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
            renameInputRow($("#table-lookup"));
        }
    }

    function tambahLookup() {
        row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowLookup', array('model' => $modDetail), true)); ?>'
        $('#table-lookup').append(row);
        renameInputRow($("#table-lookup"));
        genExt();
        $("#table-lookup tr:last .integer").maskMoney(
                {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
        );
    }

    function genExt() {
        $('.luarankeperawatan_nama').autocomplete({
            'showAnim': 'fold',
            'minLength': 3,
            'focus': function (event, ui)
            {
                $(this).val(ui.item.label);
                return false;
            },
            'select': function (event, ui)
            {
                setLuarankeperawatan(ui.item, this);
                return false;
            },
            'source': function (request, response)
            {
                $.ajax({
                    url: "<?php echo $this->createUrl('AutoCompleteLuaranKeperawatan'); ?>",
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

    function setLuarankeperawatan(data, obj){
        if (typeof $(obj).parents("tr").attr("row-rincian") === 'undefined'){
            var no = $("#norow").val();
        }else{
            var no = $(obj).parents("tr").attr("row-rincian");
        }
        
        $('#table-lookup > tbody > tr[row-rincian="'+no+'"]').find('.luarankeperawatan_id').val(data.luarankeperawatan_id);
        $('#table-lookup > tbody > tr[row-rincian="'+no+'"]').find('.luarankeperawatan_nama').val(data.luarankeperawatan_nama);
        
    }
    
    
    function setLuarankeperawatandialog(id, nama, obj){
        if (typeof $(obj).parents("tr").attr("row-rincian") === 'undefined'){
            var no = $("#norow").val();
        }else{
            var no = $(obj).parents("tr").attr("row-rincian");
        }
        
        $('#table-lookup > tbody > tr[row-rincian="'+no+'"]').find('.luarankeperawatan_id').val(id);
        $('#table-lookup > tbody > tr[row-rincian="'+no+'"]').find('.luarankeperawatan_nama').val(nama);
        
    }
    
    function cek(obj) {
        if ($(obj).is(':checked')) {
            $(obj).parents("tr").find("input[name$='[tautansdki_slki_aktif]']").val(1);
        } else {
            $(obj).parents("tr").find("input[name$='[tautansdki_slki_aktif]']").val(0);
        }
    }

    /**
     * Refresh table
     * @returns {undefined}
     */
    function refreshTable() {
        var diagnosakep_id = $("#<?php echo CHtml::activeId($model, 'diagnosakep_id') ?>").val();
        var tingkatluarankeperawatan = $("#<?php echo CHtml::activeId($model, 'tingkatluarankeperawatan') ?>").val();

        if (diagnosakep_id !== '') {
            $('#table-lookup').addClass('animation-loading');

            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('getLookup'); ?>',
                data: {diagnosakep_id: diagnosakep_id, tingkatluarankeperawatan:tingkatluarankeperawatan},
                dataType: "json",
                success: function (data) {
                    $("#table-lookup > tbody").find('tr').detach();
                    $("#table-lookup > tbody").append(data.form);
                    $('#table-lookup').removeClass('animation-loading');
                    renameInputRow($("#table-lookup"));
                    genExt();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function setDialog(obj) {
        if (typeof $(obj).parents("tr").attr("row-rincian") === 'undefined'){
            var no = $("#norow").val();
        }else{
            var no = $(obj).parents("tr").attr("row-rincian");
        }
        var row = $("#norow").val(no);
        $("#dialogLuaranKeperawatan").dialog("open");
    }

    $(document).ready(function () {
        tambahLookup();
<?php if (!empty($model->diagnosakep_id)) { ?>
            setLookup('<?php echo $model->diagnosakep_id; ?>');
<?php } ?>

<?php if (!empty($model->diagnosakep_id)) { ?>
            refreshTable();
<?php } ?>
    })

</script>