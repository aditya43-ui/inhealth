<script type="text/javascript">
function batalPeriksa(pascaanestesi_id,pasienanastesi_id)
{
	var pascaanestesi_id=pascaanestesi_id;
	var pasienanastesi_id=pasienanastesi_id;

	myConfirm("Anda yakin akan membatalkan pemeriksaan intra anestesi ini?","Perhatian!",function(r) {
		if(r){
			$.ajax({
				type:'POST',
				url:'<?php echo $this->createUrl('BatalPemeriksaan'); ?>',
				data: {pascaanestesi_id:pascaanestesi_id, pasienanastesi_id:pasienanastesi_id},
				dataType: "json",
				success:function(data){
					if(data.status == true){
						myAlert(data.pesan);
						$.fn.yiiGridView.update('daftarpasien-v-grid', {
							data: $(this).serialize() });									
					}else if(data.pesan == 'exist'){
						myAlert('Pemeriksaan tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!');
					}else{
						myAlert(data.pesan);
					}
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
		}
	});
}		
</script>