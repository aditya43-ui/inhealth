<script type="text/javascript">
    var trBahan = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowDetail', array('model' => $model, 'modDetail' => $modDetail, 'form' => $form, 'removeButton' => true), true)); ?>);
    var trBahanFirst = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowDetail', array('model' => $model, 'modDetail' => $modDetail, 'form' => $form, 'removeButton' => false), true)); ?>);

    function submitBarang(id, kode, nama) {
        var bariske = $("#bariske").val();
        $('#BarangpecahbelahdetT_' + bariske + '_barang_id').val(id);
        $('#BarangpecahbelahdetT_' + bariske + '_barang_kode').val(kode);
        $('#BarangpecahbelahdetT_' + bariske + '_barang_nama').val(nama);
    }

    function setDialog(obj) {
        var bariske = $(obj).parents('tr').find('input[name$="row"]').val();
        $("#bariske").val(bariske);
        $("#dialogBarang").dialog("open");
    }

    function batalLinen(obj)
    {
        myConfirm('Apakah Anda yakin akan membatalkan Barang ini?', 'Perhatian!',
                function (r) {
                    if (r) {
                        $(obj).parents('tr').next('tr').detach();
                        $(obj).parents('tr').detach();

<?php
$attributes = $modDetail->attributeNames();
foreach ($attributes as $i => $attribute) {
    echo "renameInput('BarangpecahbelahdetT','$attribute');";
}
?>
                        renameInput('BarangpecahbelahdetT', 'barang_nama');
                        renameInput('BarangpecahbelahdetT', 'barang_id');
                    }
                });
    }
    function addRowBarang(obj)
    {
        $(obj).parents('table').children('tbody').append(trBahan.replace());
<?php
$attributes = $modDetail->attributeNames();
foreach ($attributes as $i => $attribute) {
    echo "renameInput('BarangpecahbelahdetT','$attribute');";
}
?>
        renameInput('BarangpecahbelahdetT', 'barang_nama');
        renameInput('BarangpecahbelahdetT', 'barang_kode');
        $(obj).parents('tr').find('input[name$="[barang_nama]"]').autocomplete({'showAnim': 'fold', 'minLength': 3, 'focus': function (event, ui) {
                $(this).val("");
                return false;
            }, 'select': function (event, ui) {
                $(this).parents("tr").find("input[name$=\"[barang_id]\"]").val(ui.item.barang_id);
                $(this).parents("tr").find("input[name$=\"[barang_kode]\"]").val(ui.item.barang_kode);
                $(this).parents("tr").find("input[name$=\"[barang_nama]\"]").val(ui.item.barang_nama);
                return false;
            }, 'source': function (request, response) {
                $.ajax({
                    url: "<?php echo $this->createUrl('AutocompleteBarang'); ?>",
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
        $(obj).parents('tr').find('input[name$="[barang_kode]"]').autocomplete({'showAnim': 'fold', 'minLength': 3, 'focus': function (event, ui) {
                $(this).val("");
                return false;
            }, 'select': function (event, ui) {
                $(this).parents("tr").find("input[name$=\"[barang_id]\"]").val(ui.item.barang_id);
                $(this).parents("tr").find("input[name$=\"[barang_kode]\"]").val(ui.item.barang_kode);
                $(this).parents("tr").find("input[name$=\"[barang_nama]\"]").val(ui.item.barang_nama);
                return false;
            }, 'source': function (request, response) {
                $.ajax({
                    url: "<?php echo $this->createUrl('AutocompleteKodeBarang'); ?>",
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

//        $(obj).parents('table').find('tr:last').find('.integer').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}); //set hanya tr terakhir agar tidak error valuenya RSSP-942
        $(obj).parents('table').find('tr:last').find('.integer').maskMoney({"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}); //set hanya tr terakhir agar tidak error valuenya RSSP-942
    }

    function batalBarang(obj) {
        $(obj).parents("tr").remove();
        clear();
    }

    function clear() {
        urut = 1;
        $(".noUrut").each(function () {
            $(this).val(urut);
            urut++;
        });
    }

    function renameInput(modelName, attributeName)
    {
        var trLength = $('#table-barang tr').length;
        var i = -1;
        $('#table-barang tr').each(function () {
            if ($(this).has('input[name$="[barang_id]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('input[id="row"]').attr('value', i);
            $(this).find('input[id="row"]').val(i)
            $(this).find('input[name$="[barang_nama]"]').addClass('ui-autocomplete-input');
            $(this).find('input[name$="[barang_nama]"]').autocomplete({'showAnim': 'fold', 'minLength': 3, 'focus': function (event, ui) {
                    $(this).val("");
                    return false;
                }, 'select': function (event, ui) {
                    $(this).val(ui.item.barang_nama);
                    $(this).parents("tr").find("input[name$=\"[barang_kode]\"]").val(ui.item.barang_kode);
                    $(this).parents("tr").find("input[name$=\"[barang_id]\"]").val(ui.item.barang_id);
                    return false;
                }, 'source': function (request, response) {
                    $.ajax({
                        url: "<?php echo $this->createUrl('AutocompleteBarang'); ?>",
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

            $(this).find('input[name$="[barang_kode]"]').addClass('ui-autocomplete-input');
            $(this).find('input[name$="[barang_kode]"]').autocomplete({'showAnim': 'fold', 'minLength': 3, 'focus': function (event, ui) {
                    $(this).val("");
                    return false;
                }, 'select': function (event, ui) {
                    $(this).val(ui.item.barang_kode);
                    $(this).parents("tr").find("input[name$=\"[barang_nama]\"]").val(ui.item.barang_nama);
                    $(this).parents("tr").find("input[name$=\"[barang_id]\"]").val(ui.item.barang_id);
                    return false;
                }, 'source': function (request, response) {
                    $.ajax({
                        url: "<?php echo $this->createUrl('AutocompleteKodeBarang'); ?>",
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

        });
        clear();
    }

    function print(caraPrint)
    {
        var barangpecahbelah_id = '<?php echo isset($_GET['barangpecahbelah_id']) ? $_GET['barangpecahbelah_id'] : null; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&barangpecahbelah_id=' + barangpecahbelah_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function unformatNumbers() {
        $('.integer').each(function () {
            this.value = unformatNumber(this.value);
        });
    }
</script>