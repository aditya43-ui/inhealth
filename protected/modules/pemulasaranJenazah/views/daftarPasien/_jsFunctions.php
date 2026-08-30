<script type="text/javascript">
function dialogBatalPeriksa(pendaftaran_id,pasienmasukpenunjang_id,statusperiksa,nama_pasien)
{
	$('#titleNamaPasienBatal').html(nama_pasien);
	$('#DialogBatalperiksa #pasienmasukpenunjang_id').val(pasienmasukpenunjang_id);
	$('#DialogBatalperiksa #pendaftaran_id').val(pendaftaran_id);
	$('#DialogBatalperiksa #statusperiksa').val(statusperiksa);
	$('#DialogBatalperiksa').dialog('open');	
} 
function batalperiksa()
{
	var statusperiksa=$('#DialogBatalperiksa #statusperiksa').val();
	var pasienmasukpenunjang_id=$('#DialogBatalperiksa #pasienmasukpenunjang_id').val(); 
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
	myConfirm("Anda yakin akan membatalkan pemeriksaan pemulasaran jenazah ini?","Perhatian!",function(r) {
		if(r){
			$('#DialogBatalperiksa').dialog('close');
			$.ajax({
				type:'POST',
				url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'BatalPenunjang'); ?>',
				data: {pendaftaran_id : pendaftaran_id, pasienmasukpenunjang_id:pasienmasukpenunjang_id,nama_pemakai:nama_pemakai, kata_kunci:kata_kunci},//
				dataType: "json",
				success:function(data){
					if(data.status == true){
							myAlert(data.pesan);
							$.fn.yiiGridView.update('daftarPasien-grid', {
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