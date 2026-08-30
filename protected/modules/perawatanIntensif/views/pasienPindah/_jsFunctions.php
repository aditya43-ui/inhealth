<script type="text/javascript">
function dialogBatalPindah(pindahkamar_id,masukkamar_id=null)
{
	$('#DialogBatalPindah #pindahkamar_id').val(pindahkamar_id);
	$('#DialogBatalPindah #masukkamar_id').val(masukkamar_id);
	$('#DialogBatalPindah').dialog('open');					
} 
function batalPindah(pindahkamar_id,masukkamar_id=null)
{
	var pindahkamar_id=$('#DialogBatalPindah #pindahkamar_id').val(); 
	var masukkamar_id=$('#DialogBatalPindah #masukkamar_id').val(); 
	var tglbatal=$('#DialogBatalPindah #tglbatal').val();
	var keterangan_batal=$('#DialogBatalPindah #keterangan_batal').val();
	var nama_pemakai=$('#DialogBatalPindah #username').val();
	var kata_kunci=$('#DialogBatalPindah #password').val();

	if(tglbatal == ''){
		window.parent.myAlert('Tanggal Batal harus diisi!');
		return false;
	}
	if(keterangan_batal == ''){
		window.parent.myAlert('Alasan Batal harus diisi!');
		return false;
	}
	if(nama_pemakai == ''){
		window.parent.myAlert('Nama Pemakai harus diisi!');
		return false;
	}
	if(kata_kunci == ''){
		window.parent.myAlert('Kata Kunci harus diisi!');
		return false;
	}
	
	window.parent.myConfirm("Anda yakin akan membatalkan pindah kamar rawat intensif pasien ini?","Perhatian!",function(r) {
		if(r){
			$('#DialogBatalPindah').dialog('close');
			  $.ajax({
				type:'POST',
				url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalPindah'); ?>',
				data: {pindahkamar_id : pindahkamar_id, masukkamar_id:masukkamar_id, nama_pemakai:nama_pemakai, kata_kunci:kata_kunci},
				dataType: "json",
				success:function(data){
					if(data.status == true){
						window.parent.myAlert(data.pesan);
						$.fn.yiiGridView.update('daftarPasien-grid', {
							data: $(this).serialize() });
					}else if(data.pesan == 'exist'){
						window.parent.myAlert('Pasien telah melakukan pemeriksaan');
					}else{
						window.parent.myAlert(data.pesan);
					}
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
		}
	});
}	
</script>