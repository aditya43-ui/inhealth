<script type="text/javascript">
function showBulan(){
	var tahun = $('#<?php echo CHtml::activeId($model,'tahun'); ?>').val();
	if(tahun == ''){
		tahun = '<?php echo date('Y'); ?>';
	}
	$.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetBulanForCheckbox'); ?>',
        data: { tahun:tahun},
        dataType: "json",
        success:function(data){
				if(data.status == 'Ya'){
					myAlert(data.pesan);
				}
				$('#bulan').html(data.form);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function pilihSemuaBulan(){
	if($('#pilihSemua').is(':checked')){
		$('#cbBulan').each(function(){
			$(this).find('input').attr('checked',true);
		});
	}else{
		$('#cbBulan').each(function(){
			$(this).find('input').removeAttr('checked');
		});
	}
}

$(document).ready(function(){
//	showBulan();
//	pilihSemuaBulan();
});
</script>