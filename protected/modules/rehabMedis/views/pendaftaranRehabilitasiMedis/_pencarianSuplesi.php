<div class="row">
	<div class="span12">
            <?php echo CHtml::htmlButton('<i class="entypo-search"></i>',
                        array('onclick'=>'cariDataSuplesi();return false;',
                                  'class'=>'btn btn-mini btn-primary btn-katakunci span12',
                                  'onkeypress'=>"cariDataSuplesi();return false;",
                                  'rel'=>"tooltip",
                                  'title'=>"Klik untuk mencari data Suplesi Jasa Raharja",)); ?>
	</div>
</div>
<div class="block-tabel">
	<table class="items table table-striped table-condensed" id="table-suplesi">
		<thead>
			<tr>
                                <th>Pilih</th>
				<th>No. Register</th>
				<th>No. SEP</th>
				<th>No. SEP Awal</th>
				<th>No. Surat Jaminan</th>
				<th>Tgl. Kejadian</th>
				<th>Tgl. SEP</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>	

<script type="text/javascript">
    function cariDataSuplesi() {
        var katakunci1 = $('#RMAsuransipasienbpjsM_nopeserta').val();
        var katakunci2 = $('#RMSepT_tglsep').val();
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {
        } else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }

        isi = "";
        if (katakunci1 != '' && katakunci2 != '') {
            var isi = katakunci1;
            var aksi = 1;
        }

        if (isi == "") {
            myAlert('Isi dahulu data secara lengkap!');
            return false;
        }
        ;
        var setting = {
            url: "<?php echo Yii::app()->createUrl('/asuransi/suplesiJasaRaharja/bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&katakunci1=' + katakunci1 + '&katakunci2=' + katakunci2,
            beforeSend: function () {
                $("#table-suplesi").addClass("animation-loading");
            },
            success: function (data) {
                $("#table-suplesi").removeClass("animation-loading");
                var obj = JSON.parse(data);
                var obj1 = JSON.parse(data);
                if (obj1.metaData.message != 'Sukses') {
                    myAlert(obj1.metaData.message);
                    $("#table-suplesi > tbody > tr").remove();
                }
                var list = obj.response.jaminan;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/SetFormSuplesi'); ?>',
                    data: {suplesiList: list}, //
                    dataType: "json",
                    success: function (data) {
                        $("#table-suplesi > tbody > tr").remove();
                        $('#table-suplesi > tbody').append(data.form);
                        renameInputRow($("#table-suplesi"));
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
                // OVERWRITES old selecor
                jQuery.expr[':'].contains = function (a, i, m) {
                    return jQuery(a).text().toUpperCase()
                            .indexOf(m[3].toUpperCase()) >= 0;
                };
            },
            error: function (data) {
                $("#table-suplesi").removeClass("animation-loading");
                myAlert('Terjadi kesalahan saat briging');
                $("#table-suplesi > tbody > tr").remove();
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
    
    $('#katakunci3').keypress(function (e) {
        var key = e.which;
        if(key == 13)  // the enter key code
        {
           cariDataSuplesi();
           return false;
        }
    });
</script>