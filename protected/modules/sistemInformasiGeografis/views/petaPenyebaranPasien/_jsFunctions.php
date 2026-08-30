<script type="text/javascript">
function resizeIframe(obj){
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 50 + 'px';
}

function resetIframe(obj) {
    obj.style.height = 128 + 'px';
}

function setIframePetaPenyebaranPasien(){
    var obj_statik = document.getElementById("iframe_petapenyebaranpasien");
    resetIframe(obj_statik);
	
	var link = '<?php echo $this->createUrl("SetIframePetaPenyebaranPasien") ?>';
	var data1 = $('#penyebearanpasien-peta-search input[name*="SGPetapenyebaranpasienR"]').serialize();
	var data2 = $('#penyebearanpasien-peta-search select[name*="SGPetapenyebaranpasienR"]').serialize();
    $(obj_statik).attr('src', link+"&"+data2+"&"+data1);
	
    $(obj_statik).parent().addClass("animation-loading");
    $(obj_statik).load(function(){
        $(obj_statik).parent().removeClass("animation-loading");
        resizeIframe(obj_statik);
    });
    return false;
}

$( document ).ready(function(){
    setIframePetaPenyebaranPasien();
});
</script>