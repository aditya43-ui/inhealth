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
ubahJnsPeriode();
</script>