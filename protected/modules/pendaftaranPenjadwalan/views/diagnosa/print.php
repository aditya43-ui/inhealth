<?php
if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judul_print . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
}
?>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])) {
    echo $this->renderPartial($this->path_view . '_headerPrint');
}
?>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" valign="middle" colspan="3">
            <b><?php echo $judul_print ?></b>
        </td>
    </tr>
</table><br />
<div class="block-tabel">
    <table class="items table table-striped table-condensed" id="table-diagnosa">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script type="text/javascript">
    function cariDataDiagnosa() {
        var katakunci = '<?php echo $_GET['diagnosa']; ?>';
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }

        isi = "";
        if (katakunci != '') {
            var isi = katakunci;
            var aksi = 1; // 1 untuk mencari data fasilitas kesehatan
        }

        if (isi == "") {
            myAlert('Isi Kata Kunci terlebih dahulu!');
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {
                $("#table-diagnosa").addClass("animation-loading");
            },
            success: function(data) {
                $("#table-diagnosa").removeClass("animation-loading");
                var obj = JSON.parse(data);
                var obj1 = JSON.parse(data);
                if (obj1.metaData.message != 'Sukses') {
                    myAlert(obj1.metaData.message);
                }
                //            if(obj.response!=null){
                var list = obj.response.diagnosa;
                //				var count = obj.response.count;
                //				if(count > 0){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('setFormDiagnosa'); ?>',
                    data: {
                        diagnosaList: list
                    }, //
                    dataType: "json",
                    success: function(data) {
                        $("#table-diagnosa > tbody > tr").remove();
                        $('#table-diagnosa > tbody').append(data.form);
                        renameInputRow($("#table-diagnosa"));
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
                //				} else {
                //					myAlert("Diagnosa tidak ditemukan");
                //				}
                // OVERWRITES old selecor
                jQuery.expr[':'].contains = function(a, i, m) {
                    return jQuery(a).text().toUpperCase()
                        .indexOf(m[3].toUpperCase()) >= 0;
                };
                //            }else{
                //              myAlert(obj.metadata.message);
                //            }
            },
            error: function(data) {
                $("#table-diagnosa").removeClass("animation-loading");
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
    $(document).ready(function() {
        var diagnosa = '<?php echo $_GET['diagnosa']; ?>';
        if (diagnosa != '') {
            cariDataDiagnosa();
            $('#tabel-diagnosa').show();
        }
    });
</script>