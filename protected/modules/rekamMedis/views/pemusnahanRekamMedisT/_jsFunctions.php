<script type="text/javascript">
	function getRuangan(){
        var value = $('#<?php echo CHtml::activeId($modPasien, 'instalasi_id'); ?>').val();
        var pilih = '';
        if (jQuery.isNumeric(value)){
            $.post('<?php echo $this->createUrl('getRuanganPasien'); ?>', {instalasi_id:value}, function(data){
                if (data.total > 1){
                    pilih = '<option value="">-- Pilih --</option>';
                }else if(data.total == 0)
                {
                    pilih = '<option value="">-- Pilih --</option>';
                }
                $('#<?php echo CHtml::activeId($modPasien, 'ruanganakhir_id'); ?>').html(pilih+data.dropDown);
            }, 'json');
        }
        else{
            
        }
    }
	
    function setUrutan(){
    }
    
    function setLengkap(){
    }
	
    function cekInputan(){
//		if(requiredCheck($("form"))){
        var kosong=0;
        var jumlah=0;

        $('.cekList').each(function(){
                if ($(this).is(':checked')){
                        var warnadokumen = $(this).parents("tr").find('select[name*="[pasien_id]"]').val();
                        if(warnadokumen == ''){
                                kosong++;
                        }
                        jumlah++;
                }            
        });

        if(kosong > 0 || jumlah < 1){
                if(jumlah < 1){
                        myAlert('Silakan pilih dokumen terlebih dahulu!');
                        return false;
                }else{
                        myAlert('Isi Warna Dokumen Rekam Medis');
                        return false;
                }				
        }else{
            requiredCheck($("form"));
            $('#pemusnahanrekammedis-t-form').submit();
        }

        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
                $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer').each(function(){
                $(this).val(formatInteger($(this).val()));
        });			
//		}
    return false;
}


    function pilihSemua(obj) {
        if ($(obj).is(":checked")) {
            $(".cekList").prop("checked", true);
        } else {
            $(".cekList").prop("checked", false);
        }
        setUrutan();
        setLengkap();
    }

    <?php if(!isset($_GET['sukses']) || $_GET['sukses'] != 1): ?>
	
	$(document).ready(function() {
            setValidasiCekDisabled($("#pemusnahanrekammedis-t-form"), function() {
                if ($("#pasien-m-grid .cekList:checked").length == 0) {
                    return false;
                }
                return true;
            });
	});
	
    <?php endif; ?>	
		
</script>