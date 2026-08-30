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
    <table class="items table table-striped table-condensed" id="table-dokter">
        <thead>
            <tr>
                <th>No. Register</th>
                <th>No. SEP</th>
                <th>No. SEP Awal</th>
                <th>No. Surat Jaminan</th>
                <th>Tgl Kejadian</th>
                <th>Tgl SEP</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script type="text/javascript">
    function cariDataSuplesi() {
        var katakunci1 = '<?php echo $_GET['kartu_peserta']; ?>';
        var katakunci2 = '<?php echo $_GET['tgl_pelayanan']; ?>';
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }

        isi = "";
        if (katakunci1 != '' && katakunci2 != '') {
            var isi = katakunci1;
            var aksi = 1;
        }

        if (isi == "") {
            myAlert('Isi Kata Kunci terlebih dahulu!');
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&katakunci1=' + katakunci1 + '&katakunci2=' + katakunci2,
            beforeSend: function() {
                $("#table-dokter").addClass("animation-loading");
            },
            success: function(data) {
                $("#table-dokter").removeClass("animation-loading");
                var obj = JSON.parse(data);
                var obj1 = JSON.parse(data);
                if (obj1.metaData.message != 'Sukses') {
                    myAlert(obj1.metaData.message);
                    $("#table-dokter > tbody > tr").remove();
                }
                var list = obj.response.jaminan;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('setFormSuplesi'); ?>',
                    data: {
                        suplesiList: list
                    }, //
                    dataType: "json",
                    success: function(data) {
                        $("#table-dokter > tbody > tr").remove();
                        $('#table-dokter > tbody').append(data.form);
                        renameInputRow($("#table-dokter"));
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
                $("#table-dokter").removeClass("animation-loading");
                myAlert('Terjadi kesalahan saat briging');
                $("#table-dokter > tbody > tr").remove();
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
        var kartu_peserta = '<?php echo $_GET['kartu_peserta']; ?>';
        if (kartu_peserta != '') {
            cariDataSuplesi();
            $('#tabel-diagnosa').show();
        }
    });
</script>