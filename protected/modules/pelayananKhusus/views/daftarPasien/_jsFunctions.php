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
	myConfirm("Anda yakin akan membatalkan pemeriksaan rehabilitasi medis pasien ini?","Perhatian!",function(r) {
		if(r){
                        $('#daftarpasien-v-grid').addClass("animation-loading");
			$('#DialogBatalperiksa').dialog('close');
			$.ajax({
				type:'POST',
				url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'BatalPenunjang'); ?>',
				data: {pendaftaran_id : pendaftaran_id, pasienmasukpenunjang_id:pasienmasukpenunjang_id,nama_pemakai:nama_pemakai, kata_kunci:kata_kunci},//
				dataType: "json",
				success:function(data){
                                    $('#daftarpasien-v-grid').removeClass("animation-loading");
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
				error: function (jqXHR, textStatus, errorThrown) { 
                                    console.log(errorThrown);
                                    $('#daftarpasien-v-grid').removeClass("animation-loading");
                                }
			});
		}
	});
}

function setStatus(obj,status,pasienmasukpenunjang_id){
    var status = status;
    var pasienmasukpenunjang_id = pasienmasukpenunjang_id;
    
    myConfirm(' Yakin Akan Merubah Status Periksa Pasien? ', 'Perhatian!', function(r){
        if(r){
            $.post('<?php echo $this->createUrl('UbahStatusPeriksaPasien');?>', {status:status ,pasienmasukpenunjang_id:pasienmasukpenunjang_id}, function(data){
                $.fn.yiiGridView.update('daftarpasien-v-grid');
            }, 'json');
        }
    });    
}
</script>