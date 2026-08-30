<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>

<script>
    var set_action = (obj, jenis) => {
        var id_attr = $(obj).parents(".form-utama").attr('id');
        var set_obj = $("#" + id_attr);

        if (jenis == 'tambah') {

            var row = <?php echo CJSON::encode($this->renderPartial($this->path_view . 'lpj/row/_row_lpj', array('modLPJ' => $modLPJ), true)); ?>;
            $(obj).parents('tbody').append(row);
            renameInputRow($("#tabel-lpj"));

        } else if (jenis == 'hapus') {
            hapus_baris();
        }
    };

    var hapus_baris = (obj) => {
        var id = $(obj).parents("tr").find(".lpj_id").val();
        if (id !== '') {
            myConfirm("Apakah anda yakin akan menghapus data ini dari database?", "Perhatian!",
                function(r) {
                    if (r) {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo $this->createUrl('Delete'); ?>&id=' + id,
                            data: {
                                id: id
                            }, //
                            dataType: "json",
                            success: function(data) {
                                if (data.sukses == 1) {
                                    $(obj).parents('tr').detach();
                                    renameInput($("#tabel-lpj"));
                                    toastr.success("Data berhasil dihapus!", "Perhatian!");
                                } else {
                                    toastr.error("Data gagal dihapus!", "Perhatian!");
                                }

                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                toastr.error("Data gagal dihapus!", "Perhatian!");
                            }
                        });
                    }
                });
        } else {
            $(obj).parents('tr').detach();
            renameInputRow($("#tabel-lpj"));
        }
    };

    var renameInputRow = (obj_table) => {
        var row = 0;
        var count = $(obj_table).find("tbody > tr").length;

        $(obj_table).find("tbody > tr").each(function () {
            $(this).find(".nomor").html(row );
            $(this).attr("row-data", row);
            $(this).find('input,select,textarea').each(function () { //element <input>
                if (typeof $(this).attr("name") !== 'undefined') {
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");

                    if (old_name_arr.length == 3) {
                        $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                        $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                    }
                }
            });

            $(this).find('.btn-tambah').removeClass('hide');
            $(this).find('.btn-hapus').removeClass('hide');
            if (row == 0) {
                if (count == 1) {
                    $(this).find('.btn-hapus').addClass('hide');
                } else {
                    $(this).find('.btn-tambah').addClass('hide');
                }
            } else {
                if (count != (row + 1)) {
                    $(this).find('.btn-tambah').addClass('hide');
                }
            }

            row++;
        });

        $(obj_table).find('input[class*="integer-decimal"]').unmaskMoney();
        $(obj_table).find('input[class*="integer-decimal"]').maskMoney(
                {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 0}
        );

    };

    function hitung_jumlah(){
        var total = 0;
        unformatNumberSemua();
        $("#tabel-lpj > tbody > tr").each(function () {
            var harga = unformatNumber(parseFloat($(this).find("input[name$='[harga_satuan]']").val()));
            var jumlah = unformatNumber(parseFloat($(this).find("input[name$='[jumlah]']").val()));
            var subtotal = 0;
            if (typeof harga !== "undefined" && typeof harga !== "undefined") {
                subtotal = harga * jumlah;
                $(this).find("input[name$='[sub_total]']").val(subtotal);

                console.log('subtotal :'+subtotal);
                
                var sub = subtotal;
                total += sub;
                console.log('total :'+total);
            }
        });
        
        $("#<?php echo CHtml::activeId($model, 'total_lpj'); ?>").val(formatThousandDecimal(total));
        formatNumberSemua();
    }
</script>