<script type="text/javascript">
function setUntukTransaksi(){
	var ispenggajian = $('#<?php echo CHtml::activeId($model,'ispenggajian'); ?>');
	var ispembayarangaji = $('#<?php echo CHtml::activeId($model,'ispembayarangaji'); ?>');
	
	if (ispenggajian.is(':checked')) {
		ispembayarangaji.attr('disabled',true);
		ispenggajian.removeAttr('disabled',true);
		ispenggajian.val(1);
		ispembayarangaji.val(0);
		$('#ispenggajian').removeAttr('style','display:none;');
	} else if(ispembayarangaji.is(':checked')){
		ispenggajian.attr('disabled',true);
		ispembayarangaji.removeAttr('disabled',true);
		ispenggajian.val(0);
		ispembayarangaji.val(1);
		$('#ispembayarangaji').removeAttr('style','display:none;');
	}else{
		ispenggajian.removeAttr('disabled',true);
		ispembayarangaji.removeAttr('disabled',true);
		$('#ispembayarangaji').attr('style','display:none;');
		$('#ispenggajian').attr('style','display:none;');
		ispenggajian.val(0);
		ispembayarangaji.val(0);
	}
}	
$(document).ready(function(){
	setUntukTransaksi();
});
</script>