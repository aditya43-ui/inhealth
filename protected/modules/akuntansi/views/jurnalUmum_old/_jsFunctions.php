<script type="text/javascript">
function getDataRekening(rekening1_id,rekening2_id,rekening3_id,rekening4_id,rekening5_id)
{
	var jenis_rekening = $("#isJenisRekenig").val();
    $("#tabel-detail > tbody").find('tr').detach();
    $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getDataRekening');?>', {
		jenis_rekening:jenis_rekening, rekening1_id:rekening1_id, rekening2_id:rekening2_id,rekening3_id:rekening3_id, rekening4_id:rekening4_id, rekening5_id:rekening5_id
	},
        function(data){
			if(data != null){
				$("#tblInputRekening > tbody").append(data.replace());
				renameInputRow($("#table-detail"))
			}
    }, "json");    
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

/**
 * class integer di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

/**
* untuk print alokasi anggaran
 */
function print(caraPrint)
{
    var jurnalrekening_id = '<?php echo isset($model->jurnalrekening_id) ? $model->jurnalrekening_id : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&jurnalrekening_id='+jurnalrekening_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

$(document).ready(function(){
	formatNumberSemua();
	renameInputRow($("#table-postingjurnal"))
});
</script>
