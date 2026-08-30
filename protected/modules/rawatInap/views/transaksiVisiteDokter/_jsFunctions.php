<script type="text/javascript">

function searchVisite()
{
	//unformatNumberSemua();
    var pegawai_id = $('#<?php echo CHtml::activeId($model, "pegawai_id"); ?>').val();
    var no_rekam_medik = $('#<?php echo CHtml::activeId($model, "no_rekam_medik"); ?>').val();
    var nama_pasien = $('#<?php echo CHtml::activeId($model, "nama_pasien"); ?>').val();
    var pilih = ($('#<?php echo CHtml::activeId($model,'is_dokter'); ?>').is(":checked"))?1:0;
    var jenisVisite = $('#jenisVisite').val();
    

//	if($(obj).is(':checked')){
//		if(nama_pegawai == ''){
//			myAlert('Silakan pilih dokter terlebih dahulu!');
//			$(obj).attr('checked', false);
//			pilih.val(0);
//		}
//		pilih.val(1);
//	}else{
//		pilih.val(0);
//	}
			if(pegawai_id ==''){
				myAlert('Isi yang bertanda bintang!');
				return false;
			}else{
			$.ajax({
				type:'POST',
				url:'<?php echo $this->createUrl('LoadFormVisiteDokter'); ?>',
				data: {
                                    pegawai_id:pegawai_id,
                                    no_rekam_medik:no_rekam_medik,
                                    nama_pasien:nama_pasien,
                                    jenis_visite:jenisVisite,
                                    pilih: pilih,
                                },
				dataType: "json",
				success:function(data){
					if(data.pesan !== ""){
						myAlert(data.pesan);
						return false;
					}
					$('#table-visite > tbody').html(data.form);

				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
			}
		
}
</script>
