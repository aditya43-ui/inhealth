<script>

function loadDataClosing(id)
{
	$.post('<?php echo $this->createUrl("loadDataClosing"); ?>', 
	{id: id}, function(data)
	{
		$("#BKClosingkasirT_closingkasir_id").val(data.closingkasir_id);
		$("#BKClosingkasirT_tglclosingkasir").val(data.tglclosingkasir);
		$("#BKClosingkasirT_closingdari").val(data.closingdari);
		$("#BKClosingkasirT_sampaidengan").val(data.sampaidengan);
		$("#BKClosingkasirT_pegawai_id").val(data.nama_pegawai);
		
		loadDataSetoran(id);
	}, "json");
}

function loadDataSetoran(id)
{
	$.post('<?php echo $this->createUrl("loadDataSetoran"); ?>', 
	{id: id}, function(data)
	{
		$("#tab_setoran tbody").html(data.row);
		$("#tab_setoran tfoot").html(data.foot);
	}, "json");
}

function printSetoran()
{
    var setorankasir_id = '<?php echo $setoran->setorankasir_id; ?>';
    if(setorankasir_id.trim() != ''){
        window.open("<?php echo $this->createUrl('print') ?>&id="+setorankasir_id,"",'location=_new, width=1024px');
    }else{
        myAlert("Silakan cari data closing terlebih dahulu!");
    }
}

function cekValidasi()
{
	if ($("#tab_setoran tbody tr").length == 0) {
		myAlert("Data Closing belum dipilih.");
		return false;
	}
	if ($("#BKSetorankasirT_pegawai_id").val().trim() == "") {
		myAlert("Pegawai Setoran harus diisi.");
		return false;
	}
	
	return true;
}
	

</script>

