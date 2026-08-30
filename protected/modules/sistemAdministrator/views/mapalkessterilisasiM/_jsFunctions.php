<script type="text/javascript">
	function namalain(obj){
		var jenis_anestesi = obj.value;
		$('#<?php echo CHtml::activeId($model,'jenisanastesi_namalainnya'); ?>').val(jenis_anestesi);
	}
</script>