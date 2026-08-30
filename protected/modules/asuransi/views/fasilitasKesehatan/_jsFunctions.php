<script type="text/javascript">
    function cariDataFaskes() {
        var katakunci1 = $('#katakunci_faskes1').val();
        var katakunci2 = $('#katakunci_faskes2').val();
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }

        isi = "";
        if (katakunci1 != '') {
            var isi = katakunci1;
            var aksi = 1; // 1 untuk mencari data fasilitas kesehatan
        }
        isi1 = "";
        if (katakunci2 != '') {
            var isi1 = katakunci2;
            var aksi = 1; // 1 untuk mencari data fasilitas kesehatan
        }

        if (isi == "" || isi1 == "") {
            myAlert('Isi Kata Kunci terlebih dahulu!');
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query1=' + isi + '&query2=' + isi1,
            beforeSend: function() {
                $("#table-faskes").addClass("animation-loading");
            },
            success: function(data) {
                $("#table-faskes").removeClass("animation-loading");
                var obj = JSON.parse(data);
                var obj1 = JSON.parse(data);
                if (obj1.metaData.message != 'Sukses') {
                    myAlert(obj1.metaData.message);
                    $("#table-faskes > tbody > tr").remove();
                }
                var list = obj.response.faskes;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('setFormFaskes'); ?>',
                    data: {
                        faskesList: list
                    }, //
                    dataType: "json",
                    success: function(data) {
                        $("#table-faskes > tbody > tr").remove();
                        $('#table-faskes > tbody').append(data.form);
                        renameInputRow($("#table-faskes"));
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
                // OVERWRITES old selecor
                jQuery.expr[':'].contains = function(a, i, m) {
                    return jQuery(a).text().toUpperCase()
                        .indexOf(m[3].toUpperCase()) >= 0;
                };
            },
            error: function(data) {
                $("#table-faskes").removeClass("animation-loading");
                myAlert('Terjadi kesalahan saat briging');
                $("#table-faskes > tbody > tr").remove();
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    /**
     * rename input grid
     */
    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function() { //element <input>
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

    function printData(caraPrint) {
        var faskes = $('#katakunci_faskes1').val();
        var faskes1 = $('#katakunci_faskes2').val();
        window.open('<?php echo $this->createUrl('PrintData'); ?>&faskes=' + faskes + '&faskes1=' + faskes1 + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    $('#katakunci_faskes1').keypress(function(e) {
        var key = e.which;
        if (key == 13) // the enter key code
        {
            cariDataFaskes();
            return false;
        }
    });
</script>