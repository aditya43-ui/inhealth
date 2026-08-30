<script type="text/javascript">
function resizeIframe(obj){
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 50 + 'px';
}

function resetIframe(obj) {
    obj.style.height = 128 + 'px';
}

function setIframePetaPelayananMCU(){
    var obj_statik = document.getElementById("iframe_petapelayananmcu");
    resetIframe(obj_statik);
	
	var link = '<?php echo $this->createUrl("SetIframePetaPelayananMCU") ?>';
	var data1 = $('#pelayananmcu-peta-search input[name*="SGPetapenyebaranmcuR"]').serialize();
	var data2 = $('#pelayananmcu-peta-search select[name*="SGPetapenyebaranmcuR"]').serialize();
    $(obj_statik).attr('src', link+"&"+data2+"&"+data1);
	
    $(obj_statik).parent().addClass("animation-loading");
    $(obj_statik).load(function(){
        $(obj_statik).parent().removeClass("animation-loading");
        resizeIframe(obj_statik);
    });
    return false;
}

$( document ).ready(function(){
	$('#cb-jenispasienbadak input[name*="jenispasienbadak"]').attr('checked',true);
    setIframePetaPelayananMCU();
});
</script>