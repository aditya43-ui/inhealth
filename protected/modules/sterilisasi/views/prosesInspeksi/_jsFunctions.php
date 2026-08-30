<script type="text/javascript">
    function searchPembersihan(){
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('pencarianPembersihanView'); ?>',
		data: {data:$('#pencarian-form').serialize()},//
		dataType: "json",
		success:function(data){
			$('#tabel-pembersihan > tbody').html("");
			if(data.pesan !== ""){
				myAlert(data.pesan);
				return false;
			}
			$('#tabel-pembersihan > tbody').append(data.form);
			
			renameInputRow($("#tabel-pembersihan"));
			
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}
    
    
</script>    
 
