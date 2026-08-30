<script type="text/javascript">

function searchVisite()
{
	//unformatNumberSemua();
    var pegawai_id = $('#<?php echo CHtml::activeId($model, "pegawai_id"); ?>').val();
    var nama_pegawai = $('#<?php echo CHtml::activeId($model, "nama_pegawai"); ?>').val();
    var tgl_visit = $('#<?php echo CHtml::activeId($model, "tanggalVisite"); ?>').val();
	var tanggalVisite_akhir = $('#<?php echo CHtml::activeId($model, "tanggalVisite_akhir"); ?>').val();
    var jenisVisite = $('#<?php echo CHtml::activeId($model, "jenisVisite"); ?>').val();
    var pilih = $('#<?php echo CHtml::activeId($model,'is_dokter'); ?>');
    var daftartindakan_id = $('#<?php echo CHtml::activeId($model,'daftartindakan_id'); ?>').val();
	var berdasarkanNurseStation = $('#<?php echo CHtml::activeId($model,'is_nursestation'); ?>');
	var is_dokter = 0;
	var is_nurse_station = 0;

	if($(pilih).is(':checked')){
		is_dokter = 1;
	}else{
		is_dokter = 0;
	}
	
	if(jenisVisite==""){
		daftartindakan_id = null;
	}
	
	if($(berdasarkanNurseStation).is(':checked')){
		is_nurse_station = 1;
	}else{
		is_nurse_station = 0;
	}
	
	if(is_dokter == 1 && pegawai_id ==''){
		window.parent.myAlert('Isi yang bertanda bintang!');
		return false;
	}else{
		$('#table-visite').addClass("animation-loading");
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('LoadFormVisiteDokter'); ?>',
			data: {pegawai_id:pegawai_id,nama_pegawai:nama_pegawai,tgl_visit:tgl_visit,daftartindakan_id:daftartindakan_id,is_dokter:is_dokter,is_nurse_station:is_nurse_station,tanggalVisite_akhir:tanggalVisite_akhir},
			dataType: "json",
			success:function(data){
				if(data.pesan !== ""){
					window.parent.myAlert(data.pesan);
					$('#table-visite').removeClass("animation-loading");
					$('#table-visite > tbody').html('');
					return false;
				}
				$('#table-visite > tbody').html(data.form);
				$('#table-visite').removeClass("animation-loading");
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}
		
}
</script>
