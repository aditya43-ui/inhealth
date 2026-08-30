<script type="text/javascript">
function batalLinen(obj){
    myConfirm('Apakah Anda akan membatalkan linen ini?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').detach();
			renameInputRowBarang();
        }
    });
}
/**
* rename input grid
*/ 
function renameInputRowBarang(obj_table){
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

function print(caraPrint)
{
    var kirimperlinensteril_id = '<?php echo isset($_GET['kirimperlinensteril_id']) ? $_GET['kirimperlinensteril_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&kirimperlinensteril_id='+kirimperlinensteril_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

$(document).ready(function(){
	renameInputRowBarang($("#table-peralatansteril"));
});
</script>