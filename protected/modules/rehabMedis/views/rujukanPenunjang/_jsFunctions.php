<script type="text/javascript">
function dialogBatalPeriksa(pendaftaran_id,pasienkirimkeunitlain_id)
{
	$('#DialogBatalperiksa #pasienkirimkeunitlain_id').val(pasienkirimkeunitlain_id);
	$('#DialogBatalperiksa #pendaftaran_id').val(pendaftaran_id);
	$('#DialogBatalperiksa').dialog('open');	
} 
function batalperiksa()
{
	var pasienkirimkeunitlain_id=$('#DialogBatalperiksa #pasienkirimkeunitlain_id').val(); 
	var pendaftaran_id=$('#DialogBatalperiksa #pendaftaran_id').val(); 
	var nama_pemakai=$('#DialogBatalperiksa #username').val();
	var kata_kunci=$('#DialogBatalperiksa #password').val();

	if(nama_pemakai == ''){
		myAlert('Nama Pemakai harus diisi!');
		return false;
	}
	if(kata_kunci == ''){
		myAlert('Kata Kunci harus diisi!');
		return false;
	}
	myConfirm("Anda yakin akan membatalkan rujukan rehabilitasi medis pasien ini?","Perhatian!",function(r) {
		if(r){
			$('#DialogBatalperiksa').dialog('close');
			$.ajax({
				type:'POST',
				url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'BatalRujukan'); ?>',
				data: {pendaftaran_id : pendaftaran_id, pasienkirimkeunitlain_id:pasienkirimkeunitlain_id,nama_pemakai:nama_pemakai, kata_kunci:kata_kunci},//
				dataType: "json",
				success:function(data){
					if(data.status == true){
							myAlert(data.pesan);
							$.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
								data: $(this).serialize() });									
						}else if(data.pesan == 'exist'){
							myAlert('Rujukan tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!');
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