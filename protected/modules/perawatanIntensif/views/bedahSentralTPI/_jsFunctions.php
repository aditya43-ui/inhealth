<script type="text/javascript">
    
function cekInputQty(obj){
    if($(obj).val()==0){
        $(obj).val(1);
    }
}

function batalRujukan(pendaftaran_id,pasienkirimkeunitlain_id,obj)
{
	window.parent.myConfirm("Anda yakin akan membatalkan rujukan bedah sentral pasien ini?","Perhatian!",function(r) {
		if(r){
			$('#tblListRencanaOperasi').addClass('animation-loading');
			$.ajax({
				type:'POST',
				url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'BatalRujukan'); ?>',
				data: {pendaftaran_id : pendaftaran_id, pasienkirimkeunitlain_id:pasienkirimkeunitlain_id},//
				dataType: "json",
				success:function(data){
					if(data.status == true){
						window.parent.myAlert(data.pesan);							
						$('#tblListRencanaOperasi').removeClass('animation-loading');									
						$(obj).parents('tr').detach();
					}else if(data.pesan == 'exist'){
						window.parent.myAlert('Rujukan tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!');
						$('#tblListRencanaOperasi').removeClass('animation-loading');									
					}else{
						window.parent.myAlert(data.pesan);
						$('#tblListRencanaOperasi').removeClass('animation-loading');									
					}
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
		}
	});
}

/**
	 * update (refresh) checklist kelompok operasi
	 * harus include /js/jquery.tiler.js
	 * @param {obj} form_checklist
	 */
	function updateChecklistOperasi() {
		$('#content-operasi .checklists_operasi').addClass("animation-loading");
		$.ajax({
			type: 'POST',
			url: '<?php echo $this->createUrl('SetChecklistOperasi'); ?>',
			data: {data: $("#form-carioperasi :input").serialize()},
			dataType: "json",
			success: function (data) {
				$('#content-operasi .checklists_operasi').html(data.content);
//				$('.checkboxlist-tile').tile({widths: [256]});
				$('#content-operasi .checklists_operasi').removeClass("animation-loading");
				setCheckedOperasi($("#tblFormRencanaOperasi"));
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}
	
	/**
	 * reset pencarian & checklist operasi
	 */
	function setChecklistOperasiReset() {
		$("#form-carioperasi").find("input:not(:disabled):not([readonly])").each(function () {
			$(this).val("");
		});
		updateChecklistOperasi();
	}
	
	/**
	 * set checked operasi yang sudah ada di daftar
	 */
	function setCheckedOperasi(obj_table) {
		$(".checklists_operasi").find('input[name$="[is_pilih]"]').removeAttr('checked');
		$(obj_table).find('input[name$="[inputoperasi]"]').each(function () {
			var pemeriksaanrad_id = $(this).val();
			$(".checklists_operasi").find('input[name$="[is_pilih]"][value=' + pemeriksaanrad_id + ']').attr('checked', true);
		});

	}
	
</script>