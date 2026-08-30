<script>

var objdetid;
var objdetnama;

function setInputBank(obj) {
    $("#SetorbankT_norekening").val($(obj).find(':selected').data('norekening'));
    $("#SetorbankT_atasnama").val($(obj).find(':selected').data('atasnama'));
    
    $(".rekening5_id").val($(obj).find(':selected').data('rekening5_id'));
    $(".rekening5_nama").val($(obj).find(':selected').data('nmrekening5'));
    
    
    console.log($(obj).find(':selected').data('rekening5_id'));
    console.log($(obj).find(':selected').data('nmrekening5'));
}

function loadSetoranKasir()
{
	var tgl_awal = $("#KUSetoranbdharaT_tgl_awal").val();
	var tgl_akhir = $("#KUSetoranbdharaT_tgl_akhir").val();
        $("#tab_setoran").addClass('animation-loading');
	
	$.post('<?php echo $this->createUrl('loadSetoran'); ?>', {
		tgl_awal: tgl_awal,
		tgl_akhir: tgl_akhir
	}, function(data)
	{
		$("#tab_setoran tbody").html(data.html);
		$("#tab_setoran tfoot").html(data.footer);
        $("#tab_setoran").removeClass('animation-loading');
        setInputBank($("#SetorbankT_namabank"));
	}, "json");
}

function printSetoran(id) {
	window.open("<?php echo $this->createUrl('print') ?>&id="+id,"",'location=_new, width=1024px');
}

function cekValidasi(form) {
	var rekkosong = false;
		
    if ($("#tab_setoran tbody tr").length == 0) {
        myAlert("Data detail setoran tidak ada.");
		return false;
    }    
        
	$(".rekening5_id").each(function() {
		if ($(this).val().trim() === "") rekkosong = true;
	});
	if (rekkosong) {
		myAlert("Rekening Harus Diisi");
		return false;
	}	
    
    
    if (requiredCheck(form)) {
        $("#btn_submit").prop("disabled", true);
        
        return true;
    }
    
    return false;
}

</script>

