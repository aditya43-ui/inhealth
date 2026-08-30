
<script type="text/javascript">
function hapusBaris(obj)
{
  $(obj).parent().parent('tr').detach();
}

function refreshTabel(){
	var instalasi_id = $("#<?php echo CHtml::activeId($model, 'instalasi_id')?>").val();
	$("#tindakanruangan-m-grid input[name$='[instalasi_id]']").val(instalasi_id);
	if(instalasi_id == null || instalasi_id == ""){
		$("#tindakanruangan-m-grid input[name$='[instalasi_id]']").val(0);
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
                if (data.sukses == 1) {
                    ulangTindakan();
                }
				refreshTabel();
				myAlert(data.pesan);
                
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}
}

function ulangTindakan(){
//	$("#<?php // echo CHtml::activeId($model, 'instalasi_id')?>").val("");
	// $("#<?php echo CHtml::activeId($model, 'instalasi_id')?>").val("");
	$("#<?php echo CHtml::activeId($model, 'rekening5_id')?>").val("");
	$("#<?php echo CHtml::activeId($model, 'nmrekening5')?>").val("");
	$("#<?php echo CHtml::activeId($model, 'debitkredit')?>").val("D");
	$("#<?php echo CHtml::activeId($model, 'ispembatalan')?>").prop("checked", false);
}

</script>
