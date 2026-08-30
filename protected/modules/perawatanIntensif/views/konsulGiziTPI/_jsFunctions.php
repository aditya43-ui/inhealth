<script type="text/javascript">
function batalRujukan(pendaftaran_id,pasienkirimkeunitlain_id,obj)
{
	window.parent.myConfirm("Anda yakin akan membatalkan rujukan gizi/nutrisi pasien ini?","Perhatian!",function(r) {
		if(r){
			$('#tblListPemeriksaanRad').addClass('animation-loading');
			$.ajax({
				type:'POST',
				url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'BatalRujukan'); ?>',
				data: {pendaftaran_id : pendaftaran_id, pasienkirimkeunitlain_id:pasienkirimkeunitlain_id},//
				dataType: "json",
				success:function(data){
					if(data.status == true){
						window.parent.myAlert(data.pesan);							
						$('#tblListPemeriksaanRad').removeClass('animation-loading');									
						$(obj).parents('tr').detach();
					}else if(data.pesan == 'exist'){
						window.parent.myAlert('Rujukan tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!');
						$('#tblListPemeriksaanRad').removeClass('animation-loading');									
					}else{
						window.parent.myAlert(data.pesan);
						$('#tblListPemeriksaanRad').removeClass('animation-loading');									
					}
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
		}
	});
}	
</script>