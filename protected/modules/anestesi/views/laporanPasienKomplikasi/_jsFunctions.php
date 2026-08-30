<script type="text/javascript">
function ubahJnsPeriode(){
	var obj = $("#<?php echo CHtml::activeId($model, 'jns_periode')?>");
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



function tab(index){
    $(this).hide();
    if (index==0){
        $("#ATLapanestesikomplikasiintraV_pilihan_tab").val("intra");
        $("#div_intra").show();
        $("#div_pasca").hide();
    }else if(index==1){
        $("#ATLapanestesikomplikasiintraV_pilihan_tab").val("pasca");
        $("#div_intra").hide();
        $("#div_pasca").show();
    }
}


ubahJnsPeriode();
$(document).ready(function() {
    $("#tabmenu").children("li").children("a").click(function() {
        $("#tabmenu").children("li").attr('class','');
        $(this).parents("li").attr('class','active');
        $(".icon-pencil").remove();
        $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
    });

    $("#div_intra").show();
    $("#div_pasca").hide();
});
</script>