<div class="row form-horizontal">
    <div class="col-sm-6">    
        <div class="control-group">
            <?php echo CHtml::hiddenField('dpjs_is_load','',array('readonly'=>true)); ?>
            <?php echo CHtml::label('Kode Spesialis / Sub Spesialis','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('kode_spesialis','',array('class'=>'span3','placeholder'=>'Kata Kunci')); ?>
                <?php echo CHtml::htmlButton('<i class="entypo-search"></i>',
                        array('onclick'=>'cariDataDokter();return false;',
                                  'class'=>'btn btn-mini btn-primary btn-katakunci',
                                  'onkeypress'=>"cariDataDokter();return false;",
                                  'rel'=>"tooltip",
                                  'title'=>"Klik untuk mencari data Dokter DPJP",)); ?>
            </div>
        </div>
</div>
</div>
<div class="block-tabel">
	<table class="items table table-striped table-condensed" id="table-dokter">
		<thead>
			<tr>
                                <th style="width: 20px;">Pilih</th>
				<th>Kode</th>
				<th>Nama</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>	
<script type="text/javascript">
    function cariDataDokter() {
        var katakunci1 = $('#PPSepT_jnspelayanan').val();
        var katakunci2 = '<?php echo date('Y-m-d')?>';
        var katakunci3 = $('#kode_spesialis').val();
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {
        } else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }

        isi = "";
        if (katakunci1 != '') {
            var isi = katakunci1;
            var aksi = 1;
        }

        if (isi == "") {
            myAlert('Isi Kata Kunci terlebih dahulu!');
            return false;
        }
        ;
        var setting = {
            url: "<?php echo Yii::app()->createUrl('asuransi/dpjp/bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&katakunci1=' + katakunci1 + '&katakunci2=' + katakunci2 + '&katakunci3=' + katakunci3,
            beforeSend: function () {
                $("#table-dokter").addClass("animation-loading");
            },
            success: function (data) {
                $("#table-dokter").removeClass("animation-loading");
                var obj = JSON.parse(data);
                var obj1 = JSON.parse(data);
                if (obj1.metaData.message != 'Sukses') {
                    myAlert(obj1.metaData.message);
                    $("#table-dokter > tbody > tr").remove();
                }
                var list = obj.response.list;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/setFormDokter'); ?>',
                    data: {diagnosaList: list}, //
                    dataType: "json",
                    success: function (data) {
                        $("#table-dokter > tbody > tr").remove();
                        $('#table-dokter > tbody').append(data.form);
                        renameInputRow($("#table-dokter"));
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
                $("#table-dokter").removeClass("animation-loading");
//                myAlert('Terjadi kesalahan saat briging');
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

    function printData(caraPrint) {
        var jenis_pelayanan = $('#jenis_pelayanan').val();
        var tgl_pelayanan = $('#tgl_pelayanan').val();
        var kode_spesialis = $('#kode_spesialis').val();
        window.open('<?php echo $this->createUrl('PrintData'); ?>&jenis_pelayanan=' + jenis_pelayanan + '&tgl_pelayanan=' + tgl_pelayanan + '&kode_spesialis=' + kode_spesialis + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
    
    $('#kode_spesialis').keypress(function (e) {
        var key = e.which;
        if(key == 13)  // the enter key code
        {
           cariDataDokter();
           return false;
        }
    });
</script>