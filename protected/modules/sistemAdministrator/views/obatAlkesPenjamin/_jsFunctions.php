<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
	function verifikasi(obj){
		if(requiredCheck($(obj))){
                    $(".integer2, .float2, .integer-decimal").each(function(){
                        $(this).val(unformatNumber($(this).val()));
                    });
		}
		return true;
	}
   
   $(document).ready(function(){
	   formatNumberSemua();
	   $('.valid-persen').on('blur',function(){
			unformatNumberSemua();
			var value = parseFloat($(this).val());
			
			if(value > 100){
				myAlert('Persentasi tidak boleh lebih dari 100')
				$(this).val(0);
			}
			formatNumberSemua();
	   });
   });
</script>