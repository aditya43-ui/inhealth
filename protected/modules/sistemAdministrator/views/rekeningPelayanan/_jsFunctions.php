
<script type="text/javascript">
function hapusBaris(obj)
{
  $(obj).parent().parent('tr').detach();
}

function refreshTabel(){
	var ruangan_id = $("#<?php echo CHtml::activeId($model, 'ruangan_id')?>").val();
	$("#tindakanruangan-m-grid input[name$='[ruangan_id]']").val(ruangan_id);
	if(ruangan_id == null || ruangan_id == ""){
		$("#tindakanruangan-m-grid input[name$='[ruangan_id]']").val(0);
	}
	$.fn.yiiGridView.update('tindakanruangan-m-grid', {
		data: $("#tindakanruangan-m-grid input").serialize(),
	});
}

function refreshTabel2() {
        $.fn.yiiGridView.update('rekeningpelayanan-m-grid', {
		data: $("#rekeningpelayanan-m-grid").serialize(),
	});
}

/** 
 * menambah baris ke tabel tindakan
 * @returns {undefined}
 */	
function tambahTindakan()
{
	var debit = $("#AKPelayananRekM_rekening5_id_d").val();
	var kredit = $("#AKPelayananRekM_rekening5_id_k").val();
	
	if(requiredCheck($("#tindakanruangan-m-form"))){
		if ( ((debit == null) || (debit == '')) && ((kredit == null) || (kredit == '')) )
		{
			myAlert("Maaf, salah satu akun kredit atau akun debit harus diisi");
		}else{
			$.ajax({
				type:'POST',
				url:'<?php echo $this->createUrl('create'); ?>',
				data: $("#tindakanruangan-m-form").serialize(),
				dataType: "json",
				success:function(data){
					refreshTabel2();
					myAlert(data.pesan);
					if (data.sukses == 1) {
						ulangTindakan();
					}
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
			}
	}
}

function ulangTindakan(){
	$("#<?php echo CHtml::activeId($model, 'instalasi_id')?>").val("");
	$("#<?php echo CHtml::activeId($model, 'ruangan_id')?>").html("<option value=''>-- Pilih --</option>");
	$("#<?php echo CHtml::activeId($model, 'daftartindakan_id')?>").val("");
	$("#<?php echo CHtml::activeId($model, 'daftartindakan_nama')?>").val("");
        $("#<?php echo CHtml::activeId($model, 'nmrekening5_d')?>").val("");
	$("#<?php echo CHtml::activeId($model, 'rekening5_id_d')?>").val("");
        $("#<?php echo CHtml::activeId($model, 'nmrekening5_k')?>").val("");
	$("#<?php echo CHtml::activeId($model, 'rekening5_id_k')?>").val("");
        $("#<?php echo CHtml::activeId($model, 'jnspelayanan')?>").val("");
		
	$(".checkers :checkbox").prop("checked", false);
		
	$("#komponentarif_nama").val("");
	$("#ruangan_nama").val("");

}

</script>
