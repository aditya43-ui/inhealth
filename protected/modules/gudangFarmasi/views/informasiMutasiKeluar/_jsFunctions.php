<script type="text/javascript">
function batalMutasi(mutasioaruangan_id){
	myConfirm('Apakah Anda ingin membatalkan transaksi mutasi ini?', 'Perhatian!', function(r){
		if(r){
			
			$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('BatalMutasi'); ?>',
			data: {mutasioaruangan_id : mutasioaruangan_id},//
			dataType: "json",
			success:function(data){
				if(data.pesan){
					$.fn.yiiGridView.update('infomutasikeluar-grid', {
						data: $("#infomutasikeluar-search").serialize()
					});
					myAlert(data.pesan);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
		}
	});
	
}
</script>