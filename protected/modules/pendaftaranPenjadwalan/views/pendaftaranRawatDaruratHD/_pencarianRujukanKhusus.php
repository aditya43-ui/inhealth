<div class="row form-horizontal">
    <div class="col-sm-6">    
        <div class="control-group">
            <?php echo CHtml::hiddenField('bulan_rujukan','',array('readonly'=>true)); ?>
            <?php echo CHtml::label('No Kartu BPJS','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('norujukan_khusus','',array('class'=>'span3','placeholder'=>'No Kartu BPJS')); ?>
                <?php echo CHtml::htmlButton('<i class="entypo-search"></i>',
                        array('onclick'=>'cariDataNoRujukanKhusus();return false;',
                                  'class'=>'btn btn-mini btn-primary btn-katakunci',
                                  'onkeypress'=>"cariDataNoRujukanKhusus();return false;",
                                  'rel'=>"tooltip",
                                  'title'=>"Klik untuk mencari data Rujukan",)); ?>
            </div>
        </div>
</div>
</div>
<div class="block-tabel">
	<table class="items table table-striped table-condensed" id="table-norujukan-khusus">
		<thead>
			<tr>
                            <th style="width: 20px;">Pilih</th>
                            <?php /*
                            <th>No Rujukan</th>
                            <th>Tgl. Rujukan</th>
                            <th>No. kartu</th>
                            <th>Nama</th>
                            <th>PPK Rujukan</th>
                            <th>Sub/Spesialis</th>
                            */ ?>
                            <th>No Rujukan</th>
                            <th>Tgl. Rujukan Berlaku</th>
                            <th>Tgl. Rujukan Berakhir</th>
                            <th>No. Kartu</th>
                            <th>Nama</th>
                            <th>Diagnosa</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>	
<script type="text/javascript">

    function cariDataNoRujukanKhusus() {
//        var katakunci1 = $('#PPSepT_jnspelayanan').val();
//        var katakunci2 = '<?php echo date('Y-m-d')?>';
        var katakunci3 = $('#norujukan_khusus').val();
        var katakunci4 = $("#bulan_rujukan").val();
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {
        } else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }

        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data : 'param=14&query=' + katakunci3 + '&query2=' + katakunci4,
            beforeSend: function () {
                $("#table-norujukan-khusus").addClass("animation-loading");
            },
            success: function (data) {
                $("#table-norujukan-khusus").removeClass("animation-loading");
                var obj = JSON.parse(data);
                var obj1 = JSON.parse(data);
                if (obj1.metaData.message != 'OK') {
                    myAlert(obj1.metaData.message);
                    $("#table-norujukan-khusus > tbody > tr").remove();
                }
                var list = obj.response.rujukan;
                
                if(list.length > 0){
                    var html = "";
                    
                    for(var i=0; i<list.length; i++){

                        var objRjl = list[i];
                        // var peserta = objRjl.peserta;

                        var date1 = new Date(objRjl.tglrujukan_awal);
                        var date2 = new Date();
                        
                        var lama = (date2.getTime() - date1.getTime()) / (24 * 3600 * 1000);
                        var asalFaskes = 1;

                        /*
                        if (objMain.asalFaskes != null && objMain.asalFaskes != "") {
                            console.log("set data asal faskes");
                            asalFaskes = objRjl.asalFaskes;
                        }
                        */

                        var link = objRjl.link;

                        //var on_click = "getRujukanNoRujukanKhusus("+str_val+"); $('#dialogNoRujukanKhusus').dialog('close');";
                        
                        //if (lama > 90) {
                        //    on_click = "myAlert('Masa Berlaku Surat Rujukan Habis (Lebih dari 90 Hari arau 3 Bulan dari tanggal Rujukan). Silahkan ke Faskes Perujuk untuk perbaharui rujukan.');";
                        //}

                        console.log(objRjl);
                        
                        html += "<tr>"+
                                "<td>"+
                                objRjl.link +
                                "</td>"+
                                "<td>"+
                                objRjl.norujukan + 
                                "</td>"+
                                "<td>"+
                                objRjl.tglrujukan_awal_format + 
                                "</td>"+
                                "<td>"+
                                objRjl.tglrujukan_berakhir_format + 
                                "</td>"+
                                "<td>"+
                                objRjl.nokapst + 
                                "</td>"+
                                "<td>"+
                                objRjl.nmpst + 
                                "</td>"+
                                "<td>"+
                                objRjl.diagppk + " - " + objRjl.diagppk_nama + 
                                "</td>"+
                                "</tr>";
                    }
                    
                     $("#table-norujukan-khusus > tbody > tr").remove();
                    $('#table-norujukan-khusus > tbody').append(html);
                    renameInputRow($("#table-norujukan-khusus"));
                }
                // OVERWRITES old selecor
                jQuery.expr[':'].contains = function (a, i, m) {
                    return jQuery(a).text().toUpperCase()
                            .indexOf(m[3].toUpperCase()) >= 0;
                };
            },
            error: function (data) {
                $("#table-norujukan-khusus").removeClass("animation-loading");
                $("#table-norujukan-khusus > tbody > tr").remove();
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

function getDataCariRujukan(value){

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