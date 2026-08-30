
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
/** 
 * menambah baris ke tabel tindakan
 * @returns {undefined}
 */	
function tambahTindakan()
{
	if(requiredCheck($("#tindakanruangan-m-form"))){
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('create'); ?>',
			data: $("#tindakanruangan-m-form").serialize(),
			dataType: "json",
			success:function(data){
				refreshTabel();
				myAlert(data.pesan);
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}
}

function ulangTindakan(){
	$("#<?php echo CHtml::activeId($model, 'instalasi_id')?>").val("");
	$("#<?php echo CHtml::activeId($model, 'ruangan_id')?>").html("<option value=''>-- Pilih --</option>");
	$("#<?php echo CHtml::activeId($model, 'daftartindakan_id')?>").val("");
	$("#<?php echo CHtml::activeId($model, 'daftartindakan_nama')?>").val("");
}

</script>
