<div class="row form-horizontal">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::hiddenField('dpjs_is_load', '', array('readonly' => true)); ?>
            <?php echo CHtml::label('No Kartu BPJS', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('norujukan', '', array('class' => 'span3', 'placeholder' => 'No Kartu BPJS')); ?>
                <?php echo CHtml::htmlButton(
                    '<i class="entypo-search"></i>',
                    array(
                        'onclick' => 'cariDataNoRujukan();return false;',
                        'class' => 'btn btn-mini btn-primary btn-katakunci',
                        'onkeypress' => "cariDataNoRujukan();return false;",
                        'rel' => "tooltip",
                        'title' => "Klik untuk mencari data Rujukan",
                    )
                ); ?>
            </div>
        </div>
    </div>
</div>
<div class="block-tabel">
    <table class="items table table-striped table-condensed" id="table-norujukan">
        <thead>
            <tr>
                <th style="width: 20px;">Pilih</th>
                <th>No Rujukan</th>
                <th>Tgl. Rujukan</th>
                <th>No. kartu</th>
                <th>Nama</th>
                <th>PPK Rujukan</th>
                <th>Sub/Spesialis</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script type="text/javascript">
    function cariDataNoRujukan() {
        var katakunci3 = $("#<?php echo CHtml::activeId($model, 'nopeserta') ?>").val();
        $('#norujukan').val(katakunci3);
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }

        var jenisfaskes = '';
        $('.jenisfaskes_bpjs').each(function() {
            if ($(this).prop('checked') == true) {
                jenisfaskes = $(this).val();
            }
        });

        if (katakunci3 == "") {
            myAlert('Isi No Kartu terlebih dahulu!');
            return false;
        }

        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=18&query=' + katakunci3 + '&jenisfaskes=' + jenisfaskes,
            beforeSend: function() {
                $("#table-norujukan").addClass("animation-loading");
            },
            success: function(data) {
                $("#table-norujukan").removeClass("animation-loading");
                var obj = JSON.parse(data);
                var obj1 = JSON.parse(data);
                if (obj1.metaData.message != 'OK') {
                    myAlert(obj1.metaData.message);
                    $("#table-norujukan > tbody > tr").remove();
                }
                var list = obj.response.rujukan;

                if (list.length > 0) {
                    var html = "";

                    for (var i = 0; i < list.length; i++) {
                        var objRjl = list[i];
                        var peserta = objRjl.peserta;

                        var date1 = new Date(objRjl.tglKunjungan);
                        var date2 = new Date();

                        var lama = (date2.getTime() - date1.getTime()) / (24 * 3600 * 1000);

                        var on_click = "getRujukanNoRujukan('" + objRjl.noKunjungan + "'); $('#dialogNoRujukan').dialog('close');";

                        if (lama > 90) {
                            on_click = "myAlert('Masa Berlaku Surat Rujukan Habis (Lebih dari 90 Hari arau 3 Bulan dari tanggal Rujukan). Silahkan ke Faskes Perujuk untuk perbaharui rujukan.');";
                        }

                        console.log(objRjl);

                        html += "<tr>" +
                            "<td>" +
                            "<a class='btn-small' href='javascript:void(0);' onclick=\"" + on_click + "\">" +
                            "<i class='icon-form-check'></i></a>" +
                            "</td>" +
                            "<td>" +
                            objRjl.noKunjungan +
                            "</td>" +
                            "<td>" +
                            objRjl.tglKunjungan +
                            "</td>" +
                            "<td>" +
                            peserta.noKartu +
                            "</td>" +
                            "<td>" +
                            peserta.nama +
                            "</td>" +
                            "<td>" +
                            objRjl.provPerujuk.nama +
                            "</td>" +
                            "<td>" +
                            objRjl.poliRujukan.nama +
                            "</td>" +
                            "</tr>";
                    }

                    $("#table-norujukan > tbody > tr").remove();
                    $('#table-norujukan > tbody').append(html);
                    renameInputRow($("#table-norujukan"));
                }
                // OVERWRITES old selecor
                jQuery.expr[':'].contains = function(a, i, m) {
                    return jQuery(a).text().toUpperCase()
                        .indexOf(m[3].toUpperCase()) >= 0;
                };
            },
            error: function(data) {
                $("#table-norujukan").removeClass("animation-loading");
                $("#table-norujukan > tbody > tr").remove();
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    function getDataCariRujukan(value) {

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
        var jenis_pelayanan = $('#jenis_pelayanan').val();
        var tgl_pelayanan = $('#tgl_pelayanan').val();
        var kode_spesialis = $('#kode_spesialis').val();
        window.open('<?php echo $this->createUrl('PrintData'); ?>&jenis_pelayanan=' + jenis_pelayanan + '&tgl_pelayanan=' + tgl_pelayanan + '&kode_spesialis=' + kode_spesialis + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    $('#kode_spesialis').keypress(function(e) {
        var key = e.which;
        if (key == 13) // the enter key code
        {
            cariDataDokter();
            return false;
        }
    });
</script>