<script type="text/javascript">
//======================================Awal batal Periksa============================================================
function dialogBatalPeriksa(pendaftaran_id,statusperiksa,namaPasien)
{
	$('#titleNamaPasienBatal').html(namaPasien);
	$('#DialogBatalperiksa #pendaftaran_id').val(pendaftaran_id);
	$('#DialogBatalperiksa #statusperiksa').val(statusperiksa);
	$('#DialogBatalperiksa').dialog('open');

} 
function ubahPeriksa()
{
  var url =$('#url').val();
  var statusperiksa=$('#DialogBatalperiksa #statusperiksa').val();
  var pendaftaran_id=$('#DialogBatalperiksa #pendaftaran_id').val(); 
  var tglbatal=$('#DialogBatalperiksa #tglbatal').val();
  var keterangan_batal=$('#DialogBatalperiksa #keterangan_batal').val();
	if(statusperiksa=='${statusPeriksaBatalPeriksa}')
	{
		myAlert('Pasien Sudah Dibatalkan');
	}
	else
	{
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('ubahPeriksa'); ?>',
			data: {pendaftaran_id: pendaftaran_id,statusperiksa:statusperiksa,tglbatal:tglbatal,keterangan_batal:keterangan_batal},//
			dataType: "json",
			success:function(data){
				if(data.success) {
					$('#DialogBatalperiksa').dialog('close');
					myAlert(data.message);
				} else {
					myAlert(data.message);
					$('#DialogBatalperiksa #keterangan_batal').attr('class','error');
				}
				 $.fn.yiiGridView.update('PPInfoKunjungan-v', {
						data: $(this).serialize()
				});
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}

}   
//=======================================Akhir Batal Periksa=============================================================   
function loadFormCaraBayar(obj){
	var url = $(obj).attr('href');
	$('#iframeUbahCaraBayar').attr('src', url);
}

/**
 * submit / simpan ubah ruangan 
 **/
function simpanUbahRuangan(){
	if($('#ganti_poli #alasanperubahan').val()==''){
	   myAlert('Alasan Perubahan tidak boleh kosong!');
	   $('#ganti_poli #alasanperubahan').addClass('error');
	   return false;
	}
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('UbahRuangan'); ?>',
		data: {post: $("#form-ubahruangan input,select,textarea").serialize()},
		dataType: "json",
		success:function(data){
			myAlert(data.pesan);
			$.fn.yiiGridView.update('PPInfoKunjungan-v', {
				data: $('#formCari').serialize()
			});
			$('#ganti_poli').dialog('close');
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

</script>
    