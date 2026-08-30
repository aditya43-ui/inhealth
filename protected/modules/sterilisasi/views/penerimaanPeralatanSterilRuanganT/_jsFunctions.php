<script type="text/javascript">
function cekNoPengiriman(){
var kirimperlinensteril_no=$("#<?php echo CHtml::activeId($modCari,"kirimperlinensteril_no");?>").val();
	if (kirimperlinensteril_no == ""){
		myAlert('Isi No. Pengiriman yang akan dicari');
		return false;
	}else{
		$("#cspenerimaanperalatansteril-t-form").submit();
		return false;
	}
}
function print(caraPrint)
{
    var terimaperlinensteril_id = '<?php echo isset($_GET['terimaperlinensteril_id']) ? $_GET['terimaperlinensteril_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&terimaperlinensteril_id='+terimaperlinensteril_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

$(document).ready(function(){
	var jmlRow = $('#table-peralatansteril tbody tr').length;
	if(jmlRow === 0){
		$('#pencarian').attr('disabled',false);
	}else{
		$('#pencarian').attr('disabled',true);
	}
});
</script>