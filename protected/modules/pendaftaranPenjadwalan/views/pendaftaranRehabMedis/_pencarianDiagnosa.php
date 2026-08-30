<div class="row">
    <div class="span12">
        <div class="control-group">
            <div class="controls">
                <?php echo CHtml::label('Kata Kunci ( Kode / Nama )', '', array('class' => 'control-label')); ?>
                <?php echo CHtml::textField('katakunci_diagnosa', '', array('class' => 'span3', 'placeholder' => 'Kata Kunci')); ?>
                <?php
                echo CHtml::htmlButton('<i class="entypo-search"></i>', array('onclick' => 'cariDataDiagn0sa();return false;',
                    'class' => 'btn btn-mini btn-primary btn-katakunci',
                    'onkeypress' => "cariDataDiagn0sa();return false;",
                    'rel' => "tooltip",
                    'title' => "Klik untuk mencari data Poli",));
                ?>
            </div>
        </div>
    </div>
    <div class="span12">
        <div class="block-tabel">
            <table class="items table table-striped table-condensed" id="table-diagnosa">
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
    </div>

</div>
<script type="text/javascript">
function cariDataDiagn0sa(){
	var katakunci = $('#katakunci_diagnosa').val();
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
	
	if(katakunci != ''){
		var isi = katakunci;
		var aksi = 13;
	}
	
    if (isi=="" || !katakunci) {myAlert('Isi Kata Kunci terlebih dahulu!'); return false;};
    var setting = {
        url : "<?php echo $this->createUrl('PendaftaranRawatJalan/bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#table-diagnosa").addClass("animation-loading");
        },
        success: function(data){
            $("#table-diagnosa").removeClass("animation-loading");
            var obj = JSON.parse(data);
            var obj1 = JSON.parse(data);
            if(obj1.metaData.message != 'Sukses'){
                myAlert(obj1.metaData.message);
            }

                var list = obj.response.diagnosa;
                        $.ajax({
                                type:'POST',
                                url:'<?php echo $this->createUrl('setFormDiagnosa'); ?>',
                                data: {diagnosaList:list},//
                                dataType: "json",
                                success:function(data){
                                        $("#table-diagnosa > tbody > tr").remove(); 
                                        $('#table-diagnosa > tbody').append(data.form);
                                        renameInputRow($("#table-diagnosa"));    
                                },
                                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                        });
//				
                jQuery.expr[':'].contains = function(a, i, m) {
                  return jQuery(a).text().toUpperCase()
                          .indexOf(m[3].toUpperCase()) >= 0;
                };
        },
        error: function(data){
            $("#table-diagnosa").removeClass("animation-loading");
        }
    }
    
    if(typeof ajax_request !== 'undefined') 
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

/**
* rename input grid
*/ 
function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
    });
    
}
$(document).ready(function () {
    $('#katakunci_diagnosa').keyup(function(e){
        if(e.keyCode == 13)
        {
            cariDataDiagn0sa();
        }
    });
});

</script>