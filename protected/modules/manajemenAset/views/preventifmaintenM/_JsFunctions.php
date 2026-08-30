<script type="text/javascript">
function inputBarang(){
	barang_id = $('#PreventifmaintenM_ipmchecklist_list').val();
	if (!jQuery.isNumeric(barang_id)){
		myAlert('Isi Barang yang akan dipesan');
		return false;
	}
	else if (!jQuery.isNumeric(jumlah)){
		myAlert('Isi jumlah barang yang akan dipesan');
		return false;
	}
	else{
		$('#table-detailbarang').addClass("animation-loading");
		cekList(barang_id);
	}        
}
</script>
    