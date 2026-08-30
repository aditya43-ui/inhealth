<script type="text/javascript">	
	function batalPenerimaan(obj){
		myConfirm("Anda yakin akan membatalkan data ini?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('informasisterilisasi-grid');
							if(data.sukses > 0){
							}else{
								myAlert('Data gagal dibatalkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal dibatalkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
</script>