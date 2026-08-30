<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}
?>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="middle" colspan="3">
			<b><?php echo $judul_print ?></b>
		</td>
	</tr>
</table><br>
 <?php $this->renderPartial($this->path_view.'_tabel',array()); ?>
<script type="text/javascript">
function searchData() {
    $.ajax({
        type: 'GET',
        url: '<?php echo $this->createUrl('GetDataKemenkes'); ?>',
        dataType: "json",
         beforeSend: function(){
            $("#table-sdm").addClass("animation-loading");
        },
        success: function (data) {
            $("#table-sdm").removeClass("animation-loading");
            if(data.status!= '200'){
              $("#table-sdm > tbody > tr").remove();
                $('#table-sdm > tbody').html(data.form);
                renameInputRow($("#table-jk"));  
            }else{
                myAlert(data.pesan);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
             $("#table-sdm").removeClass("animation-loading");
            console.log(errorThrown);
        }
    });
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
$(document).ready(function(){
    searchData();
});
</script>