<script type="text/javascript">
<?php
    $random=date('YmdHis').rand(0000000000000000, 9999999999999999);
    echo $random;
?>

function resizeIframe(obj){
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 50 + 'px';
}

function resetIframe(obj) {
    obj.style.height = 128 + 'px';
}

function setIframeContent(){
    var obj_statik = document.getElementById("iframe_content");
    resetIframe(obj_statik);
    $(obj_statik).attr('src', '<?php echo $this->createUrl("SetIFrameContent") ?>');
    $(obj_statik).parent().addClass("animation-loading");
    $(obj_statik).load(function(){
        $(obj_statik).parent().removeClass("animation-loading");
        resizeIframe(obj_statik);
    });
    return false;
}

ubahJnsPeriode = function(){
	var obj = $("#PPLaporanindikatordokterV_jns_periode");
	if(obj.val() == 'hari'){
		$('.hari').show();
		$('.bulan').hide();
		$('.tahun').hide();
	}else if(obj.val() == 'bulan'){
		$('.hari').hide();
		$('.bulan').show();
		$('.tahun').hide();
	}else if(obj.val() == 'tahun'){
		$('.hari').hide();
		$('.bulan').hide();
		$('.tahun').show();
	}
}

$(document).ready(function(){
    setIframeContent();
});
</script>