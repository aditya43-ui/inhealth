<div class="row-fluid form-horizontal">
    <div class="span6">    
        <?php if($this->id != "pendaftaranRawatDarurat"){ ?>
        <div class="control-group ">
            <?php echo CHtml::hiddenField('dpjs_is_load_melayani','',array('readonly'=>true)); ?>
            <?php echo CHtml::label('Kode Spesialis / Sub Spesialis','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('kode_spesialis_melayani','',array('class'=>'span3','placeholder'=>'Ketikan kata kunci')); ?>
                <?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',
                        array('onclick'=>'cariDataDokterMelayani();return false;',
                                  'class'=>'btn btn-mini btn-primary btn-katakunci',
                                  'onkeypress'=>"cariDataDokterMelayani();return false;",
                                  'rel'=>"tooltip",
                                  'title'=>"Klik untuk mencari data Dokter DPJP yang Melayani",)); ?>
            </div>
        </div>
         <?php }?>
</div>
</div>
<div class="block-tabel">
	<table class="items table table-striped table-condensed" id="table-dokter-melayani">
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
    function cariDataDokterMelayani() {
        var katakunci1 = 2;
        <?php if(in_array(strtolower($this->id), array("pendaftaranbayibarulahir", "pendaftaranrawatinapdarirjrd"))){ ?>
                   katakunci1 = 1;
        <?php }?>
//        var katakunci1 = $('#PPSepT_jnspelayanan').val();
        var katakunci2 = '<?php echo date('Y-m-d')?>';
        var katakunci3 = $('#kode_spesialis_melayani').val();
        
        <?php if(in_array(strtolower($this->id), array("pendaftaranrawatdarurat"))){ ?>
            katakunci3 = "UMUM";
        <?php } ?>
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {
        } else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }

        isi = "";
        if (katakunci1 != '') {
            var isi = katakunci1;
        }

        if (isi == "") {
            myAlert('Isi Kata Kunci terlebih dahulu!');
            return false;
        }
        var aksi = 17;
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&katakunci1=' + katakunci1 + '&katakunci2=' + katakunci2 + '&katakunci3=' + katakunci3,
            beforeSend: function () {
                $("#table-dokter-melayani").addClass("animation-loading");
            },
            success: function (data) {
                $("#table-dokter-melayani").removeClass("animation-loading");
                var obj = JSON.parse(data);
                var obj1 = JSON.parse(data);
                if (obj1.metaData.message != 'Sukses') {
                    <?php if(strtolower($this->id) != "pendaftaranrawatdarurat"){ ?>
                    myAlert(obj1.metaData.message);
                    <?php } ?>
                    $("#table-dokter-melayani > tbody > tr").remove();
                    return false;
                }
                var list = obj.response.list;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/setFormDokterMelayani'); ?>',
                    data: {diagnosaList: list}, //
                    dataType: "json",
                    success: function (data) {
                        $("#table-dokter-melayani > tbody > tr").remove();
                        $('#table-dokter-melayani > tbody').append(data.form);
                        renameInputRowMelayani($("#table-dokter-melayani"));
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
                $("#table-dokter-melayani").removeClass("animation-loading");
//                myAlert('Terjadi kesalahan saat briging');
                $("#table-dokter-melayani > tbody > tr").remove();
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    /**
     * rename input grid
     */
    function renameInputRowMelayani(obj_table) {
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

    function printDataMelayani(caraPrint) {
        var jenis_pelayanan = $('#jenis_pelayanan').val();
        var tgl_pelayanan = $('#tgl_pelayanan').val();
        var kode_spesialis = $('#kode_spesialis_melayani').val();
        window.open('<?php echo $this->createUrl('PrintData'); ?>&jenis_pelayanan=' + jenis_pelayanan + '&tgl_pelayanan=' + tgl_pelayanan + '&kode_spesialis=' + kode_spesialis + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
    
    
 $(document).ready(function(){
    <?php if(strtolower($this->id) == "pendaftaranrawatdarurat"){ ?>
             cariDataDokterMelayani();
    <?php }?>
    $('#kode_spesialis_melayani').keypress(function (e) {
        var key = e.which;
        if(key == 13)  // the enter key code
        {
            cariDataDokterMelayani();
           return false;
        }
    });
 })
</script>