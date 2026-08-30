<script type="text/javascript">
function resizeIframe(obj){
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 50 + 'px';
}

function resetIframe(obj) {
    obj.style.height = 128 + 'px';
}

function setIframePetaPenyebaranPenyakit(){
    var obj_statik = document.getElementById("iframe_petapenyebaranpenyakit");
    resetIframe(obj_statik);
	
	var link = '<?php echo $this->createUrl("SetIframePetaPenyebaranPenyakit") ?>';
	var data1 = $('#penyebearanpenyakit-peta-search input[name*="SGPetapenyebaranpenyakitR"]').serialize();
	var data2 = $('#penyebearanpenyakit-peta-search select[name*="SGPetapenyebaranpenyakitR"]').serialize();
	var data3 = $('#penyebearanpenyakit-peta-search input[name*="SGDiagnosaM"]').serialize();
    $(obj_statik).attr('src', link+"&"+data2+"&"+data1+"&"+data3);
	
    $(obj_statik).parent().addClass("animation-loading");
    $(obj_statik).load(function(){
        $(obj_statik).parent().removeClass("animation-loading");
        resizeIframe(obj_statik);
    });
    return false;
}

function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span[name*="[ii]"]').each(function(){ //element <span>
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

$( document ).ready(function(){
	renameInputRow($("#table_pencariandiagnosa"));
    setIframePetaPenyebaranPenyakit();
});
</script>